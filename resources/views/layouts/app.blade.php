<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard SKPKKKL')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <!-- Layout Wrapper -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content Wrapper -->
        <main class="flex-1 flex flex-col relative overflow-hidden h-full">
            
            <!-- Top Header -->
            @include('partials.header')

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto w-full">
                <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
            
        </main>
    </div>

    @stack('scripts')

    {{-- ===================== LIVE NOTIFICATION SYSTEM ===================== --}}
    @auth
    <div id="toast-container" style="position:fixed; bottom:24px; left:24px; z-index:9999; display:flex; flex-direction:column-reverse; gap:12px; pointer-events:none;"></div>

    <!-- Notification Sound (Base64 encoded soft pop) -->
    <audio id="notif-sound" preload="auto">
        <source src="data:audio/mp3;base64,//NExAAAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//NExEAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//NExIAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//NExMAAANIAAAAAExBTUUzLjEwMKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq//NExQAAAOIAAAAAExBTUUzLjEwMBy2/wDAAwUGAgIFBwcHBwkJCQwNDQ0QDw8PEBERERUVFRUYGBgYHBwcHCAgICAkJCQoKSkpKywsLDIyMjI1NTU1OTk5OTw8PDxAQEBAQ0NDQ0dHR0dLS0tLT09PT1JSUlJVVVVVWFhYWFtbW1tfX19fYmJiYmVlZWVpaWlpbm5ubnFxcXF2dnZ2enl5eXx8fHx/f39/////AP//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8=" type="audio/mpeg">
    </audio>

    <style>
        .live-toast {
            pointer-events: all;
            width: 360px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            padding: 14px 16px;
            animation: toastSlideIn 0.35s cubic-bezier(0.18, 0.89, 0.32, 1.28) forwards;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border-left: 5px solid #25D366; /* WhatsApp Green */
        }
        .live-toast:hover { background: #fdfdfd; }
        .live-toast.removing {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        .live-toast-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 14px;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
        }
        .live-toast-body { flex: 1; min-width: 0; }
        .live-toast-header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;}
        .live-toast-title { font-size: 15px; font-weight: 600; color: #111b21; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .live-toast-time { font-size: 11px; color: #667781; flex-shrink: 0; margin-left: 8px;}
        .live-toast-msg { font-size: 13.5px; color: #667781; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .live-toast-close {
            position: absolute; top: 8px; right: 8px;
            background: rgba(255,255,255,0.8); border: none; cursor: pointer;
            color: #d1d5db; padding: 4px; border-radius: 50%;
            transition: all 0.2s; opacity: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .live-toast:hover .live-toast-close { opacity: 1; }
        .live-toast-close:hover { color: #4b5563; background: #f3f4f6; }

        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(-60px) scale(0.95); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(-60px) scale(0.95); }
        }
    </style>

    <script>
    (function () {
        const POLL_INTERVAL = 5000; // 5 saat
        const POLL_URL      = '{{ route("notifications.poll") }}';
        const CSRF_TOKEN    = '{{ csrf_token() }}';

        function updateBadge(count) {
            const badge = document.getElementById('notif-badge');
            if (!badge) return;
            if (count > 0) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        function playSound() {
            const audio = document.getElementById('notif-sound');
            if (audio) {
                audio.play().catch(e => { console.log('Audio autoplay disekat browser'); });
            }
        }

        // --- OS Level Notification (Desktop / Mobile) ---
        function requestOSNotification() {
            if ("Notification" in window && Notification.permission === "default") {
                Notification.requestPermission();
            }
        }

        // Minta permission bila user klik mana-mana pada screen (syarat browser)
        document.body.addEventListener('click', requestOSNotification, { once: true });

        function showOSNotification(notif) {
            if ("Notification" in window && Notification.permission === "granted") {
                const osNotif = new Notification(notif.title, {
                    body: notif.message,
                    icon: '{{ asset("images/KELAB KILAT.jpeg") }}'
                });
                osNotif.onclick = function() {
                    window.focus();
                    window.location.href = notif.url;
                };
            }
        }
        // ------------------------------------------------

        function showToast(notif) {
            // Trigger OS Notification
            showOSNotification(notif);

            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'live-toast';
            toast.onclick = function(e) {
                if(!e.target.closest('.live-toast-close')) {
                    window.location.href = notif.url;
                }
            };

            toast.innerHTML = `
                <div class="live-toast-icon">
                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="live-toast-body">
                    <div class="live-toast-header">
                        <div class="live-toast-title">${escHtml(notif.title)}</div>
                        <div class="live-toast-time">${escHtml(notif.time)}</div>
                    </div>
                    <div class="live-toast-msg">${escHtml(notif.message)}</div>
                </div>
                <button class="live-toast-close" title="Tutup">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            `;

            toast.querySelector('.live-toast-close').addEventListener('click', (e) => {
                e.stopPropagation();
                dismissToast(toast);
            });
            
            container.appendChild(toast);
            playSound();

            // Auto-dismiss selepas 6 saat
            setTimeout(() => dismissToast(toast), 6000);
        }

        function dismissToast(toast) {
            if (!toast.parentNode) return;
            toast.classList.add('removing');
            setTimeout(() => toast.remove(), 300);
        }

        function escHtml(str) {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(String(str)));
            return d.innerHTML;
        }

        async function poll() {
            try {
                const response = await fetch(POLL_URL, {
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (!response.ok) return;

                const data = await response.json();
                updateBadge(data.unread_count);

                // Dapatkan senarai ID notifikasi yang TELAHPUN dipaparkan dari localStorage
                let shownToasts = [];
                try {
                    shownToasts = JSON.parse(localStorage.getItem('skpkkkl_shown_notifs_v2')) || [];
                } catch(e) { shownToasts = []; }
                
                if (data.new_notifications && data.new_notifications.length > 0) {
                    let hasNew = false;
                    
                    data.new_notifications.reverse().forEach(notif => {
                        // Jika ID ini BELUM pernah dipaparkan sbg toast
                        if (!shownToasts.includes(notif.id)) {
                            // Masukkan ke senarai sejarah supaya tak muncul lagi
                            shownToasts.push(notif.id);
                            hasNew = true;
                            showToast(notif);
                        }
                    });

                    if (hasNew) {
                        // Kekalkan maksimum 50 ID terakhir dalam sejarah untuk jimat memori
                        if (shownToasts.length > 50) shownToasts = shownToasts.slice(-50);
                        localStorage.setItem('skpkkkl_shown_notifs_v2', JSON.stringify(shownToasts));
                    }
                }

            } catch (err) {
                // Senyap — mungkin user offline
                console.warn('[Notif Poll]', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Check immediately on load for faster feedback
            setTimeout(function () {
                poll().then(function () {
                    setInterval(poll, POLL_INTERVAL);
                });
            }, 500); // Trigger dalam masa 0.5s supaya lebih responsif
        });
    })();
    </script>
    @endauth
    {{-- ====================================================================== --}}
</body>
</html>
