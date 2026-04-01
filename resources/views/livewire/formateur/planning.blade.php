<div wire:poll.30s>
  <style>
    .plan-layout{display:grid;grid-template-columns:1fr 320px;gap:22px;align-items:start;}
    .cal-card{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
    .cal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
    .cal-month{font-family:Poppins,sans-serif;font-size:18px;font-weight:800;color:var(--txt);}
    .cal-nav{display:flex;gap:6px;}
    .cal-nbtn{width:32px;height:32px;border-radius:50%;border:1.5px solid var(--border);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;}
    .cal-nbtn:hover{background:var(--vxl);border-color:var(--vl);}
    .cal-nbtn svg{width:14px;height:14px;stroke:var(--muted);fill:none;}
    .cal-dh{display:grid;grid-template-columns:repeat(7,1fr);text-align:center;font-size:11px;font-weight:700;color:var(--muted);margin-bottom:8px;gap:2px;}
    .cal-grid{display:grid;grid-template-columns:repeat(7,1fr);gap:3px;}
    .cd{aspect-ratio:1;display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:12px;font-weight:500;border-radius:10px;cursor:pointer;transition:all .15s;position:relative;}
    .cd:hover{background:var(--vxl);}
    .cd.other{color:#D1D5DB;}
    .cd.has-live{background:rgba(13,148,136,.1);color:var(--v);font-weight:700;}
    .cd.has-live::after{content:'';position:absolute;bottom:4px;width:5px;height:5px;border-radius:50%;background:var(--v);}
    .cd.has-exam{background:rgba(220,38,38,.1);color:var(--peachd);font-weight:700;}
    .cd.has-exam::after{content:'';position:absolute;bottom:4px;width:5px;height:5px;border-radius:50%;background:var(--peachd);}
    .cd.has-office{background:rgba(5,150,105,.1);color:var(--mintd);font-weight:700;}
    .cd.has-office::after{content:'';position:absolute;bottom:4px;width:5px;height:5px;border-radius:50%;background:var(--mintd);}
    .cd.has-seminar{background:rgba(14,165,233,.1);color:var(--skyd);font-weight:700;}
    .cd.has-seminar::after{content:'';position:absolute;bottom:4px;width:5px;height:5px;border-radius:50%;background:var(--skyd);}
    .cd.today{background:var(--vgrad);color:#fff;font-weight:800;box-shadow:0 4px 12px rgba(13,148,136,.35);}
    .cd.today::after{background:#fff;}
    .cal-legend{display:flex;gap:14px;margin-top:16px;flex-wrap:wrap;}
    .leg-item{display:flex;align-items:center;gap:6px;font-size:11px;color:var(--muted);}
    .leg-dot{width:8px;height:8px;border-radius:50%;}
    .session-card{background:var(--card);border-radius:var(--rm);border:1.5px solid var(--border);padding:16px;margin-bottom:12px;cursor:pointer;transition:all .2s;position:relative;overflow:hidden;}
    .session-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:4px;border-radius:4px 0 0 4px;}
    .session-card.live-type::before{background:var(--vgrad);}
    .session-card.exam-type::before{background:var(--peachd);}
    .session-card.office-type::before{background:var(--mintd);}
    .session-card.seminar-type::before{background:var(--skyd);}
    .session-card:hover{transform:translateX(3px);box-shadow:var(--sh);}
    .sc-time{font-family:Poppins,sans-serif;font-size:13px;font-weight:800;color:var(--v);margin-bottom:4px;}
    .sc-title{font-size:13px;font-weight:700;color:var(--txt);margin-bottom:3px;}
    .sc-meta{font-size:11px;color:var(--muted);}
    .sc-actions{display:flex;gap:6px;margin-top:10px;}
    .modal-bg{position:fixed;inset:0;background:rgba(19,78,74,.3);z-index:300;display:none;align-items:center;justify-content:center;backdrop-filter:blur(5px);}
    .modal-bg.open{display:flex;}
    .modal-inner{background:#fff;border-radius:var(--r);padding:28px;max-width:480px;width:92%;box-shadow:0 24px 60px rgba(13,78,74,.2);animation:pop .35s cubic-bezier(.22,1,.36,1) both;position:relative;}
    .modal-inner h3{font-family:Poppins,sans-serif;font-size:18px;font-weight:800;color:var(--txt);margin-bottom:18px;}
    .modal-close{position:absolute;top:14px;right:14px;width:30px;height:30px;border-radius:50%;border:none;background:var(--bg);cursor:pointer;font-size:16px;}
    @media(max-width:1100px){.plan-layout{grid-template-columns:1fr;}}
  </style>

  <!-- PAGE HEADER -->
  <div style="flex:1;margin-bottom:40px;">
    <h1 style="font-size:24px;font-weight:800;margin-bottom:8px;">📅 Planning & Sessions Live</h1>
    <p style="color:var(--muted);">{{ \Carbon\Carbon::now()->format('F Y') }} · {{ count($this->upcomingSessions()) }} sessions planifiées</p>
  </div>

  <div class="tab-bar" style="margin-bottom:18px;">
    <div class="tab-item @class(['active' => $this->currentTab === 'month'])" wire:click="switchTab('month')">Mois</div>
    <div class="tab-item @class(['active' => $this->currentTab === 'week'])" wire:click="switchTab('week')">Semaine</div>
    <div class="tab-item @class(['active' => $this->currentTab === 'list'])" wire:click="switchTab('list')">Liste</div>
  </div>

  <!-- STATS -->
  <div class="grid-5 fu fu1" style="margin-bottom:32px;">
    <div class="stat-card" style="border-top:3px solid var(--v)">
      <div class="s-ico">🎬</div>
      <div class="s-val">{{ $this->stats['lives'] }}</div>
      <div class="s-lbl">Lives ce mois</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--peachd)">
      <div class="s-ico">🎓</div>
      <div class="s-val">{{ $this->stats['exams'] }}</div>
      <div class="s-lbl">Examens</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--mintd)">
      <div class="s-ico">🤝</div>
      <div class="s-val">{{ $this->stats['officeHours'] }}</div>
      <div class="s-lbl">Office hours</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--skyd)">
      <div class="s-ico">📡</div>
      <div class="s-val">{{ $this->stats['seminars'] }}</div>
      <div class="s-lbl">Séminaires</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--yeld)">
      <div class="s-ico">⏱️</div>
      <div class="s-val">{{ $this->stats['totalHours'] }}</div>
      <div class="s-lbl">Total ce mois</div>
    </div>
  </div>

  <!-- LIVE ALERT -->
  @if(count($this->upcomingSessions()) > 0)
  <div class="alert alert-warn fu fu1" style="margin-bottom:32px;">
    <div class="alert-ico">🔴</div>
    <div class="alert-info">
      <h4>Session live dans 45 minutes — {{ $this->upcomingSessions()[0]['title'] }}</h4>
      <p>{{ $this->upcomingSessions()[0]['date'] }} · {{ $this->upcomingSessions()[0]['room'] }} · {{ $this->upcomingSessions()[0]['enrolled'] }} étudiants inscrits</p>
    </div>
    <div style="display:flex;gap:8px;">
      <button class="btn btn-warning btn-sm" wire:click="launchSession({{ $this->upcomingSessions()[0]['id'] }})">▶️ Lancer la salle</button>
      <button class="btn btn-outline btn-sm" wire:click="sendReminder({{ $this->upcomingSessions()[0]['id'] }})">📧 Rappel</button>
    </div>
  </div>
  @endif

  @if($this->currentTab === 'month')
  <div class="plan-layout fu fu2">
    <!-- CALENDAR & SESSIONS -->
    <div>
      <div class="cal-card" style="margin-bottom:28px;">
        <div class="cal-hdr">
          <span class="cal-month">{{ \Carbon\Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y') }}</span>
          <div style="display:flex;align-items:center;gap:12px;">
            <div class="cal-legend">
              <div class="leg-item"><div class="leg-dot" style="background:var(--v)"></div>Live</div>
              <div class="leg-item"><div class="leg-dot" style="background:var(--peachd)"></div>Examen</div>
              <div class="leg-item"><div class="leg-dot" style="background:var(--mintd)"></div>Office hours</div>
            </div>
            <div class="cal-nav">
              <button class="cal-nbtn" wire:click="previousMonth">
                <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                  <polyline points="15 18 9 12 15 6"/>
                </svg>
              </button>
              <button class="cal-nbtn" wire:click="nextMonth">
                <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                  <polyline points="9 18 15 12 9 6"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="cal-dh">
          <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
        </div>

        <div class="cal-grid" id="calGrid">
          @php
            $currentDate = \Carbon\Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
            $firstDayOfMonth = $currentDate->copy()->startOfMonth();
            $lastDayOfMonth = $currentDate->copy()->endOfMonth();
            $firstDayWeek = $firstDayOfMonth->dayOfWeek;
            $nextMonthFirstDay = $lastDayOfMonth->copy()->addDay();

            // Previous month's days
            $prevMonth = $firstDayOfMonth->copy()->subDay();
            for($i = $firstDayWeek - 1; $i >= 0; $i--) {
              $day = $prevMonth->copy()->subDays($i);
          @endphp
            <div class="cd other">{{ $day->day }}</div>
          @php
            }

            // Current month's days
            for($d = 1; $d <= $lastDayOfMonth->day; $d++) {
              $day = \Carbon\Carbon::createFromDate($this->currentYear, $this->currentMonth, $d);
              $isToday = $day->isToday();
              $eventType = $this->monthEventsByDay[$d]['type'] ?? null;
              $hasEventClass = $eventType ? 'has-'.$eventType : '';
          @endphp
            <div class="cd @if($isToday) today @elseif($hasEventClass) {{ $hasEventClass }} @endif" title="{{ $this->monthEventsByDay[$d]['count'] ?? 0 }} session(s)">{{ $d }}</div>
          @php
            }

            // Next month's days
            $remaining = 42 - ($firstDayOfMonth->dayOfWeek + $lastDayOfMonth->day - 1);
            for($i = 1; $i <= $remaining; $i++) {
          @endphp
            <div class="cd other">{{ $i }}</div>
          @php
            }
          @endphp
        </div>
      </div>

      <!-- UPCOMING SESSIONS LIST -->
      <div style="margin-top:0;">
        <div class="sec-hdr" style="margin-bottom:20px;"><span class="sec-title">📋 Sessions à venir <span class="sec-pill">{{ count($this->upcomingSessions()) }}</span></span></div>

        @if(count($this->upcomingSessions()) > 0)
          @foreach($this->upcomingSessions() as $session)
          <div class="session-card {{ $session['type'] }}-type" wire:click="openSessionModal({{ $session['id'] }})" style="margin-bottom:14px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
              @if($session['status'])
              <span class="pill @if(str_contains($session['status'], 'min')) pill-red @elseif($session['type'] === 'office') pill-green @else pill-blue @endif" style="font-size:10px;">{{ $session['status'] }}</span>
              @endif
              <span style="font-size:10px;color:var(--muted);">{{ $session['date'] }}</span>
            </div>
            <div class="sc-title">{{ $session['title'] }}</div>
            <div class="sc-meta">{{ $session['meta'] }}</div>
            <div class="sc-actions">
              <button class="btn btn-primary btn-sm" wire:click.stop="launchSession({{ $session['id'] }})">▶️ Lancer</button>
              <button class="btn btn-ghost btn-sm" wire:click.stop="sendReminder({{ $session['id'] }})">📧 Rappel</button>
              <button class="btn btn-outline btn-sm" wire:click.stop="editSession({{ $session['id'] }})">✏️</button>
              <button class="btn btn-outline btn-sm" wire:click.stop="deleteSession({{ $session['id'] }})">🗑️</button>
            </div>
          </div>
          @endforeach
        @else
          <div style="text-align:center;padding:60px 20px;color:var(--muted);">
            <p style="font-size:14px;">Aucune session planifiée</p>
          </div>
        @endif
      </div>
    </div>

    <!-- RIGHT SIDEBAR -->
    <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:72px;">

      <!-- CREATE QUICK -->
      <div class="card card-p" style="background:var(--vgrad2);margin-bottom:8px;">
        <div style="color:rgba(255,255,255,.75);font-size:12px;font-weight:600;margin-bottom:12px;">⚡ CRÉER RAPIDEMENT</div>
        <div style="display:flex;flex-direction:column;gap:8px;">
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);justify-content:flex-start;" wire:click="openCreateModal">🎬 Nouveau live</button>
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);justify-content:flex-start;">🤝 Office hours</button>
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);justify-content:flex-start;">🎓 Examen</button>
          <button class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.2);justify-content:flex-start;">📡 Séminaire</button>
        </div>
      </div>

      <!-- ATTENDANCES -->
      <div class="card card-p" style="margin-bottom:8px;">
        <div class="card-title" style="margin-bottom:18px;">📊 Taux de présence</div>
        <div style="display:flex;flex-direction:column;gap:14px;">
          @foreach($this->attendanceRates() as $index => $attendance)
          <div>
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:6px;">
              <span style="color:var(--muted);">{{ $attendance['course'] }}</span>
              <span style="font-weight:700;color:{{ $attendance['color'] }};">{{ $attendance['rate'] }}%</span>
            </div>
            <div class="prog-bar">
              <div class="prog-fill prog-anim" style="--w:{{ $attendance['rate'] }}%;width:0;background:{{ $attendance['color'] }};animation:barGrow 1.2s {{ 0.3 + $index * 0.1 }}s both;"></div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- AUTO REMINDERS -->
      <div class="card card-p">
        <div class="card-title" style="margin-bottom:16px;">🔔 Rappels auto</div>
        <div style="display:flex;flex-direction:column;gap:12px;">
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--bg);border-radius:var(--rs);">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--txt);">24h avant le live</div>
              <div style="font-size:10px;color:var(--muted);">Email + notification</div>
            </div>
            <label class="toggle"><input type="checkbox" checked/><div class="toggle-track"></div><div class="toggle-thumb"></div></label>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--bg);border-radius:var(--rs);">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--txt);">1h avant le live</div>
              <div style="font-size:10px;color:var(--muted);">Notification push</div>
            </div>
            <label class="toggle"><input type="checkbox" checked/><div class="toggle-track"></div><div class="toggle-thumb"></div></label>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--bg);border-radius:var(--rs);">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--txt);">Rappel examen 48h</div>
              <div style="font-size:10px;color:var(--muted);">Email prioritaire</div>
            </div>
            <label class="toggle"><input type="checkbox" checked/><div class="toggle-track"></div><div class="toggle-thumb"></div></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  @elseif($this->currentTab === 'week')
  <div class="card card-p">
    <div class="sec-hdr" style="margin-bottom:16px;">
      <span class="sec-title">📅 Sessions de la semaine</span>
    </div>
    @forelse($this->weekSessions() as $session)
      <div class="session-card {{ $session['type'] }}-type">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;">
          <div>
            <div class="sc-title">{{ $session['title'] }}</div>
            <div class="sc-time">{{ \Carbon\Carbon::parse($session['start_iso'])->format('D d M H:i') }}</div>
            <div class="sc-meta">{{ $session['meta'] }}</div>
          </div>
          <div style="display:flex;gap:8px;">
            <button class="btn btn-primary btn-sm" wire:click="launchSession({{ $session['id'] }})">▶️</button>
            <button class="btn btn-outline btn-sm" wire:click="openSessionModal({{ $session['id'] }})">👁️</button>
            <button class="btn btn-ghost btn-sm" wire:click="editSession({{ $session['id'] }})">✏️</button>
          </div>
        </div>
      </div>
    @empty
      <div style="text-align:center;color:var(--muted);padding:24px 0;">Aucune session cette semaine.</div>
    @endforelse
  </div>
  @else
  <div class="card card-p">
    <div class="sec-hdr" style="margin-bottom:16px;">
      <span class="sec-title">🗂️ Toutes les sessions</span>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;">
      @forelse($this->listSessions() as $session)
        <div style="border:1px solid var(--border);border-radius:10px;padding:12px;display:grid;grid-template-columns:180px 1fr 140px 130px 220px;gap:10px;align-items:center;">
          <div style="font-size:12px;color:var(--txt);">{{ \Carbon\Carbon::parse($session['start_iso'])->format('d/m/Y H:i') }}</div>
          <div>
            <div style="font-weight:700;font-size:13px;color:var(--txt);">{{ $session['title'] }}</div>
            <div style="font-size:11px;color:var(--muted);">{{ $session['course'] }}</div>
          </div>
          <div style="font-size:12px;">{{ ucfirst($session['type']) }}</div>
          <div style="font-size:12px;">👥 {{ $session['enrolled'] }}</div>
          <div style="display:flex;gap:6px;justify-content:flex-end;">
            <button class="btn btn-primary btn-sm" wire:click="launchSession({{ $session['id'] }})">▶️</button>
            <button class="btn btn-outline btn-sm" wire:click="openSessionModal({{ $session['id'] }})">👁️</button>
            <button class="btn btn-ghost btn-sm" wire:click="editSession({{ $session['id'] }})">✏️</button>
            <button class="btn btn-outline btn-sm" wire:click="deleteSession({{ $session['id'] }})">🗑️</button>
          </div>
        </div>
      @empty
        <div style="text-align:center;color:var(--muted);padding:24px 0;">Aucune session trouvée.</div>
      @endforelse
    </div>
  </div>
  @endif

  <!-- MODAL: SESSION DETAIL -->
  <div id="sessionModal" class="modal-bg @if($showSessionModal) open @endif" wire:click="if($event->target.id === 'sessionModal') closeSessionModal()">
    <div class="modal-inner">
      <button class="modal-close" wire:click="closeSessionModal">✕</button>
      @if($selectedSession)
        <h3>{{ $selectedSession['title'] }}</h3>
        <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px;">
          <div style="display:flex;gap:10px;padding:14px;background:var(--vxl);border-radius:var(--rm);">
            <div style="font-size:28px;">📅</div>
            <div>
              <div style="font-family:Poppins,sans-serif;font-weight:700;color:var(--v);">{{ $selectedSession['date'] }}</div>
              <div style="font-size:12px;color:var(--muted);margin-top:3px;">{{ $selectedSession['course'] }}</div>
            </div>
          </div>
          <div style="font-size:13px;color:var(--txt);background:var(--bg);border-radius:10px;padding:10px;">
            {{ $selectedSession['description'] ?: 'Aucune description' }}
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
            <div style="padding:10px;background:var(--bg);border-radius:8px;">
              <div style="font-size:11px;color:var(--muted);">Salle</div>
              <div style="font-size:13px;font-weight:700;color:var(--txt);">{{ $selectedSession['room'] }}</div>
            </div>
            <div style="padding:10px;background:var(--bg);border-radius:8px;">
              <div style="font-size:11px;color:var(--muted);">Inscrits actifs</div>
              <div style="font-size:13px;font-weight:700;color:var(--txt);">{{ $selectedSession['attendees'] }}</div>
            </div>
          </div>
          @if(!empty($selectedSession['link']))
            <a href="{{ $selectedSession['link'] }}" target="_blank" class="btn btn-outline btn-sm">🔗 Ouvrir le lien de salle</a>
          @endif
          <div style="border:1px solid var(--border);border-radius:10px;padding:10px;">
            <div style="font-size:12px;font-weight:700;margin-bottom:8px;">Gestion des inscrits</div>
            <input class="form-input" wire:model.live="attendeeSearch" placeholder="Rechercher un inscrit…" style="margin-bottom:8px;">
            <div style="display:flex;flex-direction:column;gap:6px;max-height:180px;overflow:auto;">
              @foreach($selectedSession['attendee_list'] ?? [] as $attendee)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px;background:var(--bg);border-radius:8px;">
                  <div>
                    <div style="font-size:12px;font-weight:600;">{{ $attendee['name'] }}</div>
                    <div style="font-size:10px;color:var(--muted);">{{ $attendee['email'] }}</div>
                  </div>
                  <button class="btn btn-sm {{ $attendee['is_excluded'] ? 'btn-outline' : 'btn-ghost' }}"
                    wire:click="toggleAttendee({{ $selectedSession['id'] }}, {{ $attendee['id'] }})">
                    {{ $attendee['is_excluded'] ? 'Réactiver' : 'Exclure' }}
                  </button>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
      <div style="display:flex;gap:8px;justify-content:flex-end;">
        <button class="btn btn-ghost" wire:click="closeSessionModal">Fermer</button>
        <button class="btn btn-primary" wire:click="launchSession($selectedSession['id'] ?? null)">▶️ Lancer la session</button>
      </div>
    </div>
  </div>

  <!-- MODAL: CREATE SESSION -->
  <div class="modal-bg @if($showCreateModal) open @endif">
    <div class="modal-inner">
      <button class="modal-close" wire:click="closeCreateModal">✕</button>
      <h3>🗓️ Planifier une session</h3>
      <form wire:submit="createSession" style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px;">
        <div class="form-group">
          <label class="form-label">Type de session</label>
          <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <span class="pill pill-teal" style="cursor:pointer;padding:7px 14px;" wire:click="$set('sessionType', 'live')">🎬 Live</span>
            <span class="pill pill-green" style="cursor:pointer;padding:7px 14px;" wire:click="$set('sessionType', 'office')">🤝 Office hours</span>
            <span class="pill pill-red" style="cursor:pointer;padding:7px 14px;" wire:click="$set('sessionType', 'exam')">🎓 Examen</span>
            <span class="pill pill-blue" style="cursor:pointer;padding:7px 14px;" wire:click="$set('sessionType', 'seminar')">📡 Séminaire</span>
          </div>
          @error('sessionType') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Titre</label>
          <input class="form-input" wire:model="sessionTitle" placeholder="Ex: UX/UI Design — Live Figma"/>
          @error('sessionTitle') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Cours associé</label>
          <select class="form-select" wire:model="associatedCourse" style="width:100%;">
            <option value="">Sélectionner un cours</option>
            @foreach($this->courses() as $course)
              <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
          </select>
          @error('associatedCourse') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Date</label>
            <input class="form-input" wire:model="sessionDate" type="date"/>
            @error('sessionDate') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Heure</label>
            <input class="form-input" wire:model="sessionTime" type="time"/>
            @error('sessionTime') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Durée (min)</label>
            <input class="form-input" wire:model="sessionDuration" type="number"/>
            @error('sessionDuration') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Salle</label>
            <select class="form-select" wire:model="sessionRoom">
              <option value="">Sélectionner une salle</option>
              <option value="Virtuelle A">Virtuelle A</option>
              <option value="Virtuelle B">Virtuelle B</option>
              <option value="Virtuelle C">Virtuelle C</option>
            </select>
            @error('sessionRoom') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Lien salle virtuelle (Zoom/Meet)</label>
          <input class="form-input" wire:model="virtualRoomLink" placeholder="https://meet.google.com/..." />
          @error('virtualRoomLink') <span style="color:var(--peachd);font-size:12px;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Description</label>
          <input class="form-input" wire:model="sessionDescription" placeholder="Décrivez le contenu de la session…"/>
        </div>

        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px;">
          <button type="button" class="btn btn-ghost" wire:click="closeCreateModal">Annuler</button>
          <button type="submit" class="btn btn-primary">{{ $selectedEventId ? '💾 Mettre à jour' : '✅ Planifier' }}</button>
        </div>
      </form>
    </div>
  </div>

  @if (session()->has('message'))
  <div class="alert alert-success" style="position:fixed;bottom:20px;right:20px;max-width:400px;z-index:500;animation:slideIn .3s ease-out;">
    {{ session('message') }}
  </div>
  @endif
</div>
