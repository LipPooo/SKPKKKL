<!-- Backdrop for mobile -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 md:hidden" 
     @click="sidebarOpen = false"
     style="display: none;"></div>

<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 flex flex-col justify-between shadow-2xl z-50 transform transition-transform duration-300 ease-in-out -translate-x-full md:relative md:translate-x-0 md:shadow-sm"
       :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'md:translate-x-0': true }"
       @click.away="if (window.innerWidth < 768) sidebarOpen = false">
    <div>
        <!-- Logo / Brand -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 flex items-center justify-center p-1 bg-white rounded-lg border border-gray-100 shadow-sm text-rose-600">
                    <img src="{{ asset('images/KELAB KILAT.jpeg') }}" alt="Logo Kelab Kilat" class="max-h-full max-w-full object-contain">
                </div>
                <span class="text-xl font-bold tracking-tight text-rose-600">SKPKKKL<span class="text-gray-400">.</span></span>
            </div>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-rose-600 p-2 md:hidden transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- User Profile Quick Info -->
        <div class="px-6 py-6 border-b border-gray-50 bg-gray-50/30">
            <div class="flex items-center gap-4">
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-sm">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-rose-600 uppercase tracking-widest mt-0.5">
                        {{ auth()->user()->role === 'admin' ? 'Pentadbir' : (auth()->user()->role === 'boss' ? 'Pengerusi' : 'AJK') }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="p-4 space-y-1.5 mt-2">
            @php $routeName = Route::currentRouteName(); $user = Auth::user(); @endphp
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $routeName === 'dashboard' ? 'bg-rose-50 text-rose-700 font-medium border border-rose-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('fund-requests.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ str_starts_with($routeName, 'fund-requests') ? 'bg-rose-50 text-rose-700 font-medium border border-rose-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Permohonan Dana
            </a>
            <a href="{{ route('program-reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ str_starts_with($routeName, 'program-reports') ? 'bg-rose-50 text-rose-700 font-medium border border-rose-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan Program
            </a>
            @if($user->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ str_starts_with($routeName, 'admin.users') ? 'bg-rose-50 text-rose-700 font-medium border border-rose-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Pengurusan Pengguna
            </a>
            @elseif($user->role === 'boss')
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Pengurusan Ahli
            </a>
            @endif
        </nav>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $routeName === 'profile.edit' ? 'bg-rose-50 text-rose-700 font-medium border border-rose-100/50' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Tetapan
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 mt-1 rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log Keluar
            </button>
        </form>
    </div>
</aside>

