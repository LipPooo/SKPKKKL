<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard SKPKKKL')</title>
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
    <div id="toast-container" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column-reverse; gap:12px; pointer-events:none;"></div>

    <style>
        .live-toast {
            pointer-events: all;
            min-width: 320px;
            max-width: 380px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 60px -10px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.05);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            animation: toastSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            border-left: 4px solid #3b82f6;
        }
        .live-toast.removing {
            animation: toastSlideOut 0.3s ease-in forwards;
        }
        .live-toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #eff6ff;
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .live-toast-body { flex: 1; min-width: 0; }
        .live-toast-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 3px; }
        .live-toast-msg { font-size: 12px; color: #64748b; line-height: 1.5; margin-bottom: 8px; word-break: break-word; }
        .live-toast-footer { display: flex; align-items: center; gap: 8px; }
        .live-toast-time { font-size: 10px; color: #94a3b8; }
        .live-toast-link {
            font-size: 11px; font-weight: 600; color: #3b82f6;
            text-decoration: none; background: #eff6ff;
            padding: 3px 10px; border-radius: 20px;
            transition: background 0.2s;
        }
        .live-toast-link:hover { background: #dbeafe; }
        .live-toast-close {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; padding: 2px; line-height: 1;
            align-self: flex-start; flex-shrink: 0;
            transition: color 0.2s;
        }
        .live-toast-close:hover { color: #475569; }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(60px) scale(0.95); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to   { opacity: 0; transform: translateX(60px) scale(0.95); }
        }
    </style>

    <script>
    (function () {
        const POLL_INTERVAL = 15000; // 15 saat
        const POLL_URL      = '{{ route("notifications.poll") }}';
        const CSRF_TOKEN    = '{{ csrf_token() }}';

        // Simpan timestamp bagi poll terakhir
        // Poll pertama: hantar tiada 'since' → server balas dengan masa sekarang
        // Poll seterusnya: hantar 'since' = masa server dari poll sebelum
        let lastSince = null;

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

        function showToast(notif) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'live-toast';
            toast.innerHTML = `
                <div class="live-toast-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div class="live-toast-body">
                    <p class="live-toast-title">${escHtml(notif.title)}</p>
                    <p class="live-toast-msg">${escHtml(notif.message)}</p>
                    <div class="live-toast-footer">
                        <span class="live-toast-time">${escHtml(notif.time)}</span>
                        <a href="${escHtml(notif.url)}" class="live-toast-link">Lihat &rarr;</a>
                    </div>
                </div>
                <button class="live-toast-close" aria-label="Tutup">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;

            toast.querySelector('.live-toast-close').addEventListener('click', () => dismissToast(toast));
            container.appendChild(toast);

            // Auto-dismiss selepas 8 saat
            setTimeout(() => dismissToast(toast), 8000);
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
                let url = POLL_URL;
                if (lastSince) {
                    url += '?since=' + encodeURIComponent(lastSince);
                }

                const response = await fetch(url, {
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (!response.ok) return;

                const data = await response.json();

                // Kemas kini badge
                updateBadge(data.unread_count);

                // Tunjuk toast untuk setiap notifikasi baru (hanya jika bukan poll pertama)
                if (lastSince && data.new_notifications && data.new_notifications.length > 0) {
                    data.new_notifications.slice(0, 3).forEach(notif => showToast(notif));
                }

                // Simpan masa server untuk poll seterusnya
                if (data.server_time) {
                    lastSince = data.server_time;
                }

            } catch (err) {
                // Senyap — mungkin user offline atau sesi tamat
                console.warn('[Notif Poll]', err);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Poll pertama selepas 1 saat (ambil baseline masa)
            setTimeout(function () {
                poll().then(function () {
                    // Selepas poll pertama siap, mula interval setiap 15 saat
                    setInterval(poll, POLL_INTERVAL);
                });
            }, 1000);
        });
    })();
    </script>
    @endauth
    {{-- ====================================================================== --}}
</body>
</html>
