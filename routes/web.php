<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('index');
})->name('home');


Route::post('/check', function (Request $request) {
    $key = $request->input('api_key');

    if (!$key) {
        return back()->with('error', 'Пожалуйста, введите ключ.');
    }

    $litellmUrl = env('LITELLM_URL', 'http://127.0.0.1:4000');
    try {
        $response = Http::withToken($key)->get($litellmUrl . '/key/info');
    } catch (\Exception $e) {
        return back()->with('error', 'Сервер авторизации временно недоступен.');
    };

    if ($response->successful()) {
        $data = $response->json();

        $budget = $data['max_budget'] ?? 0;
        $spend = $data['spend'] ?? 0;
        $remain = max(0, $budget - $spend);

        return view('info', [
            'key' => $key,
            'budget' => $budget,
            'spend' => $spend,
            'remain' => $remain,
            'models' => $data['models'] ?? [],
            'expires' => $data['expires'] ?? null
        ]);
    }

    return back()->with('error', 'Ключ не найден или недействителен.');
})->name('check');
