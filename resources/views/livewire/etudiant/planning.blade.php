<div>
<style>
/* HEADER & TABS */
.plan-hdr {
  position: sticky;
  top: 0;
  z-index: 40;
  background: rgba(245, 243, 255, 0.95);
  backdrop-filter: blur(14px);
  border-bottom: 1.5px solid var(--border);
  padding: 20px 30px;
}

.plan-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.plan-title h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 800;
  color: var(--txt);
}

.plan-tabs {
  display: flex;
  gap: 8px;
  border-bottom: 1.5px solid var(--border);
  padding-bottom: 12px;
}

.plan-tab {
  padding: 8px 16px;
  border: none;
  background: transparent;
  font-size: 13px;
  font-weight: 600;
  color: var(--muted);
  cursor: pointer;
  border-bottom: 2px solid transparent;
  transition: all 0.2s;
  position: relative;
  margin-bottom: -14px;
}

.plan-tab:hover {
  color: var(--txt);
}

.plan-tab.active {
  color: var(--v);
  border-bottom-color: var(--v);
}

/* EXAM BANNER */
.exam-banner {
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  color: #fff;
  padding: 14px 24px;
  border-radius: var(--r);
  margin: 16px 30px 0;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 13px;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
  animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* STATS CARDS */
.stats-section {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  padding: 16px 30px 0;
  margin-bottom: 8px;
}

.stat-card {
  background: #fff;
  border: 1.5px solid var(--border);
  border-radius: var(--r);
  padding: 16px;
  text-align: center;
  box-shadow: var(--sh);
  transition: all 0.2s;
}

.stat-card:hover {
  border-color: var(--v);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.stat-value {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 800;
  color: var(--txt);
  margin-bottom: 4px;
}

.stat-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* MAIN CONTENT */
.plan-content {
  padding: 20px 30px;
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 24px;
}

/* CALENDAR CARD - LARGER */
.calendar-card {
  background: #fff;
  border-radius: var(--r);
  padding: 24px;
  border: 1.5px solid var(--border);
  box-shadow: var(--sh);
}

.cal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.cal-title {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: var(--txt);
}

.cal-nav {
  display: flex;
  gap: 8px;
}

.cal-nav-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1.5px solid var(--border);
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 14px;
}

.cal-nav-btn:hover {
  background: var(--vxl);
  border-color: var(--vl);
}

.cal-nav-btn svg {
  width: 16px;
  height: 16px;
  stroke: var(--muted);
}

/* CALENDAR GRID - ENLARGED */
.cal-days-header {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 8px;
  margin-bottom: 12px;
}

.cal-dh {
  text-align: center;
  font-size: 12px;
  font-weight: 800;
  color: var(--muted);
  padding: 10px 0;
}

.cal-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 8px;
}

.cal-day {
  min-height: 100px;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: flex-start;
  padding: 8px;
  background: #f9f8ff;
  border: 1.5px solid var(--border);
  cursor: pointer;
  transition: all 0.2s;
  position: relative;
  overflow: hidden;
}

