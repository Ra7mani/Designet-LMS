<div>
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);flex:1;}
.tabs{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.tab{padding:7px 16px;border-radius:var(--rp);font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.tab.active{background:var(--vgrad);color:#fff;}
.tab:not(.active):hover{background:var(--vxl);color:var(--v);}

/* PAGE */
.page{padding:26px 28px;display:flex;flex-direction:column;gap:24px;}

/* STATS */
.stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;}
.scard{background:#fff;border-radius:var(--rm);padding:18px 14px;text-align:center;border:1.5px solid var(--border);box-shadow:var(--sh);transition:all .2s;cursor:default;}
.scard:hover{transform:translateY(-3px);box-shadow:var(--shlift);}
.sc-ico{font-size:22px;margin-bottom:7px;}
.sc-val{font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:var(--txt);}
.sc-lbl{font-size:10px;color:var(--muted);margin-top:3px;}

/* EXAM ALERT */
.exam-alert{background:linear-gradient(135deg,#1E1B4B,#4C1D95,#7C3AED);border-radius:var(--r);padding:24px 28px;display:flex;align-items:center;gap:20px;box-shadow:0 12px 36px rgba(30,27,75,.3);position:relative;overflow:hidden;}
.exam-alert::before{content:'';position:absolute;right:140px;top:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05);}
.ea-ico{font-size:40px;flex-shrink:0;}
.ea-info{flex:1;}
.ea-info h3{font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:#fff;margin-bottom:4px;}
.ea-info p{font-size:13px;color:rgba(255,255,255,.75);margin-bottom:14px;}
.ea-meta{display:flex;gap:16px;flex-wrap:wrap;}
.ea-badge{background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);border-radius:var(--rp);padding:5px 14px;font-size:12px;font-weight:700;color:#fff;}
.ea-actions{display:flex;gap:10px;flex-shrink:0;}
.ea-btn{padding:11px 22px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;border:none;}
.ea-btn.white{background:#fff;color:var(--v);}
.ea-btn.white:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.2);}
.ea-btn.outline{background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.3);}
.ea-btn.outline:hover{background:rgba(255,255,255,.1);}

/* SECTION TITLE */
.st{font-family:'Poppins',sans-serif;font-size:16px;font-weight:700;color:var(--txt);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.stpill{font-size:11px;font-weight:700;padding:2px 9px;border-radius:var(--rp);background:var(--vxl);color:var(--v);font-family:'DM Sans',sans-serif;}
.stsub{font-size:12px;font-weight:400;color:var(--muted);margin-left:auto;font-family:'DM Sans',sans-serif;}

/* QUIZ CARD GRID */
.quiz-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.qcard{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;transition:all .25s;}
.qcard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.qcard-top{padding:20px 20px 16px;position:relative;}
.qcard-ico{font-size:32px;margin-bottom:10px;display:block;}
.qcard-tag{position:absolute;top:16px;right:16px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);}
.qcard-title{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);margin-bottom:4px;line-height:1.3;}
.qcard-course{font-size:11px;color:var(--muted);}
.qcard-bot{padding:14px 20px 18px;border-top:1.5px solid var(--border);}
.qcard-meta{display:flex;align-items:center;gap:14px;margin-bottom:12px;flex-wrap:wrap;}
.qm{display:flex;align-items:center;gap:4px;font-size:12px;color:var(--muted);}
.qm svg{width:13px;height:13px;stroke:var(--muted);}
.qcard-cta{display:flex;gap:8px;}
.qbtn{flex:1;padding:9px;border-radius:var(--rp);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .2s;text-align:center;}
.qbtn.primary{background:var(--vgrad);color:#fff;box-shadow:0 3px 10px rgba(124,58,237,.28);}
.qbtn.primary:hover{transform:translateY(-1px);}
.qbtn.ghost{background:var(--vxl);color:var(--v);}
.qbtn.disabled{background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;}

/* RESULTS TABLE */
.rtable{width:100%;border-collapse:collapse;}
.rtable thead tr{background:var(--bg);}
.rtable th{text-align:left;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);padding:9px 14px;}
.rtable th:first-child{border-radius:var(--rs) 0 0 var(--rs);}
.rtable th:last-child{border-radius:0 var(--rs) var(--rs) 0;}
.rtable td{padding:12px 14px;font-size:13px;border-bottom:1px solid var(--border);}
.rtable tr:last-child td{border-bottom:none;}
.rtable tbody tr:hover{background:var(--vxl);}
.score-pill{display:inline-flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:12px;font-weight:800;width:46px;height:26px;border-radius:var(--rp);}
.score-pill.a{background:var(--mint);color:var(--mintd);}
.score-pill.b{background:var(--sky);color:var(--skyd);}
.score-pill.c{background:var(--yel);color:var(--yeld);}
.score-pill.d{background:var(--peach);color:var(--peachd);}
.rcard{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:0;overflow:hidden;}

/* QUIZ MODAL */
.quiz-modal{position:fixed;inset:0;z-index:100;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
.quiz-container{background:#fff;border-radius:var(--r);max-width:800px;width:100%;max-height:90vh;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.quiz-header{background:linear-gradient(135deg,#1E1B4B,#4C1D95,#7C3AED);padding:20px 24px;color:#fff;display:flex;align-items:center;gap:16px;}
.quiz-header-info{flex:1;}
.quiz-header-info h2{font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;margin-bottom:2px;}
.quiz-header-info p{font-size:12px;opacity:.8;}
.timer{background:rgba(255,255,255,.15);padding:10px 18px;border-radius:var(--rp);text-align:center;border:1.5px solid rgba(255,255,255,.2);}
.timer-val{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;}
.timer-lbl{font-size:10px;opacity:.7;}
.timer.warning .timer-val{color:#FCD34D;animation:pulse 1s infinite;}
.timer.danger .timer-val{color:#F87171;animation:pulse .5s infinite;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.6;}}
.quiz-progress{display:flex;gap:4px;padding:16px 24px;background:var(--bg);border-bottom:1px solid var(--border);}
.qp-dot{width:24px;height:6px;border-radius:3px;background:var(--border);cursor:pointer;transition:all .2s;}
.qp-dot.answered{background:var(--v);}
.qp-dot.current{background:var(--vgrad);box-shadow:0 2px 8px rgba(124,58,237,.4);}
.quiz-body{flex:1;overflow-y:auto;padding:28px 24px;}
.question-num{font-size:12px;font-weight:700;color:var(--v);text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;}
.question-text{font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);margin-bottom:24px;line-height:1.5;}
.answers-list{display:flex;flex-direction:column;gap:12px;}
.answer-opt{display:flex;align-items:center;gap:14px;padding:16px 18px;border-radius:var(--rm);border:2px solid var(--border);background:#fff;cursor:pointer;transition:all .2s;}
.answer-opt:hover{border-color:var(--vl);background:var(--vxl);}
.answer-opt.selected{border-color:var(--v);background:var(--vxl);}
.answer-letter{width:32px;height:32px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:13px;font-weight:800;color:var(--muted);flex-shrink:0;transition:all .2s;}
.answer-opt.selected .answer-letter{background:var(--vgrad);color:#fff;}
.answer-text{font-size:14px;color:var(--txt);flex:1;}
.quiz-footer{padding:16px 24px;border-top:1.5px solid var(--border);display:flex;align-items:center;gap:12px;background:#fff;}
.quiz-footer .qbtn{flex:0 0 auto;padding:11px 24px;}
.quiz-footer .spacer{flex:1;}
.quiz-footer .abandon{background:transparent;color:var(--muted);border:none;padding:8px 16px;font-size:12px;cursor:pointer;}
.quiz-footer .abandon:hover{color:var(--peachd);}

/* RESULT MODAL */
.result-modal{position:fixed;inset:0;z-index:100;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;padding:20px;}
.result-card{background:#fff;border-radius:var(--r);max-width:500px;width:100%;padding:0;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.result-header{padding:32px;text-align:center;}
.result-header.passed{background:linear-gradient(135deg,#059669,#10B981);}
.result-header.failed{background:linear-gradient(135deg,#DC2626,#F87171);}
.result-icon{font-size:64px;margin-bottom:12px;}
.result-title{font-family:'Poppins',sans-serif;font-size:24px;font-weight:900;color:#fff;margin-bottom:4px;}
.result-sub{font-size:14px;color:rgba(255,255,255,.85);}
.result-body{padding:24px 32px;}
.result-score{text-align:center;margin-bottom:24px;}
.score-big{font-family:'Poppins',sans-serif;font-size:56px;font-weight:900;color:var(--txt);}
.score-label{font-size:13px;color:var(--muted);}
.result-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;}
.rs-item{text-align:center;padding:14px;background:var(--bg);border-radius:var(--rm);}
.rs-val{font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:var(--txt);}
.rs-lbl{font-size:10px;color:var(--muted);margin-top:2px;}
.result-actions{display:flex;gap:12px;}
.result-actions .qbtn{flex:1;}

/* EMPTY STATE */
.empty-box{text-align:center;padding:48px 24px;background:#fff;border-radius:var(--r);border:1.5px solid var(--border);}
.empty-box .emoji{font-size:48px;margin-bottom:12px;}
.empty-box p{color:var(--muted);margin-bottom:16px;}
.empty-box a{display:inline-flex;align-items:center;gap:6px;background:var(--vgrad);color:#fff;padding:10px 20px;border-radius:var(--rp);font-weight:600;text-decoration:none;}

@media(max-width:1100px){.quiz-grid{grid-template-columns:repeat(2,1fr);}.stats-strip{grid-template-columns:repeat(3,1fr);}}
@media(max-width:700px){.quiz-grid{grid-template-columns:1fr;}.stats-strip{grid-template-columns:repeat(2,1fr);}.exam-alert{flex-direction:column;text-align:center;}.ea-actions{flex-direction:row;justify-content:center;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <h1>📝 Quiz & Examens</h1>
  <div class="tabs">
    <div class="tab {{ $tab === 'tous' ? 'active' : '' }}" wire:click="setTab('tous')">Tous</div>
    <div class="tab {{ $tab === 'quiz' ? 'active' : '' }}" wire:click="setTab('quiz')">Quiz</div>
    <div class="tab {{ $tab === 'examens' ? 'active' : '' }}" wire:click="setTab('examens')">Examens</div>
    <div class="tab {{ $tab === 'historique' ? 'active' : '' }}" wire:click="setTab('historique')">Historique</div>
  </div>
  
</header>

<div class="page">

  @if(session('success'))
    <div style="background:var(--mint);color:var(--mintd);padding:12px 16px;border-radius:var(--rm);font-weight:600;">
      ✅ {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background:var(--peach);color:var(--peachd);padding:12px 16px;border-radius:var(--rm);font-weight:600;">
      ⚠️ {{ session('error') }}
    </div>
  @endif

  <!-- STATS -->
  <div class="stats-strip fu fu1">
    <div class="scard" style="border-top:3px solid var(--v);">
      <div class="sc-ico">📝</div>
      <div class="sc-val">{{ $stats['total_passed'] }}</div>
      <div class="sc-lbl">Quiz passes</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--mintd);">
      <div class="sc-ico">✅</div>
      <div class="sc-val">{{ $stats['total_succeeded'] }}</div>
      <div class="sc-lbl">Reussis</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--yeld);">
      <div class="sc-ico">🎯</div>
      <div class="sc-val">{{ $stats['avg_score'] }}%</div>
      <div class="sc-lbl">Score moyen</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--peachd);">
      <div class="sc-ico">⏳</div>
      <div class="sc-val">{{ $stats['upcoming'] }}</div>
      <div class="sc-lbl">Examens</div>
    </div>
    <div class="scard" style="border-top:3px solid var(--skyd);">
      <div class="sc-ico">⚡</div>
      <div class="sc-val">+{{ $stats['total_xp'] }}</div>
      <div class="sc-lbl">XP gagnes</div>
    </div>
  </div>

  <!-- EXAM ALERT -->
  @if($nextExam && $tab !== 'historique')
  <div class="exam-alert fu fu2">
    <div class="ea-ico">⚠️</div>
    <div class="ea-info">
      <h3>{{ $nextExam->title }}</h3>
      <p>Prepare-toi soigneusement : le score minimum requis est de {{ $nextExam->passing_score }}% pour valider cette certification.</p>
      <div class="ea-meta">
        <div class="ea-badge">⏱️ {{ $nextExam->duration }} minutes</div>
        <div class="ea-badge">🎯 Score min. {{ $nextExam->passing_score }}%</div>
        <div class="ea-badge">📋 {{ $nextExam->questions->count() }} questions</div>
        <div class="ea-badge">🔄 {{ $nextExam->max_attempts }} tentative(s) max</div>
      </div>
    </div>
    <div class="ea-actions">
      @php
        $examAttempts = $nextExam->attempts()->where('user_id', auth()->id())->where('status', 'completed')->count();
        $canAttemptExam = $examAttempts < $nextExam->max_attempts;
      @endphp
      @if($canAttemptExam)
        <button class="ea-btn white" wire:click="startQuiz({{ $nextExam->id }})">Commencer →</button>
      @else
        <button class="ea-btn white" disabled style="opacity:.6;cursor:not-allowed;">Max atteint</button>
      @endif
      <button class="ea-btn outline" wire:click="sendReminder({{ $nextExam->id }})">Rappel</button>
    </div>
  </div>
  @endif

  <!-- AVAILABLE QUIZZES -->
  @if($tab !== 'historique')
  <section class="fu fu3">
    <div class="st">📚 Quiz disponibles <span class="stpill">{{ $quizzes->count() }}</span></div>

    @if($quizzes->count() > 0)
    <div class="quiz-grid">
      @foreach($quizzes as $quiz)
        @php
          $attempts = $quiz->attempts->where('user_id', auth()->id())->where('status', 'completed');
          $attemptsCount = $attempts->count();
          $bestAttempt = $attempts->sortByDesc('score')->first();
          $bestScore = $bestAttempt ? round(($bestAttempt->score / max(1, $bestAttempt->total_points)) * 100) : null;
          $canAttempt = $attemptsCount < $quiz->max_attempts;
          $isExam = $quiz->isExam();
          $colors = [
            ['border' => 'var(--v)', 'bg' => 'var(--vxl)', 'tag_bg' => 'var(--vxl)', 'tag_c' => 'var(--v)'],
            ['border' => 'var(--rosed)', 'bg' => 'var(--rose)', 'tag_bg' => 'var(--rose)', 'tag_c' => 'var(--rosed)'],
            ['border' => 'var(--mintd)', 'bg' => 'var(--mint)', 'tag_bg' => 'var(--mint)', 'tag_c' => 'var(--mintd)'],
            ['border' => 'var(--skyd)', 'bg' => 'var(--sky)', 'tag_bg' => 'var(--sky)', 'tag_c' => 'var(--skyd)'],
            ['border' => 'var(--yeld)', 'bg' => 'var(--yel)', 'tag_bg' => 'var(--yel)', 'tag_c' => 'var(--yeld)'],
          ];
          $color = $colors[$loop->index % count($colors)];
          $emojis = ['💡', '💻', '🎬', '📊', '🎨'];
          $emoji = $emojis[$loop->index % count($emojis)];
        @endphp
        <div class="qcard" style="border-top:3px solid {{ $color['border'] }};">
          <div class="qcard-top" style="background:{{ $color['bg'] }};">
            @if($isExam)
              <span class="qcard-tag" style="background:var(--peach);color:var(--peachd);">⚠️ Examen</span>
            @elseif($bestScore !== null && $bestScore < $quiz->passing_score)
              <span class="qcard-tag" style="background:{{ $color['tag_bg'] }};color:{{ $color['tag_c'] }};border:1px solid rgba(0,0,0,.1);">🔄 A refaire</span>
            @elseif($attemptsCount === 0)
              <span class="qcard-tag" style="background:{{ $color['tag_bg'] }};color:{{ $color['tag_c'] }};border:1px solid rgba(0,0,0,.1);">🆕 Nouveau</span>
            @else
              <span class="qcard-tag" style="background:var(--mint);color:var(--mintd);">✅ Reussi</span>
            @endif
            <span class="qcard-ico">{{ $emoji }}</span>
            <div class="qcard-title">{{ $quiz->title }}</div>
            <div class="qcard-course">{{ $quiz->cours->title ?? 'Cours' }}</div>
          </div>
          <div class="qcard-bot">
            <div class="qcard-meta">
              <div class="qm">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $quiz->duration }} min
              </div>
              <div class="qm">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                {{ $quiz->questions->count() }} questions
              </div>
              @if($bestScore !== null)
                <div class="qm" style="color:{{ $bestScore >= $quiz->passing_score ? 'var(--mintd)' : 'var(--yeld)' }};font-weight:700;">
                  ⭐ {{ $bestScore }}% (meilleur)
                </div>
              @else
                <div class="qm">⭐ Non passe</div>
              @endif
            </div>
            <div class="qcard-cta">
              @if($canAttempt)
                <button class="qbtn primary" wire:click="startQuiz({{ $quiz->id }})" wire:loading.attr="disabled">
                  <span wire:loading.remove wire:target="startQuiz({{ $quiz->id }})">Commencer →</span>
                  <span wire:loading wire:target="startQuiz({{ $quiz->id }})">...</span>
                </button>
              @else
                <button class="qbtn disabled" disabled>Max atteint ({{ $attemptsCount }}/{{ $quiz->max_attempts }})</button>
              @endif
              <button class="qbtn ghost">{{ $attemptsCount }}/{{ $quiz->max_attempts }}</button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @else
    <div class="empty-box">
      <div class="emoji">📝</div>
      <p>Aucun quiz disponible pour le moment. Inscris-toi a des cours pour debloquer des quiz !</p>
      <a href="{{ route('etudiant.catalogue') }}">Explorer le catalogue</a>
    </div>
    @endif
  </section>
  @endif

  <!-- HISTORY TABLE -->
  @if($tab === 'historique' || $tab === 'tous')
  <section class="fu fu4">
    <div class="st">📋 Historique <span class="stpill">{{ $history->count() }}</span> <span class="stsub">Tous les resultats</span></div>
    @if($history->count() > 0)
    <div class="rcard">
      <div style="overflow-x:auto;">
        <table class="rtable">
          <thead><tr>
            <th>Quiz / Examen</th><th>Cours</th><th>Score</th><th>Statut</th><th>Tentative</th><th>Duree</th><th>Date</th><th>XP</th>
          </tr></thead>
          <tbody>
            @foreach($history as $attempt)
              @php
                $scorePercent = $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100) : 0;
                $pillClass = $scorePercent >= 90 ? 'a' : ($scorePercent >= 70 ? 'b' : ($scorePercent >= 50 ? 'c' : 'd'));
                $totalAttempts = $attempt->quiz->attempts()->where('user_id', auth()->id())->where('status', 'completed')->count();
              @endphp
              <tr>
                <td style="font-weight:600;">{{ $attempt->quiz->title }}</td>
                <td style="color:var(--muted);">{{ $attempt->quiz->cours->title ?? '-' }}</td>
                <td><span class="score-pill {{ $pillClass }}">{{ $scorePercent }}</span></td>
                <td>
                  @if($attempt->passed)
                    <span style="color:var(--mintd);font-weight:600;">✅ Reussi</span>
                  @else
                    <span style="color:var(--yeld);font-weight:600;">⚠️ A refaire</span>
                  @endif
                </td>
                <td style="color:var(--muted);">{{ $totalAttempts }}/{{ $attempt->quiz->max_attempts }}</td>
                <td style="color:var(--muted);">{{ $attempt->duration_formatted }}</td>
                <td style="color:var(--muted);">{{ $attempt->completed_at?->format('d M') }}</td>
                <td style="font-weight:700;color:var(--v);">+{{ $attempt->xp_earned }} XP</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
    <div class="empty-box">
      <div class="emoji">📋</div>
      <p>Aucun quiz termine pour le moment. Commence un quiz pour voir ton historique !</p>
    </div>
    @endif
  </section>
  @endif

</div>

<!-- QUIZ MODAL -->
@if($showQuiz && $currentQuiz)
<div class="quiz-modal" wire:poll.1s="decrementTimer">
  <div class="quiz-container">
    <div class="quiz-header">
      <div class="quiz-header-info">
        <h2>{{ $currentQuiz->title }}</h2>
        <p>{{ $currentQuiz->cours->title ?? 'Quiz' }} · {{ count($questions) }} questions</p>
      </div>
      <div class="timer {{ $timeRemaining <= 60 ? 'danger' : ($timeRemaining <= 300 ? 'warning' : '') }}">
        <div class="timer-val">{{ sprintf('%d:%02d', floor($timeRemaining / 60), $timeRemaining % 60) }}</div>
        <div class="timer-lbl">Temps restant</div>
      </div>
    </div>

    <div class="quiz-progress">
      @foreach($questions as $index => $q)
        <div
          class="qp-dot {{ $index === $currentQuestionIndex ? 'current' : '' }} {{ isset($userAnswers[$q['id']]) ? 'answered' : '' }}"
          wire:click="goToQuestion({{ $index }})"
          title="Question {{ $index + 1 }}"
        ></div>
      @endforeach
    </div>

    <div class="quiz-body">
      @if(isset($questions[$currentQuestionIndex]))
        @php $question = $questions[$currentQuestionIndex]; @endphp
        <div class="question-num">Question {{ $currentQuestionIndex + 1 }} sur {{ count($questions) }}</div>
        <div class="question-text">{{ $question['content'] }}</div>

        <div class="answers-list">
          @php
            $answers = \App\Models\Answer::where('question_id', $question['id'])->orderBy('order')->get();
            $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
          @endphp
          @foreach($answers as $i => $answer)
            <div
              class="answer-opt {{ isset($userAnswers[$question['id']]) && $userAnswers[$question['id']] == $answer->id ? 'selected' : '' }}"
              wire:click="selectAnswer({{ $answer->id }})"
            >
              <div class="answer-letter">{{ $letters[$i] ?? ($i + 1) }}</div>
              <div class="answer-text">{{ $answer->content }}</div>
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <div class="quiz-footer">
      <button class="abandon" wire:click="abandonQuiz" wire:confirm="Es-tu sur de vouloir abandonner ce quiz ?">Abandonner</button>
      <div class="spacer"></div>
      @if($currentQuestionIndex > 0)
        <button class="qbtn ghost" wire:click="previousQuestion">← Precedente</button>
      @endif
      @if($currentQuestionIndex < count($questions) - 1)
        <button class="qbtn primary" wire:click="nextQuestion">Suivante →</button>
      @else
        <button class="qbtn primary" wire:click="submitQuiz" wire:confirm="Es-tu sur de vouloir terminer ce quiz ?">
          Terminer ✓
        </button>
      @endif
    </div>
  </div>
</div>
@endif

<!-- RESULT MODAL -->
@if($showResult && $lastResult)
<div class="result-modal">
  <div class="result-card">
    <div class="result-header {{ $lastResult->passed ? 'passed' : 'failed' }}">
      <div class="result-icon">{{ $lastResult->passed ? '🎉' : '😔' }}</div>
      <div class="result-title">{{ $lastResult->passed ? 'Felicitations !' : 'Pas cette fois...' }}</div>
      <div class="result-sub">{{ $lastResult->passed ? 'Tu as reussi ce quiz !' : 'Continue tes efforts !' }}</div>
    </div>
    <div class="result-body">
      <div class="result-score">
        <div class="score-big">{{ $lastResult->score_percent }}%</div>
        <div class="score-label">Score obtenu (min. {{ $lastResult->quiz->passing_score }}%)</div>
      </div>
      <div class="result-stats">
        <div class="rs-item">
          <div class="rs-val">{{ $lastResult->correct_answers }}/{{ $lastResult->total_questions }}</div>
          <div class="rs-lbl">Bonnes reponses</div>
        </div>
        <div class="rs-item">
          <div class="rs-val">{{ $lastResult->duration_formatted }}</div>
          <div class="rs-lbl">Temps utilise</div>
        </div>
        <div class="rs-item">
          <div class="rs-val" style="color:var(--v);">+{{ $lastResult->xp_earned }}</div>
          <div class="rs-lbl">XP gagnes</div>
        </div>
      </div>
      <div class="result-actions">
        <button class="qbtn ghost" wire:click="closeResult">Fermer</button>
        @php
          $canRetry = $lastResult->quiz->attempts()
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->count() < $lastResult->quiz->max_attempts;
        @endphp
        @if($canRetry && !$lastResult->passed)
          <button class="qbtn primary" wire:click="startQuiz({{ $lastResult->quiz->id }})">Reessayer →</button>
        @else
          <button class="qbtn primary" wire:click="closeResult">Continuer</button>
        @endif
      </div>
    </div>
  </div>
</div>
@endif

</div>
