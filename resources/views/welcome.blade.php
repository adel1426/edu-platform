<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Edu Platform') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center p-6">
            <header class="mb-8 text-center">
                <h1 class="text-4xl font-bold mb-2">🎓 منصة تعليمية</h1>
                <p class="text-gray-600">منصة المواد الدراسية والدروس</p>
            </header>

            <nav class="flex gap-3">
                @auth
                    <a href="{{ url('/admin') }}"
                       class="px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition">
                        لوحة التحكم
                    </a>
                    <a href="{{ url('/dashboard') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        الرئيسية
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            تسجيل الدخول
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition">
                            إنشاء حساب
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </body>
</html>
