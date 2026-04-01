<style>
.student-grid{display:grid;grid-template-columns:1fr 320px;gap:22px;align-items:start;}
.student-table-wrap{overflow-x:auto;}
.search-filter-bar{display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;}
.filter-select{padding:8px 12px;border:1.5px solid var(--border);border-radius:var(--rp);font-family:DM Sans,sans-serif;font-size:12px;color:var(--muted);background:#fff;cursor:pointer;}
.student-row-detail{display:flex;gap:10px;align-items:center;padding:12px 14px;border-radius:var(--rm);border:1.5px solid var(--border);background:var(--bg);transition:all .2s;cursor:pointer;margin-bottom:8px;}
.student-row-detail:hover{background:var(--vxl);border-color:var(--vl);transform:translateX(3px);}
.student-row-detail.selected{background:var(--vxl);border-color:var(--v);}
.srd-av{width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:700;font-size:14px;color:#fff;flex-shrink:0;}
.srd-info{flex:1;min-width:0;}
.srd-name{font-size:13px;font-weight:700;color:var(--txt);}
.srd-course{font-size:11px;color:var(--muted);margin-top:1px;}
.srd-prog-row{display:flex;align-items:center;gap:8px;margin-top:6px;}
.srd-bar{flex:1;height:5px;background:rgba(0,0,0,.07);border-radius:var(--rp);overflow:hidden;}
.srd-fill{height:100%;border-radius:var(--rp);}
.srd-pct{font-family:Poppins,sans-serif;font-size:12px;font-weight:800;min-width:32px;text-align:right;}
.srd-score{font-family:Poppins,sans-serif;font-size:13px;font-weight:700;flex-shrink:0;}
.srd-last{font-size:10px;color:var(--muted);flex-shrink:0;}
.srd-actions{display:flex;gap:6px;flex-shrink:0;}
.detail-panel{position:sticky;top:72px;display:flex;flex-direction:column;gap:16px;}
.dp-card{background:var(--card);border-radius:var(--r);border:1.5px solid var(--border);box-shadow:var(--sh);overflow:hidden;}
.dp-header{padding:20px;display:flex;flex-direction:column;align-items:center;text-align:center;background:var(--vgrad2);}
.dp-av{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:900;font-size:24px;color:#fff;margin-bottom:10px;border:3px solid rgba(255,255,255,.3);}
.dp-name{font-family:Poppins,sans-serif;font-size:16px;font-weight:800;color:#fff;}
.dp-email{font-size:11px;color:rgba(255,255,255,.7);margin-top:2px;}
.dp-body{padding:16px;}
.dp-row{display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid var(--border);}
.dp-row:last-child{border-bottom:none;}
.dp-lbl{font-size:12px;color:var(--muted);}
.dp-val{font-size:13px;font-weight:600;color:var(--txt);}
.tab-bar{display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:24px;}
.tab-item{padding:12px 16px;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;}
.tab-item:hover{color:var(--txt);}
.tab-item.active{color:var(--v);border-bottom-color:var(--v);}
@media(max-width:1100px){.student-grid{grid-template-columns:1fr;}.detail-panel{position:static;}}
</style>

<div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;">👨‍🎓 Mes Étudiants</h1>
            <p style="color:var(--muted);margin-top:4px;">{{ $this->allStudentsEnrolled }} étudiants actifs</p>
        </div>
    </div>

    <!-- TABS -->
    <div class="tab-bar">
        <div class="tab-item @if($filter === 'tous') active @endif" wire:click="$set('filter', 'tous')" style="cursor:pointer;">
            Tous <span style="opacity:.7">({{ $this->allStudentsEnrolled }})</span>
        </div>
        <div class="tab-item @if($filter === 'actifs') active @endif" wire:click="$set('filter', 'actifs')" style="cursor:pointer;">
            Actifs <span style="opacity:.7">({{ $this->activeStudents }})</span>
        </div>
        <div class="tab-item @if($filter === 'inactifs') active @endif" wire:click="$set('filter', 'inactifs')" style="cursor:pointer;">
            Inactifs
        </div>
        <div class="tab-item @if($filter === 'difficulte') active @endif" wire:click="$set('filter', 'difficulte')" style="cursor:pointer;">
            En difficulté <span style="opacity:.7">({{ $this->strugglingStudents }})</span>
        </div>
        <div class="tab-item @if($filter === 'termines') active @endif" wire:click="$set('filter', 'termines')" style="cursor:pointer;">
            Terminés <span style="opacity:.7">({{ $this->completedStudents }})</span>
        </div>
    </div>

    <!-- STATS -->
    <div class="grid-5 fu fu1" style="margin-bottom:24px;">
        <div class="stat-card" style="border-top:3px solid var(--v)"><div class="s-ico">👨‍🎓</div><div class="s-val">{{ $this->allStudentsEnrolled }}</div><div class="s-lbl">Total étudiants</div></div>
        <div class="stat-card" style="border-top:3px solid var(--mintd)"><div class="s-ico">✅</div><div class="s-val">{{ $this->activeStudents }}</div><div class="s-lbl">Actifs cette semaine</div></div>
        <div class="stat-card" style="border-top:3px solid var(--yeld)"><div class="s-ico">⚠️</div><div class="s-val">{{ $this->strugglingStudents }}</div><div class="s-lbl">En difficulté</div></div>
        <div class="stat-card" style="border-top:3px solid var(--skyd)"><div class="s-ico">🎓</div><div class="s-val">{{ $this->completedStudents }}</div><div class="s-lbl">Certifiés</div></div>
        <div class="stat-card" style="border-top:3px solid var(--rosed)"><div class="s-ico">📊</div><div class="s-val">{{ $this->averageCompletion }}%</div><div class="s-lbl">Complétion moy.</div></div>
    </div>

    <!-- MAIN GRID -->
    <div class="student-grid fu fu2">
        <div>
            <!-- SEARCH + FILTER -->
            <div class="search-filter-bar">
                <div class="search-bar" style="flex:1;min-width:180px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input wire:model.live="searchQuery" placeholder="Rechercher un étudiant…"/>
                </div>
                <select class="filter-select" wire:model.live="courseFilter">
                    <option value="">Tous les cours</option>
                    @foreach($this->courses as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                <select class="filter-select" wire:model.live="sortBy">
                    <option value="recent">Trier par activité</option>
                    <option value="creation">Par création</option>
                </select>
                <select class="filter-select" wire:model.live="inactiveDaysThreshold">
                    <option value="7">Inactif depuis 7j+</option>
                    <option value="14">Inactif depuis 14j+</option>
                    <option value="30">Inactif depuis 30j+</option>
                </select>
            </div>

            <!-- STUDENTS LIST -->
            <div id="studentsList">
                @forelse($this->students as $student)
                    @php
                        $inscription = $student->inscriptions->first();
                        $progress = $inscription?->progress ?? 0;
                        $colorMap = match(true) {
                            $progress < 30 => '#DC2626',
                            $progress < 60 => '#D97706',
                            $progress < 90 => '#0284C7',
                            default => '#059669'
                        };
                        $initials = strtoupper(implode('', array_map(fn($w) => $w[0], explode(' ', $student->name))));
                        $lastActive = $student->updated_at?->diffForHumans() ?? 'Jamais';
                        $status = $student->updated_at?->gt(now()->subDays(7)) ? 'actif' : 'inactif';
                        $inactiveDays = $student->updated_at ? $student->updated_at->diffInDays(now()) : 999;
                    @endphp
                    <div class="student-row-detail @if($selectedStudentId === $student->id) selected @endif"
                         wire:click="selectStudent({{ $student->id }})"
                         data-status="{{ $inscription && $inscription->progress < 30 ? 'difficulte' : ($inscription && $inscription->progress == 100 ? 'termine' : 'actif') }}">
                        <div class="srd-av" style="background:linear-gradient(135deg,{{ $colorMap }},{{ adjustBrightness($colorMap, 30) }})">
                            {{ $initials }}
                        </div>
                        <div class="srd-info">
                            <div class="srd-name">{{ $student->name }}</div>
                            <div class="srd-course">
                                @if($inscription)
                                    {{ $inscription->cours->title ?? 'N/A' }}
                                @else
                                    Aucun cours
                                @endif
                            </div>
                            @if($inscription)
                                <div class="srd-prog-row">
                                    <div class="srd-bar"><div class="srd-fill" style="width:{{ $progress }}%;background:{{ $colorMap }};"></div></div>
                                    <div class="srd-pct" style="color:{{ $colorMap }};">{{ $progress }}%</div>
                                </div>
                            @endif
                        </div>
                        @if($inscription)
                            <div class="srd-score" style="color:{{ $colorMap }};">{{ round($progress) }}/100</div>
                        @endif
                        <div class="srd-last">{{ $student->updated_at?->diffForHumans(short: true) ?? 'Jamais' }}</div>
                        <div class="srd-actions">
                            <a href="{{ route('formateur.forum') }}" class="btn btn-sm btn-ghost">💬</a>
                            <span class="pill @if($status === 'actif') pill-green @else pill-red @endif">
                                @if($status === 'actif')
                                    ✓ Actif
                                @else
                                    ✕ Inactif
                                @endif
                            </span>
                            @if($inactiveDays >= (int) $inactiveDaysThreshold)
                                <button class="btn btn-sm btn-outline" wire:click.stop="sendReminder({{ $student->id }})">🔔 Relancer</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:40px;color:var(--muted);">
                        <p style="font-size:14px;">Aucun étudiant trouvé</p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINATION -->
            @if($this->students->hasPages())
                <div style="text-align:center;padding:16px;font-size:13px;color:var(--muted);">
                    {{ $this->students->links() }}
                </div>
            @endif
        </div>

        <!-- DETAIL PANEL -->
        @if($this->selectedStudentDetail)
            @php
                $student = $this->selectedStudentDetail;
                $inscription = $student->inscriptions->first();
                $progress = $inscription?->progress ?? 0;
                $colorMap = match(true) {
                    $progress < 30 => '#DC2626',
                    $progress < 60 => '#D97706',
                    $progress < 90 => '#0284C7',
                    default => '#059669'
                };
                $initials = strtoupper(implode('', array_map(fn($w) => $w[0], explode(' ', $student->name))));
                $status = $student->updated_at?->gt(now()->subDays(7)) ? 'Actif' : 'Inactif';
                $statusColor = $status === 'Actif' ? '#4ADE80' : '#EF4444';
            @endphp
            <div class="detail-panel">
                <div class="dp-card">
                    <div class="dp-header">
                        <div class="dp-av" style="background:linear-gradient(135deg,{{ $colorMap }},{{ adjustBrightness($colorMap, 30) }})">
                            {{ $initials }}
                        </div>
                        <div class="dp-name">{{ $student->name }}</div>
                        <div class="dp-email">{{ $student->email }}</div>
                        <div style="margin-top:8px;">
                            <span class="pill" style="background:rgba(74,222,128,.2);color:{{ $statusColor }};">
                                ● {{ $status }}
                            </span>
                        </div>
                    </div>
                    <div class="dp-body">
                        <div class="dp-row"><span class="dp-lbl">Cours suivi</span><span class="dp-val">{{ $inscription->cours->title ?? 'N/A' }}</span></div>
                        <div class="dp-row"><span class="dp-lbl">Progression</span><span class="dp-val" style="color:{{ $colorMap }};">{{ $progress }}%</span></div>
                        <div class="dp-row"><span class="dp-lbl">Score estimé</span><span class="dp-val">{{ round($progress) }}/100</span></div>
                        <div class="dp-row"><span class="dp-lbl">Inscrit depuis</span><span class="dp-val">{{ $inscription->enrolled_at?->format('d M Y') ?? 'N/A' }}</span></div>
                        <div class="dp-row"><span class="dp-lbl">Dernière activité</span><span class="dp-val">{{ $student->updated_at?->format('d M Y H:i') ?? 'N/A' }}</span></div>
                        <div class="dp-row"><span class="dp-lbl">Statut</span><span class="dp-val" style="text-transform:capitalize;">{{ $inscription->status ?? 'N/A' }}</span></div>
                    </div>
                    <div style="padding:16px;display:flex;flex-direction:column;gap:8px;">
                        <a href="{{ route('formateur.forum') }}" class="btn btn-primary" style="width:100%;justify-content:center;text-decoration:none;">💬 Envoyer un message</a>
                        <button class="btn btn-outline" style="width:100%;justify-content:center;">📊 Rapport complet</button>
                        <div class="card" style="padding:10px;background:var(--bg);">
                            <div style="font-size:11px;color:var(--muted);margin-bottom:6px;">Message privé rapide</div>
                            <textarea class="form-input" wire:model.live="messageText" placeholder="Écrire un message..." style="min-height:70px;"></textarea>
                            <button class="btn btn-sm btn-primary" style="margin-top:8px;width:100%;" wire:click="sendMessageToSelectedStudent">Envoyer</button>
                        </div>
                    </div>
                </div>
                <div class="dp-card card-p">
                    <div class="card-title" style="margin-bottom:12px;">📈 Activité (7 derniers jours)</div>
                    <div style="display:flex;align-items:flex-end;gap:8px;height:60px;justify-content:space-between;">
                        @forelse($this->studentActivity as $index => $activity)
                        <div style="flex:1;height:{{ $activity }}%;background:{{ $index === 6 ? 'var(--vgrad)' : 'var(--vxl)' }};border-radius:4px 4px 0 0;"></div>
                        @empty
                        <div style="text-align:center;width:100%;color:var(--muted);font-size:12px;">Aucune donnée d'activité</div>
                        @endforelse
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:10px;color:var(--muted);">
                        <span>L</span><span>M</span><span>M</span><span>J</span><span>V</span><span>S</span><span>D</span>
                    </div>
                </div>
            </div>
        @else
            <div class="detail-panel">
                <div class="dp-card" style="display:flex;align-items:center;justify-content:center;min-height:300px;color:var(--muted);">
                    <div style="text-align:center;">
                        <p style="font-size:14px;">Sélectionnez un étudiant pour voir ses détails</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="card card-p" style="margin-top:22px;">
        <div class="card-title" style="margin-bottom:10px;">📝 Devoirs / Soumissions en attente de correction</div>
        <div style="display:flex;flex-direction:column;gap:8px;">
            @forelse($this->pendingSubmissions as $attempt)
                <div style="padding:10px;border:1px solid var(--border);border-radius:10px;background:var(--bg);">
                    <div style="display:flex;justify-content:space-between;gap:10px;align-items:center;flex-wrap:wrap;">
                        <div style="font-size:13px;">
                            <strong>{{ $attempt->user->name ?? 'Étudiant' }}</strong>
                            · {{ $attempt->quiz->title ?? 'Devoir' }}
                            · {{ $attempt->quiz->cours->title ?? 'Cours' }}
                        </div>
                        <button class="btn btn-sm btn-outline" wire:click="startGrading({{ $attempt->id }})">Noter</button>
                    </div>

                    @if($selectedAttemptId === $attempt->id)
                        <div style="margin-top:8px;display:grid;grid-template-columns:120px 1fr auto;gap:8px;align-items:center;">
                            <input type="number" min="0" max="100" class="form-input" wire:model.live="gradeScore" placeholder="Note /100"/>
                            <input type="text" class="form-input" wire:model.live="feedbackText" placeholder="Feedback formateur"/>
                            <button class="btn btn-sm btn-primary" wire:click="submitGrade">Valider</button>
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding:14px;color:var(--muted);text-align:center;">Aucune soumission en attente.</div>
            @endforelse
        </div>
    </div>
</div>

@php
    // Helper function to adjust color brightness
    function adjustBrightness($color, $percent) {
        // Convert hex to RGB
        $color = ltrim($color, '#');
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));

        // Adjust
        $r = (int)($r * (1 + $percent / 100));
        $g = (int)($g * (1 + $percent / 100));
        $b = (int)($b * (1 + $percent / 100));

        // Clamp values
        $r = min(255, $r);
        $g = min(255, $g);
        $b = min(255, $b);

        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }
@endphp