.cal-day:hover {
  background: var(--vxl);
  border-color: var(--v);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.cal-day.today {
  background: linear-gradient(135deg, var(--v) 0%, #7c3aed 100%);
  border-color: var(--v);
  color: #fff;
}

.cal-day.other {
  background: #f5f5f5;
  opacity: 0.4;
}

.cal-day-num {
  font-weight: 700;
  font-size: 14px;
  color: var(--txt);
  margin-bottom: 6px;
}

.cal-day.today .cal-day-num {
  color: #fff;
}

.cal-day.other .cal-day-num {
  color: var(--muted);
}

/* EVENT TITLES IN CALENDAR */
.cal-day-events {
  flex: 1;
  width: 100%;
  font-size: 10px;
  line-height: 1.3;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.cal-event-tag {
  padding: 2px 6px;
  border-radius: 3px;
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 9px;
  color: #fff;
}

.cal-event-tag.session {
  background: #8b5cf6;
}

.cal-event-tag.exam {
  background: #ef4444;
}

.cal-event-tag.course {
  background: #10b981;
}

.cal-day.today .cal-event-tag {
  opacity: 0.9;
}

/* CALENDAR LEGEND */
.cal-legend {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  padding: 16px;
  background: rgba(0, 0, 0, 0.02);
  border-radius: var(--rm);
  font-size: 12px;
  margin-top: 16px;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 8px;
}

.legend-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
}

.dot-live {
  background: #8b5cf6;
}

.dot-exam {
  background: #ef4444;
}

.dot-course {
  background: #10b981;
}

/* SIDEBAR */
.plan-sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* EVENTS CARD */
.events-card {
  background: #fff;
  border-radius: var(--r);
  padding: 20px;
  border: 1.5px solid var(--border);
  box-shadow: var(--sh);
  max-height: 650px;
  overflow-y: auto;
}

.events-title {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: var(--txt);
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.event-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
  padding: 12px;
  background: var(--bg);
  border-radius: var(--rm);
  margin-bottom: 10px;
  transition: all 0.2s;
  cursor: pointer;
  border-left: 4px solid #ccc;
}

.event-item.session {
  border-left-color: #8b5cf6;
}

.event-item.exam {
  border-left-color: #ef4444;
}

.event-item.course {
  border-left-color: #10b981;
}

.event-item:hover {
  background: var(--vxl);
  transform: translateX(2px);
}

.event-time {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 700;
  color: var(--v);
}

.event-name {
  font-size: 12px;
  font-weight: 600;
  color: var(--txt);
}

.event-details {
  font-size: 10px;
  color: var(--muted);
}

.event-status {
  font-size: 9px;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 3px;
  display: inline-block;
  color: #fff;
  width: fit-content;
}

.status-live {
  background: #ef4444;
  animation: pulse 2s infinite;
}

.status-upcoming {
  background: var(--v);
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

/* EMPTY STATE */
.empty-events {
  text-align: center;
  padding: 30px 10px;
  color: var(--muted);
  font-size: 13px;
}

.empty-events span {
  font-size: 32px;
  display: block;
  margin-bottom: 8px;
}

/* PROFESSIONAL MODAL */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 50;
  padding: 20px;
  animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.modal-content {
  background: #fff;
  border-radius: 12px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  overflow: hidden;
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-header {
  background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
  padding: 24px;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.modal-header h2 {
  color: #fff;
  font-size: 18px;
  font-weight: 700;
  margin: 0;
}

.modal-close {
  background: rgba(255, 255, 255, 0.2);
  border: none;
  color: #fff;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}

.modal-close:hover {
  background: rgba(255, 255, 255, 0.3);
}

.modal-body {
  padding: 24px;
  max-height: 60vh;
  overflow-y: auto;
}

.modal-section {
  margin-bottom: 18px;
}

.modal-section:last-child {
  margin-bottom: 0;
}

.modal-label {
  font-size: 11px;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
  display: block;
}

.modal-value {
  font-size: 14px;
  color: var(--txt);
  font-weight: 500;
}

.modal-badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 700;
  color: #fff;
  margin-top: 6px;
}

.modal-badge.session {
  background: #8b5cf6;
}

.modal-badge.exam {
  background: #ef4444;
}

.modal-badge.course {
  background: #10b981;
}

.modal-divider {
  height: 1px;
  background: var(--border);
  margin: 16px 0;
}

.modal-button {
  display: inline-block;
  width: 100%;
  padding: 12px 16px;
  background: #8b5cf6;
  color: #fff;
  text-align: center;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 10px;
  text-decoration: none;
  font-size: 14px;
  box-sizing: border-box;
  user-select: none;
  -webkit-appearance: none;
}

.modal-button:hover {
  background: #7c3aed;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

/* RESPONSIVE */
@media (max-width: 1200px) {
  .plan-content {
    grid-template-columns: 1fr;
  }
  .stats-section {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 700px) {
  .plan-hdr {
    padding: 16px;
  }
  .plan-content {
    padding: 16px;
  }
  .cal-day {
    min-height: 80px;
    padding: 6px;
  }
  .cal-grid {
    gap: 4px;
  }
  .stats-section {
    grid-template-columns: 1fr;
    padding: 16px;
  }
}
</style>

<!-- HEADER -->
<div class="plan-hdr">
  <div class="plan-title">
    <h1>📅 Planning</h1>
    
  </div>

  <!-- TABS -->
  <div class="plan-tabs">
    <button wire:click="switchView('month')" class="plan-tab @if($this->viewMode === 'month') active @endif">
      Mois
    </button>
    <button wire:click="switchView('week')" class="plan-tab @if($this->viewMode === 'week') active @endif">
      Semaine
    </button>
    <button wire:click="switchView('list')" class="plan-tab @if($this->viewMode === 'list') active @endif">
      Liste
    </button>
  </div>
</div>

<!-- EXAM BANNER -->
@if($this->upcomingExams && $this->formatTimeRemaining($this->upcomingExams->start_date))
<div class="exam-banner">
  <div>⚠️</div>
  <div>
    <strong>{{ $this->upcomingExams->title }}</strong> — Dans
    {{ $this->formatTimeRemaining($this->upcomingExams->start_date) }}!
  </div>
</div>
@endif

<!-- STATISTICS CARDS -->
@php
  $stats = $this->statistics;
@endphp
<div class="stats-section">
  <div class="stat-card">
    <div class="stat-value">{{ $stats['live_sessions'] }}</div>
    <div class="stat-label">Sessions Live</div>
  </div>
  <div class="stat-card">
    <div class="stat-value">{{ $stats['exams'] }}</div>
    <div class="stat-label">Examens</div>
  </div>
  <div class="stat-card">
    <div class="stat-value">{{ $stats['webinars'] }}</div>
    <div class="stat-label">Webinaires</div>
  </div>
  <div class="stat-card">
    <div class="stat-value">{{ $stats['planned_hours'] }}</div>
    <div class="stat-label">Heures Planifiées</div>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="plan-content">
  <!-- CALENDAR (LEFT) - ENLARGED -->
  <div class="calendar-card">
    <div class="cal-header">
      <div class="cal-title">{{ \Carbon\Carbon::create($this->currentYear, $this->currentMonth, 1)->locale('fr')->isoFormat('MMMM YYYY') }}</div>
      <div class="cal-nav">
        <button class="cal-nav-btn" wire:click="previousMonth">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="cal-nav-btn" wire:click="nextMonth">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>
    </div>

    <div class="cal-days-header">
      <span class="cal-dh">Lun</span>
      <span class="cal-dh">Mar</span>
      <span class="cal-dh">Mer</span>
      <span class="cal-dh">Jeu</span>
      <span class="cal-dh">Ven</span>
      <span class="cal-dh">Sam</span>
      <span class="cal-dh">Dim</span>
    </div>

    <div class="cal-grid">
      @foreach($this->calendarDays as $day)
        <div class="cal-day
          @if(!$day['isCurrentMonth']) other @endif
          @if($day['isToday'] ?? false) today @endif">
          <div class="cal-day-num">{{ $day['day'] }}</div>
          @if($day['hasEvents'] && count($day['events']) > 0)
            <div class="cal-day-events">
              @foreach($day['events'] as $event)
                <div class="cal-event-tag {{ $event->event_type }}" wire:click="selectEvent({{ $event->id }})">
                  {{ $event->title }}
                </div>
              @endforeach
            </div>
          @endif
        </div>
      @endforeach
    </div>

    <!-- LEGEND -->
    <div class="cal-legend">
      <div class="legend-item">
        <div class="legend-dot dot-live"></div>
        <span>Live</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot dot-exam"></div>
        <span>Examen</span>
      </div>
      <div class="legend-item">
        <div class="legend-dot dot-course"></div>
        <span>Cours</span>
      </div>
    </div>
  </div>

  <!-- SIDEBAR (RIGHT) -->
  <div class="plan-sidebar">
    <!-- TODAY'S EVENTS -->
    <div class="events-card">
      <div class="events-title">📌 Aujourd'hui - {{ now()->locale('fr')->format('d') }} {{ now()->locale('fr')->format('F') }}</div>
      @if($this->todayEvents->isEmpty())
        <div class="empty-events">
          <span>📭</span>
          Aucun événement
        </div>
      @else
        @foreach($this->todayEvents as $event)
          <div class="event-item {{ $event->event_type }}" wire:click="selectEvent({{ $event->id }})">
            <div class="event-time">{{ $event->start_date->format('H:i') }} - {{ $event->end_date->format('H:i') }}</div>
            <div class="event-name">{{ $event->title }}</div>
            @if($event->session && $event->session->formateur)
              <div class="event-details">👨‍🏫 {{ $event->session->formateur->name }}</div>
            @endif
            <span class="event-status
              @if($event->start_date < now() && $event->end_date > now()) status-live @else status-upcoming @endif">
              {{ $event->start_date < now() && $event->end_date > now() ? '🔴 EN DIRECT' : '📅 À VENIR' }}
            </span>
          </div>
        @endforeach
      @endif
    </div>

    <!-- UPCOMING EVENTS -->
    <div class="events-card">
      <div class="events-title">🗓️ À venir</div>
      @if($this->allUpcomingEvents->isEmpty())
        <div class="empty-events">
          <span>📭</span>
          Aucun événement
        </div>
      @else
        @foreach($this->allUpcomingEvents as $event)
          <div class="event-item {{ $event->event_type }}" wire:click="selectEvent({{ $event->id }})">
            <div class="event-time">{{ $event->start_date->format('H:i') }} — {{ $event->start_date->locale('fr')->format('d M') }}</div>
            <div class="event-name">{{ $event->title }}</div>
            @if($event->session && $event->session->formateur)
              <div class="event-details">{{ $event->session->formateur->name }}</div>
            @endif
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>

<!-- PROFESSIONAL EVENT MODAL -->
@if($this->selectedEvent)
<div class="modal-overlay" wire:click.self="closeEventModal()">
  <div class="modal-content" @click.stop>
    <!-- HEADER -->
    <div class="modal-header">
      <h2>{{ $this->selectedEvent->title }}</h2>
      <button class="modal-close" wire:click="closeEventModal()">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <!-- BODY -->
    <div class="modal-body">

      <!-- TYPE BADGE -->
      <div class="modal-section">
        <span class="modal-badge {{ $this->selectedEvent->event_type }}">
          @switch($this->selectedEvent->event_type)
            @case('session') 📌 Session @break
            @case('exam') 📝 Examen @break
            @case('course') 📚 Cours @break
          @endswitch
        </span>
      </div>

      <div class="modal-divider"></div>

      <!-- COURSE/QUIZ -->
      @if($this->selectedEvent->cours)
        <div class="modal-section">
          <label class="modal-label">Cours</label>
          <div class="modal-value">{{ $this->selectedEvent->cours->title }}</div>
        </div>
      @endif

      @if($this->selectedEvent->quiz)
        <div class="modal-section">
          <label class="modal-label">Quiz/Examen</label>
          <div class="modal-value">{{ $this->selectedEvent->quiz->title }}</div>
        </div>
      @endif

      <!-- DESCRIPTION -->
      @if($this->selectedEvent->description)
        <div class="modal-section">
          <label class="modal-label">Description</label>
          <div class="modal-value">{{ $this->selectedEvent->description }}</div>
        </div>
      @endif

      <div class="modal-divider"></div>

      <!-- DATES & TIMES -->
      <div class="modal-section">
        <label class="modal-label">⏰ Début</label>
        <div class="modal-value">{{ $this->selectedEvent->start_date->locale('fr')->format('d M Y à H:i') }}</div>
      </div>

      <div class="modal-section">
        <label class="modal-label">🏁 Fin</label>
        <div class="modal-value">{{ $this->selectedEvent->end_date->locale('fr')->format('d M Y à H:i') }}</div>
      </div>

      <div class="modal-section">
        <label class="modal-label">⏱️ Durée</label>
        <div class="modal-value">{{ $this->selectedEvent->start_date->diffInMinutes($this->selectedEvent->end_date) }} minutes</div>
      </div>

      <!-- LOCATION -->
      @if($this->selectedEvent->location)
        <div class="modal-section">
          <label class="modal-label">📍 Lieu</label>
          <div class="modal-value">{{ $this->selectedEvent->location }}</div>
        </div>
      @endif

      <div class="modal-divider"></div>

      <!-- SESSION INFO -->
      @if($this->selectedEvent->session)
        <div class="modal-section">
          @if($this->selectedEvent->session->formateur)
            <label class="modal-label">👨‍🏫 Formateur</label>
            <div class="modal-value">{{ $this->selectedEvent->session->formateur->name }}</div>
          @endif

          <label class="modal-label" style="margin-top: 12px;">👥 Capacité</label>
          <div class="modal-value">{{ $this->selectedEvent->session->max_attendees }} participants</div>

          @if($this->selectedEvent->session->virtual_room_link)
            <a href="{{ $this->selectedEvent->session->virtual_room_link }}" target="_blank" rel="noopener noreferrer" class="modal-button" style="display:inline-block;width:100%;">
              📞 Rejoindre la salle virtuelle
            </a>
          @endif
        </div>
      @endif

      <!-- EXAM INFO -->
      @if($this->selectedEvent->quiz)
        <div class="modal-section">
          <label class="modal-label">❓ Questions</label>
          <div class="modal-value">{{ $this->selectedEvent->quiz->questions()->count() }} questions</div>

          <label class="modal-label" style="margin-top: 12px;">⏱️ Durée</label>
          <div class="modal-value">{{ $this->selectedEvent->quiz->duration }} minutes</div>

          <label class="modal-label" style="margin-top: 12px;">✅ Score minimum</label>
          <div class="modal-value">{{ $this->selectedEvent->quiz->passing_score }}%</div>
        </div>
      @endif

    </div>
  </div>
</div>
@endif

</div>
