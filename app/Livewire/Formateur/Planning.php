<?php

namespace App\Livewire\Formateur;

use App\Models\Cours;
use App\Models\Session;
use App\Notifications\SessionReminderNotification;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

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

    public $virtualRoomLink = '';

    public $sessionDescription = '';

    // Session details for modal
    public $selectedSession = null;

    // Tab/view filters
    public $currentTab = 'month';

    public $attendeeSearch = '';

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

    #[Computed]
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

    #[Computed]
    public function upcomingSessions()
    {
        $formateur = auth()->user();

        return Session::where('formateur_id', $formateur->id)
            ->with('cours.inscriptions')
            ->where('end_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($session) {
                $duration = $session->start_time->diffInMinutes($session->end_time);
                $hours = intdiv($duration, 60);
                $mins = $duration % 60;
                $durationText = $hours > 0 ? "{$hours}h".($mins > 0 ? " {$mins}min" : '') : "{$mins}min";
                $attendeesCount = $this->countAttendees($session);

                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'type' => $session->type,
                    'date' => $session->start_time->format('d M H:i').' – '.$session->end_time->format('H:i'),
                    'meta' => $attendeesCount.' inscrits · '.($session->session_room ?? 'En ligne').' · '.$durationText,
                    'status' => $this->getSessionStatus($session),
                    'enrolled' => $attendeesCount,
                    'room' => $session->session_room ?? 'Virtuelle',
                    'link' => $session->virtual_room_link,
                    'course' => $session->cours->title ?? 'N/A',
                    'description' => $session->description,
                ];
            });
    }

    #[Computed]
    public function weekSessions()
    {
        $formateur = auth()->user();
        $start = now()->startOfWeek();
        $end = now()->endOfWeek();

        return Session::where('formateur_id', $formateur->id)
            ->with('cours.inscriptions')
            ->whereBetween('start_time', [$start, $end])
            ->orderBy('start_time')
            ->get()
            ->map(fn ($session) => $this->formatSession($session));
    }

    #[Computed]
    public function listSessions()
    {
        $formateur = auth()->user();

        return Session::where('formateur_id', $formateur->id)
            ->with('cours.inscriptions')
            ->orderBy('start_time')
            ->get()
            ->map(fn ($session) => $this->formatSession($session));
    }

    #[Computed]
    public function monthEventsByDay()
    {
        $formateur = auth()->user();

        return Session::where('formateur_id', $formateur->id)
            ->whereMonth('start_time', $this->currentMonth)
            ->whereYear('start_time', $this->currentYear)
            ->get()
            ->groupBy(fn ($session) => $session->start_time->day)
            ->map(function ($sessions) {
                $priority = ['exam', 'live', 'office', 'seminar'];
                $type = collect($priority)->first(fn ($candidate) => $sessions->contains(fn ($s) => $s->type === $candidate)) ?? 'live';

                return [
                    'type' => $type,
                    'count' => $sessions->count(),
                ];
            })
            ->toArray();
    }

    #[Computed]
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
                    ? min(100, (int) $course->inscriptions->avg('progress') ?? 70)
                    : 70;

                return [
                    'course' => $course->title,
                    'rate' => max(70, $rate),
                    'color' => $colors[$index % count($colors)],
                ];
            })
            ->take(4);
    }

    #[Computed]
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

        return $hours.'h';
    }

    private function getSessionStatus($session)
    {
        $now = now();
        if ($session->start_time > $now) {
            $diff = $now->diffInMinutes($session->start_time);
            if ($diff <= 45) {
                return '🔴 Dans '.$diff.' min';
            }

            return $session->type === 'office' ? 'Office hours' : ucfirst($session->type);
        }

        if ($session->end_time >= $now) {
            return '🔴 En direct maintenant';
        }

        return 'Terminé';
    }

    public function switchTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function openCreateModal()
    {
        $this->selectedEventId = null;
        $this->resetFormData();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetFormData();
    }

    public function openSessionModal($sessionId)
    {
        $session = Session::with('cours.inscriptions.etudiant')->find($sessionId);
        if (! $session || $session->formateur_id !== auth()->id()) {
            return;
        }

        $this->selectedSession = [
            'id' => $session->id,
            'title' => $session->title,
            'description' => $session->description,
            'date' => $session->start_time->format('d M Y H:i').' – '.$session->end_time->format('H:i'),
            'course' => $session->cours->title ?? 'N/A',
            'room' => $session->session_room ?? 'Virtuelle',
            'link' => $session->virtual_room_link,
            'status' => $this->getSessionStatus($session),
            'attendees' => $this->countAttendees($session),
            'attendee_list' => $this->attendeeList($session),
        ];
        $this->showSessionModal = true;
    }

    public function closeSessionModal()
    {
        $this->showSessionModal = false;
        $this->selectedSession = null;
    }

    public function createSession()
    {
        $validated = $this->validate([
            'sessionType' => 'required|in:live,exam,office,seminar',
            'sessionTitle' => 'required|string|max:255',
            'associatedCourse' => 'required|exists:cours,id',
            'sessionDate' => 'required|date',
            'sessionTime' => 'required',
            'sessionDuration' => 'required|integer|min:15',
            'sessionRoom' => 'required|string|max:255',
            'virtualRoomLink' => 'nullable|url|max:2048',
            'sessionDescription' => 'nullable|string|max:5000',
        ]);

        $formateur = auth()->user();
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['sessionDate'].' '.$validated['sessionTime']);
        $endTime = $startTime->copy()->addMinutes($validated['sessionDuration']);

        $payload = [
            'title' => $validated['sessionTitle'],
            'description' => $validated['sessionDescription'] ? trim($validated['sessionDescription']) : null,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'type' => $validated['sessionType'],
            'session_room' => $validated['sessionRoom'],
            'cours_id' => $validated['associatedCourse'],
            'formateur_id' => $formateur->id,
            'status' => 'scheduled',
            'max_attendees' => 30,
            'virtual_room_link' => $validated['virtualRoomLink'] ?? null,
        ];

        if ($this->selectedEventId) {
            $session = Session::find($this->selectedEventId);
            if ($session && $session->formateur_id === $formateur->id) {
                $session->update($payload);
                session()->flash('message', '✏️ Session modifiée avec succès');
            }
        } else {
            Session::create($payload);
            session()->flash('message', '✅ Session planifiée avec succès !');
        }

        $this->closeCreateModal();
    }

    public function launchSession($sessionId)
    {
        if (! $sessionId) {
            return;
        }

        $session = Session::find($sessionId);
        if (! $session || $session->formateur_id !== auth()->id()) {
            session()->flash('message', '❌ Session introuvable');

            return;
        }

        if (! $session->virtual_room_link) {
            $slug = Str::slug($session->title ?: 'session-'.$session->id);
            $session->virtual_room_link = 'https://meet.google.com/'.$slug.'-'.$session->id;
        }

        $session->status = 'in_progress';
        $session->save();

        return redirect()->away($session->virtual_room_link);
    }

    public function sendReminder($sessionId)
    {
        $session = Session::with('cours.inscriptions.etudiant')->find($sessionId);
        if (! $session || $session->formateur_id !== auth()->id()) {
            session()->flash('message', '❌ Session introuvable');

            return;
        }

        $excluded = collect($session->excluded_attendee_ids ?? []);
        $notified = 0;

        foreach ($session->cours->inscriptions as $inscription) {
            if (! $inscription->etudiant || $excluded->contains($inscription->etudiant_id)) {
                continue;
            }

            $inscription->etudiant->notify(new SessionReminderNotification($session));
            $notified++;
        }

        session()->flash('message', '📧 Rappel envoyé à '.$notified.' inscrits');
    }

    public function editSession($sessionId)
    {
        $session = Session::find($sessionId);
        if (! $session || $session->formateur_id !== auth()->id()) {
            session()->flash('message', '❌ Session introuvable');

            return;
        }

        $this->selectedEventId = $session->id;
        $this->sessionType = $session->type;
        $this->sessionTitle = $session->title;
        $this->associatedCourse = (string) $session->cours_id;
        $this->sessionDate = $session->start_time->format('Y-m-d');
        $this->sessionTime = $session->start_time->format('H:i');
        $this->sessionDuration = $session->start_time->diffInMinutes($session->end_time);
        $this->sessionRoom = $session->session_room ?? '';
        $this->virtualRoomLink = $session->virtual_room_link ?? '';
        $this->sessionDescription = $session->description ?? '';
        $this->showCreateModal = true;
    }

    public function deleteSession($sessionId)
    {
        $session = Session::find($sessionId);
        if ($session && $session->formateur_id === auth()->id()) {
            $session->delete();
            session()->flash('message', '🗑 Session supprimée');
        }
    }

    public function toggleAttendee($sessionId, $studentId)
    {
        $session = Session::with('cours.inscriptions')->find($sessionId);
        if (! $session || $session->formateur_id !== auth()->id()) {
            return;
        }

        $isStudentInCourse = $session->cours->inscriptions->contains(fn ($insc) => (int) $insc->etudiant_id === (int) $studentId);
        if (! $isStudentInCourse) {
            return;
        }

        $excluded = collect($session->excluded_attendee_ids ?? [])->map(fn ($id) => (int) $id);
        if ($excluded->contains((int) $studentId)) {
            $excluded = $excluded->reject(fn ($id) => $id === (int) $studentId)->values();
        } else {
            $excluded->push((int) $studentId);
        }

        $session->update(['excluded_attendee_ids' => $excluded->values()->all()]);
        $this->openSessionModal($sessionId);
    }

    private function resetFormData()
    {
        $this->selectedEventId = null;
        $this->sessionType = '';
        $this->sessionTitle = '';
        $this->associatedCourse = '';
        $this->sessionDate = now()->format('Y-m-d');
        $this->sessionTime = '10:00';
        $this->sessionDuration = 120;
        $this->sessionRoom = '';
        $this->virtualRoomLink = '';
        $this->sessionDescription = '';
    }

    private function countAttendees(Session $session): int
    {
        $total = $session->cours?->inscriptions?->count() ?? 0;
        $excluded = count($session->excluded_attendee_ids ?? []);

        return max(0, $total - $excluded);
    }

    private function attendeeList(Session $session): array
    {
        $excluded = collect($session->excluded_attendee_ids ?? [])->map(fn ($id) => (int) $id);
        $search = trim($this->attendeeSearch);

        return $session->cours?->inscriptions
            ?->filter(function ($inscription) use ($search) {
                if ($search === '') {
                    return true;
                }

                return str_contains(mb_strtolower($inscription->etudiant->name ?? ''), mb_strtolower($search));
            })
            ->map(function ($inscription) use ($excluded) {
                return [
                    'id' => (int) $inscription->etudiant_id,
                    'name' => $inscription->etudiant->name ?? 'Étudiant',
                    'email' => $inscription->etudiant->email ?? '',
                    'is_excluded' => $excluded->contains((int) $inscription->etudiant_id),
                ];
            })
            ->values()
            ->toArray() ?? [];
    }

    private function formatSession(Session $session): array
    {
        $duration = $session->start_time->diffInMinutes($session->end_time);
        $hours = intdiv($duration, 60);
        $mins = $duration % 60;
        $durationText = $hours > 0 ? "{$hours}h".($mins > 0 ? " {$mins}min" : '') : "{$mins}min";

        return [
            'id' => $session->id,
            'title' => $session->title,
            'type' => $session->type,
            'date' => $session->start_time->format('d M H:i').' – '.$session->end_time->format('H:i'),
            'meta' => $this->countAttendees($session).' inscrits · '.($session->session_room ?? 'En ligne').' · '.$durationText,
            'status' => $this->getSessionStatus($session),
            'enrolled' => $this->countAttendees($session),
            'room' => $session->session_room ?? 'Virtuelle',
            'link' => $session->virtual_room_link,
            'course' => $session->cours->title ?? 'N/A',
            'description' => $session->description,
            'start_iso' => $session->start_time->toIso8601String(),
            'end_iso' => $session->end_time->toIso8601String(),
        ];
    }

    public function render()
    {
        return view('livewire.formateur.planning');
    }
}
