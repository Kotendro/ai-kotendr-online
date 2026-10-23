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

    $litellmUrl = env('LITELLM_URL');
    $masterKey = env('LITELLM_MASTER_KEY');

    try {
        $response = Http::withToken($masterKey)->get($litellmUrl . '/key/info', [
            'key' => $key
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Сервер авторизации временно недоступен.');
    };

    if ($response->successful()) {
        $data = $response->json();
        
        $info = $data['info'] ?? $data;

        $budget = $info['max_budget'] ?? 0;
        $spend = $info['spend'] ?? 0;
        $remain = max(0, $budget - $spend);
        $last_active = $info['last_active'] ?? null;

        return view('info', [
            'last_active' => $last_active,
            'budget' => $budget,
            'spend' => $spend,
            'remain' => $remain,
            'models' => $info['models'] ?? [],
        ]);
    }

    return back()->with('error', 'Ключ не найден или недействителен.');
})->name('check');
