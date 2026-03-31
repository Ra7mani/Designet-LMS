<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\DirectMessage;
use App\Models\ForumMessage;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['students' => [], 'courses' => [], 'messages' => []]);
        }

        $authUser = auth()->user();

        // Search students enrolled in formateur's courses
        $students = User::where('role', 'etudiant')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->whereHas('inscriptions', function ($q) use ($authUser) {
                $q->whereIn('cours_id', $authUser->cours()->pluck('id'));
            })
            ->select('id', 'name', 'email')
            ->limit(5)
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
            ])
            ->toArray();

        // Search formateur's courses
        $courses = $authUser->cours()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('inscriptions')
            ->select('id', 'title', 'description')
            ->limit(5)
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'students_count' => $c->inscriptions->count(),
            ])
            ->toArray();

        $courseIds = $authUser->cours()->pluck('id');

        $directMessages = DirectMessage::where(function ($q) use ($authUser) {
            $q->where('sender_id', $authUser->id)
                ->orWhere('receiver_id', $authUser->id);
        })
            ->where('content', 'like', "%{$query}%")
            ->with('sender', 'receiver')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($message) use ($authUser) {
                $otherUser = $message->sender_id === $authUser->id ? $message->receiver : $message->sender;

                return [
                    'id' => 'dm-'.$message->id,
                    'type' => 'direct',
                    'name' => $otherUser->name ?? 'Utilisateur',
                    'content' => mb_strimwidth($message->content, 0, 60, '...'),
                    'url' => route('formateur.forum'),
                ];
            });

        $forumMessages = ForumMessage::whereHas('channel', function ($q) use ($courseIds) {
            $q->whereIn('cours_id', $courseIds);
        })
            ->where('content', 'like', "%{$query}%")
            ->where('user_id', '!=', $authUser->id)
            ->with('user')
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn ($message) => [
                'id' => 'fm-'.$message->id,
                'type' => 'forum',
                'name' => $message->user->name ?? 'Étudiant',
                'content' => mb_strimwidth($message->content, 0, 60, '...'),
                'url' => route('formateur.forum'),
            ]);

        $messages = $directMessages
            ->concat($forumMessages)
            ->take(6)
            ->values()
            ->toArray();

        return response()->json([
            'students' => $students,
            'courses' => $courses,
            'messages' => $messages,
        ]);
    }
}
