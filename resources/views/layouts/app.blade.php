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
</head>

<body class="bg-white text-gray-900 font-mono relative min-h-screen">

    <!-- Логотип вне основного контейнера (в левом верхнем углу) -->
    <div class="absolute top-4 left-4 sm:top-6 sm:left-8 font-bold text-gray-400 tracking-wider select-none">
        kotendr
    </div>

    <!-- Центральный контейнер (бывший body) -->
    <div class="max-w-2xl mx-auto p-6 pt-16 sm:p-12">
        
        <!-- Общая шапка -->
        <header class="flex justify-between items-baseline pb-4 mb-3">
            <div>
                <h1 class="text-2xl font-bold">@yield('header_title')</h1>
                <!-- Место для подзаголовка (например, последней активности) -->
                @yield('header_subtitle')
            </div>
            <div class="flex flex-col text-right">
                <!-- Место для ссылок навигации -->
                @yield('header_links')
            </div>
        </header>

        <!-- Навигация по странице -->
        <div>
            @yield('page_links')
        </div>

        <!-- Основной контент страницы -->
        <main>
            @yield('content')
        </main>
        
    </div>

</body>

</html>