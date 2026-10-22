<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-white text-gray-900 font-mono p-6 sm:p-12 max-w-lg mx-auto">

    <h1 class="text-2xl font-bold mb-8">API Вход</h1>

    @if(session('error'))
    <div class="text-red-600 mb-6">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('check') }}" class="flex flex-col gap-4">
        @csrf
        <label class="flex flex-col gap-2">
            <span class="text-gray-600">Введите ваш API ключ:</span>
            <input type="text" name="api_key" placeholder="sk-..." required
                class="border border-gray-300 p-2 focus:outline-none focus:border-black transition-colors">
        </label>
        <button type="submit" class="bg-black text-white p-2 hover:bg-gray-800 transition-colors">
            Проверить
        </button>
    </form>

</body>

</html>