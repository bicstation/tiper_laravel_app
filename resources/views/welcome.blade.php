{{-- resources/views/welcome.blade.php --}}

@extends('layouts.app') {{-- layouts.app をマスターレイアウトとして継承 --}}

@section('content') {{-- app.blade.php の @yield('content') に挿入されるコンテンツをここに記述 --}}
<div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-file me-1"></i>Welcomeページ
            </li>
        </ol>
    </nav>
    <h1 class="mb-4"><i class="fas fa-star me-2"></i>ようこそ！Tiper.Liveへ</h1>
    <p>このページは、あなたのLaravelアプリケーションのトップページです。サイドバーが正しく表示されることを確認しましょう。</p>

    {{-- 元々の Laravel のデフォルトコンテンツをここに含める --}}
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <svg viewBox="0 0 629 555" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto bg-gray-100 dark:bg-gray-900"><g opacity=".4" filter="url(#a)"><path d="M294.755 244.789L254 554h229L629 244.789h-334.245z" fill="#FF2D20"></path></g><g opacity=".4" filter="url(#b)"><path d="M491.56 0L398 244.789h231L629 0H491.56z" fill="#FF2D20"></path></g><path d="M141.226 244.789L0 554h228.307L369.534 244.789H141.226z" fill="#FF2D20"></path><path d="M369.534 244.789L228.307 554h-73.914L294.755 244.789h74.779z" fill="#CC0000"></path><path d="M141.226 244.789L294.755 244.789L228.307 554L0 554L141.226 244.789z" fill="#FF2D20"></path><g opacity=".4" filter="url(#c)"><path d="M421.365 9.176L327.798 244.789H491.56L421.365 9.176z" fill="#FF2D20"></path></g><defs><filter id="a" x="240" y="234.789" width="399" height="339.211" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur stdDeviation="5" result="effect1_foregroundBlur_359_7811"></feGaussianBlur></filter><filter id="b" x="388" y="0" width="251" height="254.789" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur stdDeviation="5" result="effect1_foregroundBlur_359_7811"></feGaussianBlur></filter><filter id="c" x="317.798" y=".176" width="183.762" height="254.613" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood><feBlend in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend><feGaussianBlur stdDeviation="5" result="effect1_foregroundBlur_359_7811"></feGaussianBlur></filter></defs></svg>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a href="https://laravel.com/docs" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-800/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0113.912 3.5m-.337 1.345a4.49 4.49 0 00-.791-1.243m1.007 1.243a4.49 4.49 0 01-.791 1.243m-3.134-1.243a4.49 4.49 0 00-.792 1.243m3.137-1.243A4.49 4.49 0 0110.09 3.5M12 20.042V13m-4.007-4.491a4.473 4.473 0 00-7.394 2.871M12 20.042V13m4.007-4.491a4.473 4.473 0 017.394 2.871M5.257 10.11ZM17.257 10.11M12 13V2.25s-4.782 9.75-9 11.25c-1.514.492-2.668 1.159-3.266 1.666a.25.25 0 00-.012.012l-.006.006-.003.003-.001.001A.75.75 0 011 17.25c.005-.008.012-.014.022-.02l.006-.006.003-.003A11.751 11.751 0 0012 20.042V13c0-1.724 2.059-4.254 3.75-6.104ZM17.257 10.11h0a4.5 4.5 0 00-5.405-4.473Z" />
                            </div>

                            <h2 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">Documentation</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laravel has wonderful documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience, we recommend reading all of the documentation from beginning to end.
                            </p>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>

                    <a href="https://laracasts.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-800/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0113.912 3.5m-.337 1.345a4.49 4.49 0 00-.791-1.243m1.007 1.243a4.49 4.49 0 01-.791 1.243m-3.134-1.243a4.49 4.49 0 00-.792 1.243m3.137-1.243A4.49 4.49 0 0110.09 3.5M12 20.042V13m-4.007-4.491a4.473 4.473 0 00-7.394 2.871M12 20.042V13m4.007-4.491a4.473 4.473 0 017.394 2.871M5.257 10.11ZM17.257 10.11M12 13V2.25s-4.782 9.75-9 11.25c-1.514.492-2.668 1.159-3.266 1.666a.25.25 0 00-.012.012l-.006.006-.003.003-.001.001A.75.75 0 011 17.25c.005-.008.012-.014.022-.02l.006-.006.003-.003A11.751 11.751 0 0012 20.042V13c0-1.724 2.059-4.254 3.75-6.104ZM17.257 10.11h0a4.5 4.5 0 00-5.405-4.473Z" />
                            </div>

                            <h2 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">Laracasts</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laracasts is a series of video tutorials for Laravel and PHP. From beginner to expert, Laracasts has something for everyone.
                            </p>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>

                    <a href="https://laravel-news.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-800/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0113.912 3.5m-.337 1.345a4.49 4.49 0 00-.791-1.243m1.007 1.243a4.49 4.49 0 01-.791 1.243m-3.134-1.243a4.49 4.49 0 00-.792 1.243m3.137-1.243A4.49 4.49 0 0110.09 3.5M12 20.042V13m-4.007-4.491a4.473 4.473 0 00-7.394 2.871M12 20.042V13m4.007-4.491a4.473 4.473 0 017.394 2.871M5.257 10.11ZM17.257 10.11M12 13V2.25s-4.782 9.75-9 11.25c-1.514.492-2.668 1.159-3.266 1.666a.25.25 0 00-.012.012l-.006.006-.003.003-.001.001A.75.75 0 011 17.25c.005-.008.012-.014.022-.02l.006-.006.003-.003A11.751 11.751 0 0012 20.042V13c0-1.724 2.059-4.254 3.75-6.104ZM17.257 10.11h0a4.5 4.5 0 00-5.405-4.473Z" />
                            </div>

                            <h2 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">Laravel News</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laravel News is a community driven portal for all of the latest Laravel and PHP news, tutorials, and packages.
                            </p>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>

                    <a href="https://vibrant-laravel.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-800/20">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="M6.004 15.495H3.844v-4.07h2.16M15.467 15.495h-2.16v-4.07h2.16M12 15.495h-2.16v-4.07h2.16M18.966 15.495h-2.16v-4.07h2.16M3.844 19.33H1V7.82h2.844M11.28 19.33H8.435V7.82h2.844M18.966 19.33h-2.844V7.82h2.844M23 19.33h-2.16V7.82H23M12 3.84V1h-2.16v2.84M23 3.84V1h-2.16v2.84M18.966 3.84V1h-2.16v2.84M6.004 3.84V1H3.844v2.84Z" />
                            </div>

                            <h2 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">Vibrant Laravel</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Vibrant Laravel is a resource for learning Laravel with a focus on modern techniques and best practices.
                            </p>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                    <div class="flex items-center gap-4">
                        <a href="https://github.com/sponsors/taylorotwell" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:outline-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            Sponsor
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </div>
@endsection
