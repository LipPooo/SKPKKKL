<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tetapan Profil - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative overflow-hidden">
            @include('partials.header', ['title' => 'Tetapan Profil'])

            <div class="flex-1 overflow-y-auto w-full p-6 sm:p-8">
                <div class="max-w-4xl mx-auto space-y-8">
                    
                    @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Profile Information -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="font-bold text-gray-900">Maklumat Profil</h3>
                            <p class="text-xs text-gray-500 mt-1">Kemaskini nama dan alamat emel akaun anda.</p>
                        </div>
                        <div class="p-8">
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Penuh</label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                                        @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Emel</label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                                        @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-sm shadow-blue-600/20">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Update Password -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/50 text-sm">
                            <h3 class="font-bold text-gray-900 text-sm">Kemaskini Kata Laluan</h3>
                            <p class="text-xs text-gray-500 mt-1">Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak untuk kekal selamat.</p>
                        </div>
                        <div class="p-8">
                            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <div class="max-w-xl space-y-6">
                                    <div>
                                        <label for="current_password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Kata Laluan Semasa</label>
                                        <input type="password" name="current_password" id="current_password" required
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                                        @error('current_password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Kata Laluan Baru</label>
                                        <input type="password" name="password" id="password" required
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                                        @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Sahkan Kata Laluan Baru</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required
                                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-sm shadow-black/20">
                                        Tukar Kata Laluan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>
