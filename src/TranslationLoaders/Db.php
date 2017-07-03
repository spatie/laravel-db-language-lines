<?php

namespace Spatie\TranslationLoader\TranslationLoaders;

use Spatie\TranslationLoader\LanguageLine;
use Spatie\TranslationLoader\Exceptions\InvalidConfiguration;

class Db implements TranslationLoader
{
    public function loadTranslations(string $namespace, string $locale, string $group): array
    {
        $model = $this->getConfiguredModelClass();

        return $model::getTranslationsForGroup($namespace, $locale, $group);
    }

    protected function getConfiguredModelClass(): string
    {
        $modelClass = config('laravel-translation-loader.model');

        if (! is_a(new $modelClass, LanguageLine::class)) {
            throw InvalidConfiguration::invalidModel($modelClass);
        }

        return $modelClass;
    }
}
