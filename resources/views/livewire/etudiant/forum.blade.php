<div wire:poll.5s="refreshRealtimeData">
<style>
/* HEADER */
.hdr{position:sticky;top:0;z-index:50;background:rgba(245,243,255,.92);backdrop-filter:blur(14px);border-bottom:1.5px solid var(--border);padding:15px 28px;display:flex;align-items:center;gap:14px;}
.hdr h1{font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--txt);flex:1;}
.tabs{display:flex;gap:4px;background:#fff;border-radius:var(--rp);padding:4px;border:1.5px solid var(--border);box-shadow:var(--sh);}
.tab{padding:7px 16px;border-radius:var(--rp);font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.tab.active{background:var(--vgrad);color:#fff;}
.forum-layout{display:grid;grid-template-columns:280px 1fr;height:calc(100vh - 72px);overflow:hidden;}
.channels{background:#fff;border-right:1.5px solid var(--border);display:flex;flex-direction:column;overflow:hidden;}
.ch-hdr{padding:18px 16px 12px;border-bottom:1.5px solid var(--border);}
.ch-list{flex:1;overflow-y:auto;padding:10px;}
.ch-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:8px;cursor:pointer;transition:all .2s;margin-bottom:2px;}
.ch-item:hover{background:var(--bg);}
.ch-item.active{background:var(--vgrad);}
.ch-item.active .ch-name{color:#fff;}
.ch-ico{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.ch-info{flex:1;min-width:0;}
.ch-name{font-size:13px;font-weight:600;color:var(--txt);}
.ch-badge{background:#EF4444;color:#fff;font-size:10px;font-weight:800;border-radius:6px;padding:1px 6px;flex-shrink:0;}
.msg-panel{display:flex;flex-direction:column;background:var(--bg);overflow:hidden;}
.msg-hdr{background:#fff;border-bottom:1.5px solid var(--border);padding:16px 20px;display:flex;align-items:center;gap:12px;flex-shrink:0;}
.msg-hdr-name{font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;color:var(--txt);}
.msg-list{flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:4px;}
.msg-group{display:flex;gap:10px;align-items:flex-end;margin-bottom:14px;}
.msg-group.own{flex-direction:row-reverse;}
.msg-grav{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;color:#fff;flex-shrink:0;}
.msg-body{display:flex;flex-direction:column;gap:4px;}
.msg-group.own .msg-body{align-items:flex-end;}
.msg-bubble{padding:11px 15px;border-radius:18px;font-size:13px;}
.msg-bubble.other{background:#fff;border:1.5px solid var(--border);color:var(--txt);}
.msg-bubble.own{background:var(--vgrad);color:#fff;}
.msg-composer{background:#fff;border-top:1.5px solid var(--border);padding:14px 20px;flex-shrink:0;}
.composer-box{display:flex;align-items:center;gap:10px;background:var(--bg);border:1.5px solid var(--border);border-radius:12px;padding:10px 14px;}
.comp-input{flex:1;border:none;outline:none;background:transparent;font-size:13px;color:var(--txt);}
.comp-send{width:36px;height:36px;border-radius:50%;background:var(--vgrad);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
</style>

<header class="hdr">
  <h1>💬 Forum & Messages</h1>
  <div class="tabs">
    <div class="tab {{ $view === 'forum' ? 'active' : '' }}" wire:click="switchTab('forum')">Forum</div>
    <div class="tab {{ $view === 'messages' ? 'active' : '' }}" wire:click="switchTab('messages')">Messages privés</div>
    <div class="tab {{ $view === 'announcements' ? 'active' : '' }}" wire:click="switchTab('announcements')">Annonces</div>
  </div>
  
</header>

@if($view === 'forum')
<div class="forum-layout">
  <!-- LEFT CHANNELS -->
  <div class="channels">
    <div class="ch-hdr">
      <div style="font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);">📚 Forums cours</div>
    </div>
    <div class="ch-list">
      @forelse($channels as $channel)
        <div class="ch-item {{ $selectedChannel && $selectedChannel->id === $channel['id'] ? 'active' : '' }}"
             wire:click="selectChannel({{ $channel['id'] }})">
          <div class="ch-ico" style="background:var(--vxl);">{{ $channel['icon'] ?? '📚' }}</div>
          <div class="ch-info">
            <div class="ch-name">{{ $channel['name'] }}</div>
          </div>
          @if($channel['unread_count'] > 0)
            <div class="ch-badge">{{ $channel['unread_count'] }}</div>
          @endif
        </div>
      @empty
        <div style="padding:20px;text-align:center;color:var(--muted);font-size:13px;">Aucun forum disponible</div>
      @endforelse
    </div>
  </div>

  <!-- CENTER MESSAGES -->
  <div class="msg-panel">
    @if($selectedChannel)
      <div class="msg-hdr">
        <div style="flex:1;">
          <div class="msg-hdr-name"># {{ $selectedChannel->name }}</div>
          <div style="font-size:12px;color:var(--muted);margin-top:1px;">{{ count($messages) }} messages</div>
        </div>
      </div>

      <div class="msg-list" id="msgList">
        @forelse($messages as $msg)
          <div class="msg-group {{ $msg['user_id'] === auth()->id() ? 'own' : '' }}">
            <div class="msg-grav" style="background:{{ $msg['user_id'] === auth()->id() ? 'var(--vgrad)' : '#0284C7' }};">
              {{ substr($msg['user']['name'] ?? 'U', 0, 2) }}
            </div>
            <div class="msg-body">
              <div style="font-size:11px;font-weight:700;color:{{ $msg['user_id'] === auth()->id() ? 'var(--muted)' : 'var(--v)' }};margin-bottom:2px;padding:0 4px;">
                {{ $msg['user']['name'] ?? 'Utilisateur' }}
              </div>
              <div class="msg-bubble {{ $msg['user_id'] === auth()->id() ? 'own' : 'other' }}">
                {{ $msg['content'] }}
              </div>
              <div style="display:flex;gap:8px;align-items:center;font-size:10px;color:var(--muted);">
                <span>{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                <div style="display:flex;gap:4px;align-items:center;">
                  <button wire:click="addReaction({{ $msg['id'] }})" style="background:transparent;border:none;cursor:pointer;font-size:16px;opacity:1;transition:all .2s;display:flex;align-items:center;gap:3px;" title="Aimer" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">👍 <span style="font-size:9px;opacity:0.8;">{{ $msg['reactions'] ?? 0 }}</span></button>
                  <button onclick="showReportModal(event, {{ $msg['id'] }})" style="background:transparent;border:none;cursor:pointer;font-size:16px;opacity:1;transition:all .2s;" title="Signaler" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">🚩</button>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div style="text-align:center;color:var(--muted);padding:40px;font-size:13px;">Aucun message. Soyez le premier à écrire!</div>
        @endforelse
      </div>

      <div class="msg-composer">
        <div class="composer-box">
          <input class="comp-input" placeholder="Écrire un message..."
                 wire:model.live="messageContent" wire:keydown.enter="sendMessage()" />
          <button class="comp-send" wire:click="sendMessage()">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke="#fff" style="width:15px;height:15px;">
              <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
          </button>
        </div>
      </div>
    @else
      <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--muted);font-size:14px;">
        Sélectionnez un forum pour commencer
      </div>
    @endif
  </div>
</div>
@elseif($view === 'messages')
<div class="forum-layout">
  <!-- LEFT USERS -->
  <div class="channels">
    <div class="ch-hdr">
      <div style="font-family:'Poppins',sans-serif;font-size:14px;font-weight:700;color:var(--txt);">👥 Conversations</div>
    </div>
    <div class="ch-list">
      @forelse($dmUsers as $user)
        <div class="ch-item {{ $dmWith && $dmWith->id === $user['id'] ? 'active' : '' }}"
             wire:click="selectDmUser({{ $user['id'] }})">
          <div class="ch-ico" style="background:var(--vxl);">{{ substr($user['name'], 0, 1) }}</div>
          <div class="ch-info">
            <div class="ch-name">{{ $user['name'] }}</div>
          </div>
          @if($user['unread_count'] > 0)
            <div class="ch-badge">{{ $user['unread_count'] }}</div>
          @endif
        </div>
      @empty
        <div style="padding:20px;text-align:center;color:var(--muted);font-size:13px;">Aucune conversation</div>
      @endforelse
    </div>
  </div>

  <!-- CENTER MESSAGES -->
  <div class="msg-panel">
    @if($dmWith)
      <div class="msg-hdr">
        <div style="flex:1;">
          <div class="msg-hdr-name">{{ $dmWith->name }}</div>
          <div style="font-size:12px;color:var(--muted);margin-top:1px;">{{ count($dmMessages) }} messages</div>
        </div>
      </div>

      <div class="msg-list" id="msgList">
        @forelse($dmMessages as $msg)
          <div class="msg-group {{ $msg['sender_id'] === auth()->id() ? 'own' : '' }}">
            <div class="msg-grav" style="background:{{ $msg['sender_id'] === auth()->id() ? 'var(--vgrad)' : '#0284C7' }};">
              {{ substr($msg['sender_id'] === auth()->id() ? auth()->user()->name : $dmWith->name, 0, 2) }}
            </div>
            <div class="msg-body">
              <div class="msg-bubble {{ $msg['sender_id'] === auth()->id() ? 'own' : 'other' }}">
                {{ $msg['content'] }}
              </div>
              <div style="font-size:10px;color:var(--muted);margin-top:2px;">
                {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
              </div>
            </div>
          </div>
        @empty
          <div style="text-align:center;color:var(--muted);padding:40px;font-size:13px;">Aucun message. Commencez la conversation!</div>
        @endforelse
      </div>

      <div class="msg-composer">
        <div class="composer-box">
          <input class="comp-input" placeholder="Écrire un message..."
                 wire:model.live="dmContent" wire:keydown.enter="sendDmMessage()" />
          <button class="comp-send" wire:click="sendDmMessage()">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke="#fff" style="width:15px;height:15px;">
              <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
          </button>
        </div>
      </div>
    @else
      <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--muted);font-size:14px;">
        Sélectionnez une conversation pour commencer
      </div>
    @endif
  </div>
</div>
@else
<div style="padding:24px;max-width:900px;margin:0 auto;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <h2 style="font-size:20px;font-weight:700;color:var(--txt);">📢 Annonces de cours</h2>
  </div>

  @forelse($announcements as $ann)
    <div style="background:#fff;border:1.5px solid var(--border);border-left:4px solid {{ $ann['is_pinned'] ? '#D97706' : 'var(--v)' }};border-radius:12px;padding:16px 18px;margin-bottom:12px;">
      <div style="display:flex;justify-content:space-between;gap:12px;align-items:start;">
        <div style="font-size:15px;font-weight:700;color:var(--txt);">
          @if($ann['is_pinned'])📌 @endif{{ $ann['title'] }}
        </div>
        <div style="font-size:11px;color:var(--muted);white-space:nowrap;">{{ $ann['published_at'] ?? '' }}</div>
      </div>
      <div style="font-size:13px;color:var(--txt);margin-top:8px;line-height:1.6;">{{ $ann['content'] }}</div>
      <div style="font-size:11px;color:var(--muted);margin-top:10px;">
        {{ $ann['course'] }} · {{ $ann['author'] }}
      </div>
    </div>
  @empty
    <div style="text-align:center;color:var(--muted);padding:34px 0;font-size:14px;">
      Aucune annonce disponible pour vos cours.
    </div>
  @endforelse
</div>
@endif

<!-- REPORT MESSAGE MODAL -->
<div id="reportModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:16px;padding:32px;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.25);">
    <div style="font-family:'Poppins',sans-serif;font-size:18px;font-weight:700;color:var(--txt);margin-bottom:16px;">
      Signaler ce message
    </div>
    <div style="margin-bottom:16px;">
      <label style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;">Raison</label>
      <select id="reportReason" style="width:100%;padding:10px;margin-top:6px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;">
        <option value="">Sélectionnez une raison</option>
        <option value="spam">Spam</option>
        <option value="inappropriate">Contenu inapproprié</option>
        <option value="harassment">Harcèlement</option>
        <option value="other">Autre</option>
      </select>
    </div>
    <div style="margin-bottom:20px;">
      <label style="font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;">Détails (optionnel)</label>
      <textarea id="reportDescription" style="width:100%;padding:10px;margin-top:6px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;min-height:80px;font-family:inherit;" placeholder="Fournissez plus de détails..."></textarea>
    </div>
    <div style="display:flex;gap:8px;">
      <button onclick="closeReportModal()" style="flex:1;padding:10px;border-radius:8px;border:1.5px solid var(--border);background:transparent;color:var(--txt);font-weight:600;cursor:pointer;">Annuler</button>
      <button onclick="submitReport()" style="flex:1;padding:10px;border-radius:8px;border:none;background:var(--vgrad);color:#fff;font-weight:600;cursor:pointer;">Signaler</button>
    </div>
  </div>
</div>

<script>
let reportingMessageId = null;

function showReportModal(e, msgId) {
  e.preventDefault();
  reportingMessageId = msgId;
  document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
  document.getElementById('reportModal').style.display = 'none';
  reportingMessageId = null;
  document.getElementById('reportReason').value = '';
  document.getElementById('reportDescription').value = '';
}

function submitReport() {
  const reason = document.getElementById('reportReason').value;
  if (!reason) {
    alert('Veuillez sélectionner une raison');
    return;
  }
  @this.reportMessage(reportingMessageId, reason);
  closeReportModal();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
  const modal = document.getElementById('reportModal');
  if (e.target === modal) {
    closeReportModal();
  }
});

// Auto-scroll to bottom when new messages arrive
Livewire.on('scroll-to-bottom', () => {
  const msgList = document.getElementById('msgList');
  if (msgList) {
    setTimeout(() => {
      msgList.scrollTop = msgList.scrollHeight;
    }, 100);
  }
});
</script>
</div>
