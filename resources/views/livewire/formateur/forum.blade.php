<div>
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
.msg-group{display:flex;gap:10px;align-items:flex-end;margin-bottom:14px;}
.msg-group.own{flex-direction:row-reverse;}
.msg-gav{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:Poppins,sans-serif;font-weight:700;font-size:12px;color:#fff;flex-shrink:0;margin-bottom:2px;}
.msg-body{display:flex;flex-direction:column;gap:3px;max-width:70%;}
.msg-group.own .msg-body{align-items:flex-end;}
.msg-sender{font-size:11px;font-weight:700;color:var(--v);margin-bottom:2px;padding:0 4px;}
.msg-bubble{padding:11px 15px;border-radius:18px;font-size:13px;line-height:1.55;}
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
@media(max-width:1100px){.forum-layout{grid-template-columns:240px 1fr;}.threads-panel{display:none;}}
@media(max-width:640px){.forum-layout{grid-template-columns:1fr;}.channels-panel{display:none;}}
</style>

<header class="page-header">
    <h1 style="flex:1;">💬 Forum &amp; Messages</h1>
    <div class="tab-bar">
        <div class="tab-item @class(['active' => $this->tab === 'forum'])" wire:click="switchTab('forum')">Forum</div>
        <div class="tab-item @class(['active' => $this->tab === 'privates'])" wire:click="switchTab('privates')">Privés</div>
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

    <div class="forum-layout" style="margin:-28px;height:calc(100vh - 72px);">
        <!-- CHANNELS -->
        <div class="channels-panel">
            <div class="ch-hdr">
                <div style="font-family:Poppins,sans-serif;font-size:14px;font-weight:700;color:var(--txt);margin-bottom:10px;">Espaces de discussion</div>
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
                        <div class="ch-item">
                            <div class="av-sm" style="background: {{ $msg['gradient'] }}; width:36px;height:36px;">{{ $msg['initials'] }}</div>
                            <div class="ch-info">
                                <div class="ch-name">{{ $msg['name'] }}</div>
                                <div class="ch-last">{{ $msg['last_message'] }}</div>
                            </div>
                            <div style="font-size:10px;color:var(--muted);">{{ $msg['time'] }}</div>
                            @if (isset($msg['unread']) && $msg['unread'] > 0)
                                <div class="ch-badge">{{ $msg['unread'] }}</div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- MESSAGES -->
        <div class="msg-panel">
            <div class="msg-hdr">
                <div style="width:40px;height:40px;border-radius:12px;background:var(--vxl);display:flex;align-items:center;justify-content:center;font-size:20px;">{{ $this->currentChannel()['icon'] ?? '💬' }}</div>
                <div>
                    <div class="msg-hdr-name"># {{ $this->currentChannel()['name'] ?? 'Forum' }}</div>
                    <div class="msg-hdr-sub">41 étudiants · 3 messages non lus</div>
                </div>
                <div style="margin-left:auto;display:flex;gap:8px;">
                    <div class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
                    <div class="icon-btn"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/></svg></div>
                </div>
            </div>

            <div class="msg-list" id="msgList">
                <div class="msg-date-sep"><span>Hier · 15 mars 2026</span></div>
                @foreach ($this->messages() as $msg)
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
                    <input class="composer-input" wire:model.live="messageInput" placeholder="Écrire dans #{{ $this->currentChannel()['name'] ?? 'Forum' }}…" wire:keydown.enter="sendMessage"/>
                    <button class="send-btn" wire:click="sendMessage"><svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg></button>
                </div>
            </div>
        </div>

        <!-- THREADS -->
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
                            @if (isset($thread['likes']))
                                <span>❤️ {{ $thread['likes'] }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
</div>
</div>
