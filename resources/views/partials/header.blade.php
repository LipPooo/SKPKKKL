<header class="bg-white/70 backdrop-blur-xl border-b border-gray-200 z-50 sticky top-0">
    <div class="flex items-center justify-between h-16 px-6 sm:px-8">
        <div class="flex items-center gap-4">
            <button @click.stop="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-rose-600 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">{{ $title ?? 'Ringkasan Utama' }}</h1>
        </div>
        
        <div class="flex items-center gap-5">
            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }">
                <button id="notif-bell-btn" @click="open = !open" class="text-gray-400 hover:text-rose-600 transition-colors relative p-2 rounded-xl hover:bg-gray-50">
                    @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                    <span id="notif-badge" class="absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 rounded-full border-2 border-white text-[10px] text-white flex items-center justify-center font-bold {{ $unreadCount > 0 ? '' : 'hidden' }}">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" style="display: none;" @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="fixed inset-x-4 sm:absolute sm:inset-x-auto sm:right-0 mt-3 sm:w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                    <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                        <span class="font-bold text-gray-800 text-sm">Notifikasi</span>
                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.mark-as-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-rose-600 hover:underline">Tandakan semua dibaca</button>
                            </form>
                        @endif
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse(Auth::user()->notifications()->latest()->take(10)->get() as $notification)
                            <a href="{{ route('notifications.read', $notification->id) }}" class="block p-4 hover:bg-gray-50 transition-colors border-b border-gray-50 {{ $notification->read_at ? '' : 'bg-rose-50/30' }}">
                                <div class="flex gap-3">
                                    <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center
                                        @if($notification->data['type'] === 'new_request') bg-rose-100 text-rose-600
                                        @elseif($notification->data['type'] === 'ready_for_boss') bg-amber-100 text-amber-600
                                        @else bg-emerald-100 text-emerald-600 @endif">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-gray-800 leading-tight mb-0.5">{{ $notification->data['title'] }}</p>
                                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">{{ $notification->data['message'] }}</p>
                                        <p class="text-[10px] text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center">
                                <p class="text-gray-400 text-sm italic">Tiada notifikasi setakat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="h-6 w-px bg-gray-200"></div>
            
            <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='{{ route('profile.edit') }}'">
                <div class="text-right hidden sm:block">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-0.5 group-hover:text-rose-500 transition-colors">
                        {{ Auth::user()->role === 'admin' ? 'Pentadbir' : (Auth::user()->role === 'boss' ? 'Pengerusi' : 'AJK') }}
                    </p>
                    <p class="text-sm font-bold text-gray-800 group-hover:text-rose-600 transition-colors">{{ Auth::user()->name }}</p>
                </div>
                <img src="{{ Auth::user()->profile_photo_url }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="w-10 h-10 rounded-xl object-cover border-2 border-white shadow-sm group-hover:border-rose-100 transition-all">
            </div>
        </div>
    </div>
</header>
