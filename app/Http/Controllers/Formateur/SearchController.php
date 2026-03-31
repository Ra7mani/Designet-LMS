<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cours;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['students' => [], 'courses' => []]);
        }

        $authUser = auth()->user();

        // Search students enrolled in formateur's courses
        $students = User::where('role', 'etudiant')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->whereHas('inscriptions', function($q) use ($authUser) {
                $q->whereIn('cours_id', $authUser->cours()->pluck('id'));
            })
            ->select('id', 'name', 'email')
            ->limit(5)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'email' => $s->email,
            ])
            ->toArray();

        // Search formateur's courses
        $courses = $authUser->cours()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('inscriptions')
            ->select('id', 'title', 'description')
            ->limit(5)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'students_count' => $c->inscriptions->count(),
            ])
            ->toArray();

        return response()->json([
            'students' => $students,
            'courses' => $courses,
        ]);
    }
}
