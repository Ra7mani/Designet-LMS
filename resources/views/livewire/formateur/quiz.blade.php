<div>
<style>
.quiz-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.qcard{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;cursor:pointer;transition:all .25s cubic-bezier(.22,1,.36,1);}
.qcard:hover{transform:translateY(-4px);box-shadow:var(--shlift);}
.qcard-top{padding:20px;position:relative;}
.qcard-ico{font-size:32px;margin-bottom:8px;display:block;}
.qcard-title{font-family:Poppins,sans-serif;font-size:14px;font-weight:700;color:var(--txt);margin-bottom:4px;}
.qcard-sub{font-size:11px;color:var(--muted);}
.qcard-tag{position:absolute;top:14px;right:14px;font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--rp);}
.qcard-bot{padding:12px 20px 16px;border-top:1.5px solid var(--border);}
.qcard-stats{display:flex;gap:12px;margin-bottom:10px;font-size:11px;color:var(--muted);}
.correction-item{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);transition:all .2s;cursor:pointer;margin-bottom:10px;}
.correction-item:hover{background:var(--vxl);border-color:var(--vl);}
.ci-student{display:flex;align-items:center;gap:8px;min-width:160px;}
.ci-info{flex:1;}
.ci-name{font-size:13px;font-weight:600;color:var(--txt);}
.ci-sub{font-size:11px;color:var(--muted);margin-top:1px;}
.correction-modal{background:#fff;border-radius:var(--r);padding:28px;max-width:600px;width:92%;box-shadow:0 24px 60px rgba(13,78,74,.2);animation:pop .35s cubic-bezier(.22,1,.36,1) both;position:relative;}
.score-input-big{font-family:Poppins,sans-serif;font-size:40px;font-weight:900;width:80px;text-align:center;border:2px solid var(--border);border-radius:var(--rm);padding:8px;color:var(--v);}
@media(max-width:960px){.quiz-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){.quiz-grid{grid-template-columns:1fr;}}
</style>

<header class="page-header">
    <div style="flex:1">
        <h1>📝 Quiz &amp; Examens</h1>
        <p>{{ $this->stats['total_quizzes'] }} quiz créés · {{ $this->stats['pending_grading'] }} devoirs à corriger</p>
    </div>
    <div class="tab-bar">
        <div class="tab-item @class(['active' => $this->filter === 'tous'])" wire:click="updateFilter('tous')">Tous</div>
        <div class="tab-item @class(['active' => $this->filter === 'quiz'])" wire:click="updateFilter('quiz')">Quiz</div>
        <div class="tab-item @class(['active' => $this->filter === 'exam'])" wire:click="updateFilter('exam')">Examens</div>
        <div class="tab-item @class(['active' => $this->filter === 'devoir'])" wire:click="updateFilter('devoir')">Devoirs</div>
    </div>
    <button class="btn btn-primary btn-sm" wire:click="openCreateQuiz()">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Créer un quiz
    </button>
</header>

<div class="page-content">
    @if (session()->has('success'))
        <div style="background:var(--mint);color:var(--mintd);padding:12px 16px;border-radius:var(--rm);margin-bottom:16px;font-size:12px;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- STATS -->
    <div class="grid-5 fu fu1">
        <div class="stat-card" style="border-top:3px solid var(--v)">
            <div class="s-ico">📝</div>
            <div class="s-val">{{ $this->stats['total_quizzes'] }}</div>
            <div class="s-lbl">Quiz créés</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--mintd)">
            <div class="s-ico">✅</div>
            <div class="s-val">{{ $this->stats['total_attempts'] }}</div>
            <div class="s-lbl">Tentatives total</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--yeld)">
            <div class="s-ico">📊</div>
            <div class="s-val">{{ round($this->stats['average_score']) }}%</div>
            <div class="s-lbl">Score moyen global</div>
        </div>
        <div class="stat-card" style="border-top:3px solid var(--rosed)">
            <div class="s-ico">📋</div>
            <div class="s-val">{{ $this->stats['pending_grading'] }}</div>
            <div class="s-lbl">Devoirs à corriger</div>
            @if ($this->stats['pending_grading'] > 0)
                <div class="s-trend trend-down">⚠️ Urgent</div>
            @endif
        </div>
        <div class="stat-card" style="border-top:3px solid var(--skyd)">
            <div class="s-ico">🏆</div>
            <div class="s-val">{{ $this->stats['success_rate'] }}%</div>
            <div class="s-lbl">Taux de réussite</div>
        </div>
    </div>

    <!-- DEVOIRS À CORRIGER -->
    @if ($this->pendingSubmissions->count() > 0)
        <section class="fu fu2">
            <div class="sec-hdr">
                <span class="sec-title">🔴 Devoirs à corriger <span class="sec-pill" style="background:var(--peach);color:var(--peachd);">{{ $this->stats['pending_grading'] }} urgents</span></span>
            </div>
            <div class="card card-p" style="padding:16px;">
                @foreach ($this->pendingSubmissions as $submission)
                    <div class="correction-item" wire:click="openCorrection({{ $submission->id }})">
                        <div class="ci-student">
                            <div class="av-sm" style="background:linear-gradient(135deg,#DB2777,#F472B6);width:38px;height:38px;">
                                {{ substr($submission->user->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="ci-name">{{ $submission->user->name }}</div>
                                <div style="font-size:10px;color:var(--muted);">Rendu {{ $submission->created_at->format('d M H:i') }}</div>
                            </div>
                        </div>
                        <div class="ci-info">
                            <div class="ci-name" style="font-size:12px;">{{ $submission->quiz->title }}</div>
                            <div style="font-size:11px;color:var(--muted);">{{ $submission->quiz->cours->title ?? 'Cours' }}</div>
                        </div>
                        <span class="pill pill-orange">À corriger</span>
                        <button class="btn btn-primary btn-sm" onclick="event.stopPropagation();" wire:click.stop="openCorrection({{ $submission->id }})">Corriger →</button>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- MES QUIZ -->
    <section class="fu fu3">
        <div class="sec-hdr">
            <span class="sec-title">📝 Mes Quiz &amp; Examens <span class="sec-pill">{{ $this->quizzes->total() }}</span></span>
        </div>
        @if ($this->quizzes->count() > 0)
            <div class="quiz-grid" id="quizGrid">
                @foreach ($this->quizzes as $quiz)
                    <div class="qcard" data-type="{{ $quiz->type->value }}">
                        <div class="qcard-top" style="background: {{ $this->getQuizColor($quiz->type) }};">
                            <span class="qcard-tag" style="background: {{ $this->getQuizColor($quiz->type) }}; color: {{ $this->getQuizTextColor($quiz->type) }};">
                                @if ($quiz->type->value === 'exam')
                                    🎓 Examen Final
                                @elseif ($quiz->type->value === 'devoir')
                                    📋 Devoir
                                @else
                                    📝 Quiz
                                @endif
                            </span>
                            <span class="qcard-ico">{{ $this->getQuizIcon($quiz->type) }}</span>
                            <div class="qcard-title">{{ $quiz->title }}</div>
                            <div class="qcard-sub">{{ $quiz->duration }} min · {{ $quiz->questions->count() }} questions · {{ ucfirst($quiz->type->value) }}</div>
                        </div>
                        <div class="qcard-bot">
                            <div class="qcard-stats">
                                <span>👨‍🎓 {{ $quiz->attempts->count() }} tentatives</span>
                                <span>📊 Moy. {{ round($quiz->attempts->avg('score_percent') ?? 0) }}%</span>
                                @if ($quiz->type->value !== 'devoir')
                                    <span>✅ {{ $quiz->attempts->where('status', 'completed')->where('score_percent', '>=', $quiz->passing_score)->count() }}/{{ $quiz->attempts->count() }}</span>
                                @endif
                            </div>
                            <div class="btn-ghost btn btn-sm" style="display:flex;justify-content:center;width:100%;">Voir les résultats</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- PAGINATION -->
            <div style="margin-top:24px;">
                {{ $this->quizzes->links() }}
            </div>
        @else
            <div style="text-align:center;color:var(--muted);padding:40px;">
                Aucun quiz trouvé pour ce filtre
            </div>
        @endif
    </section>

    <!-- MODAL CORRECTION -->
    @if ($this->correctionModalOpen && $this->selectedSubmission)
        <div class="modal-bg" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div class="correction-modal">
                <button class="modal-close" wire:click="closeCorrection()" style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:24px;cursor:pointer;">✕</button>
                <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">✏️ Corriger le devoir</h3>
                <p style="color:var(--v);font-weight:600;font-size:14px;margin-bottom:16px;">{{ $this->selectedSubmission->user->name }} — {{ $this->selectedSubmission->quiz->title }}</p>

                <div style="background:var(--bg);border-radius:var(--rm);padding:16px;margin-bottom:18px;">
                    <div style="font-size:12px;font-weight:600;color:var(--muted);margin-bottom:8px;">RENDU DE L'ÉTUDIANT</div>
                    <p style="font-size:13px;color:var(--txt);line-height:1.6;">
                        L'étudiant a tenté le quiz le {{ $this->selectedSubmission->created_at->format('d/m/Y à H:i') }}.
                        Score initial: {{ $this->selectedSubmission->score_percent ?? 'Non noté' }}/100
                    </p>
                </div>

                <div style="display:grid;grid-template-columns:auto 1fr;gap:16px;align-items:center;margin-bottom:16px;">
                    <div style="text-align:center;">
                        <div style="font-size:11px;font-weight:600;color:var(--muted);margin-bottom:6px;">NOTE / 100</div>
                        <input type="number" class="score-input-big" wire:model.live="correctionScore" min="0" max="100"/>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <div style="font-size:12px;font-weight:600;color:var(--muted);">Évaluation rapide</div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <span class="pill pill-green" style="cursor:pointer;" wire:click="$set('correctionScore', 90)">⭐ Excellent (90+)</span>
                            <span class="pill pill-teal" style="cursor:pointer;" wire:click="$set('correctionScore', 80)">👍 Bien (80+)</span>
                            <span class="pill pill-orange" style="cursor:pointer;" wire:click="$set('correctionScore', 65)">👌 Acceptable (65+)</span>
                            <span class="pill pill-red" style="cursor:pointer;" wire:click="$set('correctionScore', 40)">⚠️ À revoir</span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Commentaire pédagogique</label>
                    <textarea class="form-input" rows="4" wire:model="correctionComment" placeholder="Votre retour détaillé pour l'étudiant…"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button class="btn btn-ghost" wire:click="closeCorrection()">Annuler</button>
                    <button class="btn btn-primary" wire:click="submitCorrection()">✅ Envoyer la correction</button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL CREATE QUIZ -->
    @if ($this->createQuizModalOpen)
        <div class="modal-bg" style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div class="correction-modal">
                <button class="modal-close" wire:click="closeCreateQuiz()" style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:24px;cursor:pointer;">✕</button>
                <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">➕ Créer un nouveau quiz</h3>

                <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px;">
                    <div class="form-group">
                        <label class="form-label">Titre du quiz</label>
                        <input class="form-input" placeholder="Ex: Quiz Wireframing Avancé"/>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Cours associé</label>
                            <select class="form-select">
                                @foreach (auth()->user()->cours as $course)
                                    <option>{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select class="form-select">
                                <option value="quiz">Quiz QCM</option>
                                <option value="exam">Examen final</option>
                                <option value="devoir">Devoir libre</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Durée (min)</label>
                            <input class="form-input" type="number" value="20"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Score minimum</label>
                            <input class="form-input" type="number" value="70"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nombre de tentatives</label>
                        <select class="form-select">
                            <option>1 tentative</option>
                            <option selected>3 tentatives</option>
                            <option>Illimitées</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button class="btn btn-ghost" wire:click="closeCreateQuiz()">Annuler</button>
                    <button class="btn btn-primary">Créer le quiz</button>
                </div>
            </div>
        </div>
    @endif
</div>
</div>

