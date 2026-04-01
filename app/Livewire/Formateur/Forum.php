<?php

namespace App\Livewire\Formateur;

use App\Models\Announcement;
use App\Models\DirectMessage;
use App\Models\ForumChannel;
use App\Models\ForumMessage;
use App\Models\ReportedMessage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class Forum extends Component
{
    use WithPagination;

    public $tab = 'forum';
    public $selectedChannelId = null;
    public $selectedPrivateUserId = null;
    public $messageInput = '';
    public $searchQuery = '';
    public $newThreadTitle = '';
    public $showThreadModal = false;
    public $showAnnouncementModal = false;
    public $showReportModal = false;
    public $showPrivateComposer = false;

    public $announcementTitle = '';
    public $announcementContent = '';
    public $reportReason = '';
    public $reportDescription = '';
    public $reportMessageId = null;
    public $privateMessageInput = '';

    #[Computed]
    public function channels()
    {
        $courseIds = auth()->user()->cours()->pluck('id');

        return ForumChannel::whereIn('cours_id', $courseIds)
            ->with(['cours', 'messages.user'])
            ->get()
            ->map(function ($channel) {
                $lastMsg = $channel->lastMessage();
                $unreadCount = $channel->messages()
                    ->where('user_id', '!=', auth()->id())
                    ->where('is_read', false)
                    ->where('is_hidden', false)
                    ->count();

                return [
                    'id' => $channel->id,
                    'name' => $channel->name,
                    'icon' => $channel->icon ?? '💬',
                    'color' => 'var(--vxl)',
                    'last_message' => $lastMsg ? substr($lastMsg->user->name, 0, 20).': '.substr($lastMsg->content, 0, 30).'...' : 'Aucun message',
                    'unread' => $unreadCount,
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function privateMessages()
    {
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
            $firstChannel = ForumChannel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))->first();
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
            ->where('is_hidden', false)
            ->with('user', 'pinnedBy')
            ->orderBy('is_pinned', 'desc')
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
                    'is_pinned' => $msg->is_pinned,
                    'is_solution' => $msg->is_solution,
                    'canModerate' => auth()->user()->is_formateur,
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function currentPrivateUser()
    {
        if (! $this->selectedPrivateUserId) {
            return null;
        }

        return collect($this->privateMessages())->firstWhere('id', $this->selectedPrivateUserId);
    }

    #[Computed]
    public function privateUserMessages()
    {
        if (! $this->selectedPrivateUserId) {
            return [];
        }

        return DirectMessage::where(function ($q) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $this->selectedPrivateUserId);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->selectedPrivateUserId)
                ->where('receiver_id', auth()->id());
        })
            ->with('sender', 'receiver')
            ->orderBy('created_at')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'author' => $msg->sender->name,
                    'initials' => strtoupper(substr($msg->sender->name, 0, 2)),
                    'gradient' => 'linear-gradient(135deg,'.$this->getGradient($msg->sender_id).')',
                    'message' => $msg->content,
                    'time' => $msg->created_at->format('H:i'),
                    'isOwn' => $msg->sender_id === auth()->id(),
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function threads()
    {
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

    #[Computed]
    public function announcements()
    {
        return Announcement::whereIn('cours_id', auth()->user()->cours()->pluck('id'))
            ->with('user', 'cours')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($ann) {
                return [
                    'id' => $ann->id,
                    'title' => $ann->title,
                    'content' => $ann->content,
                    'author' => $ann->user->name,
                    'course' => $ann->cours->name,
                    'is_pinned' => $ann->is_pinned,
                    'published_at' => $ann->published_at?->format('d M Y H:i'),
                ];
            })
            ->toArray();
    }

    public function selectChannel($channelId)
    {
        $this->selectedChannelId = $channelId;
        $this->selectedPrivateUserId = null;
        $this->markChannelAsRead($channelId);
    }

    public function selectPrivateUser($userId)
    {
        $this->selectedPrivateUserId = $userId;
        $this->selectedChannelId = null;
        $this->markPrivateMessagesAsRead($userId);
    }

    public function markChannelAsRead($channelId)
    {
        ForumMessage::where('channel_id', $channelId)
            ->where('user_id', '!=', auth()->id())
            ->update(['is_read' => true]);
    }

    public function markPrivateMessagesAsRead($userId)
    {
        DirectMessage::where('receiver_id', auth()->id())
            ->where('sender_id', $userId)
            ->update(['is_read' => true]);
    }

    public function switchTab($newTab)
    {
        $this->tab = $newTab;
    }

    public function sendMessage()
    {
        $this->validate([
            'messageInput' => 'required|string|max:5000',
            'selectedChannelId' => 'required|exists:forum_channels,id',
        ]);

        ForumMessage::create([
            'channel_id' => $this->selectedChannelId,
            'user_id' => auth()->id(),
            'content' => trim($this->messageInput),
            'is_read' => true,
        ]);

        session()->flash('success', '✉️ Message envoyé');
        $this->messageInput = '';
        $this->resetComputedProperties(['channels', 'messages']);
    }

    public function sendPrivateMessage()
    {
        $this->validate([
            'privateMessageInput' => 'required|string|max:5000',
            'selectedPrivateUserId' => 'required|exists:users,id',
        ]);

        DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedPrivateUserId,
            'content' => trim($this->privateMessageInput),
            'is_read' => false,
        ]);

        session()->flash('success', '💬 Message privé envoyé');
        $this->privateMessageInput = '';
        $this->resetComputedProperties(['privateMessages', 'privateUserMessages']);
    }

    public function pinMessage($messageId)
    {
        if (auth()->user()->is_formateur) {
            $message = ForumMessage::find($messageId);
            if ($message) {
                $message->update([
                    'is_pinned' => ! $message->is_pinned,
                    'pinned_by' => auth()->id(),
                ]);

                session()->flash('success', $message->is_pinned ? '📌 Message épinglé' : '📌 Message dépinglé');
                $this->resetComputedProperties(['messages']);
            }
        }
    }

    public function markAsSolution($messageId)
    {
        if (auth()->user()->is_formateur) {
            $message = ForumMessage::find($messageId);
            if ($message) {
                $message->update(['is_solution' => ! $message->is_solution]);

                session()->flash('success', $message->is_solution ? '✅ Marqué comme solution' : '❌ Solution retirée');
                $this->resetComputedProperties(['messages']);
            }
        }
    }

    public function hideMessage($messageId)
    {
        if (auth()->user()->is_formateur) {
            $message = ForumMessage::find($messageId);
            if ($message) {
                $message->update(['is_hidden' => true]);

                session()->flash('success', '👁️ Message masqué');
                $this->resetComputedProperties(['messages']);
            }
        }
    }

    public function deleteMessage($messageId)
    {
        if (auth()->user()->is_formateur) {
            $message = ForumMessage::find($messageId);
            if ($message) {
                $message->delete();

                session()->flash('success', '🗑️ Message supprimé');
                $this->resetComputedProperties(['messages']);
            }
        }
    }

    public function openReportModal($messageId)
    {
        $this->reportMessageId = $messageId;
        $this->showReportModal = true;
    }

    public function closeReportModal()
    {
        $this->showReportModal = false;
        $this->reportMessageId = null;
        $this->reportReason = '';
        $this->reportDescription = '';
    }

    public function submitReport()
    {
        $this->validate([
            'reportMessageId' => 'required|exists:forum_messages,id',
            'reportReason' => 'required|string|max:50',
            'reportDescription' => 'nullable|string|max:1000',
        ]);

        ReportedMessage::create([
            'message_id' => $this->reportMessageId,
            'reporter_id' => auth()->id(),
            'reason' => $this->reportReason,
            'description' => trim((string) $this->reportDescription),
            'status' => 'pending',
        ]);

        session()->flash('success', '⚠️ Message signalé aux modérateurs');
        $this->closeReportModal();
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
        $this->validate([
            'newThreadTitle' => 'required|string|max:255',
        ]);

        $courseIds = auth()->user()->cours()->pluck('id')->first();

        if ($courseIds) {
            ForumChannel::create([
                'cours_id' => $courseIds,
                'name' => trim($this->newThreadTitle),
                'icon' => '💬',
            ]);

            session()->flash('success', '➕ Nouveau canal créé');
            $this->closeThreadModal();
            $this->resetComputedProperties(['channels']);
        }
    }

    public function openAnnouncementModal()
    {
        $this->showAnnouncementModal = true;
    }

    public function closeAnnouncementModal()
    {
        $this->showAnnouncementModal = false;
        $this->announcementTitle = '';
        $this->announcementContent = '';
    }

    public function createAnnouncement()
    {
        $this->validate([
            'announcementTitle' => 'required|string|max:255',
            'announcementContent' => 'required|string|max:10000',
        ]);

        $courseIds = auth()->user()->cours()->pluck('id')->first();

        if ($courseIds) {
            Announcement::create([
                'cours_id' => $courseIds,
                'user_id' => auth()->id(),
                'title' => trim($this->announcementTitle),
                'content' => trim($this->announcementContent),
                'published_at' => now(),
            ]);

            session()->flash('success', '📢 Annonce créée');
            $this->closeAnnouncementModal();
            $this->resetComputedProperties(['announcements']);
        }
    }

    public function markAllAsRead()
    {
        if ($this->selectedChannelId) {
            $this->markChannelAsRead($this->selectedChannelId);
            session()->flash('success', '✓ Tous les messages marqués comme lus');
            $this->resetComputedProperties(['messages']);
        }
    }

    public function refreshRealtimeData()
    {
        if ($this->tab === 'forum') {
            $this->resetComputedProperties(['channels', 'messages']);
            return;
        }

        if ($this->tab === 'privates') {
            $this->resetComputedProperties(['privateMessages', 'privateUserMessages']);
            return;
        }

        if ($this->tab === 'announcements') {
            $this->resetComputedProperties(['announcements']);
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
