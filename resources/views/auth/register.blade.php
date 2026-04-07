<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akaun - SKPKKKL</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .scroll-container {
            overflow: hidden;
            white-space: nowrap;
            background: #2563eb;
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
            background: rgba(249, 250, 251, 0.85);
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
                <span class="text-4xl font-bold tracking-tight text-rose-600">SKPKKKL<span class="text-gray-400">.</span></span>
            </div>
        </div>
        <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-gray-900">
            Daftar Akaun Baharu
        </h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Sila isi maklumat di bawah untuk mendaftar
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-100 sm:rounded-2xl sm:px-10">
            
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-5" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Penuh
                    </label>
                    <div class="mt-1.5">
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700">
                            No Pekerja
                        </label>
                        <div class="mt-1.5">
                            <input id="employee_id" name="employee_id" type="text" required value="{{ old('employee_id') }}"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 sm:text-sm bg-gray-50/50 transition-colors">
                        </div>
                    </div>

                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Alamat E-mel
                    </label>
                    <div class="mt-1.5">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Kata Laluan
                    </label>
                    <div class="mt-1.5">
                        <input id="password" name="password" type="password" required
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Ulang Kata Laluan
                    </label>
                    <div class="mt-1.5">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 sm:text-sm bg-gray-50/50 transition-colors">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-xl border border-transparent bg-rose-600 py-3 px-4 text-sm font-medium text-white shadow-sm shadow-rose-600/20 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-all">
                        Daftar Akaun
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah mempunyai akaun? 
                    <a href="{{ route('login') }}" class="font-medium text-rose-600 hover:text-rose-500 transition-colors">
                        Log masuk di sini
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
