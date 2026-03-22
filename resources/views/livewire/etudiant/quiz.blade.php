<x-layouts.etudiant>
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
.qcard{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;cursor:pointer;transition:all .25s;}
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

/* RESULTS TABLE */
.rtable{width:100%;border-collapse:collapse;}
.rtable thead tr{background:var(--bg);}
.rtable th{text-align:left;font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);padding:9px 14px;}
.rtable th:first-child{border-radius:var(--rs) 0 0 var(--rs);}
.rtable th:last-child{border-radius:0 var(--rs) var(--rs) 0;}
.rtable td{padding:12px 14px;font-size:13px;border-bottom:1px solid var(--border);}
.rtable tr:last-child td{border-bottom:none;}
.rtable tbody tr:hover{background:var(--vxl);cursor:pointer;}
.score-pill{display:inline-flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-size:12px;font-weight:800;width:46px;height:26px;border-radius:var(--rp);}
.score-pill.a{background:var(--mint);color:var(--mintd);}
.score-pill.b{background:var(--sky);color:var(--skyd);}
.score-pill.c{background:var(--yel);color:var(--yeld);}
.rcard{background:#fff;border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:0;overflow:hidden;}

@media(max-width:1100px){.quiz-grid{grid-template-columns:repeat(2,1fr);}.stats-strip{grid-template-columns:repeat(3,1fr);}}
@media(max-width:700px){.quiz-grid{grid-template-columns:1fr;}.stats-strip{grid-template-columns:repeat(2,1fr);}.exam-alert{flex-direction:column;text-align:center;}.ea-actions{flex-direction:row;justify-content:center;}}
</style>

<!-- HEADER -->
<header class="hdr">
  <h1>{{ "\u{1F4DD}" }} Quiz & Examens</h1>
  <div class="tabs">
    <div class="tab active" onclick="switchTab(this)">Tous</div>
    <div class="tab" onclick="switchTab(this)">Quiz</div>
    <div class="tab" onclick="switchTab(this)">Examens</div>
    <div class="tab" onclick="switchTab(this)">Historique</div>
  </div>
  <div class="av-sm" style="background:var(--vgrad);width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;">
    {{ auth()->user()->initials() }}
  </div>
</header>

<div class="page">

  <!-- STATS -->
  <div class="stats-strip fu fu1">
    <div class="scard" style="border-top:3px solid var(--v);"><div class="sc-ico">{{ "\u{1F4DD}" }}</div><div class="sc-val">12</div><div class="sc-lbl">Quiz passes</div></div>
    <div class="scard" style="border-top:3px solid var(--mintd);"><div class="sc-ico">{{ "\u{2705}" }}</div><div class="sc-val">10</div><div class="sc-lbl">Reussis</div></div>
    <div class="scard" style="border-top:3px solid var(--yeld);"><div class="sc-ico">{{ "\u{1F3AF}" }}</div><div class="sc-val">82%</div><div class="sc-lbl">Score moyen</div></div>
    <div class="scard" style="border-top:3px solid var(--peachd);"><div class="sc-ico">{{ "\u{23F3}" }}</div><div class="sc-val">3</div><div class="sc-lbl">A venir</div></div>
    <div class="scard" style="border-top:3px solid var(--skyd);"><div class="sc-ico">{{ "\u{26A1}" }}</div><div class="sc-val">+540</div><div class="sc-lbl">XP gagnes</div></div>
  </div>

  <!-- EXAM ALERT -->
  <div class="exam-alert fu fu2">
    <div class="ea-ico">{{ "\u{26A0}" }}</div>
    <div class="ea-info">
      <h3>Examen Motion Design - Dans 2 jours !</h3>
      <p>Prepare-toi soigneusement : le score minimum requis est de 70% pour valider ta certification Motion Design Pro.</p>
      <div class="ea-meta">
        <div class="ea-badge">{{ "\u{1F4C5}" }} Mercredi 18 mars - 09h00</div>
        <div class="ea-badge">{{ "\u{23F1}" }} 45 minutes</div>
        <div class="ea-badge">{{ "\u{1F3AF}" }} Score min. 70%</div>
        <div class="ea-badge">{{ "\u{1F4CB}" }} QCM - 20 questions</div>
      </div>
    </div>
    <div class="ea-actions">
      <button class="ea-btn white" onclick="showToast('Demarrage du quiz...')">S'entrainer {{ "\u{2192}" }}</button>
      <button class="ea-btn outline" onclick="showToast('Rappel email active !')">Rappel</button>
    </div>
  </div>

  <!-- AVAILABLE QUIZZES -->
  <section class="fu fu3">
    <div class="st">{{ "\u{1F4DA}" }} Quiz disponibles <span class="stpill">5</span></div>
    <div class="quiz-grid">

      <div class="qcard" style="border-top:3px solid var(--v);">
        <div class="qcard-top" style="background:var(--vxl);">
          <span class="qcard-tag" style="background:var(--vxl);color:var(--v);border:1px solid rgba(124,58,237,.2);">{{ "\u{1F504}" }} A refaire</span>
          <span class="qcard-ico">{{ "\u{1F4A1}" }}</span>
          <div class="qcard-title">Wireframing Avance</div>
          <div class="qcard-course">UX/UI Design - Chapitre 12</div>
        </div>
        <div class="qcard-bot">
          <div class="qcard-meta">
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>15 min</div>
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>10 questions</div>
            <div class="qm">{{ "\u{2B50}" }} 78% (dernier)</div>
          </div>
          <div class="qcard-cta">
            <button class="qbtn primary" onclick="showToast('Demarrage du quiz...')">Commencer {{ "\u{2192}" }}</button>
            <button class="qbtn ghost" onclick="showToast('Apercu du quiz')">Apercu</button>
          </div>
        </div>
      </div>

      <div class="qcard" style="border-top:3px solid var(--peachd);">
        <div class="qcard-top" style="background:var(--peach);">
          <span class="qcard-tag" style="background:var(--peach);color:var(--peachd);">{{ "\u{26A0}" }} Examen</span>
          <span class="qcard-ico">{{ "\u{1F3AC}" }}</span>
          <div class="qcard-title">Examen Motion Design</div>
          <div class="qcard-course">Motion Design Pro - Certificant</div>
        </div>
        <div class="qcard-bot">
          <div class="qcard-meta">
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>45 min</div>
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>20 questions</div>
            <div class="qm" style="color:var(--peachd);font-weight:700;">18 mars - 09h00</div>
          </div>
          <div class="qcard-cta">
            <button class="qbtn primary" onclick="showToast('Mode entrainement...')">S'entrainer {{ "\u{2192}" }}</button>
            <button class="qbtn ghost" onclick="showToast('Programme de l\'examen')">Details</button>
          </div>
        </div>
      </div>

      <div class="qcard" style="border-top:3px solid var(--rosed);">
        <div class="qcard-top" style="background:var(--rose);">
          <span class="qcard-tag" style="background:var(--rose);color:var(--rosed);">{{ "\u{1F195}" }} Nouveau</span>
          <span class="qcard-ico">{{ "\u{1F4BB}" }}</span>
          <div class="qcard-title">Laravel REST API</div>
          <div class="qcard-course">Dev Web Full Stack - Module 4</div>
        </div>
        <div class="qcard-bot">
          <div class="qcard-meta">
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>20 min</div>
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>12 questions</div>
            <div class="qm">{{ "\u{2B50}" }} Non passe</div>
          </div>
          <div class="qcard-cta">
            <button class="qbtn primary" onclick="showToast('Demarrage du quiz...')">Commencer {{ "\u{2192}" }}</button>
            <button class="qbtn ghost" onclick="showToast('Details du quiz')">Details</button>
          </div>
        </div>
      </div>

      <div class="qcard" style="border-top:3px solid var(--skyd);">
        <div class="qcard-top" style="background:var(--sky);">
          <span class="qcard-tag" style="background:var(--sky);color:var(--skyd);">{{ "\u{1F195}" }} Nouveau</span>
          <span class="qcard-ico">{{ "\u{1F4CA}" }}</span>
          <div class="qcard-title">Pandas & Matplotlib</div>
          <div class="qcard-course">Data Science - Module 3</div>
        </div>
        <div class="qcard-bot">
          <div class="qcard-meta">
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>25 min</div>
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>15 questions</div>
            <div class="qm">{{ "\u{2B50}" }} Non passe</div>
          </div>
          <div class="qcard-cta">
            <button class="qbtn primary" onclick="showToast('Demarrage du quiz...')">Commencer {{ "\u{2192}" }}</button>
            <button class="qbtn ghost" onclick="showToast('Details du quiz')">Details</button>
          </div>
        </div>
      </div>

      <div class="qcard" style="border-top:3px solid var(--yeld);">
        <div class="qcard-top" style="background:var(--yel);">
          <span class="qcard-tag" style="background:var(--yel);color:var(--yeld);">{{ "\u{1F512}" }} Examen Final</span>
          <span class="qcard-ico">{{ "\u{1F4A1}" }}</span>
          <div class="qcard-title">Examen Final UX/UI</div>
          <div class="qcard-course">UX/UI Design - Certificant</div>
        </div>
        <div class="qcard-bot">
          <div class="qcard-meta">
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>90 min</div>
            <div class="qm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>30 questions</div>
            <div class="qm" style="color:var(--yeld);font-weight:700;">28 mars - 14h00</div>
          </div>
          <div class="qcard-cta">
            <button class="qbtn ghost" style="flex:1;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;">Disponible le 28 mars</button>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- HISTORY TABLE -->
  <section class="fu fu4">
    <div class="st">{{ "\u{1F4CB}" }} Historique <span class="stpill">12</span> <span class="stsub">Tous les resultats</span></div>
    <div class="rcard">
      <table class="rtable">
        <thead><tr>
          <th>Quiz / Examen</th><th>Cours</th><th>Score</th><th>Statut</th><th>Tentative</th><th>Date</th><th>XP gagne</th>
        </tr></thead>
        <tbody>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Principes UX</td><td style="color:var(--muted);">UX/UI Design</td><td><span class="score-pill a">94</span></td><td><span style="color:var(--mintd);font-weight:600;">{{ "\u{2705}" }} Reussi</span></td><td style="color:var(--muted);">1/3</td><td style="color:var(--muted);">14 mars</td><td style="font-weight:700;color:var(--v);">+120 XP</td></tr>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Quiz Wireframing</td><td style="color:var(--muted);">UX/UI Design</td><td><span class="score-pill a">88</span></td><td><span style="color:var(--mintd);font-weight:600;">{{ "\u{2705}" }} Reussi</span></td><td style="color:var(--muted);">1/3</td><td style="color:var(--muted);">10 mars</td><td style="font-weight:700;color:var(--v);">+100 XP</td></tr>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Quiz After Effects</td><td style="color:var(--muted);">Motion Design</td><td><span class="score-pill a">91</span></td><td><span style="color:var(--mintd);font-weight:600;">{{ "\u{2705}" }} Reussi</span></td><td style="color:var(--muted);">1/3</td><td style="color:var(--muted);">5 mars</td><td style="font-weight:700;color:var(--v);">+110 XP</td></tr>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Laravel Basics</td><td style="color:var(--muted);">Dev Web</td><td><span class="score-pill b">76</span></td><td><span style="color:var(--mintd);font-weight:600;">{{ "\u{2705}" }} Reussi</span></td><td style="color:var(--muted);">2/3</td><td style="color:var(--muted);">8 mars</td><td style="font-weight:700;color:var(--v);">+80 XP</td></tr>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Wireframing Avance</td><td style="color:var(--muted);">UX/UI Design</td><td><span class="score-pill c">78</span></td><td><span style="color:var(--yeld);font-weight:600;">{{ "\u{26A0}" }} A refaire</span></td><td style="color:var(--muted);">1/3</td><td style="color:var(--muted);">2 mars</td><td style="font-weight:700;color:var(--v);">+60 XP</td></tr>
          <tr onclick="showToast('Detail du resultat')"><td style="font-weight:600;">Python Pandas</td><td style="color:var(--muted);">Data Science</td><td><span class="score-pill c">68</span></td><td><span style="color:var(--yeld);font-weight:600;">{{ "\u{26A0}" }} A refaire</span></td><td style="color:var(--muted);">1/3</td><td style="color:var(--muted);">28 fev.</td><td style="font-weight:700;color:var(--v);">+50 XP</td></tr>
        </tbody>
      </table>
    </div>
  </section>

</div>

<script>
function switchTab(el){
  document.querySelectorAll('.tab').forEach(i=>i.classList.remove('active'));
  el.classList.add('active');
  showToast('Vue : '+el.textContent);
}
</script>
</x-layouts.etudiant>
