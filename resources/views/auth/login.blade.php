<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log Masuk - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .scroll-container {
            overflow: hidden;
            white-space: nowrap;
            background: #ffee00ff;
            color: white;
            padding: 8px 0;
            font-weight: 600;
            font-size: 0.875rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
        }
        .scroll-text {
            display: inline-block;
            animation: scroll 20s linear infinite;
        }
        .login-bg {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .login-overlay {
            background: #800020;
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="login-bg font-sans antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 login-overlay -z-10"></div>
    
    <div class="scroll-container">
        <div class="scroll-text">
            Sistem Kelulusan Program KKKL (SKPKKKL) &nbsp;&bull;&nbsp; Sistem Kelulusan Program KKKL (SKPKKKL) &nbsp;&bull;&nbsp; Sistem Kelulusan Program KKKL (SKPKKKL)
        </div>
    </div>
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex flex-col items-center">
            <div class="h-24 w-24 mb-4 flex items-center justify-center p-2 bg-white rounded-2xl shadow-sm border border-gray-100">
                <img src="{{ asset('images/KELAB KILAT.jpeg') }}" alt="Logo Kelab Kilat" class="max-h-full max-w-full object-contain">
            </div>
            <div class="flex items-center px-6">
                <!-- Using same styling as the dashboard logo -->
                <span class="text-4xl font-bold tracking-tight text-white">SKPKKKL<span class="text-white">.</span></span>
            </div>
        </div>
        <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-gray-900">
            Log Masuk
        </h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Sistem Pengurusan Kewangan dan Laporan
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-200 sm:rounded-2xl sm:px-10">
            
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-start shadow-sm">
                    <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Alamat E-mel
                    </label>
                    <div class="mt-1.5">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Kata Laluan
                    </label>
                    <div class="mt-1.5">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            Lupa kata laluan?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-xl border border-transparent bg-blue-600 py-3 px-4 text-sm font-medium text-white shadow-sm shadow-blue-600/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                        Log Masuk
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum mempunyai akaun? 
                    <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                        Buat akaun baharu
                    </a>
                </p>
            </div>
            
        </div>
        
        <p class="mt-8 text-center text-xs text-gray-400">
            &copy; 2026 SKPKKKL. Semua hak cipta terpelihara.
        </p>
    </div>
</body>
</html>
