@extends('layouts.app')

@section('title', 'Модели API')
@section('header_title', 'Модели API')

@push('head')
<style>
    html { scroll-behavior: smooth; }
</style>
@endpush

@section('header_links')
<a href="{{ route('info') }}" class="text-blue-600 hover:underline">Войти</a>
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline">Документация</a>
@endsection

@section('content')
@if(count($groups) > 0)
<div class="mb-8 border border-gray-300 p-3">
    <p class="font-bold mb-2">Навигация</p>
    <div class="flex flex-col text-sm">
        @foreach($groups as $group)
            <a href="#provider-{{ $group['key'] }}" class="text-blue-600 hover:underline">{{ $group['title'] }}</a>
        @endforeach
    </div>
</div>
@endif

<div class="space-y-8 text-sm text-gray-800">
    @forelse($groups as $group)
        <section id="provider-{{ $group['key'] }}" class="scroll-mt-6">
            <h2 class="text-lg font-bold mb-3">{{ $group['title'] }}</h2>

            <div class="flex flex-col gap-5">
                @foreach($group['models'] as $model)
                    <div id="model-{{ hash('sha256', $model['model_name']) }}" class="scroll-mt-6">
                        <p class="font-bold text-black text-base">{{ $model['model_name'] }}</p>

                        @if($model['input_cost_per_token'] !== null || $model['output_cost_per_token'] !== null)
                            <div class="flex gap-8 text-gray-600 mt-1">
                                <span><span class="text-sm text-gray-400">Ввод</span> ${{ number_format(($model['input_cost_per_token'] ?? 0) * 1000000, 2) }} <span class="text-sm text-gray-400">за 1М токенов</span></span>
                                <span><span class="text-sm text-gray-400">Вывод</span> ${{ number_format(($model['output_cost_per_token'] ?? 0) * 1000000, 2) }} <span class="text-sm text-gray-400">за 1М токенов</span></span>
                            </div>
                        @else
                            <p class="text-sm text-gray-400">Цены не указаны</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @empty
        <p class="text-red-600">Не удалось загрузить список моделей.</p>
    @endforelse
</div>
@endsection
