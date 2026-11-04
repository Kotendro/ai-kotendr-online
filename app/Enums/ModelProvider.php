<?php

namespace App\Enums;

/**
 * Провайдер модели. Значение кейса — префикс имени модели в LiteLLM
 * ("~deepseek/deepseek-flash-latest" -> "deepseek").
 * Порядок кейсов задаёт порядок разделов на странице документации.
 */
enum ModelProvider: string
{
    case OpenAI = 'openai';
    case Anthropic = 'anthropic';
    case Google = 'google';
    case DeepSeek = 'deepseek';
    case Qwen = 'qwen';
    case Moonshot = 'moonshotai';
    case XAI = 'xai';
    case Meta = 'meta-llama';
    case Mistral = 'mistral';
    case Cohere = 'cohere';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::OpenAI => 'OpenAI (GPT)',
            self::Anthropic => 'Anthropic (Claude)',
            self::Google => 'Google (Gemini)',
            self::DeepSeek => 'DeepSeek',
            self::Qwen => 'Qwen (Alibaba)',
            self::Moonshot => 'Moonshot (Kimi)',
            self::XAI => 'xAI (Grok)',
            self::Meta => 'Meta (Llama)',
            self::Mistral => 'Mistral',
            self::Cohere => 'Cohere',
            self::Other => 'Прочие модели',
        };
    }

    /**
     * Позиция раздела в списке: чем меньше, тем выше. «Прочие» — всегда в конце.
     */
    public function sortOrder(): int
    {
        $index = array_search($this, self::cases(), true);

        return $index === false ? PHP_INT_MAX : $index;
    }

    /**
     * Определяет провайдера по имени модели: "~openai/gpt-mini-latest" -> OpenAI.
     */
    public static function fromModelName(string $modelName): self
    {
        $name = ltrim($modelName, '~');

        if (! str_contains($name, '/')) {
            return self::Other;
        }

        return self::tryFrom(strtolower(strtok($name, '/'))) ?? self::Other;
    }
}
