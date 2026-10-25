@extends('layouts.app')

@section('title', 'Интеграция API')
@section('header_title', 'Интеграция API')

@push('head')
<style>
    html { scroll-behavior: smooth; }
</style>
@endpush

@section('header_links')
<a href="{{ route('info') }}" class="text-blue-600 hover:underline">Войти</a>
<a href="{{ route('docs.index') }}" class="text-blue-600 hover:underline mt-1">Документация</a>
@endsection

@section('content')
@php
    $apiKey = session('api_key', 'sk-ваш-ключ');
    $baseUrl = 'https://ai.kotendr.online/v1';
@endphp

<div class="mb-8 border border-gray-300 p-3">
    <p class="font-bold mb-2">Навигация</p>
    <div class="flex flex-col text-sm">
        <a href="#curl" class="text-blue-600 hover:underline">cURL</a>
        <a href="#python" class="text-blue-600 hover:underline">Python</a>
        <a href="#cursor" class="text-blue-600 hover:underline">Cursor IDE</a>
        <a href="#vscode" class="text-blue-600 hover:underline">VSCode/Cline</a>
        <a href="#continue" class="text-blue-600 hover:underline">Continue.dev</a>
        <a href="#codex" class="text-blue-600 hover:underline">Codex CLI</a>
    </div>
</div>

<div class="space-y-8 text-sm text-gray-800">

    <!-- cURL -->
    <section id="curl" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">cURL</h2>
        <p class="mb-2 text-gray-600">Пример базового HTTP-запроса из терминала:</p>
        <pre class="bg-gray-100 p-3 overflow-x-auto"><code>curl {{ $baseUrl }}/chat/completions \
  -H "Authorization: Bearer {{ $apiKey }}" \
  -H "Content-Type: application/json" \
  -d '{"model":"qwen/qwen3-coder-next","messages":[{"role":"user","content":"Hello!"}]}'</code></pre>
    </section>

    <!-- Python -->
    <section id="python" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">Python (OpenAI SDK)</h2>
        <p class="mb-2 text-gray-600">Пример вызова через официальную библиотеку <code>openai</code>:</p>
        <pre class="bg-gray-100 p-3 overflow-x-auto"><code>from openai import OpenAI

client = OpenAI(
    base_url="{{ $baseUrl }}",
    api_key="{{ $apiKey }}"
)

resp = client.chat.completions.create(
    model="qwen/qwen3-coder-next",
    messages=[{"role": "user", "content": "Hello!"}],
)
print(resp.choices[0].message.content)</code></pre>
    </section>

    <!-- Cursor IDE -->
    <section id="cursor" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">Cursor IDE</h2>
        <p class="mb-2 text-gray-600">Параметры подключения в настройках редактора (<code>Settings -> Models</code>):</p>
        <ul class="list-disc list-inside space-y-1">
            <li><strong>OpenAI API Key:</strong> <code>{{ $apiKey }}</code></li>
            <li><strong>Override OpenAI Base URL:</strong> <code>{{ $baseUrl }}</code></li>
            <li><strong>Models (+ Add model):</strong> <code>qwen/qwen3-coder-next</code></li>
        </ul>
    </section>

    <!-- VSCode / Cline -->
    <section id="vscode" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">VSCode/Cline</h2>
        <p class="mb-2 text-gray-600">Параметры подключения в настройках расширения:</p>
        <ul class="list-disc list-inside space-y-1">
            <li><strong>API Provider:</strong> <code>OpenAI Compatible</code></li>
            <li><strong>Base URL:</strong> <code>{{ $baseUrl }}</code></li>
            <li><strong>API Key:</strong> <code>{{ $apiKey }}</code></li>
            <li><strong>Model ID:</strong> <code>qwen/qwen3-coder-next</code></li>
        </ul>
    </section>

    <!-- Continue.dev -->
    <section id="continue" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">Continue.dev</h2>
        <p class="mb-2 text-gray-600">Вариант конфигурации для файла <code>config.yaml</code>:</p>
        <pre class="bg-gray-100 p-3 overflow-x-auto"><code>models:
  - name: qwen3-coder-next
    provider: openai
    model: qwen/qwen3-coder-next
    apiBase: {{ $baseUrl }}
    apiKey: {{ $apiKey }}
    roles:
      - chat
      - edit
      - apply</code></pre>
    </section>

    <!-- Codex CLI -->
    <section id="codex" class="scroll-mt-6">
        <h2 class="text-lg font-bold mb-2">Codex CLI</h2>
        <p class="mb-2 text-gray-600">Вариант конфигурации для файла <code>config.toml</code>:</p>
        <pre class="bg-gray-100 p-3 overflow-x-auto"><code>model = "qwen/qwen3-coder-next"
model_provider = "kotendr"
model_context_window = 258000
model_auto_compact_token_limit = 220000

[model_providers.kotendr]
name = "Kotendr"
base_url = "{{ $baseUrl }}"
wire_api = "responses"
experimental_bearer_token = "{{ $apiKey }}"</code></pre>
    </section>

</div>
@endsection