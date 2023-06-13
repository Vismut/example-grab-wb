<?php

namespace Src\Models\Api\WB;

use Src\Models\TranslitiratorWB;

class UrlHandler
{
    public array $url = [];

    private static string $translitive = TranslitiratorWB::class;

    public function parseBreadcrumbs(string $bradcrumbs): array
    {
        $arrPath = explode('/', $bradcrumbs);

        $this->url = array_map(function ($value) {
            return self::translitive($value);
        }, $arrPath);

        return $this->url;
    }

    public static function translitive(string $income): string
    {
        return static::$translitive::transliterate(str_replace(['Я', 'я'], ['Ya', 'ya'], $income));
    }
}