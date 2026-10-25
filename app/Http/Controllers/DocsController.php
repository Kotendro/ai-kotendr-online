<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DocsController extends Controller
{
    public function index()
    {
        return view('docs.index');
    }

    public function integration()
    {
        return view('docs.integration');
    }

    public function models()
    {
        $models = Cache::get('litellm_models_info');

        if ($models === null) {
            try {

                $litellmUrl = rtrim(env('LITELLM_URL'), '/');
                $masterKey = env('LITELLM_MASTER_KEY');

                $response = Http::withToken($masterKey)
                    ->timeout(5)
                    ->get($litellmUrl . '/v1/model/info');

                if ($response->successful()) {
                    $data = $response->json();
                    $models = [];

                    if (isset($data['data']) && is_array($data['data'])) {
                        foreach ($data['data'] as $item) {
                            $modelInfo = $item['model_info'] ?? [];

                            $models[] = [
                                'model_name'   => $item['model_name'] ?? 'Unknown',
                                'input_cost_per_token'  => $modelInfo['input_cost_per_token'] ?? null,
                                'output_cost_per_token' => $modelInfo['output_cost_per_token'] ?? null,
                            ];
                        }
                        usort($models, fn($a, $b) => strnatcasecmp($a['model_name'], $b['model_name']));
                    }
                    
                    Cache::put('litellm_models_info', $models, now()->addHour());
                } else {
                    $models = [];
                }
            } catch (\Exception $e) {
                $models = [];
            }
        }

        return view('docs.models', compact('models'));
    }
}
