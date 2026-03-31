<div>
  <style>
    .stats-layout{display:grid;grid-template-columns:1fr 300px;gap:22px;align-items:start;}
    .chart-area{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);padding:24px;}
    .chart-bars{display:flex;align-items:flex-end;gap:10px;height:180px;justify-content:space-between;}
    .chart-bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;}
    .chart-bar{width:100%;border-radius:8px 8px 0 0;transition:height .8s ease;cursor:pointer;position:relative;}
    .chart-bar:hover::after{content:attr(data-val);position:absolute;top:-28px;left:50%;transform:translateX(-50%);background:var(--txt);color:#fff;font-size:11px;font-weight:700;padding:3px 8px;border-radius:6px;white-space:nowrap;}
    .chart-lbl{font-size:11px;color:var(--muted);font-weight:500;}
    .chart-lbl-val{font-size:12px;font-weight:700;color:var(--v);}
    .donut-wrap{display:flex;align-items:center;justify-content:center;gap:28px;flex-wrap:wrap;}
    .donut-legend{display:flex;flex-direction:column;gap:10px;}
    .dleg-item{display:flex;align-items:center;gap:8px;font-size:13px;}
    .dleg-dot{width:12px;height:12px;border-radius:3px;flex-shrink:0;}
    .revenue-row{display:flex;gap:14px;margin-bottom:14px;flex-wrap:wrap;}
    .rev-card{background:var(--bg);border-radius:var(--rm);padding:16px;border:1.5px solid var(--border);flex:1;min-width:120px;}
    .rev-val{font-family:Poppins,sans-serif;font-size:20px;font-weight:800;color:var(--txt);}
    .rev-lbl{font-size:11px;color:var(--muted);margin-top:2px;}
    .rev-trend{font-size:11px;font-weight:600;margin-top:4px;}
    .heatmap-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:3px;}
    .hm-cell{aspect-ratio:1;border-radius:3px;cursor:pointer;transition:transform .15s;}
    .hm-cell:hover{transform:scale(1.3);}
    .hm-0{background:#F0FDF4;} .hm-1{background:#BBF7D0;} .hm-2{background:#4ADE80;} .hm-3{background:#16A34A;} .hm-4{background:var(--v);}
    .course-perf-item{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);margin-bottom:10px;cursor:pointer;transition:all .2s;}
    .course-perf-item:hover{background:var(--vxl);border-color:var(--vl);}
    .cpi-ico{font-size:26px;flex-shrink:0;}
    .cpi-info{flex:1;min-width:0;}
    .cpi-name{font-size:13px;font-weight:700;color:var(--txt);}
    .cpi-sub{font-size:11px;color:var(--muted);margin-top:1px;}
    .cpi-bar-wrap{display:flex;align-items:center;gap:8px;margin-top:6px;}
    .cpi-bar{flex:1;height:5px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
    .cpi-fill{height:100%;border-radius:var(--rp);}
    @media(max-width:1100px){.stats-layout{grid-template-columns:1fr;}}
  </style>

  <!-- PAGE HEADER -->
  <header class="page-header" style="margin-bottom:40px;">
    <div style="flex:1">
      <h1>📊 Statistiques & Revenus</h1>
      <p>{{ now()->format('F Y') }} · Données en temps réel</p>
    </div>
    <div class="tab-bar">
      <div class="tab-item {{ $period === '7j' ? 'active' : '' }}" wire:click="switchPeriod('7j')">7 jours</div>
      <div class="tab-item {{ $period === 'mois' ? 'active' : '' }}" wire:click="switchPeriod('mois')">Ce mois</div>
      <div class="tab-item {{ $period === 'trimestre' ? 'active' : '' }}" wire:click="switchPeriod('trimestre')">Trimestre</div>
      <div class="tab-item {{ $period === 'annee' ? 'active' : '' }}" wire:click="switchPeriod('annee')">Année</div>
    </div>
  </header>

  <!-- KPI STATS -->
  <div class="grid-5 fu fu1" style="margin-bottom:32px;">
    <div class="stat-card" style="border-top:3px solid var(--v)">
      <div class="s-ico">💰</div>
      <div class="s-val">{{ number_format($monthlyRevenue) }}€</div>
      <div class="s-lbl">Revenus du mois</div>
      <div class="s-trend trend-up">↑ +22%</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--mintd)">
      <div class="s-ico">👨‍🎓</div>
      <div class="s-val">+{{ $newStudents }}</div>
      <div class="s-lbl">Nouveaux inscrits</div>
      <div class="s-trend trend-up">↑ +{{ $newStudentsPercent }}%</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--yeld)">
      <div class="s-ico">⭐</div>
      <div class="s-val">{{ number_format($averageRating, 1) }}</div>
      <div class="s-lbl">Note moyenne</div>
      <div class="s-trend trend-up">↑ +{{ number_format($ratingTrend, 1) }}</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--skyd)">
      <div class="s-ico">📊</div>
      <div class="s-val">{{ $avgCompletion }}%</div>
      <div class="s-lbl">Complétion moy.</div>
      <div class="s-trend trend-up">↑ +{{ $completionTrend }}%</div>
    </div>
    <div class="stat-card" style="border-top:3px solid var(--rosed)">
      <div class="s-ico">⏱️</div>
      <div class="s-val">{{ $hoursTeachedThisMonth }}h</div>
      <div class="s-lbl">Enseignées ce mois</div>
      <div class="s-trend trend-up">↑ +{{ $hoursTrend }}h</div>
    </div>
  </div>

  <div class="stats-layout fu fu2">
    <!-- LEFT COLUMN -->
    <div style="display:flex;flex-direction:column;gap:22px;">

      <!-- REVENUS BAR CHART -->
      <div class="chart-area">
        <div class="sec-hdr" style="margin-bottom:20px;">
          <span class="sec-title">💰 Revenus mensuels 2026</span>
          <span style="font-family:Poppins,sans-serif;font-size:20px;font-weight:900;color:var(--v);">{{ number_format($totalRevenue) }} €</span>
        </div>
        <div class="revenue-row">
          <div class="rev-card">
            <div class="rev-val">{{ number_format($monthlyRevenue) }}€</div>
            <div class="rev-lbl">Mars (en cours)</div>
            <div class="rev-trend trend-up">↑ +22%</div>
          </div>
          <div class="rev-card">
            <div class="rev-val">2 330€</div>
            <div class="rev-lbl">Févr. 2026</div>
            <div class="rev-trend trend-up">↑ +8%</div>
          </div>
          <div class="rev-card">
            <div class="rev-val">2 160€</div>
            <div class="rev-lbl">Janv. 2026</div>
            <div class="rev-trend trend-up">↑ +12%</div>
          </div>
          <div class="rev-card">
            <div class="rev-val">{{ number_format($totalRevenue) }}€</div>
            <div class="rev-lbl">Total 2026</div>
            <div class="rev-trend trend-up">↑ Top 5%</div>
          </div>
        </div>
        <div class="chart-bars" id="revenueChart"></div>
        <div id="chartLabels" style="display:flex;gap:10px;justify-content:space-between;margin-top:8px;"></div>
      </div>

      <!-- ENROLLMENTS DONUT CHART -->
      <div class="chart-area">
        <div class="sec-hdr" style="margin-bottom:20px;">
          <span class="sec-title">👨‍🎓 Inscriptions par cours</span>
        </div>
        <div class="donut-wrap">
          <svg width="160" height="160" viewBox="0 0 160 160">
            <circle cx="80" cy="80" r="60" fill="none" stroke="#F0FDF4" stroke-width="28"/>
            <circle cx="80" cy="80" r="60" fill="none" stroke="var(--v)" stroke-width="28" stroke-dasharray="160 217" stroke-dashoffset="-10" transform="rotate(-90 80 80)" style="transition:stroke-dasharray 1s"/>
            <circle cx="80" cy="80" r="60" fill="none" stroke="var(--mintd)" stroke-width="28" stroke-dasharray="76 301" stroke-dashoffset="-170" transform="rotate(-90 80 80)"/>
            <circle cx="80" cy="80" r="60" fill="none" stroke="var(--skyd)" stroke-width="28" stroke-dasharray="93 284" stroke-dashoffset="-246" transform="rotate(-90 80 80)"/>
            <circle cx="80" cy="80" r="60" fill="none" stroke="var(--yeld)" stroke-width="28" stroke-dasharray="48 329" stroke-dashoffset="-339" transform="rotate(-90 80 80)"/>
            <text x="80" y="77" text-anchor="middle" font-family="Poppins,sans-serif" font-size="22" font-weight="900" fill="var(--txt)">128</text>
            <text x="80" y="96" text-anchor="middle" font-family="DM Sans,sans-serif" font-size="11" fill="var(--muted)">étudiants</text>
          </svg>
          <div class="donut-legend">
            <div class="dleg-item">
              <div class="dleg-dot" style="background:var(--v)"></div>
              <div><div style="font-weight:700;">UX/UI Design</div><div style="font-size:11px;color:var(--muted);">41 étudiants · 32%</div></div>
            </div>
            <div class="dleg-item">
              <div class="dleg-dot" style="background:var(--mintd)"></div>
              <div><div style="font-weight:700;">Figma Masterclass</div><div style="font-size:11px;color:var(--muted);">35 étudiants · 27%</div></div>
            </div>
            <div class="dleg-item">
              <div class="dleg-dot" style="background:var(--skyd)"></div>
              <div><div style="font-weight:700;">Fondamentaux UX</div><div style="font-size:11px;color:var(--muted);">28 étudiants · 22%</div></div>
            </div>
            <div class="dleg-item">
              <div class="dleg-dot" style="background:var(--yeld)"></div>
              <div><div style="font-weight:700;">UX Research</div><div style="font-size:11px;color:var(--muted);">24 étudiants · 19%</div></div>
            </div>
          </div>
        </div>
      </div>

      <!-- PERFORMANCE PAR COURS -->
      <div class="chart-area">
        <div class="sec-hdr" style="margin-bottom:16px;"><span class="sec-title">📚 Performance par cours</span></div>
        @foreach($this->coursePerformance as $course)
        <div class="course-perf-item">
          <div class="cpi-ico">{{ $course['icon'] }}</div>
          <div class="cpi-info">
            <div class="cpi-name">{{ $course['name'] }}</div>
            <div class="cpi-sub">{{ $course['students'] }} étudiants · ⭐ {{ number_format($course['rating'], 1) }} · {{ number_format($course['monthlyRevenue']) }}€/mois</div>
            <div class="cpi-bar-wrap">
              <div class="cpi-bar">
                <div class="cpi-fill" style="width:{{ $course['completion'] }}%;background:{{ $course['color'] }};"></div>
              </div>
              <span style="font-size:12px;font-weight:700;color:{{ $course['color'] }};">{{ $course['completion'] }}%</span>
            </div>
          </div>
          <div style="text-align:right;font-family:Poppins,sans-serif;font-size:18px;font-weight:900;color:{{ $course['color'] }};">{{ number_format($course['monthlyRevenue']) }}€</div>
        </div>
        @endforeach
      </div>

      <!-- ACTIVITY HEATMAP -->
      <div class="chart-area">
        <div class="sec-hdr" style="margin-bottom:16px;"><span class="sec-title">📅 Activité des étudiants (3 mois)</span></div>
        <div class="heatmap-grid" id="heatmap"></div>
        <div style="display:flex;align-items:center;gap:6px;margin-top:10px;font-size:11px;color:var(--muted);">
          <span>Moins</span>
          <div style="width:12px;height:12px;border-radius:2px;" class="hm-0"></div>
          <div style="width:12px;height:12px;border-radius:2px;" class="hm-1"></div>
          <div style="width:12px;height:12px;border-radius:2px;" class="hm-2"></div>
          <div style="width:12px;height:12px;border-radius:2px;" class="hm-3"></div>
          <div style="width:12px;height:12px;border-radius:2px;" class="hm-4"></div>
          <span>Plus</span>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN (STICKY) -->
    <div style="display:flex;flex-direction:column;gap:18px;position:sticky;top:72px;">

      <!-- TOTAL REVENUE CARD -->
      <div class="card card-p" style="background:var(--vgrad2);">
        <div style="color:rgba(255,255,255,.7);font-size:12px;font-weight:600;margin-bottom:8px;">💰 REVENUS TOTAUX</div>
        <div style="font-family:Poppins,sans-serif;font-size:36px;font-weight:900;color:#fff;line-height:1;">{{ number_format($totalRevenue) }} €</div>
        <div style="font-size:12px;color:rgba(255,255,255,.7);margin-top:6px;">Depuis le début · Janv. 2024</div>
        <div style="margin-top:14px;height:6px;background:rgba(255,255,255,.15);border-radius:var(--rp);overflow:hidden;">
          <div style="height:100%;width:94.7%;background:linear-gradient(90deg,#A7F3D0,#34D399);border-radius:var(--rp);"></div>
        </div>
        <div style="font-size:11px;color:rgba(255,255,255,.65);margin-top:5px;">Objectif 2026 : 40 000€ · 87% atteint</div>
        <div style="margin-top:16px;display:grid;grid-template-columns:1fr 1fr;gap:8px;">
          <div style="background:rgba(255,255,255,.1);border-radius:var(--rm);padding:12px;text-align:center;border:1px solid rgba(255,255,255,.1);">
            <div style="font-family:Poppins,sans-serif;font-size:18px;font-weight:900;color:#fff;">{{ number_format($monthlyRevenue) }}€</div>
            <div style="font-size:10px;color:rgba(255,255,255,.6);">Ce mois</div>
          </div>
          <div style="background:rgba(255,255,255,.1);border-radius:var(--rm);padding:12px;text-align:center;border:1px solid rgba(255,255,255,.1);">
            <div style="font-family:Poppins,sans-serif;font-size:18px;font-weight:900;color:#fff;">{{ number_format($quarterlyRevenue) }}€</div>
            <div style="font-size:10px;color:rgba(255,255,255,.6);">Ce trimestre</div>
          </div>
        </div>
      </div>

      <!-- RATINGS -->
      <div class="card card-p">
        <div class="card-title">⭐ Notes & Avis</div>
        <div style="text-align:center;margin-bottom:16px;">
          <div style="font-family:Poppins,sans-serif;font-size:48px;font-weight:900;color:var(--v);">{{ number_format($averageRating, 1) }}</div>
          <div style="font-size:22px;margin-bottom:4px;">⭐⭐⭐⭐⭐</div>
          <div style="font-size:12px;color:var(--muted);">Basé sur 312 avis</div>
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;">
          @foreach($this->ratingsBreakdown as $rating)
          <div style="display:flex;align-items:center;gap:8px;font-size:12px;">
            <span style="min-width:20px;color:var(--muted);">{{ $rating['stars'] }}⭐</span>
            <div style="flex:1;height:7px;background:var(--bg);border-radius:var(--rp);overflow:hidden;">
              <div style="height:100%;width:{{ $rating['percent'] }}%;background:var(--yeld);border-radius:var(--rp);opacity:{{ 1 - ($rating['stars'] - 1) * 0.15 }};"></div>
            </div>
            <span style="color:var(--muted);min-width:28px;">{{ $rating['percent'] }}%</span>
          </div>
          @endforeach
        </div>
      </div>

      <!-- RECENT AVIS -->
      <div class="card card-p">
        <div class="card-title">💬 Derniers avis</div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          @foreach($this->recentReviews as $review)
          <div style="padding:12px;background:var(--bg);border-radius:var(--rm);border-left:3px solid var(--yeld);">
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px;">
              <div class="av-sm" style="background:{{ $review['gradient'] }};width:24px;height:24px;font-size:9px;">{{ $review['initials'] }}</div>
              <span style="font-size:12px;font-weight:600;">{{ $review['name'] }}</span>
              <span style="margin-left:auto;font-size:12px;color:var(--yeld);">@for($i = 0; $i < $review['rating']; $i++)⭐@endfor</span>
            </div>
            <div style="font-size:12px;color:var(--txt);line-height:1.5;font-style:italic;">{{ $review['text'] }}</div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>

  <script>
    document.addEventListener('livewire:updated', function() {
      initCharts();
    });

    document.addEventListener('DOMContentLoaded', function() {
      initCharts();
    });

    function initCharts() {
      const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
      const vals = [1840, 2020, 1760, 2160, 2330, 2840, 0, 0, 0, 0, 0, 0];
      const maxV = Math.max(...vals.filter(v => v > 0));
      const chart = document.getElementById('revenueChart');
      const labels = document.getElementById('chartLabels');

      if (!chart || chart.children.length > 0) return;

      vals.slice(0, 7).forEach(function(v, i) {
        const wrap = document.createElement('div');
        wrap.className = 'chart-bar-wrap';
        if (v > 0) {
          const bar = document.createElement('div');
          bar.className = 'chart-bar';
          bar.style.cssText = 'height:0;background:' + (i === 5 ? 'var(--vgrad)' : 'rgba(13,148,136,.2)') + ';';
          bar.setAttribute('data-val', v + '€');
          setTimeout(function(b, h) { b.style.height = h + 'px'; b.style.transition = 'height .8s ease'; }, (i * 80 + 300), bar, (v / maxV) * 170);
          const valLbl = document.createElement('div');
          valLbl.className = 'chart-lbl-val';
          valLbl.style.color = (i === 5) ? 'var(--v)' : 'var(--muted)';
          valLbl.textContent = v + '€';
          wrap.appendChild(bar);
          wrap.appendChild(valLbl);
        } else {
          const bar2 = document.createElement('div');
          bar2.style.cssText = 'flex:1;background:#F3F4F6;border-radius:8px 8px 0 0;';
          wrap.appendChild(bar2);
          const noLbl = document.createElement('div');
          noLbl.className = 'chart-lbl';
          noLbl.style.color = '#E5E7EB';
          noLbl.textContent = '—';
          wrap.appendChild(noLbl);
        }
        const lbl = document.createElement('div');
        lbl.className = 'chart-lbl';
        lbl.textContent = months[i];
        wrap.appendChild(lbl);
        chart.appendChild(wrap);
      });

      // Heatmap
      const hm = document.getElementById('heatmap');
      if (!hm || hm.children.length > 0) return;

      const levels = [0,1,2,1,0,3,2,1,4,3,2,1,0,0,1,2,3,4,3,2,1,2,3,4,2,1,0,1,2,3,4,3,2,1,2,3,1,0,0,1,2,3,2,1,0,0,1,2,3,4,3,2,1,2,3,4,2,1,0,1,2,1,2,3,4,3,2,1,0,1,2,3,2,1,0,0,1,2,1,0,0,2,3,2,1,0,0,1];
      levels.forEach(function(l, i) {
        const cell = document.createElement('div');
        cell.className = 'hm-cell hm-' + l;
        cell.title = 'Activité: ' + ['Faible', 'Basse', 'Moyenne', 'Haute', 'Très haute'][l];
        cell.onclick = function() {
          Livewire.dispatch('showMessage', ['📅 Activité: ' + ['Faible', 'Basse', 'Moyenne', 'Haute', 'Très haute'][l]]);
        };
        hm.appendChild(cell);
      });
    }
  </script>
</div>
