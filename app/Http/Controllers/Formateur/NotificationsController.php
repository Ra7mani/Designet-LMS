<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $courseIds = $authUser->cours()->pluck('id');

        if ($courseIds->isEmpty()) {
            return response()->json([]);
        }

        // Get recent notifications (reviews/avis)
        $notifications = Avis::whereHas('inscription', function($q) use ($courseIds) {
            $q->whereIn('cours_id', $courseIds);
        })
        ->with('inscription.etudiant', 'inscription.cours')
        ->latest()
        ->limit(10)
        ->get()
        ->map(fn($review) => [
            'id' => $review->id,
            'user_name' => $review->inscription->etudiant->name ?? 'Utilisateur',
            'user_avatar' => strtoupper(substr($review->inscription->etudiant->name ?? 'U', 0, 1)),
            'message' => 'a laissé un avis ' . $review->rating . ' étoiles',
            'course_title' => $review->inscription->cours->title,
            'created_at' => $review->created_at->diffForHumans(),
            'type' => 'review',
        ])
        ->toArray();

        return response()->json($notifications);
    }
}
