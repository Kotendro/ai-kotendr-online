@extends('layouts.app')

@section('title', 'Модели API')
@section('header_title', 'Модели API')

@section('header_links')
<a href="{{ route('info') }}" class="text-blue-600 hover:underline">Войти</a>
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline">Документация</a>
@endsection

@section('content')
<div class="mb-8">
    <div class="flex flex-col gap-6">
        @forelse($models as $model)
            <div id="model-{{ hash('sha256', $model['model_name']) }}" class="scroll-mt-4">
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
        @empty
            <p class="text-red-600">Не удалось загрузить список моделей.</p>
        @endforelse
    </div>
</div>
@endsection