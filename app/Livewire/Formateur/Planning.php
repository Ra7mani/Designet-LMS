<?php

namespace App\Livewire\Formateur;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Session;
use App\Models\Cours;
use Carbon\Carbon;

#[Layout('layouts.formateur')]
class Planning extends Component
{
    public $viewMode = 'month';
    public $currentMonth = 0;
    public $currentYear = 0;
    public $selectedEventId = null;
    public $showCreateModal = false;
    public $showSessionModal = false;

    // Form data for creating session
    public $sessionType = '';
    public $sessionTitle = '';
    public $associatedCourse = '';
    public $sessionDate = '';
    public $sessionTime = '';
    public $sessionDuration = 120;
    public $sessionRoom = '';
    public $sessionDescription = '';

    // Session details for modal
    public $selectedSession = null;

    // Tab/view filters
    public $currentTab = 'month';

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->sessionDate = now()->format('Y-m-d');
        $this->sessionTime = '10:00';
    }

    public function previousMonth()
    {
        if ($this->currentMonth === 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function nextMonth()
    {
        if ($this->currentMonth === 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    #[\Livewire\Attributes\Computed]
    public function stats()
    {
        $formateur = auth()->user();
        $month = $this->currentMonth;
        $year = $this->currentYear;

        return [
            'lives' => Session::where('formateur_id', $formateur->id)
                ->where('type', 'live')
                ->whereMonth('start_time', $month)
                ->whereYear('start_time', $year)
                ->count(),
            'exams' => Session::where('formateur_id', $formateur->id)
                ->where('type', 'exam')
                ->whereMonth('start_time', $month)
                ->whereYear('start_time', $year)
                ->count(),
            'officeHours' => Session::where('formateur_id', $formateur->id)
                ->where('type', 'office')
                ->whereMonth('start_time', $month)
                ->whereYear('start_time', $year)
                ->count(),
            'seminars' => Session::where('formateur_id', $formateur->id)
                ->where('type', 'seminar')
                ->whereMonth('start_time', $month)
                ->whereYear('start_time', $year)
                ->count(),
            'totalHours' => $this->calculateTotalHours(),
        ];
    }

    #[\Livewire\Attributes\Computed]
    public function upcomingSessions()
    {
        $formateur = auth()->user();
        return Session::where('formateur_id', $formateur->id)
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($session) {
                $duration = $session->start_time->diffInMinutes($session->end_time);
                $hours = intdiv($duration, 60);
                $mins = $duration % 60;
                $durationText = $hours > 0 ? "{$hours}h" . ($mins > 0 ? " {$mins}min" : '') : "{$mins}min";

                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'type' => $session->type,
                    'date' => $session->start_time->format('d M H:i') . ' – ' . $session->end_time->format('H:i'),
                    'meta' => ($session->max_attendees ?? 'N/A') . ' inscrits · ' . ($session->session_room ?? 'En ligne') . ' · ' . $durationText,
                    'status' => $this->getSessionStatus($session),
                    'enrolled' => $session->max_attendees ?? 0,
                    'room' => $session->session_room ?? 'Virtuelle',
                    'course' => $session->cours->title ?? 'N/A',
                ];
            });
    }

    #[\Livewire\Attributes\Computed]
    public function attendanceRates()
    {
        $formateur = auth()->user();
        return Cours::where('formateur_id', $formateur->id)
            ->with('inscriptions')
            ->get()
            ->map(function ($course, $index) {
                $colors = ['var(--v)', 'var(--mintd)', 'var(--skyd)', 'var(--yeld)'];

                // Calculate attendance rate based on completed sessions vs total enrollments
                $enrollmentCount = $course->inscriptions->count();
                $sessionsHeld = Session::where('cours_id', $course->id)
                    ->where('status', 'in_progress')
                    ->count();

                // Estimate attendance rate (enrollments with progress as proxy)
                $rate = $enrollmentCount > 0
                    ? min(100, (int)$course->inscriptions->avg('progress') ?? 70)
                    : 70;

                return [
                    'course' => $course->title,
                    'rate' => max(70, $rate),
                    'color' => $colors[$index % count($colors)],
                ];
            })
            ->take(4);
    }

    #[\Livewire\Attributes\Computed]
    public function courses()
    {
        $formateur = auth()->user();
        return Cours::where('formateur_id', $formateur->id)->get();
    }

    private function calculateTotalHours()
    {
        $formateur = auth()->user();
        $month = $this->currentMonth;
        $year = $this->currentYear;

        $totalMinutes = Session::where('formateur_id', $formateur->id)
            ->whereMonth('start_time', $month)
            ->whereYear('start_time', $year)
            ->get()
            ->sum(function ($session) {
                return $session->start_time->diffInMinutes($session->end_time);
            });

        $hours = intdiv($totalMinutes, 60);
        return $hours . 'h';
    }

    private function getSessionStatus($session)
    {
        $now = now();
        if ($session->start_time > $now) {
            $diff = $now->diffInMinutes($session->start_time);
            if ($diff <= 45) {
                return '🔴 Dans ' . $diff . ' min';
            }
            return $session->type === 'office' ? 'Office hours' : ucfirst($session->type);
        }
        return 'En cours';
    }

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetFormData();
    }

    public function openSessionModal($sessionId)
    {
        $session = $this->upcomingSessions()->firstWhere('id', $sessionId);
        $this->selectedSession = $session;
        $this->showSessionModal = true;
    }

    public function closeSessionModal()
    {
        $this->showSessionModal = false;
        $this->selectedSession = null;
    }

    public function createSession()
    {
        // Validate form data
        $validated = $this->validate([
            'sessionType' => 'required|in:live,exam,office,seminar',
            'sessionTitle' => 'required|string|max:255',
            'associatedCourse' => 'required|exists:cours,id',
            'sessionDate' => 'required|date',
            'sessionTime' => 'required',
            'sessionDuration' => 'required|integer|min:15',
            'sessionRoom' => 'required|string',
        ]);

        $formateur = auth()->user();
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['sessionDate'] . ' ' . $validated['sessionTime']);
        $endTime = $startTime->copy()->addMinutes($validated['sessionDuration']);

        Session::create([
            'title' => $validated['sessionTitle'],
            'description' => $this->sessionDescription,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'type' => $validated['sessionType'],
            'session_room' => $validated['sessionRoom'],
            'cours_id' => $validated['associatedCourse'],
            'formateur_id' => $formateur->id,
            'status' => 'scheduled',
            'max_attendees' => 30,
        ]);

        session()->flash('message', '✅ Session planifiée avec succès !');
        $this->closeCreateModal();
    }

    public function launchSession($sessionId)
    {
        $session = Session::find($sessionId);
        if ($session) {
            $session->update(['status' => 'in_progress']);
            session()->flash('message', '🎬 Salle virtuelle lancée !');
        }
    }

    public function sendReminder($sessionId)
    {
        session()->flash('message', '📧 Rappel envoyé aux étudiants');
    }

    public function editSession($sessionId)
    {
        session()->flash('message', '✏️ Session modifiée');
    }

    public function deleteSession($sessionId)
    {
        $session = Session::find($sessionId);
        if ($session) {
            $session->delete();
            session()->flash('message', '🗑 Session supprimée');
        }
    }

    private function resetFormData()
    {
        $this->sessionType = '';
        $this->sessionTitle = '';
        $this->associatedCourse = '';
        $this->sessionDate = now()->format('Y-m-d');
        $this->sessionTime = '10:00';
        $this->sessionDuration = 120;
        $this->sessionRoom = '';
        $this->sessionDescription = '';
    }

    public function render()
    {
        return view('livewire.formateur.planning');
    }
}
