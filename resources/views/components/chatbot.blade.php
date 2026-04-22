<div id="chatbot-wrap">

    {{-- Tombol buka/tutup --}}
    <button id="chatbot-toggle"
        onclick="toggleChat()"
        title="Tanya Asisten Sanggar"
        style="position:fixed;bottom:28px;right:28px;width:56px;height:56px;background:#C65D2E;border-radius:50%;border:none;cursor:pointer;z-index:9999;box-shadow:0 8px 24px rgba(198,93,46,.45);display:flex;align-items:center;justify-content:center;transition:all .3s">
        <svg id="icon-chat" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        <svg id="icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" style="display:none">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
        {{-- Badge notifikasi --}}
        <div id="chat-badge" style="position:absolute;top:-2px;right:-2px;width:14px;height:14px;background:#EF4444;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center">
            <span style="color:#fff;font-size:7px;font-weight:900">1</span>
        </div>
    </button>

    {{-- Jendela chat --}}
    <div id="chatbot-window"
        style="position:fixed;bottom:96px;right:28px;width:360px;height:500px;background:#fff;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.18);z-index:9998;display:none;flex-direction:column;overflow:hidden;border:1px solid #E8E0D8;transition:all .3s">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#A34A22,#C65D2E);padding:16px 20px;display:flex;align-items:center;gap:12px;flex-shrink:0">
            <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div style="flex:1">
                <div style="color:#fff;font-weight:700;font-size:.9rem;line-height:1.2">Asisten Sanggar</div>
                <div style="color:rgba(255,255,255,.75);font-size:.75rem">🟢 Online · Powered by Gemini AI</div>
            </div>
            <button onclick="clearChat()" title="Hapus riwayat chat"
                style="background:rgba(255,255,255,.15);border:none;border-radius:8px;padding:5px 8px;cursor:pointer;color:#fff;font-size:.75rem">
                Hapus
            </button>
        </div>

        {{-- Pesan-pesan --}}
        <div id="chat-messages"
            style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:#FAF8F6;scroll-behavior:smooth">

            {{-- Pesan selamat datang --}}
            {{-- Pesan selamat datang --}}
<div class="msg-bot">
    Halo! Saya asisten virtual <strong>Sanggar Mulya Bhakti</strong> 🎭<br><br>
    Ada yang bisa saya bantu?
</div>

            {{-- Quick replies --}}
            <div id="quick-replies" style="display:flex;flex-wrap:wrap;gap:6px">
                <button class="quick-btn" onclick="sendQuick('Bagaimana cara daftar anggota?')">Cara daftar?</button>
                <button class="quick-btn" onclick="sendQuick('Apa saja jadwal latihan?')">Jadwal latihan</button>
                <button class="quick-btn" onclick="sendQuick('Tarian apa saja yang diajarkan?')">Tarian tersedia</button>
                <button class="quick-btn" onclick="sendQuick('Berapa biaya pendaftaran?')">Biaya daftar</button>
                <button class="quick-btn" onclick="sendQuick('Bagaimana cara menghubungi sanggar?')">Kontak</button>
            </div>
        </div>

        {{-- Input area --}}
        <div style="padding:12px 14px;border-top:1px solid #E8E0D8;background:#fff;display:flex;gap:8px;flex-shrink:0">
            <input
                id="chat-input"
                type="text"
                placeholder="Ketik pertanyaan..."
                autocomplete="off"
                style="flex:1;padding:10px 14px;border:1.5px solid #E8E0D8;border-radius:50px;font-size:.875rem;outline:none;font-family:inherit;transition:border-color .2s"
                onfocus="this.style.borderColor='#C65D2E'"
                onblur="this.style.borderColor='#E8E0D8'"
                onkeydown="if(event.key==='Enter' && !event.shiftKey){event.preventDefault();sendMessage();}"
            >
            <button
                id="send-btn"
                onclick="sendMessage()"
                style="width:40px;height:40px;background:#C65D2E;border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .2s"
                onmouseover="this.style.background='#A34A22'"
                onmouseout="this.style.background='#C65D2E'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
