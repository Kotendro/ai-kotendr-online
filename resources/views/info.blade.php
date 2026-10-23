@extends('layouts.app')

@section('title', 'Информация о ключе')
@section('header_title', 'Статистика ключа')

@section('header_subtitle')
@if($last_active)
<p class="text-xs text-gray-400 mt-1">Последняя активность: {{ \Carbon\Carbon::parse($last_active)->format('d.m.Y H:i') }}</p>
@endif
@endsection

@section('header_links')
<a href="{{ route('logout') }}" class="text-blue-600 hover:underline">Выйти</a>
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline">Документация</a>
@endsection

@section('content')
<div class="flex flex-col gap-2 mb-8 text-lg">
    <p>Доступный остаток: <span class="font-bold text-green-600">${{ number_format($remain, 2) }}</span></p>
    <p class="text-gray-600">Общий лимит: ${{ number_format($budget, 2) }}</p>
    <p class="text-gray-600">Потрачено: ${{ number_format($spend, 2) }}</p>
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
@endsection