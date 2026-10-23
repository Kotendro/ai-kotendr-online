@extends('layouts.app')

@section('title', 'Вход')
@section('header_title', 'API вход')

@section('header_links')
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline">Документация</a>
@endsection

@section('content')
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
@endsection