<?php

namespace App\Livewire\Formateur;

use App\Models\DirectMessage;
use App\Models\ForumChannel;
use App\Models\ForumMessage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.formateur')]
class Forum extends Component
{
    public $tab = 'forum';

    public $selectedChannelId = null;

    public $messageInput = '';

    public $searchQuery = '';

    public $newThreadTitle = '';

    public $showThreadModal = false;

    #[Computed]
    public function channels()
    {
        // Get forum channels for instructor's courses
        $courseIds = auth()->user()->cours()->pluck('id');

        return ForumChannel::whereIn('cours_id', $courseIds)
            ->with(['cours', 'messages.user'])
            ->get()
            ->map(function ($channel) {
                $lastMsg = $channel->lastMessage();

                return [
                    'id' => $channel->id,
                    'name' => $channel->name,
                    'icon' => $channel->icon ?? '💬',
                    'color' => 'var(--vxl)',
                    'last_message' => $lastMsg ? substr($lastMsg->user->name, 0, 20).': '.substr($lastMsg->content, 0, 30).'...' : 'Aucun message',
                    'unread' => $channel->unreadCount(auth()->id()),
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function privateMessages()
    {
        // Get private messages for instructor
        return DirectMessage::where('receiver_id', auth()->id())
            ->orWhere('sender_id', auth()->id())
            ->with('sender', 'receiver')
            ->latest()
            ->get()
            ->groupBy(function ($msg) {
                return $msg->sender_id === auth()->id() ? $msg->receiver_id : $msg->sender_id;
            })
            ->map(function ($messages, $userId) {
                $user = $messages->first()->sender_id === auth()->id()
                    ? $messages->first()->receiver
                    : $messages->first()->sender;

                $lastMessage = $messages->first();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'initials' => strtoupper(substr($user->name, 0, 2)),
                    'gradient' => 'linear-gradient(135deg,'.$this->getGradient($user->id).')',
                    'last_message' => substr($lastMessage->content, 0, 40).'...',
                    'time' => $lastMessage->created_at->diffForHumans(),
                    'unread' => $messages->where('is_read', false)->where('receiver_id', auth()->id())->count(),
                ];
            })
            ->values()
            ->toArray();
    }

    #[Computed]
    public function currentChannel()
    {
        if (! $this->selectedChannelId) {
            $firstChannel = ForumChannel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))
                ->first();

            return $firstChannel ? $this->channels()[0] ?? null : null;
        }

        return collect($this->channels())->firstWhere('id', $this->selectedChannelId);
    }

    #[Computed]
    public function messages()
    {
        if (! $this->selectedChannelId) {
            return [];
        }

        return ForumMessage::where('channel_id', $this->selectedChannelId)
            ->with('user')
            ->orderBy('created_at')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'author' => $msg->user->name,
                    'initials' => strtoupper(substr($msg->user->name, 0, 2)),
                    'gradient' => 'linear-gradient(135deg,'.$this->getGradient($msg->user_id).')',
                    'message' => $msg->content,
                    'time' => $msg->created_at->format('H:i'),
                    'isOwn' => $msg->user_id === auth()->id(),
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function threads()
    {
        // Use channels as threads (since no separate thread model)
        $courseIds = auth()->user()->cours()->pluck('id');

        return ForumChannel::whereIn('cours_id', $courseIds)
            ->with('messages.user', 'cours')
            ->get()
            ->map(function ($channel) {
                $messageCount = $channel->messages()->count();
                $viewCount = $channel->messages()->distinct('user_id')->count();

                return [
                    'id' => $channel->id,
                    'author' => $channel->cours->formateur->name ?? 'Formateur',
                    'initials' => strtoupper(substr($channel->cours->formateur->name ?? 'F', 0, 2)),
                    'gradient' => 'linear-gradient(135deg,#0284C7,#38BDF8)',
                    'title' => '📋 '.$channel->name,
                    'preview' => $channel->description ?? 'Aucune description',
                    'replies' => $messageCount,
                    'views' => $viewCount,
                    'answered' => $messageCount > 0,
                    'time' => $channel->messages()->latest()->first()?->created_at?->diffForHumans() ?? 'Jamais',
                ];
            })
            ->toArray();
    }

    public function selectChannel($channelId)
    {
        $this->selectedChannelId = $channelId;
    }

    public function switchTab($newTab)
    {
        $this->tab = $newTab;
    }

    public function sendMessage()
    {
        if (trim($this->messageInput) && $this->selectedChannelId) {
            ForumMessage::create([
                'channel_id' => $this->selectedChannelId,
                'user_id' => auth()->id(),
                'content' => $this->messageInput,
                'is_read' => true,
            ]);

            session()->flash('success', '✉️ Message envoyé');
            $this->messageInput = '';
        }
    }

    public function openThreadModal()
    {
        $this->showThreadModal = true;
    }

    public function closeThreadModal()
    {
        $this->showThreadModal = false;
        $this->newThreadTitle = '';
    }

    public function createThread()
    {
        if (trim($this->newThreadTitle)) {
            // Create new forum channel
            $courseIds = auth()->user()->cours()->pluck('id')->first();

            if ($courseIds) {
                ForumChannel::create([
                    'cours_id' => $courseIds,
                    'name' => $this->newThreadTitle,
                    'icon' => '💬',
                ]);

                session()->flash('success', '➕ Nouveau canal créé');
                $this->closeThreadModal();
            }
        }
    }

    private function getGradient($userId)
    {
        $colors = [
            '#0284C7,#38BDF8',
            '#DB2777,#F472B6',
            '#059669,#34D399',
            '#D97706,#FCD34D',
            '#7C3AED,#A78BFA',
        ];

        return $colors[$userId % count($colors)];
    }

    public function render()
    {
        return view('livewire.formateur.forum');
    }
}
