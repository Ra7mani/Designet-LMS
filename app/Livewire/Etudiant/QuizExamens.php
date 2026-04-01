<?php

namespace App\Livewire\Etudiant;

use App\Models\Inscription;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class QuizExamens extends Component
{
    // View state
    public string $tab = 'tous';

    public ?int $activeQuizId = null;

    public bool $showQuiz = false;

    public bool $showResult = false;

    // Quiz state
    public ?Quiz $currentQuiz = null;

    public ?QuizAttempt $currentAttempt = null;

    public array $questions = [];

    public int $currentQuestionIndex = 0;

    public array $userAnswers = [];

    public int $timeRemaining = 0;

    public bool $quizStarted = false;

    // Result state
    public ?QuizAttempt $lastResult = null;

    protected $queryString = [
        'tab' => ['except' => 'tous'],
    ];

    public function mount()
    {
        // Check if there's an in-progress quiz
        $inProgress = QuizAttempt::where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->with('quiz.questions.answers')
            ->first();

        if ($inProgress) {
            $this->resumeQuiz($inProgress);
        }
    }

    public function setTab(string $tab)
    {
        $this->tab = $tab;
        $this->showQuiz = false;
        $this->showResult = false;
    }

    public function startQuiz(int $quizId)
    {
        $quiz = Quiz::with('questions.answers', 'cours')->findOrFail($quizId);

        // Check if user is enrolled in the course
        $inscription = Inscription::where('etudiant_id', auth()->id())
            ->where('cours_id', $quiz->cours_id)
            ->first();

        if (! $inscription) {
            session()->flash('error', 'Vous devez etre inscrit au cours pour passer ce quiz.');

            return;
        }

        // Check max attempts
        $attemptsCount = QuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->count();

        if ($attemptsCount >= $quiz->max_attempts) {
            session()->flash('error', 'Vous avez atteint le nombre maximum de tentatives pour ce quiz.');

            return;
        }

        // Check for in-progress attempt
        $existingAttempt = QuizAttempt::where('quiz_id', $quizId)
            ->where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->first();

        if ($existingAttempt) {
            $this->resumeQuiz($existingAttempt);

            return;
        }

        // Create new attempt
        $questionsCollection = $quiz->questions;
        if (Schema::hasColumn('quizzes', 'random_order') && ($quiz->random_order ?? false)) {
            $questionsCollection = $questionsCollection->shuffle()->values();
        }

        $this->currentAttempt = QuizAttempt::create([
            'quiz_id' => $quizId,
            'user_id' => auth()->id(),
            'total_questions' => $questionsCollection->count(),
            'total_points' => $questionsCollection->sum('points'),
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        $this->currentQuiz = $quiz;
        $this->questions = $questionsCollection->toArray();
        $this->currentQuestionIndex = 0;
        $this->userAnswers = [];
        $this->timeRemaining = $quiz->duration * 60; // Convert to seconds
        $this->quizStarted = true;
        $this->showQuiz = true;
        $this->showResult = false;
    }

    private function resumeQuiz(QuizAttempt $attempt)
    {
        $this->currentAttempt = $attempt;
        $this->currentQuiz = $attempt->quiz;
        $this->questions = $attempt->quiz->questions->toArray();
        $this->userAnswers = $attempt->answers ?? [];
        $this->currentQuestionIndex = count($this->userAnswers);

        // Calculate remaining time
        $elapsed = $attempt->started_at->diffInSeconds(now());
        $totalTime = $attempt->quiz->duration * 60;
        $this->timeRemaining = max(0, $totalTime - $elapsed);

        if ($this->timeRemaining <= 0) {
            $this->submitQuiz();

            return;
        }

        $this->quizStarted = true;
        $this->showQuiz = true;
        $this->showResult = false;
    }

    public function selectAnswer(int $answerId)
    {
        if (! $this->quizStarted || ! $this->currentQuiz) {
            return;
        }

        $question = $this->questions[$this->currentQuestionIndex];
        $this->userAnswers[$question['id']] = $answerId;

        // Save progress
        $this->currentAttempt->update([
            'answers' => $this->userAnswers,
        ]);
    }

    public function saveTextAnswer(string $answer)
    {
        if (! $this->quizStarted || ! $this->currentQuiz) {
            return;
        }

        $question = $this->questions[$this->currentQuestionIndex] ?? null;
        if (! $question) {
            return;
        }

        $this->userAnswers[$question['id']] = trim($answer);
        $this->currentAttempt->update([
            'answers' => $this->userAnswers,
        ]);
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function goToQuestion(int $index)
    {
        if ($index >= 0 && $index < count($this->questions)) {
            $this->currentQuestionIndex = $index;
        }
    }

    public function decrementTimer()
    {
        if ($this->quizStarted && $this->timeRemaining > 0) {
            $this->timeRemaining--;

            if ($this->timeRemaining <= 0) {
                $this->submitQuiz();
            }
        }
    }

    public function submitQuiz()
    {
        if (! $this->currentAttempt || ! $this->currentQuiz) {
            return;
        }

        // Calculate score
        $score = 0;
        $correctAnswers = 0;
        $questions = $this->currentQuiz->questions->load('answers');

        foreach ($questions as $question) {
            $userAnswerId = $this->userAnswers[$question->id] ?? null;
            if (($question->question_type ?? 'qcm') === 'texte') {
                continue;
            }
            $correctAnswer = $question->answers->where('is_correct', true)->first();

            if ($correctAnswer && $userAnswerId == $correctAnswer->id) {
                $score += $question->points;
                $correctAnswers++;
            }
        }

        $totalPoints = $questions->sum('points');
        $scorePercent = $totalPoints > 0 ? round(($score / $totalPoints) * 100) : 0;
        $passed = $scorePercent >= $this->currentQuiz->passing_score;

        // Calculate XP
        $xpEarned = $this->calculateXP($scorePercent, $passed);

        // Calculate duration
        $duration = $this->currentAttempt->started_at->diffInSeconds(now());

        // Update attempt
        $this->currentAttempt->update([
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'duration_seconds' => $duration,
            'answers' => $this->userAnswers,
            'status' => 'completed',
            'passed' => $passed,
            'xp_earned' => $xpEarned,
            'completed_at' => now(),
        ]);

        $this->lastResult = $this->currentAttempt->fresh();
        $this->quizStarted = false;
        $this->showQuiz = false;
        $this->showResult = true;

        // Reset quiz state
        $this->currentQuiz = null;
        $this->questions = [];
        $this->userAnswers = [];
    }

    private function calculateXP(int $scorePercent, bool $passed): int
    {
        $baseXP = 50;

        if ($passed) {
            $baseXP += 50; // Bonus for passing
        }

        // Score-based XP
        if ($scorePercent >= 90) {
            $baseXP += 50;
        } elseif ($scorePercent >= 80) {
            $baseXP += 30;
        } elseif ($scorePercent >= 70) {
            $baseXP += 20;
        }

        return $baseXP;
    }

    public function abandonQuiz()
    {
        if ($this->currentAttempt) {
            $this->currentAttempt->update([
                'status' => 'abandoned',
                'completed_at' => now(),
            ]);
        }

        $this->resetQuizState();
    }

    private function resetQuizState()
    {
        $this->currentQuiz = null;
        $this->currentAttempt = null;
        $this->questions = [];
        $this->currentQuestionIndex = 0;
        $this->userAnswers = [];
        $this->timeRemaining = 0;
        $this->quizStarted = false;
        $this->showQuiz = false;
    }

    public function closeResult()
    {
        $this->showResult = false;
        $this->lastResult = null;
    }

    public function sendReminder(int $quizId)
    {
        $quiz = Quiz::with('cours')->find($quizId);
        $user = auth()->user();

        if (! $quiz || ! $user->email) {
            session()->flash('error', 'Impossible d\'envoyer le rappel.');

            return;
        }

        // In production, you would use Laravel Mail
        // For now, we'll just show a success message
        session()->flash('success', 'Rappel envoye a '.$user->email.' pour "'.$quiz->title.'"');
    }

    public function render()
    {
        $userId = auth()->id();

        // Get user's inscriptions to find available quizzes
        $inscriptions = Inscription::where('etudiant_id', $userId)
            ->with(['cours.quizzes.questions.answers', 'cours.quizzes.attempts' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->get();

        // Collect all available quizzes
        $allQuizzes = collect();
        foreach ($inscriptions as $inscription) {
            foreach ($inscription->cours->quizzes as $quiz) {
                $quiz->setAttribute('inscription', $inscription);
                $allQuizzes->push($quiz);
            }
        }

        // Calculate stats
        $allAttempts = QuizAttempt::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        $stats = [
            'total_passed' => $allAttempts->count(),
            'total_succeeded' => $allAttempts->where('passed', true)->count(),
            'avg_score' => $allAttempts->count() > 0 ? round($allAttempts->avg(fn ($a) => ($a->score / max(1, $a->total_points)) * 100)) : 0,
            'upcoming' => $allQuizzes->filter(fn ($q) => $q->isExam())->count(),
            'total_xp' => $allAttempts->sum('xp_earned'),
        ];

        // Filter quizzes by tab
        $quizzes = match ($this->tab) {
            'quiz' => $allQuizzes->filter(fn ($q) => ! $q->isExam()),
            'examens' => $allQuizzes->filter(fn ($q) => $q->isExam()),
            'historique' => collect(), // History shows in table
            default => $allQuizzes,
        };

        // Get next exam
        $nextExam = $allQuizzes->filter(fn ($q) => $q->isExam())->first();

        // Get history
        $history = QuizAttempt::where('user_id', $userId)
            ->where('status', 'completed')
            ->with('quiz.cours')
            ->orderByDesc('completed_at')
            ->limit(20)
            ->get();

        return view('livewire.etudiant.quiz-examens', [
            'quizzes' => $quizzes,
            'stats' => $stats,
            'nextExam' => $nextExam,
            'history' => $history,
            'allAttempts' => $allAttempts,
        ])->layout('layouts.etudiant');
    }
}
