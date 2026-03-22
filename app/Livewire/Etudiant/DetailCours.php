<?php

namespace App\Livewire\Etudiant;

use App\Enums\EnrollStatus;
use App\Models\Avis;
use App\Models\Cours;
use App\Models\Inscription;
use Livewire\Component;

class DetailCours extends Component
{
    public Cours $cours;
    public bool $dejaInscrit = false;
    public ?Inscription $inscription = null;

    // Review form
    public int $rating = 5;
    public string $comment = '';
    public bool $hasReviewed = false;
    public ?Avis $userReview = null;
    public bool $showReviewForm = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount(int $id): void
    {
        $this->cours = Cours::with([
            'categorie',
            'formateur',
            'chapitres.lecons',
            'quizzes.questions',
            'inscriptions.avis',
            'inscriptions.etudiant',
        ])->withCount('inscriptions')->findOrFail($id);

        $this->inscription = Inscription::where('etudiant_id', auth()->id())
            ->where('cours_id', $this->cours->id)
            ->with('avis')
            ->first();

        $this->dejaInscrit = $this->inscription !== null;

        // Check if user has already reviewed
        if ($this->inscription) {
            $this->userReview = $this->inscription->avis->first();
            $this->hasReviewed = $this->userReview !== null;

            // Pre-fill form if editing
            if ($this->userReview) {
                $this->rating = $this->userReview->rating;
                $this->comment = $this->userReview->comment ?? '';
            }
        }
    }

    public function inscrire(): void
    {
        if ($this->dejaInscrit) {
            return;
        }

        $this->inscription = Inscription::create([
            'etudiant_id' => auth()->id(),
            'cours_id'    => $this->cours->id,
            'enrolled_at' => now(),
            'progress'    => 0,
            'status'      => EnrollStatus::Active,
        ]);

        $this->dejaInscrit = true;
        session()->flash('success', 'Inscription reussie ! Vous pouvez maintenant acceder au cours.');
    }

    public function setRating(int $stars): void
    {
        $this->rating = $stars;
    }

    public function toggleReviewForm(): void
    {
        $this->showReviewForm = !$this->showReviewForm;
    }

    public function submitReview(): void
    {
        if (!$this->dejaInscrit || !$this->inscription) {
            session()->flash('error', 'Vous devez etre inscrit pour laisser un avis.');
            return;
        }

        $this->validate();

        if ($this->hasReviewed && $this->userReview) {
            // Update existing review
            $this->userReview->update([
                'rating' => $this->rating,
                'comment' => $this->comment ?: null,
                'is_approved' => true, // Auto-approve updates
            ]);
            session()->flash('success', 'Votre avis a ete mis a jour !');
        } else {
            // Create new review
            $this->userReview = Avis::create([
                'inscription_id' => $this->inscription->id,
                'rating' => $this->rating,
                'comment' => $this->comment ?: null,
                'is_approved' => true, // Auto-approve for now
            ]);
            $this->hasReviewed = true;
            session()->flash('success', 'Merci pour votre avis !');
        }

        $this->showReviewForm = false;

        // Refresh course data
        $this->cours->load(['inscriptions.avis', 'inscriptions.etudiant']);
    }

    public function deleteReview(): void
    {
        if ($this->userReview) {
            $this->userReview->delete();
            $this->userReview = null;
            $this->hasReviewed = false;
            $this->rating = 5;
            $this->comment = '';
            session()->flash('success', 'Votre avis a ete supprime.');

            // Refresh course data
            $this->cours->load(['inscriptions.avis', 'inscriptions.etudiant']);
        }
    }

    public function render()
    {
        // Calculate stats
        $chaptersCount = $this->cours->chapitres->count();
        $lessonsCount = $this->cours->chapitres->sum(fn($c) => $c->lecons->count());
        $quizzesCount = $this->cours->quizzes->count();
        $questionsCount = $this->cours->quizzes->sum(fn($q) => $q->questions->count());
        $studentsCount = $this->cours->inscriptions_count;

        // Calculate total duration
        $totalDuration = $this->cours->chapitres->sum(fn($c) => $c->lecons->sum('duration'));

        // Get reviews from inscriptions (approved only for display)
        $avis = $this->cours->inscriptions
            ->pluck('avis')
            ->flatten()
            ->filter(fn($a) => $a && $a->is_approved)
            ->sortByDesc('created_at');

        $avgRating = $avis->count() > 0 ? round($avis->avg('rating'), 1) : 0;

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $avis->where('rating', $i)->count();
            $ratingDistribution[$i] = [
                'count' => $count,
                'percent' => $avis->count() > 0 ? round(($count / $avis->count()) * 100) : 0,
            ];
        }

        return view('livewire.etudiant.detail-cours', [
            'chaptersCount' => $chaptersCount,
            'lessonsCount' => $lessonsCount,
            'quizzesCount' => $quizzesCount,
            'questionsCount' => $questionsCount,
            'studentsCount' => $studentsCount,
            'totalDuration' => $totalDuration,
            'avis' => $avis,
            'avgRating' => $avgRating,
            'ratingDistribution' => $ratingDistribution,
        ])->layout('layouts.etudiant');
    }
}
