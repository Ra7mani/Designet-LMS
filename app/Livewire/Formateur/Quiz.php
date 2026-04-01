<?php

namespace App\Livewire\Formateur;

use App\Enums\QuizType;
use App\Models\Cours;
use App\Models\DirectMessage;
use App\Models\Event;
use App\Models\Question;
use App\Models\Quiz as QuizModel;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.formateur')]
class Quiz extends Component
{
    use WithPagination;

    public $filter = 'tous';

    public $selectedQuizId = null;

    public $correctionModalOpen = false;

    public $createQuizModalOpen = false;

    public $showQuizDetails = false;

    public $correctionComment = '';

    public $correctionScore = 0;

    public $selectedSubmission = null;

    public $selectedQuiz = null;

    public $quizTitle = '';

    public $quizCoursId = '';

    public $quizChapitreId = '';

    public $quizType = 'quiz';

    public $quizDuration = 20;

    public $quizPassingScore = 70;

    public $quizMaxAttempts = 3;

    public $quizRandomOrder = false;

    public $quizIsPublished = false;

    public $quizAvailableFrom = '';

    public $quizAvailableUntil = '';

    public $editingQuizId = null;

    public array $questionsDraft = [];

    #[Computed]
    public function quizzes()
    {
        return QuizModel::whereIn('cours_id', auth()->user()->cours()->pluck('id'))
            ->when($this->filter !== 'tous', fn ($q) => $q->where('type', $this->filter))
            ->with('cours', 'chapitre')
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
            ->where(function ($query) {
                $query->where('status', 'submitted')
                    ->orWhere(function ($sub) {
                        $sub->where('status', 'completed');
                        if ($this->supportsQuestionType()) {
                            $sub->whereHas('quiz.questions', fn ($q) => $q->where('question_type', 'texte'));
                        }
                        if (Schema::hasColumn('quiz_attempts', 'is_graded')) {
                            $sub->where(function ($grading) {
                                $grading->where('is_graded', false)->orWhereNull('is_graded');
                            });
                        }
                    });
            })
            ->with('user', 'quiz')
            ->latest()
            ->get();
    }

    #[Computed]
    public function formateurCourses()
    {
        return Cours::where('formateur_id', auth()->id())
            ->with('chapitres:id,cours_id,title')
            ->orderBy('title')
            ->get();
    }

    #[Computed]
    public function selectedQuizStats()
    {
        if (! $this->selectedQuiz) {
            return [
                'attempts_count' => 0,
                'students_count' => 0,
                'average_score' => 0,
                'success_rate' => 0,
                'hardest_question' => null,
            ];
        }

        $attempts = QuizAttempt::where('quiz_id', $this->selectedQuiz->id)
            ->whereIn('status', ['completed', 'graded'])
            ->get();

        $studentsCount = $attempts->pluck('user_id')->unique()->count();
        $avgScore = (float) ($attempts->avg('score_percent') ?? 0);
        $successRate = $attempts->count() > 0
            ? round(($attempts->where('score_percent', '>=', $this->selectedQuiz->passing_score)->count() / $attempts->count()) * 100)
            : 0;

        $hardestQuestion = null;
        $questionMap = [];

        foreach ($attempts as $attempt) {
            $answers = $attempt->answers ?? [];
            foreach ($this->selectedQuiz->questions as $question) {
                $qid = $question->id;
                $questionMap[$qid] ??= ['question' => $question, 'total' => 0, 'wrong' => 0];

                if (! array_key_exists($qid, $answers)) {
                    continue;
                }

                $questionMap[$qid]['total']++;

                $givenAnswerId = $answers[$qid];
                $questionType = $this->supportsQuestionType() ? ($question->question_type ?? 'qcm') : 'qcm';
                if ($questionType === 'texte') {
                    continue;
                }

                $correct = $question->answers->firstWhere('is_correct', true);
                if (! $correct || (int) $correct->id !== (int) $givenAnswerId) {
                    $questionMap[$qid]['wrong']++;
                }
            }
        }

        $worstRate = -1;
        foreach ($questionMap as $row) {
            if ($row['total'] === 0) {
                continue;
            }
            $wrongRate = round(($row['wrong'] / $row['total']) * 100);
            if ($wrongRate > $worstRate) {
                $worstRate = $wrongRate;
                $hardestQuestion = [
                    'content' => $row['question']->content,
                    'wrong_rate' => $wrongRate,
                ];
            }
        }

        return [
            'attempts_count' => $attempts->count(),
            'students_count' => $studentsCount,
            'average_score' => round($avgScore),
            'success_rate' => $successRate,
            'hardest_question' => $hardestQuestion,
        ];
    }

