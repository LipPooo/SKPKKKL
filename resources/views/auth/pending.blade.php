<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akaun Menunggu Kelulusan - SKPKKKL</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/KELAB KILAT.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-bg {
            background-color: #9f1239;
            background-image: url('{{ asset('images/KELAB KILAT.jpeg') }}');
            background-size: 500px;
            background-position: center;
            background-repeat: repeat;
            background-attachment: fixed;
        }
        .login-overlay {
            background: rgba(159, 18, 57, 0.86);
        }
    </style>
</head>
<body class="login-bg font-sans antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative">
    <div class="absolute inset-0 login-overlay -z-10"></div>
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="h-24 w-24 mx-auto mb-4 flex items-center justify-center p-2 bg-white rounded-2xl shadow-sm border border-gray-100">
            <img src="{{ asset('images/KELAB KILAT.jpeg') }}" alt="Logo Kelab Kilat" class="max-h-full max-w-full object-contain">
        </div>
        <h2 class="text-3xl font-bold text-gray-900">Akaun Menunggu Kelulusan</h2>
        <div class="mt-8 bg-white py-8 px-4 shadow-sm border border-gray-100 sm:rounded-2xl sm:px-10">
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="mt-4 text-gray-600">
                    Terima kasih kerana mendaftar. Akaun anda telah berjaya dicipta dan sekarang sedang menunggu kelulusan daripada pihak Admin.
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Sila hubungi Admin jika anda mempunyai sebarang pertanyaan.
                </p>
            </div>
            <div class="mt-6">
                <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                    Kembali ke Log Masuk
                </a>
            </div>
        </div>
    </div>
</body>
</html>
