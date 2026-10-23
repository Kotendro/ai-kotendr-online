<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiKeyController extends Controller
{
    /**
     * Отображение страницы ввода API-ключа
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Выход и очистка сессии
     */
    public function logout()
    {
        session()->flush();
        
        return redirect()->route('home');
    }

    /**
     * Отправка запроса на LiteLMM для проверки ключа.
     * Редиректит в /info при успехе.
     */
    public function check(Request $request)
    {
        $key = $request->input('api_key');

        if (!$key) {
            return back()->with('error', 'Пожалуйста, введите ключ.');
        }

        $litellmUrl = rtrim(env('LITELLM_URL'), '/');
        $masterKey = env('LITELLM_MASTER_KEY');

        try {
            $response = Http::withToken($masterKey)->get($litellmUrl . '/key/info', [
                'key' => $key
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Сервер авторизации временно недоступен.');
        }

        if ($response->successful()) {
            $data = $response->json();
            $info = $data['info'] ?? $data;

            $budget = $info['max_budget'] ?? 0;
            $spend = $info['spend'] ?? 0;
            $remain = max(0, $budget - $spend);
            $last_active = $info['last_active'] ?? null;
            $models = $info['models'] ?? [];

            session()->put([
                'api_key' => $key,
                'last_active' => $last_active,
                'budget' => $budget,
                'spend' => $spend,
                'remain' => $remain,
                'models' => $models,
            ]);

            return redirect()->route('info');
        }

        return back()->with('error', 'Ключ не найден или недействителен.');
    }

    /**
     * Основная информация о API-ключе
     */
    public function info()
    {
        $key = session('api_key');

        if (!$key) {
            return redirect()->route('home');
        }

        $litellmUrl = rtrim(env('LITELLM_URL'), '/');
        $masterKey = env('LITELLM_MASTER_KEY');

        $last_active = session('last_active');
        $budget = session('budget');
        $spend = session('spend');
        $remain = session('remain');
        $models = session('models', []);

        try {
            $response = Http::withToken($masterKey)->get($litellmUrl . '/key/info', [
                'key' => $key
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $info = $data['info'] ?? $data;

                $budget = $info['max_budget'] ?? $budget;
                $spend = $info['spend'] ?? $spend;
                $remain = max(0, $budget - $spend);
                $last_active = $info['last_active'] ?? $last_active;
                $models = $info['models'] ?? $models;

                session()->put([
                    'last_active' => $last_active,
                    'budget' => $budget,
                    'spend' => $spend,
                    'remain' => $remain,
                    'models' => $models,
                ]);
            }
        } catch (\Exception $e) {
            
        }

        return view('info', compact('last_active', 'budget', 'spend', 'remain', 'models'));
    }
}