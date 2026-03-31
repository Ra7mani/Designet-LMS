<style>
.course-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;}
.ccard{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;transition:all .25s cubic-bezier(.22,1,.36,1);cursor:pointer;}
.ccard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.ccard-top{padding:22px 20px 16px;position:relative;}
.ccard-emoji{font-size:36px;margin-bottom:8px;display:block;}
.ccard-tag{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);}
.ccard-title{font-family:Poppins,sans-serif;font-size:15px;font-weight:700;color:var(--txt);margin-bottom:4px;}
.ccard-sub{font-size:11px;color:var(--muted);}
.ccard-bot{padding:14px 20px 18px;border-top:1.5px solid var(--border);}
.ccard-stats{display:flex;gap:14px;margin-bottom:10px;font-size:12px;color:var(--muted);flex-wrap:wrap;}
.ccard-stat{display:flex;align-items:center;gap:4px;}
.ccard-actions{display:flex;gap:8px;}
.detail-two{display:grid;grid-template-columns:1fr 300px;gap:22px;align-items:start;}
.chapter-item{display:flex;align-items:center;gap:12px;padding:13px 16px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);transition:all .2s;cursor:pointer;margin-bottom:10px;}
.chapter-item:hover{background:var(--vxl);border-color:var(--vl);}
.chapter-num{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:800;font-size:12px;flex-shrink:0;}
.chapter-info{flex:1;min-width:0;}
.chapter-title{font-size:13px;font-weight:600;color:var(--txt);}
.chapter-meta{font-size:11px;color:var(--muted);margin-top:2px;}
.chapter-actions{display:flex;gap:6px;}
@media(max-width:1100px){.course-grid{grid-template-columns:repeat(2,1fr);}.detail-two{grid-template-columns:1fr;}}
@media(max-width:640px){.course-grid{grid-template-columns:1fr;}}
</style>

