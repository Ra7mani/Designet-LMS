<div wire:poll.5s="refreshRealtimeData">
<style>
.forum-layout{display:grid;grid-template-columns:280px 1fr 300px;height:calc(100vh - 72px);overflow:hidden;}
.channels-panel{background:#fff;border-right:1.5px solid var(--border);display:flex;flex-direction:column;overflow:hidden;}
.ch-hdr{padding:16px;border-bottom:1.5px solid var(--border);}
.ch-search{display:flex;align-items:center;gap:6px;background:var(--bg);border:1.5px solid var(--border);border-radius:var(--rp);padding:7px 12px;}
.ch-search svg{width:14px;height:14px;stroke:var(--muted);fill:none;flex-shrink:0;}
.ch-search input{border:none;outline:none;background:transparent;font-size:12px;color:var(--txt);width:100%;}
.ch-list{flex:1;overflow-y:auto;padding:10px;}
.ch-section{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);padding:10px 8px 5px;}
.ch-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--rs);cursor:pointer;transition:all .2s;margin-bottom:2px;}
.ch-item:hover{background:var(--vxl);}
.ch-item.active{background:linear-gradient(135deg,#0D9488,#0891B2);color:#fff;}
.ch-item.active .ch-name,.ch-item.active .ch-last{color:#fff;}
.ch-item.active .ch-last{color:rgba(255,255,255,.75);}
.ch-ico{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.ch-info{flex:1;min-width:0;}
.ch-name{font-size:13px;font-weight:600;color:var(--txt);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ch-last{font-size:11px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:1px;}
.ch-badge{background:#EF4444;color:#fff;font-size:10px;font-weight:800;border-radius:var(--rp);padding:1px 6px;flex-shrink:0;}
.msg-panel{display:flex;flex-direction:column;background:var(--bg);overflow:hidden;}
.msg-hdr{background:#fff;border-bottom:1.5px solid var(--border);padding:16px 20px;display:flex;align-items:center;gap:12px;flex-shrink:0;}
.msg-hdr-name{font-family:Poppins,sans-serif;font-size:15px;font-weight:700;color:var(--txt);}
.msg-hdr-sub{font-size:12px;color:var(--muted);margin-top:1px;}
.msg-list{flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:4px;}
.msg-date-sep{text-align:center;margin:14px 0;}
.msg-date-sep span{background:#fff;border:1.5px solid var(--border);color:var(--muted);font-size:11px;font-weight:600;padding:4px 14px;border-radius:var(--rp);}
.msg-group{display:flex;gap:10px;align-items:flex-end;margin-bottom:14px;position:relative;}
.msg-group:hover .msg-actions{display:flex;}
.msg-group.own{flex-direction:row-reverse;}
.msg-group.own .msg-actions{flex-direction:row-reverse;}
.msg-actions{display:none;gap:4px;align-items:center;position:absolute;-webkit-backdrop-filter:blur(10px);backdrop-filter:blur(10px);background:rgba(255,255,255,0.95);border-radius:20px;padding:6px 10px;border:1px solid var(--border);z-index:10;top:-28px;right:0;}
.msg-action-btn{width:20px;height:20px;border-radius:50%;border:none;background:transparent;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;transition:all .2s;}
.msg-action-btn:hover{background:var(--vxl);}
.msg-gav{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:700;font-size:12px;color:#fff;flex-shrink:0;margin-bottom:2px;}
.msg-body{display:flex;flex-direction:column;gap:3px;max-width:70%;}
.msg-group.own .msg-body{align-items:flex-end;}
.msg-sender{font-size:11px;font-weight:700;color:var(--v);margin-bottom:2px;padding:0 4px;}
.msg-bubble{padding:11px 15px;border-radius:18px;font-size:13px;line-height:1.55;position:relative;}
.msg-bubble.solution::before{content:'✅ SOLUTION';position:absolute;top:-18px;left:0;font-size:9px;font-weight:700;color:var(--vl);padding:0 6px;}
.msg-bubble.pinned::before{content:'📌 ÉPINGLÉ';position:absolute;top:-18px;left:0;font-size:9px;font-weight:700;color:#D97706;padding:0 6px;}
.msg-bubble.other{background:#fff;border:1.5px solid var(--border);border-bottom-left-radius:4px;color:var(--txt);}
.msg-bubble.own{background:linear-gradient(135deg,#0D9488,#0891B2);color:#fff;border-bottom-right-radius:4px;}
.msg-time{font-size:10px;color:var(--muted);padding:0 4px;}
.msg-composer{background:#fff;border-top:1.5px solid var(--border);padding:14px 20px;flex-shrink:0;}
.composer-box{display:flex;align-items:center;gap:10px;background:var(--bg);border:1.5px solid var(--border);border-radius:var(--rm);padding:10px 14px;}
.composer-box:focus-within{border-color:var(--vl);}
.composer-input{flex:1;border:none;outline:none;background:transparent;font-family:DM Sans,sans-serif;font-size:13px;color:var(--txt);}
.composer-input::placeholder{color:var(--muted);}
.send-btn{width:36px;height:36px;border-radius:50%;background:var(--vgrad);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;flex-shrink:0;}
.send-btn:hover{transform:scale(1.1);}
.send-btn svg{width:15px;height:15px;stroke:#fff;fill:none;}
.threads-panel{background:#fff;border-left:1.5px solid var(--border);display:flex;flex-direction:column;overflow:hidden;}
.tp-hdr{padding:16px;border-bottom:1.5px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.tp-title{font-family:Poppins,sans-serif;font-size:14px;font-weight:700;color:var(--txt);}
.thread-list{flex:1;overflow-y:auto;padding:12px;}
.thread-item{padding:12px;border-radius:var(--rm);border:1.5px solid var(--border);margin-bottom:10px;cursor:pointer;transition:all .2s;}
.thread-item:hover{border-color:var(--vl);background:var(--vxl);}
.thread-item.pinned{border-color:rgba(217,119,6,.25);background:var(--yel);}
.th-top{display:flex;align-items:center;gap:6px;margin-bottom:6px;}
.th-av{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.th-author{font-size:12px;font-weight:600;color:var(--txt);}
.th-time{font-size:10px;color:var(--muted);margin-left:auto;}
.th-title{font-family:Poppins,sans-serif;font-size:12px;font-weight:700;color:var(--txt);margin-bottom:4px;line-height:1.3;}
.th-preview{font-size:11px;color:var(--muted);margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.th-meta{display:flex;gap:10px;font-size:10px;color:var(--muted);}
.announcement-item{padding:12px;border-radius:var(--rm);border-left:4px solid var(--vl);background:var(--vxl);margin-bottom:10px;cursor:pointer;transition:all .2s;}
.announcement-item:hover{border-left-color:var(--v);background:linear-gradient(135deg,rgba(13,148,136,0.1),rgba(8,145,178,0.1));}
.announcement-item.pinned{border-left-color:#D97706;background:rgba(217,119,6,0.08);}
.ann-title{font-size:12px;font-weight:700;color:var(--txt);margin-bottom:3px;}
.ann-preview{font-size:11px;color:var(--muted);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.ann-meta{font-size:10px;color:var(--muted);margin-top:6px;}
@media(max-width:1100px){.forum-layout{grid-template-columns:240px 1fr;}.threads-panel{display:none;}}
@media(max-width:640px){.forum-layout{grid-template-columns:1fr;}.channels-panel{display:none;}}
.private-msg-item{padding:9px 10px;border-radius:var(--rs);cursor:pointer;transition:all .2s;margin-bottom:2px;display:flex;align-items:center;gap:9px;}
.private-msg-item:hover{background:var(--vxl);}
.private-msg-item.active{background:linear-gradient(135deg,#0D9488,#0891B2);color:#fff;}
.av-xs{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;flex-shrink:0;}
.pm-info{flex:1;min-width:0;}
.pm-name{font-size:12px;font-weight:600;color:var(--txt);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.private-msg-item.active .pm-name{color:#fff;}
</style>

<header class="page-header">
    <h1 style="flex:1;">💬 Forum &amp; Messages</h1>
    <div class="tab-bar">
        <div class="tab-item @class(['active' => $this->tab === 'forum'])" wire:click="switchTab('forum')">Forum</div>
        <div class="tab-item @class(['active' => $this->tab === 'privates'])" wire:click="switchTab('privates')">Privés</div>
        <div class="tab-item @class(['active' => $this->tab === 'announcements'])" wire:click="switchTab('announcements')">Annonces</div>
    </div>
    <div class="icon-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <span class="notif-dot"></span>
    </div>
</header>

<div class="page-content">
    @if (session()->has('success'))
        <div style="position:fixed;top:80px;right:20px;background:var(--mint);color:var(--mintd);padding:12px 16px;border-radius:var(--rm);font-size:12px;font-weight:600;z-index:100;">
            {{ session('success') }}
        </div>
    @endif

    @if ($this->tab === 'forum' || $this->tab === 'privates')
        <div class="forum-layout" style="margin:-28px;height:calc(100vh - 72px);">
            <!-- CHANNELS -->
            <div class="channels-panel">
                <div class="ch-hdr">
                    <div style="font-family:Poppins,sans-serif;font-size:14px;font-weight:700;color:var(--txt);margin-bottom:10px;">{{ $this->tab === 'forum' ? 'Espaces de discussion' : 'Messages privés' }}</div>
                    <div class="ch-search">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input wire:model.live="searchQuery" placeholder="Rechercher…"/>
                    </div>
                </div>
                <div class="ch-list">
                    @if ($this->tab === 'forum')
                        <div class="ch-section">📚 Forums Cours</div>
                        @foreach ($this->channels() as $channel)
                            <div class="ch-item @if ($this->selectedChannelId === $channel['id']) active @endif" wire:click="selectChannel({{ $channel['id'] }})">
                                <div class="ch-ico" style="background: {{ $channel['color'] }};">{{ $channel['icon'] }}</div>
                                <div class="ch-info">
                                    <div class="ch-name">{{ $channel['name'] }}</div>
                                    <div class="ch-last">{{ $channel['last_message'] }}</div>
                                </div>
                                @if ($channel['unread'] > 0)
                                    <div class="ch-badge">{{ $channel['unread'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="ch-section">💬 Messages privés</div>
                        @foreach ($this->privateMessages() as $msg)
                            <div class="private-msg-item @if ($this->selectedPrivateUserId === $msg['id']) active @endif" wire:click="selectPrivateUser({{ $msg['id'] }})">
                                <div class="av-xs" style="background: {{ $msg['gradient'] }}">{{ $msg['initials'] }}</div>
                                <div class="pm-info">
                                    <div class="pm-name">{{ $msg['name'] }}</div>
                                    <div style="font-size:10px;color:var(--muted);margin-top:1px;">{{ $msg['last_message'] }}</div>
                                </div>
                                @if ($msg['unread'] > 0)
                                    <div class="ch-badge">{{ $msg['unread'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- MESSAGES -->
            <div class="msg-panel">
                @if ($this->tab === 'forum' && $this->currentChannel())
                    <!-- FORUM VIEW -->
                    <div class="msg-hdr">
                        <div style="width:40px;height:40px;border-radius:12px;background:var(--vxl);display:flex;align-items:center;justify-content:center;font-size:20px;">{{ $this->currentChannel()['icon'] ?? '💬' }}</div>
                        <div>
                            <div class="msg-hdr-name"># {{ $this->currentChannel()['name'] ?? 'Forum' }}</div>
                            <div class="msg-hdr-sub">{{ $this->currentChannel()['unread'] ?? 0 }} message@if(($this->currentChannel()['unread'] ?? 0) > 1)s@endif non lu@if(($this->currentChannel()['unread'] ?? 0) > 1)s@endif</div>
                        </div>
                        <div style="margin-left:auto;display:flex;gap:8px;">
                            <button class="icon-btn" wire:click="markAllAsRead()" title="Marquer tous comme lus">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M20 6L9 17l-5-5"/><path d="M20 6L9 17l-5-5"/></svg>
                            </button>
                            <button class="icon-btn" wire:click="openAnnouncementModal()" title="Créer une annonce">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="msg-list" id="msgList">
                        @foreach ($this->messages() as $msg)
                            <div class="msg-group @if ($msg['isOwn']) own @endif">
                                <div class="msg-gav" style="background: {{ $msg['gradient'] }}">{{ $msg['initials'] }}</div>
                                <div class="msg-body">
                                    @if ($msg['is_pinned'] || $msg['is_solution'])
                                        <div style="font-size:9px;font-weight:700;color:#D97706;margin-bottom:2px;">
                                            @if ($msg['is_pinned'])📌 ÉPINGLÉ @endif
                                            @if ($msg['is_solution'])✅ SOLUTION @endif
                                        </div>
                                    @endif
                                    <div class="msg-sender">{{ $msg['author'] }} @if ($msg['isOwn'])(Vous)@endif</div>
                                    <div class="msg-bubble @if (!$msg['isOwn']) other @else own @endif">{{ $msg['message'] }}</div>
                                    <div class="msg-time">{{ $msg['time'] }}</div>
                                </div>
                                @if ($msg['canModerate'])
                                    <div class="msg-actions">
                                        <button class="msg-action-btn" wire:click="pinMessage({{ $msg['id'] }})" title="@if($msg['is_pinned'])Dépingler@else Épingler @endif">
                                            {{ $msg['is_pinned'] ? '📌' : '📍' }}
                                        </button>
                                        <button class="msg-action-btn" wire:click="markAsSolution({{ $msg['id'] }})" title="@if($msg['is_solution'])Retirer solution@else Marquer solution @endif">
                                            {{ $msg['is_solution'] ? '❌' : '✅' }}
                                        </button>
                                        <button class="msg-action-btn" wire:click="hideMessage({{ $msg['id'] }})" title="Masquer">
                                            👁️
                                        </button>
                                        <button class="msg-action-btn" wire:click="deleteMessage({{ $msg['id'] }})" title="Supprimer">
                                            🗑️
                                        </button>
                                        <button class="msg-action-btn" wire:click="openReportModal({{ $msg['id'] }})" title="Signaler">
                                            ⚠️
                                        </button>
                                    </div>
                                @else
                                    <div class="msg-actions">
                                        <button class="msg-action-btn" wire:click="openReportModal({{ $msg['id'] }})" title="Signaler">
                                            ⚠️
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="msg-composer">
                        <div class="composer-box">
                            <div style="font-size:20px;cursor:pointer;">😊</div>
                            <div style="font-size:20px;cursor:pointer;">📎</div>
                            <input class="composer-input" wire:model.live="messageInput" placeholder="Écrire dans #{{ $this->currentChannel()['name'] ?? 'Forum' }}…" wire:keydown.enter="sendMessage"/>
                            <button class="send-btn" wire:click="sendMessage"><svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></button>
                        </div>
                    </div>
                @elseif ($this->tab === 'privates' && $this->currentPrivateUser())
                    <!-- PRIVATE MESSAGE VIEW -->
                    <div class="msg-hdr">
                        <div class="av-xs" style="background: {{ $this->currentPrivateUser()['gradient'] }}; width:40px; height:40px;">{{ $this->currentPrivateUser()['initials'] }}</div>
                        <div>
                            <div class="msg-hdr-name">{{ $this->currentPrivateUser()['name'] }}</div>
                            <div class="msg-hdr-sub">Message privé</div>
                        </div>
                    </div>

                    <div class="msg-list">
                        @foreach ($this->privateUserMessages() as $msg)
                            <div class="msg-group @if ($msg['isOwn']) own @endif">
                                <div class="msg-gav" style="background: {{ $msg['gradient'] }}">{{ $msg['initials'] }}</div>
                                <div class="msg-body">
                                    <div class="msg-sender">{{ $msg['author'] }} @if ($msg['isOwn'])(Vous)@endif</div>
                                    <div class="msg-bubble @if (!$msg['isOwn']) other @else own @endif">{{ $msg['message'] }}</div>
                                    <div class="msg-time">{{ $msg['time'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="msg-composer">
                        <div class="composer-box">
                            <div style="font-size:20px;cursor:pointer;">😊</div>
                            <div style="font-size:20px;cursor:pointer;">📎</div>
                            <input class="composer-input" wire:model.live="privateMessageInput" placeholder="Écrire un message à {{ $this->currentPrivateUser()['name'] }}…" wire:keydown.enter="sendPrivateMessage"/>
                            <button class="send-btn" wire:click="sendPrivateMessage"><svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></button>
                        </div>
                    </div>
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--muted);">
                        <div style="text-align:center;">
                            <div style="font-size:48px;margin-bottom:12px;">👋</div>
                            <div style="font-size:14px;font-weight:600;">Sélectionnez un {{ $this->tab === 'forum' ? 'canal' : 'contact' }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- THREADS / RIGHT PANEL -->
            <div class="threads-panel">
                <div class="tp-hdr">
                    <div class="tp-title">🗂️ Fils de discussion</div>
                    <button class="btn btn-primary btn-sm" wire:click="openThreadModal">+ Fil</button>
                </div>
                <div class="thread-list">
                    @foreach ($this->threads() as $thread)
                        <div class="thread-item @if ($thread['pinned'] ?? false) pinned @endif">
                            <div class="th-top">
                                <div class="th-av" style="background: {{ $thread['gradient'] }}">{{ $thread['initials'] }}</div>
                                <div class="th-author">{{ $thread['author'] }}</div>
                                <div class="th-time">{{ $thread['time'] }}</div>
                                @if ($thread['pinned'] ?? false)
                                    <span class="pill pill-orange" style="font-size:9px;padding:1px 6px;">📌</span>
                                @elseif ($thread['answered'] ?? false)
                                    <span class="pill pill-green" style="font-size:9px;padding:1px 5px;">✅ Répondu</span>
                                @elseif ($thread['unanswered'] ?? false)
                                    <span class="pill pill-red" style="font-size:9px;padding:1px 5px;">❓ Sans réponse</span>
                                @endif
                            </div>
                            <div class="th-title">{{ $thread['title'] }}</div>
                            <div class="th-preview">{{ $thread['preview'] }}</div>
                            <div class="th-meta">
                                @if (isset($thread['replies']))
                                    <span>💬 {{ $thread['replies'] }}</span>
                                @endif
                                @if (isset($thread['views']))
                                    <span>👁 {{ $thread['views'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif ($this->tab === 'announcements')
        <!-- ANNOUNCEMENTS TAB -->
        <div style="padding:28px;max-width:800px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
                <h2 style="font-size:20px;font-weight:700;">📢 Annonces</h2>
                <button class="btn btn-primary" wire:click="openAnnouncementModal">+ Créer une annonce</button>
            </div>

            <div>
                @foreach ($this->announcements() as $ann)
                    <div class="announcement-item @if ($ann['is_pinned']) pinned @endif">
                        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:8px;">
                            <div style="flex:1;">
                                <div class="ann-title">
                                    @if ($ann['is_pinned'])📌 @endif
                                    {{ $ann['title'] }}
                                </div>
                                <div class="ann-preview">{{ $ann['content'] }}</div>
                            </div>
                        </div>
                        <div class="ann-meta">
                            <span>{{ $ann['course'] }}</span> ·
                            <span>{{ $ann['author'] }}</span> ·
                            <span>{{ $ann['published_at'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- THREAD MODAL -->
    @if ($this->showThreadModal)
        <div style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div style="background:#fff;border-radius:var(--r);padding:28px;max-width:500px;width:92%;box-shadow:0 24px 60px rgba(13,78,74,.2);">
                <button style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:24px;cursor:pointer;" wire:click="closeThreadModal()">✕</button>
                <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">➕ Créer un nouveau fil de discussion</h3>

                <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
                    <div class="form-group">
                        <label class="form-label">Titre du fil</label>
                        <input class="form-input" wire:model="newThreadTitle" placeholder="Ex: Question sur les affordances en UX…"/>
                    </div>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button class="btn btn-ghost" wire:click="closeThreadModal()">Annuler</button>
                    <button class="btn btn-primary" wire:click="createThread()">Créer le fil</button>
                </div>
            </div>
        </div>
    @endif

    <!-- ANNOUNCEMENT MODAL -->
    @if ($this->showAnnouncementModal)
        <div style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div style="background:#fff;border-radius:var(--r);padding:28px;max-width:600px;width:92%;box-shadow:0 24px 60px rgba(13,78,74,.2);">
                <button style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:24px;cursor:pointer;" wire:click="closeAnnouncementModal()">✕</button>
                <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">📢 Créer une annonce</h3>

                <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
                    <div class="form-group">
                        <label class="form-label">Titre</label>
                        <input class="form-input" wire:model="announcementTitle" placeholder="Titre de l'annonce…"/>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contenu</label>
                        <textarea class="form-input" wire:model="announcementContent" placeholder="Contenu de l'annonce…" rows="6" style="resize:vertical;"></textarea>
                    </div>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button class="btn btn-ghost" wire:click="closeAnnouncementModal()">Annuler</button>
                    <button class="btn btn-primary" wire:click="createAnnouncement()">Publier l'annonce</button>
                </div>
            </div>
        </div>
    @endif

    <!-- REPORT MODAL -->
    @if ($this->showReportModal)
        <div style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:1000;">
            <div style="background:#fff;border-radius:var(--r);padding:28px;max-width:500px;width:92%;box-shadow:0 24px 60px rgba(13,78,74,.2);">
                <button style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:24px;cursor:pointer;" wire:click="closeReportModal()">✕</button>
                <h3 style="font-size:18px;font-weight:700;margin-bottom:16px;">⚠️ Signaler le message</h3>

                <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:20px;">
                    <div class="form-group">
                        <label class="form-label">Raison du signalement</label>
                        <select class="form-input" wire:model="reportReason">
                            <option value="">Sélectionner une raison…</option>
                            <option value="spam">Spam</option>
                            <option value="offensive">Contenu offensant</option>
                            <option value="inappropriate">Inapproprié</option>
                            <option value="misinformation">Désinformation</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description (optionnel)</label>
                        <textarea class="form-input" wire:model="reportDescription" placeholder="Détails supplémentaires…" rows="4" style="resize:vertical;"></textarea>
                    </div>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;">
                    <button class="btn btn-ghost" wire:click="closeReportModal()">Annuler</button>
                    <button class="btn btn-primary" wire:click="submitReport()">Signaler</button>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
