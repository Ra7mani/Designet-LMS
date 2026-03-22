<?php

namespace App\Livewire\Etudiant;

use App\Models\Event;
use App\Models\Inscription;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.etudiant')]
class Planning extends Component
{
    public int $currentMonth;
    public int $currentYear;
    public ?int $selectedEventId = null;
    public string $viewMode = 'month'; // month, week, list

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    /**
     * Get user's course IDs from inscriptions
     */
    private function getUserCourseIds()
    {
        return Inscription::where('etudiant_id', auth()->id())
            ->pluck('cours_id')
            ->toArray();
    }

    #[Computed]
    public function todayEvents()
    {
        $courseIds = $this->getUserCourseIds();

        return Event::whereIn('cours_id', $courseIds)
            ->whereBetween('start_date', [
                now()->startOfDay(),
                now()->endOfDay()
            ])
            ->orderBy('start_date')
            ->get();
    }

    #[Computed]
    public function thisWeekEvents()
    {
        $courseIds = $this->getUserCourseIds();
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        return Event::whereIn('cours_id', $courseIds)
            ->whereBetween('start_date', [$weekStart, $weekEnd])
            ->where(function ($query) {
                $query->where('start_date', '<', now()->startOfDay())
                      ->orWhere('start_date', '>', now()->endOfDay());
            })
            ->orderBy('start_date')
            ->get();
    }

    #[Computed]
    public function calendarDays()
    {
        $courseIds = $this->getUserCourseIds();
        $first = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $first->daysInMonth;
        $firstDayOfWeek = $first->dayOfWeek;
        $offset = $firstDayOfWeek === 0 ? 6 : $firstDayOfWeek - 1;

        $days = [];
        $dayCounter = 1;
        $today = now();

        // Get all events for this month (filtered by user's courses)
        $monthStart = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfDay();
        $monthEnd = Carbon::create($this->currentYear, $this->currentMonth, $daysInMonth)->endOfDay();
        $monthEvents = Event::whereIn('cours_id', $courseIds)
            ->whereBetween('start_date', [$monthStart, $monthEnd])
            ->get();

        // Previous month days
        $prevMonth = $first->copy()->subMonth();
        $prevMonthDays = $prevMonth->daysInMonth;
        for ($i = $offset; $i > 0; $i--) {
            $days[] = [
                'day' => $prevMonthDays - $i + 1,
                'isCurrentMonth' => false,
                'hasEvents' => false,
                'eventType' => null,
                'date' => null,
                'events' => [],
            ];
        }

        // Current month days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);

            // Get events for this day
            $dayEvents = $monthEvents->filter(fn($e) => $e->start_date->toDateString() === $date->toDateString());
            $eventTypes = $dayEvents->pluck('event_type')->unique()->toArray();

            // Determine primary event type (priority: exam > session > course)
            $eventType = null;
            if (in_array('exam', $eventTypes)) {
                $eventType = 'exam';
            } elseif (in_array('session', $eventTypes)) {
                $eventType = 'session';
            } elseif (in_array('course', $eventTypes)) {
                $eventType = 'course';
            }

            $days[] = [
                'day' => $day,
                'isCurrentMonth' => true,
                'isToday' => $date->toDateString() === $today->toDateString(),
                'hasEvents' => $dayEvents->isNotEmpty(),
                'eventType' => $eventType,
                'date' => $date->toDateString(),
                'events' => $dayEvents->sortBy('start_date')->take(2)->values(),
            ];
            $dayCounter++;
        }

        // Next month days
        $remainingDays = 42 - count($days);
        for ($i = 1; $i <= $remainingDays; $i++) {
            $days[] = [
                'day' => $i,
                'isCurrentMonth' => false,
                'hasEvents' => false,
                'eventType' => null,
                'date' => null,
                'events' => [],
            ];
        }

        return $days;
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

    public function switchView($mode)
    {
        $this->viewMode = $mode;
    }

    public function selectEvent($eventId)
    {
        $this->selectedEventId = $eventId;
    }

    public function closeEventModal()
    {
        $this->selectedEventId = null;
    }

    #[Computed]
    public function selectedEvent()
    {
        if (!$this->selectedEventId) {
            return null;
        }

        return Event::with(['session', 'quiz', 'cours', 'creator'])->find($this->selectedEventId);
    }

    #[Computed]
    public function upcomingExams()
    {
        $courseIds = $this->getUserCourseIds();

        return Event::whereIn('cours_id', $courseIds)
            ->where('event_type', 'exam')
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->first();
    }

    public function formatTimeRemaining($date)
    {
        $now = now();
        $diff = $date->diff($now);

        if ($date < $now) {
            return null; // Past event
        }

        // If more than 1 day remaining
        if ($diff->days > 0) {
            return sprintf('%d jour%s', $diff->days, $diff->days > 1 ? 's' : '');
        }

        // Less than 1 day - show hours and minutes
        $hours = $diff->h;
        $minutes = $diff->i;

        if ($hours > 0 && $minutes > 0) {
            return sprintf('%dh %dmin', $hours, $minutes);
        } elseif ($hours > 0) {
            return sprintf('%dh', $hours);
        } else {
            return sprintf('%dmin', $minutes);
        }
    }

    #[Computed]
    public function allUpcomingEvents()
    {
        $courseIds = $this->getUserCourseIds();

        return Event::whereIn('cours_id', $courseIds)
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->take(20)
            ->get();
    }

    #[Computed]
    public function statistics()
    {
        $courseIds = $this->getUserCourseIds();
        $today = now()->toDateString();
        $today_end = now()->endOfDay();

        return [
            'live_sessions' => Event::whereIn('cours_id', $courseIds)
                ->where('event_type', 'session')
                ->whereBetween('start_date', [now()->subHours(2), $today_end])
                ->count(),
            'exams' => Event::whereIn('cours_id', $courseIds)
                ->where('event_type', 'exam')
                ->where('start_date', '>', now())
                ->count(),
            'webinars' => Event::whereIn('cours_id', $courseIds)
                ->where('event_type', 'course')
                ->where('start_date', '>', now())
                ->count(),
            'planned_hours' => Event::whereIn('cours_id', $courseIds)
                ->where('start_date', '>=', now()->startOfMonth())
                ->where('start_date', '<=', now()->endOfMonth())
                ->get()
                ->sum(fn($e) => $e->start_date->diffInHours($e->end_date))
        ];
    }

    public function render()
    {
        return view('livewire.etudiant.planning');
    }
}