    #[Computed]
    public function selectedQuizResults()
    {
        if (! $this->selectedQuiz) {
            return collect();
        }

        return QuizAttempt::where('quiz_id', $this->selectedQuiz->id)
            ->with('user')
            ->orderByDesc('completed_at')
            ->orderByDesc('id')
            ->limit(25)
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
            $newScore = max(0, min(100, (int) $this->correctionScore));
            $totalPoints = max(1, (int) $this->selectedSubmission->total_points);
            $convertedScore = (int) round(($newScore / 100) * $totalPoints);

            $this->selectedSubmission->update([
                'score' => $convertedScore,
                'status' => 'graded',
                'grader_comment' => $this->correctionComment,
                'is_graded' => true,
                'graded_at' => now(),
            ]);

            session()->flash('success', '✅ Correction envoyée ! Note : '.$newScore.'/100');
            $this->closeCorrection();
        }
    }

    public function openCreateQuiz()
    {
        $this->resetCreateForm();
        $this->createQuizModalOpen = true;
    }

    public function closeCreateQuiz()
    {
        $this->createQuizModalOpen = false;
        $this->resetCreateForm();
    }

    public function updateFilter($newFilter)
    {
        $this->filter = $newFilter;
        $this->resetPage();
    }

    public function addQuestionDraft()
    {
        $nextOrder = count($this->questionsDraft) + 1;
        $this->questionsDraft[] = [
            'content' => '',
            'question_type' => 'qcm',
            'points' => 1,
            'answers' => [
                ['content' => '', 'is_correct' => true],
                ['content' => '', 'is_correct' => false],
            ],
            'order' => $nextOrder,
        ];
    }

    public function removeQuestionDraft($index)
    {
        if (! isset($this->questionsDraft[$index])) {
            return;
        }
        array_splice($this->questionsDraft, $index, 1);
        $this->reindexQuestionDraftOrder();
    }

    public function addAnswerDraft($questionIndex)
    {
        if (! isset($this->questionsDraft[$questionIndex])) {
            return;
        }
        $this->questionsDraft[$questionIndex]['answers'][] = ['content' => '', 'is_correct' => false];
    }

    public function removeAnswerDraft($questionIndex, $answerIndex)
    {
        if (! isset($this->questionsDraft[$questionIndex]['answers'][$answerIndex])) {
            return;
        }
        array_splice($this->questionsDraft[$questionIndex]['answers'], $answerIndex, 1);
        if (empty($this->questionsDraft[$questionIndex]['answers'])) {
            $this->questionsDraft[$questionIndex]['answers'][] = ['content' => '', 'is_correct' => true];
        }
    }

    public function setCorrectAnswerDraft($questionIndex, $answerIndex)
    {
        if (! isset($this->questionsDraft[$questionIndex]['answers'][$answerIndex])) {
            return;
        }

        foreach ($this->questionsDraft[$questionIndex]['answers'] as $idx => $answer) {
            $this->questionsDraft[$questionIndex]['answers'][$idx]['is_correct'] = $idx === (int) $answerIndex;
        }
    }

    public function updateQuestionTypeDraft($questionIndex, $type)
    {
        if (! isset($this->questionsDraft[$questionIndex])) {
            return;
        }

        $this->questionsDraft[$questionIndex]['question_type'] = $type;

        if ($type === 'texte') {
            $this->questionsDraft[$questionIndex]['answers'] = [];
        }

        if (in_array($type, ['qcm', 'vf'], true) && empty($this->questionsDraft[$questionIndex]['answers'])) {
            $this->questionsDraft[$questionIndex]['answers'] = $type === 'vf'
                ? [
                    ['content' => 'Vrai', 'is_correct' => true],
                    ['content' => 'Faux', 'is_correct' => false],
                ]
                : [
                    ['content' => '', 'is_correct' => true],
                    ['content' => '', 'is_correct' => false],
                ];
        }
    }

    public function saveQuiz()
    {
        $validated = $this->validate([
            'quizTitle' => ['required', 'string', 'max:255'],
            'quizCoursId' => ['required', 'integer'],
            'quizChapitreId' => ['nullable', 'integer'],
            'quizType' => ['required', 'in:quiz,exam,devoir'],
            'quizDuration' => ['required', 'integer', 'min:1', 'max:600'],
            'quizPassingScore' => ['required', 'integer', 'min:0', 'max:100'],
            'quizMaxAttempts' => ['required', 'integer', 'min:1', 'max:99'],
            'quizAvailableFrom' => ['nullable', 'date'],
            'quizAvailableUntil' => ['nullable', 'date', 'after:quizAvailableFrom'],
        ]);

        if (count($this->questionsDraft) === 0) {
            $this->addError('questionsDraft', 'Ajoutez au moins une question.');

            return;
        }

        foreach ($this->questionsDraft as $idx => $questionDraft) {
            if (blank(trim((string) ($questionDraft['content'] ?? '')))) {
                $this->addError('questionsDraft', 'Chaque question doit avoir un énoncé.');

                return;
            }
            $qType = $questionDraft['question_type'] ?? 'qcm';
            if (in_array($qType, ['qcm', 'vf'], true)) {
                $answers = $questionDraft['answers'] ?? [];
                if (count($answers) < 2) {
                    $this->addError('questionsDraft', 'Les questions fermées exigent au moins 2 réponses.');

                    return;
                }

                $hasCorrect = false;
                foreach ($answers as $answer) {
                    if (blank(trim((string) ($answer['content'] ?? '')))) {
                        $this->addError('questionsDraft', 'Chaque réponse doit avoir un texte.');

                        return;
                    }
                    if (($answer['is_correct'] ?? false) === true) {
                        $hasCorrect = true;
                    }
                }

                if (! $hasCorrect) {
                    $this->addError('questionsDraft', 'Sélectionnez une réponse correcte pour chaque question.');

                    return;
                }
            }
        }

        $course = Cours::where('id', $validated['quizCoursId'])
            ->where('formateur_id', auth()->id())
            ->firstOrFail();

        DB::transaction(function () use ($validated, $course) {
            $quiz = $this->editingQuizId
                ? QuizModel::where('id', $this->editingQuizId)->where('cours_id', $course->id)->firstOrFail()
                : new QuizModel;

            $payload = [
                'cours_id' => $course->id,
                'chapitre_id' => $validated['quizChapitreId'] ?: null,
                'title' => $validated['quizTitle'],
                'type' => QuizType::from($validated['quizType']),
                'duration' => $validated['quizDuration'],
                'passing_score' => $validated['quizPassingScore'],
                'max_attempts' => $validated['quizMaxAttempts'],
            ];
            if (Schema::hasColumn('quizzes', 'is_published')) {
                $payload['is_published'] = (bool) $this->quizIsPublished;
            }
            if (Schema::hasColumn('quizzes', 'random_order')) {
                $payload['random_order'] = (bool) $this->quizRandomOrder;
            }
            if (Schema::hasColumn('quizzes', 'available_from')) {
                $payload['available_from'] = $validated['quizAvailableFrom'] ? Carbon::parse($validated['quizAvailableFrom']) : null;
            }
            if (Schema::hasColumn('quizzes', 'available_until')) {
                $payload['available_until'] = $validated['quizAvailableUntil'] ? Carbon::parse($validated['quizAvailableUntil']) : null;
            }
            $quiz->fill($payload);
            $quiz->save();

            $existingQuestionIds = [];
            foreach ($this->questionsDraft as $qIndex => $draft) {
                $question = isset($draft['id'])
                    ? Question::where('id', $draft['id'])->where('quiz_id', $quiz->id)->first()
                    : null;

                if (! $question) {
                    $question = new Question;
                    $question->quiz_id = $quiz->id;
                }

                $question->content = trim((string) $draft['content']);
                if ($this->supportsQuestionType()) {
                    $question->question_type = $draft['question_type'] ?? 'qcm';
                }
                $question->points = max(1, (int) ($draft['points'] ?? 1));
                $question->order = $qIndex + 1;
                $question->save();

                $existingQuestionIds[] = $question->id;

                $qType = $this->supportsQuestionType() ? ($question->question_type ?? 'qcm') : 'qcm';
                if ($qType === 'texte') {
                    $question->answers()->delete();
                    continue;
                }

                $existingAnswerIds = [];
                foreach ($draft['answers'] ?? [] as $aIndex => $answerDraft) {
                    $answer = isset($answerDraft['id'])
                        ? $question->answers()->where('id', $answerDraft['id'])->first()
                        : $question->answers()->newModelInstance();

                    $answer->question_id = $question->id;
                    $answer->content = trim((string) $answerDraft['content']);
                    $answer->is_correct = (bool) ($answerDraft['is_correct'] ?? false);
                    $answer->order = $aIndex + 1;
                    $answer->save();
                    $existingAnswerIds[] = $answer->id;
                }

                $question->answers()->whereNotIn('id', $existingAnswerIds)->delete();
            }

            $quiz->questions()->whereNotIn('id', $existingQuestionIds)->delete();

            if (Schema::hasColumn('quizzes', 'is_published') && $quiz->is_published) {
                $this->notifyStudentsForPublishedQuiz($quiz);
            }

            if (Schema::hasColumn('quizzes', 'available_from') && $quiz->type === QuizType::Exam && $quiz->available_from) {
                $this->scheduleExamEvent($quiz);
            }
        });

        session()->flash('success', $this->editingQuizId ? '✅ Quiz mis à jour.' : '✅ Quiz créé avec succès.');
        $this->closeCreateQuiz();
        $this->resetPage();
    }

    public function editQuiz($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId);
        $this->editingQuizId = $quiz->id;
        $this->quizTitle = $quiz->title;
        $this->quizCoursId = (string) $quiz->cours_id;
        $this->quizChapitreId = $quiz->chapitre_id ? (string) $quiz->chapitre_id : '';
        $this->quizType = $quiz->type->value;
        $this->quizDuration = (int) $quiz->duration;
        $this->quizPassingScore = (int) $quiz->passing_score;
        $this->quizMaxAttempts = (int) $quiz->max_attempts;
        $this->quizRandomOrder = Schema::hasColumn('quizzes', 'random_order') ? (bool) ($quiz->random_order ?? false) : false;
        $this->quizIsPublished = Schema::hasColumn('quizzes', 'is_published') ? (bool) ($quiz->is_published ?? false) : false;
        $this->quizAvailableFrom = Schema::hasColumn('quizzes', 'available_from') ? optional($quiz->available_from)->format('Y-m-d\TH:i') : '';
        $this->quizAvailableUntil = Schema::hasColumn('quizzes', 'available_until') ? optional($quiz->available_until)->format('Y-m-d\TH:i') : '';

        $this->questionsDraft = $quiz->questions()->with('answers')->orderBy('order')->get()->map(function ($question) {
            return [
                'id' => $question->id,
                'content' => $question->content,
                'question_type' => $question->question_type ?? 'qcm',
                'points' => $question->points,
                'order' => $question->order,
                'answers' => $question->answers->map(fn ($answer) => [
                    'id' => $answer->id,
                    'content' => $answer->content,
                    'is_correct' => (bool) $answer->is_correct,
                ])->values()->all(),
            ];
        })->values()->all();

        $this->createQuizModalOpen = true;
    }

    public function duplicateQuiz($quizId)
    {
        $source = $this->resolveOwnedQuiz($quizId, true);

        DB::transaction(function () use ($source) {
            $copy = $source->replicate([
                'is_published',
                'available_from',
                'available_until',
            ]);
            $copy->title = $source->title.' (Copie)';
            if (Schema::hasColumn('quizzes', 'is_published')) {
                $copy->is_published = false;
            }
            if (Schema::hasColumn('quizzes', 'available_from')) {
                $copy->available_from = null;
            }
            if (Schema::hasColumn('quizzes', 'available_until')) {
                $copy->available_until = null;
            }
            $copy->save();

            foreach ($source->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->quiz_id = $copy->id;
                $newQuestion->save();

                foreach ($question->answers as $answer) {
                    $newAnswer = $answer->replicate();
                    $newAnswer->question_id = $newQuestion->id;
                    $newAnswer->save();
                }
            }
        });

        session()->flash('success', '📄 Quiz dupliqué en brouillon.');
    }

    public function deleteQuiz($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId);
        $title = $quiz->title;
        $quiz->delete();

        session()->flash('success', '🗑️ Quiz supprimé : '.$title);
    }

    public function showResults($quizId)
    {
        $this->selectedQuiz = $this->resolveOwnedQuiz($quizId, true);
        $this->showQuizDetails = true;
    }

    public function closeResults()
    {
        $this->selectedQuiz = null;
        $this->showQuizDetails = false;
    }

    public function publishQuiz($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId);
        if (! Schema::hasColumn('quizzes', 'is_published')) {
            session()->flash('success', 'ℹ️ Mettez à jour la base (migrate) pour publier les quiz.');

            return;
        }
        $quiz->update(['is_published' => true]);
        $this->notifyStudentsForPublishedQuiz($quiz->fresh('cours'));
        if (Schema::hasColumn('quizzes', 'available_from') && $quiz->type === QuizType::Exam && $quiz->available_from) {
            $this->scheduleExamEvent($quiz->fresh());
        }
        session()->flash('success', '🚀 Quiz publié et étudiants notifiés.');
    }

    public function unpublishQuiz($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId);
        if (! Schema::hasColumn('quizzes', 'is_published')) {
            session()->flash('success', 'ℹ️ Mettez à jour la base (migrate) pour dépublier les quiz.');

            return;
        }
        $quiz->update(['is_published' => false]);
        session()->flash('success', '⏸️ Quiz dépublié.');
    }

    public function exportResultsCsv($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId, true);
        $rows = [];
        $rows[] = ['Etudiant', 'Email', 'Tentative', 'Score (%)', 'Statut', 'Date'];
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)->with('user')->orderByDesc('completed_at')->get();
        foreach ($attempts as $attempt) {
            $rows[] = [
                $attempt->user->name ?? 'Étudiant',
                $attempt->user->email ?? '',
                (string) $attempt->id,
                (string) $attempt->score_percent,
                $attempt->status,
                optional($attempt->completed_at ?? $attempt->created_at)->format('Y-m-d H:i'),
            ];
        }

        $lines = collect($rows)->map(function ($row) {
            return collect($row)->map(function ($value) {
                $escaped = str_replace('"', '""', (string) $value);

                return '"'.$escaped.'"';
            })->implode(',');
        })->implode("\n");

        $filename = 'quiz-'.$quiz->id.'-resultats.csv';
        $dir = storage_path('app/exports');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($dir.DIRECTORY_SEPARATOR.$filename, $lines);

        return response()->download($dir.DIRECTORY_SEPARATOR.$filename)->deleteFileAfterSend(true);
    }

    public function exportResultsPdf($quizId)
    {
        $quiz = $this->resolveOwnedQuiz($quizId, true);
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)->with('user')->orderByDesc('completed_at')->get();
        $stats = $this->selectedQuiz && $this->selectedQuiz->id === $quiz->id ? $this->selectedQuizStats : null;

        $pdf = Pdf::loadView('pdf.quiz-results', [
            'quiz' => $quiz,
            'attempts' => $attempts,
            'stats' => $stats,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'quiz-'.$quiz->id.'-resultats.pdf');
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

    private function resetCreateForm(): void
    {
        $this->editingQuizId = null;
        $this->quizTitle = '';
        $this->quizCoursId = '';
        $this->quizChapitreId = '';
        $this->quizType = 'quiz';
        $this->quizDuration = 20;
        $this->quizPassingScore = 70;
        $this->quizMaxAttempts = 3;
        $this->quizRandomOrder = false;
        $this->quizIsPublished = false;
        $this->quizAvailableFrom = '';
        $this->quizAvailableUntil = '';
        $this->questionsDraft = [];
    }

    private function reindexQuestionDraftOrder(): void
    {
        foreach ($this->questionsDraft as $idx => $question) {
            $this->questionsDraft[$idx]['order'] = $idx + 1;
        }
    }

    private function resolveOwnedQuiz($quizId, $withRelations = false): QuizModel
    {
        $query = QuizModel::whereIn('cours_id', auth()->user()->cours()->pluck('id'));
        if ($withRelations) {
            $query->with('cours', 'questions.answers');
        }

        return $query->findOrFail($quizId);
    }

    private function notifyStudentsForPublishedQuiz(QuizModel $quiz): void
    {
        $studentIds = DB::table('inscriptions')
            ->where('cours_id', $quiz->cours_id)
            ->pluck('etudiant_id')
            ->unique()
            ->values();

        if ($studentIds->isEmpty()) {
            return;
        }

        $message = 'Nouveau '.($quiz->type->value === 'exam' ? 'examen' : 'quiz').': "'.$quiz->title.'" est publié.';
        foreach ($studentIds as $studentId) {
            DirectMessage::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $studentId,
                'content' => $message,
                'is_read' => false,
            ]);
        }
    }

    private function scheduleExamEvent(QuizModel $quiz): void
    {
        $start = $quiz->available_from;
        $end = $quiz->available_until ?? $start?->copy()->addMinutes(max(15, (int) $quiz->duration));
        if (! $start || ! $end) {
            return;
        }

        Event::updateOrCreate(
            ['quiz_id' => $quiz->id, 'event_type' => 'exam'],
            [
                'title' => 'Examen: '.$quiz->title,
                'description' => 'Examen programmé pour le cours '.$quiz->cours->title,
                'start_date' => $start,
                'end_date' => $end,
                'location' => 'En ligne',
                'cours_id' => $quiz->cours_id,
                'created_by' => auth()->id(),
            ]
        );
    }

    private function supportsQuestionType(): bool
    {
        return Schema::hasColumn('questions', 'question_type');
    }
}
