<?php

namespace App\Livewire\Etudiant;

use App\Models\ForumChannel;
use App\Models\ForumMessage;
use App\Models\MessageReaction;
use App\Models\ReportedMessage;
use App\Models\DirectMessage;
use App\Models\User;
use Livewire\Component;

class Forum extends Component
{
    public ?ForumChannel $selectedChannel = null;
    public $channels = [];
    public $messages = [];
    public $messageContent = '';
    public $view = 'forum'; // 'forum' or 'messages'
    public $dmWith = null;
    public $dmUsers = [];
    public $dmMessages = [];
    public $dmContent = '';
    public $searchQuery = '';

    public function mount(): void
    {
        $this->loadChannels();
    }

    public function loadChannels(): void
    {
        $user = auth()->user();
        $inscriptionIds = $user->inscriptions()->pluck('cours_id');

        $this->channels = ForumChannel::whereIn('cours_id', $inscriptionIds)
            ->with('messages.user')
            ->orderBy('name')
            ->get()
            ->map(fn($channel) => [
                'id' => $channel->id,
                'name' => $channel->name,
                'icon' => $channel->icon ?? '📚',
                'unread_count' => $channel->unreadCount($user->id),
            ])
            ->toArray();

        if (count($this->channels) > 0 && !$this->selectedChannel) {
            $this->selectChannel($this->channels[0]['id']);
        }
    }

    public function selectChannel($channelId): void
    {
        $this->selectedChannel = ForumChannel::with(['messages.user', 'messages.reactions'])->find($channelId);
        $messages = $this->selectedChannel?->messages()
            ->with('user')
            ->latest()
            ->get();

        $this->messages = $messages?->map(fn($m) => [
            'id' => $m->id,
            'user_id' => $m->user_id,
            'user' => ['name' => $m->user->name, 'initials' => $m->user->initials()],
            'content' => $m->content,
            'created_at' => $m->created_at,
            'reactions' => $m->reactions->count(),
            'is_read' => $m->is_read,
        ])->reverse()->toArray() ?? [];

        // Mark messages as read
        if ($this->selectedChannel) {
            ForumMessage::where('channel_id', $channelId)
                ->where('user_id', '!=', auth()->id())
                ->update(['is_read' => true]);
        }

        // Reload channels to update unread badge
        $this->loadChannels();
    }

    public function sendMessage(): void
    {
        $this->validate(['messageContent' => 'required|string|max:5000']);

        if (!$this->selectedChannel) {
            return;
        }

        ForumMessage::create([
            'channel_id' => $this->selectedChannel->id,
            'user_id' => auth()->id(),
            'content' => $this->messageContent,
        ]);

        $this->messageContent = '';
        $this->selectChannel($this->selectedChannel->id);
        $this->dispatch('scroll-to-bottom');
    }

    public function addReaction($messageId, $emoji = '👍'): void
    {
        $existingReaction = MessageReaction::where('message_id', $messageId)
            ->where('user_id', auth()->id())
            ->where('emoji', $emoji)
            ->first();

        if ($existingReaction) {
            $existingReaction->delete();
        } else {
            MessageReaction::create([
                'message_id' => $messageId,
                'user_id' => auth()->id(),
                'emoji' => $emoji,
            ]);
        }

        $this->selectChannel($this->selectedChannel->id);
    }

    public function reportMessage($messageId, $reason): void
    {
        $existingReport = ReportedMessage::where('message_id', $messageId)
            ->where('reporter_id', auth()->id())
            ->first();

        if (!$existingReport) {
            ReportedMessage::create([
                'message_id' => $messageId,
                'reporter_id' => auth()->id(),
                'reason' => $reason,
            ]);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Message signalé']);
        }

        $this->selectChannel($this->selectedChannel->id);
    }

    public function switchTab($tab): void
    {
        $this->view = $tab;
        if ($tab === 'messages') {
            $this->loadDmUsers();
        }
    }

    public function loadDmUsers(): void
    {
        $user = auth()->user();
        $courseIds = $user->inscriptions()->pluck('cours_id');

        // Get other students in same courses
        $this->dmUsers = User::where('role', 'etudiant')
            ->where('id', '!=', $user->id)
            ->whereHas('inscriptions', function ($q) use ($courseIds) {
                $q->whereIn('cours_id', $courseIds);
            })
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get()
            ->map(fn($u) => [
                'id' => $u->id,
                'name' => $u->name,
                'unread_count' => DirectMessage::where('sender_id', $u->id)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->count(),
            ])
            ->toArray();
    }

    public function selectDmUser($userId): void
    {
        $this->dmWith = User::find($userId);
        $this->loadDmMessages();
    }

    public function loadDmMessages(): void
    {
        if (!$this->dmWith) {
            $this->dmMessages = [];
            return;
        }

        $userId = auth()->id();
        $dmUserId = $this->dmWith->id;

        $this->dmMessages = DirectMessage::where(function ($query) use ($userId, $dmUserId) {
            $query->where('sender_id', $userId)->where('receiver_id', $dmUserId);
        })
        ->orWhere(function ($query) use ($userId, $dmUserId) {
            $query->where('sender_id', $dmUserId)->where('receiver_id', $userId);
        })
        ->latest()
        ->get()
        ->map(fn($m) => [
            'id' => $m->id,
            'sender_id' => $m->sender_id,
            'content' => $m->content,
            'created_at' => $m->created_at,
        ])
        ->reverse()
        ->toArray();

        // Mark messages as read
        DirectMessage::where('sender_id', $dmUserId)
            ->where('receiver_id', $userId)
            ->update(['is_read' => true]);

        $this->loadDmUsers();
    }

    public function sendDmMessage(): void
    {
        $this->validate(['dmContent' => 'required|string|max:5000']);

        if (!$this->dmWith) {
            return;
        }

        DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->dmWith->id,
            'content' => $this->dmContent,
        ]);

        $this->dmContent = '';
        $this->loadDmMessages();
        $this->dispatch('scroll-to-bottom');
    }

    public function render()
    {
        return view('livewire.etudiant.forum', [
            'channels' => $this->channels,
            'selectedChannel' => $this->selectedChannel,
            'messages' => $this->messages,
            'dmUsers' => $this->dmUsers,
            'dmWith' => $this->dmWith,
            'dmMessages' => $this->dmMessages,
        ])->layout('layouts.etudiant');
    }
}
