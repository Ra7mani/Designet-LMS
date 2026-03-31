<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\DirectMessage;
use App\Models\ForumMessage;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $courseIds = $authUser->cours()->pluck('id');

        if ($courseIds->isEmpty()) {
            return response()->json([
                'unread_count' => 0,
                'items' => [],
            ]);
        }

        $reviews = Avis::whereHas('inscription', function ($q) use ($courseIds) {
            $q->whereIn('cours_id', $courseIds);
        })
            ->with('inscription.etudiant', 'inscription.cours')
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn ($review) => [
                'id' => 'review-'.$review->id,
                'user_name' => $review->inscription->etudiant->name ?? 'Utilisateur',
                'user_avatar' => strtoupper(substr($review->inscription->etudiant->name ?? 'U', 0, 1)),
                'message' => 'a laissé un avis '.$review->rating.' étoiles',
                'course_title' => $review->inscription->cours->title,
                'created_at' => $review->created_at->diffForHumans(),
                'sort_at' => $review->created_at->timestamp,
                'type' => 'review',
                'is_unread' => true,
            ]);

        $assignments = QuizAttempt::whereHas('quiz', fn ($q) => $q->whereIn('cours_id', $courseIds))
            ->where('status', 'completed')
            ->with('user', 'quiz.cours')
            ->latest('completed_at')
            ->limit(4)
            ->get()
            ->map(fn ($attempt) => [
                'id' => 'assignment-'.$attempt->id,
                'user_name' => $attempt->user->name ?? 'Étudiant',
                'user_avatar' => strtoupper(substr($attempt->user->name ?? 'E', 0, 1)),
                'message' => 'a rendu un devoir',
                'course_title' => $attempt->quiz->cours->title ?? 'Cours',
                'created_at' => ($attempt->completed_at ?? $attempt->updated_at)->diffForHumans(),
                'sort_at' => ($attempt->completed_at ?? $attempt->updated_at)->timestamp,
                'type' => 'assignment',
                'is_unread' => true,
            ]);

        $questions = ForumMessage::whereHas('channel', function ($q) use ($courseIds) {
            $q->whereIn('cours_id', $courseIds);
        })
            ->where('user_id', '!=', $authUser->id)
            ->where('is_read', false)
            ->with('user', 'channel.cours')
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn ($question) => [
                'id' => 'question-'.$question->id,
                'user_name' => $question->user->name ?? 'Étudiant',
                'user_avatar' => strtoupper(substr($question->user->name ?? 'E', 0, 1)),
                'message' => 'a posé une question',
                'course_title' => $question->channel->cours->title ?? 'Forum',
                'created_at' => $question->created_at->diffForHumans(),
                'sort_at' => $question->created_at->timestamp,
                'type' => 'question',
                'is_unread' => true,
            ]);

        $directMessages = DirectMessage::where('receiver_id', $authUser->id)
            ->where('is_read', false)
            ->with('sender')
            ->latest()
            ->limit(4)
            ->get()
            ->map(fn ($message) => [
                'id' => 'message-'.$message->id,
                'user_name' => $message->sender->name ?? 'Utilisateur',
                'user_avatar' => strtoupper(substr($message->sender->name ?? 'U', 0, 1)),
                'message' => 'vous a envoyé un message',
                'course_title' => 'Messages privés',
                'created_at' => $message->created_at->diffForHumans(),
                'sort_at' => $message->created_at->timestamp,
                'type' => 'message',
                'is_unread' => true,
            ]);

        $notifications = $reviews
            ->concat($assignments)
            ->concat($questions)
            ->concat($directMessages)
            ->sortByDesc('sort_at')
            ->take(12)
            ->values()
            ->map(function ($item) {
                unset($item['sort_at']);

                return $item;
            });

        return response()->json([
            'unread_count' => $notifications->where('is_unread', true)->count(),
            'items' => $notifications,
        ]);
    }
}
