@extends('layouts.app')

@section('title', 'Статистика ключа')
@section('header_title', 'Статистика ключа')

@section('header_subtitle')
@if($last_active)
<p class="text-sm text-gray-400 mt-1">Последняя активность: {{ \Carbon\Carbon::parse($last_active)->format('d.m.Y H:i') }}</p>
@endif
@endsection

@section('header_links')
<a href="{{ route('logout') }}" class="text-blue-600 hover:underline">Выйти</a>
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline">Документация</a>
@endsection

@section('content')
<div class="mb-8">
    <p class="text-lg">
        Доступный остаток: <span class="font-bold text-green-600">${{ number_format($remain * 100, 2) }}</span>
    </p>
    <p class="text-sm text-gray-400 mt-0.5">

        Потрачено: ${{ number_format($spend * 100, 2) }}
    </p>
</div>

<div class="mb-8">
    <p class="mb-2 font-bold">Доступные модели</p>
    @if(in_array('all-proxy-models', $models, true))
        <a href="{{ route('docs.models') }}" class="text-blue-600 hover:underline">Все модели</a>
    @elseif(empty($models))
        <span class="text-gray-500">Нет моделей</span>
    @else
        <ul class="list-disc list-inside text-gray-700 flex flex-col gap-1">
            @foreach($models as $model)
                <li>
                    <a href="{{ route('docs.models') }}#model-{{ hash('sha256', $model) }}" class="text-blue-600 hover:underline">{{ $model }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection