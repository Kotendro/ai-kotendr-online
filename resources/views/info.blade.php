<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о ключе</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-white text-gray-900 font-mono p-6 sm:p-12 max-w-lg mx-auto">

    <div class="flex justify-between items-baseline border-b border-gray-200 pb-4 mb-6">
        <h1 class="text-2xl font-bold">Статистика ключа</h1>
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Выйти</a>
    </div>

    <div class="flex flex-col gap-3 mb-8 text-lg">
        <p>Доступный остаток: <span class="font-bold text-green-600">${{ number_format($remain, 2) }}</span></p>
        <p class="text-gray-600">Общий лимит: ${{ number_format($budget, 2) }}</p>
        <p class="text-gray-600">Потрачено: ${{ number_format($spend, 2) }}</p>

        @if($expires)
        <p class="text-gray-600">Действует до: {{ \Carbon\Carbon::parse($expires)->format('d.m.Y H:i') }}</p>
        @endif
    </div>

    <div class="mb-8">
        <p class="mb-2 font-bold">Доступные модели:</p>
        <ul class="list-disc list-inside text-gray-700 flex flex-col gap-1">
            @forelse($models as $model)
            <li>{{ $model }}</li>
            @empty
            <li>Все модели (без ограничений)</li>
            @endforelse
        </ul>
    </div>

</body>

</html>