<div>
  <!-- PAGE HEADER -->
  <div style="margin-bottom:32px;">
    <div style="display:flex;justify-content:space-between;align-items:start;flex-wrap:wrap;gap:16px;">
      <div>
        <h1 style="font-size:24px;font-weight:800;margin-bottom:4px;">📚 Mes Cours</h1>
        <p style="color:var(--muted);font-size:13px;">{{ $this->stats['published'] }} publiés · {{ $this->stats['draft'] }} brouillons</p>
      </div>
      <a href="{{ route('formateur.creer-cours') }}" class="btn btn-primary btn-sm"><svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Nouveau cours</a>
    </div>
  </div>

  <!-- STATS -->
  <div class="grid-4 fu fu1" style="margin-bottom:32px;">
    <div class="stat-card" style="border-top:3px solid var(--v)"><div class="s-ico">📚</div><div class="s-val">{{ $this->stats['published'] }}</div><div class="s-lbl">Cours publiés</div><div class="s-trend trend-up">↑ {{ $this->stats['draft'] }} brouillons</div></div>
    <div class="stat-card" style="border-top:3px solid var(--mintd)"><div class="s-ico">👨‍🎓</div><div class="s-val">{{ $this->stats['totalStudents'] }}</div><div class="s-lbl">Étudiants total</div><div class="s-trend trend-up">↑ Tous vos cours</div></div>
    <div class="stat-card" style="border-top:3px solid var(--yeld)"><div class="s-ico">⭐</div><div class="s-val">{{ number_format($this->stats['averageRating'], 1) }}</div><div class="s-lbl">Note moyenne</div><div class="s-trend trend-up">↑ {{ $this->stats['averageRating'] >= 4.5 ? 'Excellent' : 'Bon' }}</div></div>
    <div class="stat-card" style="border-top:3px solid var(--rosed)"><div class="s-ico">📝</div><div class="s-val">{{ $this->stats['pendingAssignments'] }}</div><div class="s-lbl">Devoirs créés</div><div class="s-trend trend-up">📋 Dans vos cours</div></div>
  </div>

  <!-- FILTERS & SEARCH -->
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
    <div class="tab-bar">
      <button class="tab-item{{ $this->filterStatus === 'tous' ? ' active' : '' }}" wire:click="$set('filterStatus', 'tous')">Tous</button>
      <button class="tab-item{{ $this->filterStatus === 'published' ? ' active' : '' }}" wire:click="$set('filterStatus', 'published')">Publiés</button>
      <button class="tab-item{{ $this->filterStatus === 'draft' ? ' active' : '' }}" wire:click="$set('filterStatus', 'draft')">Brouillons</button>
    </div>
    <div class="search-bar" style="min-width:200px;"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input wire:model.live="searchQuery" placeholder="Filtrer…" style="border:none;background:transparent;color:var(--txt);outline:none;width:100%;"/></div>
  </div>

  <!-- COURSES GRID -->
  <section style="margin-bottom:40px;">
    <div class="course-grid">
      @forelse($this->filteredCourses as $course)
        <div class="ccard" wire:click="selectCourse({{ $course->id }})">
          <div class="ccard-top" style="background:{{ $course->status === 'published' ? 'var(--vxl)' : '#F3F4F6' }};">
            <span class="ccard-emoji">💡</span>
            <span class="ccard-tag" style="background:{{ $course->status === 'published' ? 'var(--vxl);color:var(--v)' : '#E5E7EB;color:#6B7280' }};">{{ $course->status === 'published' ? '✅ Publié' : '🚧 Brouillon' }}</span>
            <div class="ccard-title">{{ $course->title }}</div>
            <div class="ccard-sub">{{ $course->category ?? 'Design' }} · {{ $course->level ?? 'Tous niveaux' }} · {{ $course->chapitres->count() }} leçons</div>
          </div>
          <div class="ccard-bot">
            <div class="ccard-stats">
              <div class="ccard-stat">👨‍🎓 {{ $course->inscriptions->count() }} étudiants</div>
              <div class="ccard-stat">⭐ {{ number_format($course->rating ?? 0, 1) }}</div>
              <div class="ccard-stat">💰 {{ $course->price == 0 ? 'Gratuit' : number_format($course->price, 0).' TND' }}</div>
              <div class="ccard-stat">📊 {{ intval($course->inscriptions->avg('progress') ?? 0) }}% complétion</div>
            </div>
            <div style="margin-bottom:10px;"><div class="prog-bar"><div class="prog-fill prog-v" style="width:{{ intval($course->inscriptions->avg('progress') ?? 0) }}%;"></div></div></div>
            <div class="ccard-actions">
              <a href="{{ route('formateur.editer-cours', $course->id) }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center;">✏️ Modifier</a>
              <button class="btn btn-outline btn-sm">Stats</button>
              <button class="btn btn-ghost btn-sm">Voir</button>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--muted);">
          Aucun cours trouvé. <a href="{{ route('formateur.creer-cours') }}" style="color:var(--v);font-weight:600;">Créer un nouveau cours</a>
        </div>
      @endforelse
    </div>

    <!-- PAGINATION -->
    @if($this->filteredCourses->hasPages())
      <div style="margin-top:32px;display:flex;justify-content:center;">
        {{ $this->filteredCourses->links() }}
      </div>
    @endif
  </section>

  <!-- COURSE DETAILS -->
  @if($this->courseDetails)
    <section>
      <div style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;margin-bottom:4px;">📋 Chapitres — {{ $this->courseDetails->title }}</h2>
      </div>

      <div class="detail-two">
        <div>
          @forelse($this->courseDetails->chapitres as $index => $chapter)
            <div class="chapter-item">
              <div class="chapter-num" style="background:{{ $index < 3 ? 'var(--mintd)' : 'var(--v)' }};color:#fff;">{{ $index + 1 }}</div>
              <div class="chapter-info">
                <div class="chapter-title">{{ $chapter->title }}</div>
                <div class="chapter-meta">{{ $chapter->lecons->count() ?? 0 }} leçons · {{ intval($chapter->lecons->count() * 12) }} min · Complété par {{ $this->chapterCompletionPercentages[$chapter->id] ?? 60 }}%</div>
              </div>
              <div class="chapter-actions">
                <a href="{{ route('formateur.editer-cours', $this->courseDetails->id) }}" class="btn btn-sm btn-ghost">Éditer</a>
              </div>
            </div>
          @empty
            <div style="text-align:center;padding:40px;color:var(--muted);">Aucun chapitre créé</div>
          @endforelse
        </div>

        <!-- COURSE STATS -->
        <div class="card card-p">
          <div class="card-title">📊 Statistiques du cours</div>
          <div style="display:flex;flex-direction:column;gap:14px;">
            <div>
              <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px;">
                <span style="color:var(--muted);">Complétion moyenne</span>
                <span style="font-weight:700;color:var(--v);">{{ intval($this->courseDetails->inscriptions->avg('progress') ?? 0) }}%</span>
              </div>
              <div class="prog-bar"><div class="prog-fill prog-v" style="width:{{ intval($this->courseDetails->inscriptions->avg('progress') ?? 0) }}%;"></div></div>
            </div>
            <div>
              <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px;">
                <span style="color:var(--muted);">Étudiants inscrits</span>
                <span style="font-weight:700;color:var(--mintd);">{{ $this->courseDetails->inscriptions->count() }}</span>
              </div>
              <div class="prog-bar"><div class="prog-fill prog-mint" style="width:{{ min(($this->courseDetails->inscriptions->count() / 100) * 100, 100) }}%;"></div></div>
            </div>
            <div>
              <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:5px;">
                <span style="color:var(--muted);">Taux satisfaction</span>
                <span style="font-weight:700;color:var(--yeld);">{{ number_format($this->courseDetails->rating ?? 0, 0) }}%</span>
              </div>
              <div class="prog-bar"><div class="prog-fill" style="width:{{ number_format($this->courseDetails->rating ?? 0, 0) }}%;background:var(--yeld);"></div></div>
            </div>
          </div>

          <div style="margin-top:18px;padding-top:14px;border-top:1px solid var(--border);">
            <div style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:10px;">AVIS RÉCENTS</div>
            @forelse($this->courseDetails->avis->take(2) as $review)
              <div style="font-size:13px;color:var(--txt);margin-bottom:8px;padding:10px;background:var(--bg);border-radius:var(--rs);">{{ str_repeat('⭐', intval($review->rating)) }} <em>"{{ $review->comment }}"</em> — {{ $review->user->name ?? 'Anonyme' }}</div>
            @empty
              <div style="font-size:12px;color:var(--muted);padding:10px;">Aucun avis pour le moment</div>
            @endforelse
          </div>
        </div>
      </div>
    </section>
  @endif

</div>