.msg-bot {
    background: #fff;
    border: 1px solid #E8E0D8;
    border-radius: 16px 16px 16px 4px;
    padding: 10px 14px;
    font-size: .875rem;
    line-height: 1.65;
    color: #3D3D3D;
    max-width: 88%;
    align-self: flex-start;
    animation: msgIn .25s ease;
}
.msg-user {
    background: #C65D2E;
    color: #fff;
    border-radius: 16px 16px 4px 16px;
    padding: 10px 14px;
    font-size: .875rem;
    line-height: 1.65;
    max-width: 88%;
    align-self: flex-end;
    animation: msgIn .25s ease;
}
.msg-loading {
    background: #fff;
    border: 1px solid #E8E0D8;
    border-radius: 16px 16px 16px 4px;
    padding: 12px 16px;
    align-self: flex-start;
    display: flex;
    gap: 4px;
    align-items: center;
}
.msg-loading span {
    width: 7px; height: 7px;
    background: #ADADAD; border-radius: 50%;
    animation: dotBounce .8s ease-in-out infinite;
}
.msg-loading span:nth-child(2) { animation-delay: .15s; }
.msg-loading span:nth-child(3) { animation-delay: .3s; }
@keyframes dotBounce {
    0%, 80%, 100% { transform: scale(.7); opacity: .5; }
    40% { transform: scale(1); opacity: 1; }
}
@keyframes msgIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.quick-btn {
    background: #FDF0EA;
    border: 1px solid rgba(198,93,46,.25);
    color: #C65D2E;
    font-size: .75rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 50px;
    cursor: pointer;
    transition: all .15s;
    font-family: inherit;
}
.quick-btn:hover { background: #C65D2E; color: #fff; }
#chat-messages::-webkit-scrollbar { width: 4px; }
#chat-messages::-webkit-scrollbar-track { background: transparent; }
#chat-messages::-webkit-scrollbar-thumb { background: #E8E0D8; border-radius: 2px; }
</style>

<script>
(function() {
    const sessionId = 'chat_' + Math.random().toString(36).substr(2, 9);
    let isOpen = false;

    window.toggleChat = function() {
        isOpen = !isOpen;
        const win   = document.getElementById('chatbot-window');
        const iconC = document.getElementById('icon-chat');
        const iconX = document.getElementById('icon-close');
        const badge = document.getElementById('chat-badge');

        win.style.display  = isOpen ? 'flex' : 'none';
        iconC.style.display = isOpen ? 'none'  : 'block';
        iconX.style.display = isOpen ? 'block' : 'none';
        if (badge) badge.style.display = 'none';

        if (isOpen) {
            document.getElementById('chat-input').focus();
            scrollBottom();
        }
    };

    window.sendQuick = function(msg) {
        const qr = document.getElementById('quick-replies');
        if (qr) qr.style.display = 'none';
        document.getElementById('chat-input').value = msg;
        sendMessage();
    };

    window.clearChat = function() {
        const msgs = document.getElementById('chat-messages');
        msgs.innerHTML = '<div class="msg-bot">Chat dihapus. Ada yang bisa saya bantu? 😊</div>';
        fetch('{{ route("chatbot.clear") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
            body: JSON.stringify({ session_id: sessionId })
        });
    };

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    function appendMsg(content, role) {
        const msgs = document.getElementById('chat-messages');
        const div  = document.createElement('div');
        div.className = role === 'user' ? 'msg-user' : 'msg-bot';
        // Format **bold** dan newline
        div.innerHTML = content
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
            .replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>')
            .replace(/\n/g,'<br>');
        msgs.appendChild(div);
        scrollBottom();
        return div;
    }

    function appendLoading() {
        const msgs = document.getElementById('chat-messages');
        const div  = document.createElement('div');
        div.className = 'msg-loading';
        div.id = 'typing-indicator';
        div.innerHTML = '<span></span><span></span><span></span>';
        msgs.appendChild(div);
        scrollBottom();
    }

    function removeLoading() {
        document.getElementById('typing-indicator')?.remove();
    }

    function scrollBottom() {
        const msgs = document.getElementById('chat-messages');
        setTimeout(() => msgs.scrollTop = msgs.scrollHeight, 50);
    }

    window.sendMessage = async function() {
        const input   = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        input.value  = '';
        input.disabled = true;
        document.getElementById('send-btn').disabled = true;

        appendMsg(message, 'user');
        appendLoading();

        try {
            const res = await fetch('{{ route("chatbot.chat") }}', {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });

            const data = await res.json();
            removeLoading();

            if (data.success) {
                appendMsg(data.reply, 'bot');
            } else {
                appendMsg('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
            }
        } catch (err) {
            removeLoading();
            appendMsg('Maaf, koneksi bermasalah. Pastikan server berjalan.', 'bot');
        } finally {
            input.disabled = false;
            document.getElementById('send-btn').disabled = false;
            input.focus();
        }
    };
})();
</script>
