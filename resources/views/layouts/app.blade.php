<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- yield('title') подставит заголовок-->
    <title>@yield('title', 'API')</title>
    @vite(['resources/css/app.css'])
    <!-- Место для вставки уникальных стилей страницы -->
    @stack('head')
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>

<body class="bg-white text-gray-900 font-mono relative min-h-screen">

    <!-- Логотип -->
    <a href="{{ route('info') }}">
        <div class="absolute top-4 left-4 flex items-center gap-2 select-none">
            <svg class="w-6 h-6 text-gray-400" style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 512 512">
                <path d="M370.0918,52.146c-5.1312-5.1035-13.45-4.73-18.5638.3856-22.8748,22.8576-42.4939,50.3563-57.9047,81.18a262.8544,262.8544,0,0,0-75.3363,0,312.9512,312.9512,0,0,0-57.8235-81.1607c-5.11-5.1238-13.4326-5.5051-18.5681-.4027C83.3926,110.2814,46,198.3378,46,297.2485c0,91.875,93.9771,166.25,210,166.25,115.9375,0,210-74.375,210-166.25C466,198.3368,428.5262,110.2781,370.0918,52.146ZM146.625,330.8493c-24.3274-4.7254-44.9762-22.3129-56.875-46.7258,11.8988-24.4128,32.5476-42,56.875-46.7247Zm26.25,0V237.3988c24.2377,4.7243,44.9762,22.3119,56.875,46.7247C217.8512,308.5364,197.1127,326.1239,172.875,330.8493Zm166.25,0c-24.3274-4.7254-44.9762-22.3129-56.875-46.7258,11.8988-24.4128,32.5476-42,56.875-46.7247Zm26.25,0V237.3988c24.2377,4.7243,44.9762,22.3119,56.875,46.7247C410.3512,308.5364,389.6127,326.1239,365.375,330.8493Z"/>
            </svg>
            <span class="font-bold text-gray-400 tracking-wider">ai.kotendr</span>
        </div>
    </a>

    <!-- Центральный контейнер -->
    <div class="max-w-2xl mx-auto p-6 pt-16">
        
        <!-- Общая шапка -->
        <header class="flex justify-between items-baseline pb-4 mb-3">
            <div>
                <h1 class="text-2xl font-bold">@yield('header_title')</h1>
                <!-- Место для подзаголовка -->
                @yield('header_subtitle')
            </div>
            <div class="flex flex-col text-right">
                <!-- Место для ссылок навигации -->
                @yield('header_links')
            </div>
        </header>

        <!-- Основной контент страницы -->
        <main>
            @yield('content')
        </main>
        
    </div>

</body>

</html>