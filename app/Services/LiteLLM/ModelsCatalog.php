<?php

namespace App\Services\LiteLLM;

use App\Enums\ModelProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Каталог моделей из LiteLLM: загрузка, кэширование, маппинг и группировка по провайдеру.
 */
class ModelsCatalog
{
    private const CACHE_KEY = 'litellm:model-info:v1';

    private const CACHE_TTL_HOURS = 1;

    private const TIMEOUT_SECONDS = 5;

    /**
     * Модели, сгруппированные по провайдеру, в порядке отображения.
     *
     * @return array<int, array{key: string, title: string, models: array<int, array<string, mixed>>}>
     */
    public function grouped(): array
    {
        $grouped = [];

        foreach ($this->all() as $model) {
            $grouped[$model['provider']][] = $model;
        }

        $groups = [];

        foreach ($grouped as $key => $models) {
            $provider = ModelProvider::tryFrom($key) ?? ModelProvider::Other;

            usort($models, fn ($a, $b) => strnatcasecmp($a['model_name'], $b['model_name']));

            $groups[] = [
                'key' => $provider->value,
                'title' => $provider->label(),
                'order' => $provider->sortOrder(),
                'models' => $models,
            ];
        }

        usort($groups, fn ($a, $b) => $a['order'] <=> $b['order'] ?: strnatcasecmp($a['key'], $b['key']));

        return array_map(
            fn (array $group) => array_diff_key($group, ['order' => null]),
            $groups
        );
    }

    /**
     * Плоский список моделей с ценами.
     *
     * @return array<int, array{
     *     model_name: string,
     *     provider: string,
     *     input_cost_per_token: float|null,
     *     output_cost_per_token: float|null
     * }>
     */
    public function all(): array
    {
        $models = [];

        foreach ($this->rawModelInfo() as $item) {
            $modelInfo = $item['model_info'] ?? [];
            $modelName = $item['model_name'] ?? 'Unknown';

            $models[] = [
                'model_name' => $modelName,
                'provider' => ModelProvider::fromModelName($modelName)->value,
                'input_cost_per_token' => $modelInfo['input_cost_per_token'] ?? null,
                'output_cost_per_token' => $modelInfo['output_cost_per_token'] ?? null,
            ];
        }

        return $models;
    }

    /**
     * Сырой ответ LiteLLM `/v1/model/info`. Кэшируем только успешные ответы,
     * чтобы недоступность LiteLLM не «залипала» на час.
     *
     * @return array<int, array<string, mixed>>
     */
    private function rawModelInfo(): array
    {
        $cached = Cache::get(self::CACHE_KEY);

        if (is_array($cached)) {
            return $cached;
        }

        $data = $this->fetch();

        if ($data !== []) {
            Cache::put(self::CACHE_KEY, $data, now()->addHours(self::CACHE_TTL_HOURS));
        }

        return $data;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetch(): array
    {
        $url = rtrim((string) config('services.litellm.url'), '/');

        if ($url === '') {
            return [];
        }

        try {
            $response = Http::withToken((string) config('services.litellm.key'))
                ->timeout(self::TIMEOUT_SECONDS)
                ->get($url.'/v1/model/info');
        } catch (Throwable) {
            return [];
        }

        if (! $response->successful()) {
            return [];
        }

        $data = $response->json('data');

        return is_array($data) ? array_values(array_filter($data, 'is_array')) : [];
    }
}
