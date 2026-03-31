<?php

namespace App\Livewire\Formateur;

use App\Models\Quiz as QuizModel;
use App\Models\QuizAttempt;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class Quiz extends Component
{
    use WithPagination;

    public $filter = 'tous';
    public $selectedQuizId = null;
    public $correctionModalOpen = false;
    public $createQuizModalOpen = false;
    public $correctionComment = '';
    public $correctionScore = 0;
    public $selectedSubmission = null;

    #[Computed]
    public function quizzes()
    {
        return QuizModel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))
            ->when($this->filter !== 'tous', fn($q) => $q->where('type', $this->filter))
            ->with('questions', 'attempts')
            ->paginate(9);
    }

    #[Computed]
    public function stats()
    {
        $allQuizzes = QuizModel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))->get();
        $allAttempts = QuizAttempt::whereIn('quiz_id', $allQuizzes->pluck('id'))->get();

        return [
            'total_quizzes' => $allQuizzes->count(),
            'total_attempts' => $allAttempts->count(),
            'average_score' => $allAttempts->avg('score_percent') ?? 0,
            'pending_grading' => $this->pendingSubmissions()->count(),
            'success_rate' => $allAttempts->where('status', 'completed')->count() > 0
                ? round(($allAttempts->where('status', 'completed')->where('score_percent', '>=', 70)->count() /
                        $allAttempts->where('status', 'completed')->count()) * 100)
                : 0,
        ];
    }

    #[Computed]
    public function pendingSubmissions()
    {
        $quizIds = QuizModel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))->pluck('id');

        return QuizAttempt::whereIn('quiz_id', $quizIds)
            ->where('status', 'submitted')
            ->with('user', 'quiz')
            ->latest()
            ->get();
    }

    public function selectQuiz($id)
    {
        $this->selectedQuizId = $id;
    }

    public function openCorrection($submissionId)
    {
        $this->selectedSubmission = QuizAttempt::findOrFail($submissionId);
        $this->correctionScore = $this->selectedSubmission->score_percent ?? 0;
        $this->correctionComment = '';
        $this->correctionModalOpen = true;
    }

    public function closeCorrection()
    {
        $this->correctionModalOpen = false;
        $this->selectedSubmission = null;
        $this->correctionScore = 0;
        $this->correctionComment = '';
    }

    public function submitCorrection()
    {
        if ($this->selectedSubmission) {
            $this->selectedSubmission->update([
                'score_percent' => $this->correctionScore,
                'status' => 'graded',
                'grader_comment' => $this->correctionComment,
            ]);

            session()->flash('success', '✅ Correction envoyée ! Note : ' . $this->correctionScore . '/100');
            $this->closeCorrection();
        }
    }

    public function openCreateQuiz()
    {
        $this->createQuizModalOpen = true;
    }

    public function closeCreateQuiz()
    {
        $this->createQuizModalOpen = false;
    }

    public function updateFilter($newFilter)
    {
        $this->filter = $newFilter;
        $this->resetPage();
    }

    public function getQuizColor($type)
    {
        $typeStr = is_object($type) ? $type->value : $type;
        $colors = [
            'quiz' => 'var(--vxl)',
            'exam' => 'var(--peach)',
            'devoir' => 'var(--yel)',
        ];
        return $colors[$typeStr] ?? 'var(--vxl)';
    }

    public function getQuizTextColor($type)
    {
        $typeStr = is_object($type) ? $type->value : $type;
        $colors = [
            'quiz' => 'var(--v)',
            'exam' => 'var(--peachd)',
            'devoir' => 'var(--yeld)',
        ];
        return $colors[$typeStr] ?? 'var(--v)';
    }

    public function getQuizIcon($type)
    {
        $typeStr = is_object($type) ? $type->value : $type;
        $icons = [
            'quiz' => '💡',
            'exam' => '📋',
            'devoir' => '🎭',
        ];
        return $icons[$typeStr] ?? '📝';
    }

    public function render()
    {
        return view('livewire.formateur.quiz');
    }
}
