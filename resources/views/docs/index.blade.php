@extends('layouts.app')

@section('title', 'Документация')
@section('header_title', 'Документация')

@section('header_links')
<a href="{{ route('info') }}" class="text-blue-600 hover:underline">Войти</a>
@endsection

@section('content')
<div class="border border-gray-300 p-3">
    <p class="font-bold mb-2">Ссылки</p>
    <div class="flex flex-col text-sm">
        <a href="{{ route('docs.integration') }}" class="text-blue-600 hover:underline">Интеграция API</a>
        <a href="{{ route('docs.models') }}" class="text-blue-600 hover:underline">Модели и цены</a>
    </div>
</div>
@endsection