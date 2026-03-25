<div>
<style>
.hero{background:var(--vgrad2);border-radius:var(--r);padding:28px 32px;display:grid;grid-template-columns:1fr auto;gap:20px;box-shadow:0 12px 36px rgba(13,148,136,.30);position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;top:-50px;right:200px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05);}
.hero h2{font-family:'Poppins',sans-serif;font-size:23px;font-weight:800;color:#fff;margin-bottom:6px;}
.hero p{font-size:13px;color:rgba(255,255,255,.75);line-height:1.6;margin-bottom:18px;}
.hero-badges{display:flex;gap:10px;flex-wrap:wrap;}
.hero-badge{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);border-radius:var(--rp);padding:5px 14px;font-size:12px;font-weight:700;color:#fff;}
.hero-right{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;}
.rating-big{background:rgba(255,255,255,.12);border-radius:var(--r);padding:18px 24px;text-align:center;border:1px solid rgba(255,255,255,.15);}
.rating-big .r-val{font-family:'Poppins',sans-serif;font-size:36px;font-weight:900;color:#fff;line-height:1;}
.rating-big .r-stars{font-size:18px;margin:4px 0;}
.rating-big .r-lbl{font-size:11px;color:rgba(255,255,255,.65);}
.activity-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.act-card{border-radius:var(--r);padding:20px;position:relative;overflow:hidden;cursor:pointer;transition:all .25s cubic-bezier(.22,1,.36,1);border:1.5px solid transparent;}
.act-card:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.act-card.teal{background:var(--vxl);border-color:rgba(13,148,136,.15);}
.act-card.mint{background:var(--mint);border-color:rgba(5,150,105,.15);}
.act-arrow{position:absolute;top:16px;right:16px;width:30px;height:30px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;box-shadow:var(--sh);}
.act-arrow svg{width:14px;height:14px;fill:none;stroke:var(--v);}
.act-rating{display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:700;background:#fff;padding:3px 9px;border-radius:var(--rp);box-shadow:var(--sh);margin-bottom:10px;color:var(--yeld);}
.act-ico{font-size:28px;margin-bottom:8px;display:block;}
.act-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);margin-bottom:4px;}
.act-meta{font-size:11px;color:var(--muted);}
.two-col{display:grid;grid-template-columns:1fr 340px;gap:32px;align-items:start;margin-top:32px;}
.right-col{display:flex;flex-direction:column;gap:20px;}
.revenue-card{background:var(--vgrad2);border-radius:var(--r);padding:22px;box-shadow:0 8px 28px rgba(13,148,136,.25);position:relative;overflow:hidden;}
.revenue-card h3{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:4px;}
.revenue-val{font-family:'Poppins',sans-serif;font-size:32px;font-weight:900;color:#fff;margin:8px 0;}
.revenue-trend{font-size:12px;color:rgba(255,255,255,.75);}
.stat-card{background:var(--card);border-radius:var(--rm);padding:18px;border-top:3px solid var(--v);box-shadow:var(--sh);}
.s-ico{font-size:24px;margin-bottom:6px;}
.s-val{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;color:var(--txt);}
.s-lbl{font-size:12px;color:var(--muted);margin-top:4px;}
.grid-5{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;}
.sec-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.sec-title{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);}
.sec-pill{background:var(--vxl);color:var(--v);padding:2px 8px;border-radius:var(--rp);font-size:11px;font-weight:700;margin-left:6px;}
.sec-link{color:var(--v);font-size:13px;font-weight:600;text-decoration:none;}
.alert{border-radius:var(--r);padding:16px 20px;display:flex;align-items:center;gap:16px;margin-bottom:20px;}
.alert-warn{background:var(--yel);border:1.5px solid rgba(217,119,6,.25);}
.alert-ico{font-size:20px;flex-shrink:0;}
.alert-info{flex:1;}
.alert-info h4{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--yeld);margin-bottom:2px;}
.alert-info p{font-size:12px;color:var(--muted);margin:0;}
.card{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);}
.card-p{padding:20px;}
.card-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.card-sub{float:right;font-size:12px;color:var(--muted);}
.data-table{width:100%;border-collapse:collapse;}
.data-table th{background:var(--bg);padding:12px 16px;text-align:left;font-size:12px;font-weight:700;color:var(--muted);border-bottom:1.5px solid var(--border);}
.data-table td{padding:12px 16px;border-bottom:1px solid var(--border);font-size:13px;}
.data-table tbody tr:hover{background:var(--vxl);}
.user-cell{display:flex;align-items:center;gap:8px;}
.mini-av{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:11px;color:#fff;flex-shrink:0;background:var(--v);}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:var(--rs);font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;}
.btn-primary{background:var(--vgrad);color:#fff;box-shadow:var(--sh);}
.btn-primary:hover{transform:translateY(-2px);box-shadow:var(--shlift);}
.btn-sm{padding:6px 12px;font-size:11px;}
.fu{animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;}
.fu1{animation-delay:.04s}.fu2{animation-delay:.10s}.fu3{animation-delay:.17s}
.fu4{animation-delay:.24s}.fu5{animation-delay:.32s}
@keyframes fadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:1100px){.two-col{grid-template-columns:1fr;}.right-col{display:grid;grid-template-columns:1fr 1fr;}}
@media(max-width:640px){.activity-grid{grid-template-columns:1fr;}.right-col{grid-template-columns:1fr;}.hero{grid-template-columns:1fr;}.hero-right{display:none;}}
.section-spacing{margin-top:32px;}
</style>

  <!-- HERO -->
  <div class="hero fu fu1">
    <div>
      <h2>Bienvenue sur votre espace formateur 🚀</h2>
      <p>Vous avez <strong style="color:#fff;">{{ $this->totalStudents }} étudiants actifs</strong> cette semaine. Votre meilleur cours a {{ number_format($this->averageRating, 1) }}⭐.</p>
      <div class="hero-badges">
        <div class="hero-badge">🔴 Live à 10h00</div>
        <div class="hero-badge">📝 {{ $this->pendingAssignmentsCount }} devoirs à corriger</div>
        <div class="hero-badge">💬 5 messages non lus</div>
        <div class="hero-badge">💰 Revenus : {{ number_format($this->monthlyRevenue) }}€ ce mois</div>
      </div>
      <div style="margin-top:18px;display:flex;gap:10px;">
        <a href="#" class="btn btn-sm" style="background:#fff;color:var(--v);">▶️ Lancer le live</a>
        <a href="#" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);">Gérer mes cours</a>
      </div>
    </div>
    <div class="hero-right">
      <div class="rating-big">
        <div class="r-val">{{ number_format($this->averageRating, 1) }}</div>
        <div class="r-stars">⭐⭐⭐⭐⭐</div>
        <div class="r-lbl">Note moyenne globale</div>
      </div>
      <div style="text-align:center;color:rgba(255,255,255,.7);font-size:12px;">🏅 {{ $this->ratingPercentile }} des formateurs</div>
    </div>
  </div>

  <!-- STATS -->
  <div class="grid-5 fu fu2 section-spacing">
    <div class="stat-card" style="border-top:3px solid var(--v)"><div class="s-ico">📚</div><div class="s-val">{{ $this->publicCoursesCount }}</div><div class="s-lbl">Cours publiés</div><div class="s-trend trend-up">↑ +{{ $this->courseTrend }} ce mois</div></div>
    <div class="stat-card" style="border-top:3px solid var(--mintd)"><div class="s-ico">👨‍🎓</div><div class="s-val">{{ $this->totalStudents }}</div><div class="s-lbl">Étudiants actifs</div><div class="s-trend trend-up">↑ +{{ $this->studentTrend }} cette semaine</div></div>
    <div class="stat-card" style="border-top:3px solid var(--yeld)"><div class="s-ico">💰</div><div class="s-val">{{ number_format($this->monthlyRevenue) }}€</div><div class="s-lbl">Revenus du mois</div><div class="s-trend trend-up">↑ +22% vs N-1</div></div>
    <div class="stat-card" style="border-top:3px solid var(--skyd)"><div class="s-ico">⭐</div><div class="s-val">{{ number_format($this->averageRating, 1) }}</div><div class="s-lbl">Note moyenne</div><div class="s-trend trend-up">↑ {{ $this->ratingPercentile }}</div></div>
    <div class="stat-card" style="border-top:3px solid var(--rosed)"><div class="s-ico">📝</div><div class="s-val">{{ $this->pendingAssignmentsCount }}</div><div class="s-lbl">Devoirs à corriger</div><div class="s-trend trend-down">⚠️ En attente</div></div>
  </div>

  <!-- ALERT -->
  @if($this->nextSession)
  <div class="alert alert-warn fu fu2 section-spacing">
    <div class="alert-ico">🔴</div>
    <div class="alert-info">
      <h4>Session live dans 45 minutes — {{ $this->nextSession['course_title'] }}</h4>
      <p>{{ $this->nextSession['students'] }} étudiants inscrits · {{ $this->nextSession['title'] ?? 'Salle virtuelle' }} · {{ $this->nextSession['date']->format('d/m/Y') }} {{ $this->nextSession['time'] }} – {{ $this->nextSession['date']->copy()->addHours(2)->format('H:i') }}</p>
    </div>
    <a href="{{ route('formateur.planning') }}" class="btn btn-warning btn-sm" style="background:var(--yeld);color:var(--yeld);">Préparer →</a>
  </div>
  @endif

  <!-- MAIN LAYOUT -->
  <div class="two-col">
    <div style="display:flex;flex-direction:column;gap:32px;">

      <!-- MES COURS ACTIFS -->
      <section class="fu fu3">
        <div class="sec-hdr">
          <span class="sec-title">📚 Mes cours actifs <span class="sec-pill">{{ count($this->coursesList) }}</span></span>
          <a href="#" class="sec-link">Gérer →</a>
        </div>
        <div class="activity-grid">
          @forelse($this->coursesList as $course)
            <div class="act-card teal">
              <div class="act-arrow"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg></div>
              <div class="act-rating">⭐ {{ number_format($course['rating'], 1) }}</div>
              <span class="act-ico">💡</span>
              <div class="act-title">{{ $course['title'] }}</div>
              <div class="act-meta">{{ $course['students'] }} étudiants · {{ $course['progressPercentage'] }}% · {{ $course['level'] }}</div>
            </div>
          @empty
            <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--muted);">Aucun cours. <a href="{{ route('formateur.creer-cours') }}" style="color:var(--v);font-weight:600;">Créer un cours</a></div>
          @endforelse
        </div>
      </section>

      <!-- DEVOIRS À CORRIGER -->
      <section class="fu fu5">
        <div class="sec-hdr">
          <span class="sec-title">📋 Devoirs à corriger <span class="sec-pill">{{ $this->pendingAssignmentsCount }}</span></span>
          <a href="#" class="sec-link">Voir tous →</a>
        </div>
        <div class="card" style="overflow:hidden;">
          <table class="data-table">
            <thead><tr><th>Étudiant</th><th>Cours</th><th>Devoir</th><th>Rendu le</th><th>Action</th></tr></thead>
            <tbody>
              @forelse($this->pendingAssignments as $assignment)
                <tr>
                  <td><div class="user-cell"><div class="mini-av">{{ $assignment['student_avatar'] }}</div><span style="font-weight:600;">{{ $assignment['student_name'] }}</span></div></td>
                  <td>{{ $assignment['course_title'] }}</td><td>{{ $assignment['assignment_title'] }}</td><td style="color:var(--muted);">{{ $assignment['submitted_at'] }}</td>
                  <td><a href="#" class="btn btn-sm btn-primary">Corriger</a></td>
                </tr>
              @empty
                <tr><td colspan="5" style="text-align:center;padding:20px;color:var(--muted);">Aucun devoir à corriger</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

    </div>

    <!-- RIGHT COL -->
    <div class="right-col">

      <!-- REVENUS -->
      <div class="revenue-card fu fu2">
        <h3>💰 Revenus ce mois</h3>
        <div class="revenue-val">{{ number_format($this->monthlyRevenue) }} €</div>
        <div class="revenue-trend">↑ +{{ number_format($this->revenueTrend) }}€ vs mois précédent · <strong style="color:#fff;">{{ number_format($this->totalRevenue) }}€</strong> total</div>
        <div style="margin-top:16px;">
          <div style="display:flex;justify-content:space-between;font-size:11px;color:rgba(255,255,255,.7);margin-bottom:6px;"><span>Objectif mensuel</span><span>{{ number_format($this->monthlyRevenue) }} / 3000€</span></div>
          <div style="height:8px;background:rgba(255,255,255,.15);border-radius:var(--rp);overflow:hidden;">
            <div style="height:100%;width:{{ min(($this->monthlyRevenue / 3000) * 100, 100) }}%;background:linear-gradient(90deg,#A7F3D0,#34D399);border-radius:var(--rp);"></div>
          </div>
          <div style="font-size:10px;color:rgba(255,255,255,.6);margin-top:5px;">{{ number_format(min(($this->monthlyRevenue / 3000) * 100, 100), 1) }}% de l'objectif atteint</div>
        </div>
      </div>

      <!-- NOTIFICATIONS -->
      <div class="card fu fu4">
        <div class="card-title" style="padding:18px 20px 0;">🔔 Activité récente</div>
        <div style="display:flex;flex-direction:column;gap:10px;padding:16px 20px;">
          @forelse($this->recentNotifications as $notif)
            <div style="display:flex;gap:10px;padding:10px;background:var(--bg);border-radius:var(--rm);">
              <div style="font-size:16px;">{{ $notif['type'] === 'review' ? '⭐' : '📚' }}</div>
              <div style="flex:1;">
                <div style="font-size:12px;font-weight:600;color:var(--txt);">{{ $notif['user_name'] }} {{ $notif['message'] }}</div>
                <div style="font-size:11px;color:var(--muted);">{{ $notif['course_title'] }} · {{ $notif['created_at'] }}</div>
              </div>
            </div>
          @empty
            <div style="text-align:center;padding:20px;color:var(--muted);">Aucune activité récente</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>

</div>
