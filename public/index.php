<?php
require('vendor/autoload.php');

use Src\Models\Api\WB\Api;
use Src\Models\Http\Handler;
use Src\Models\Api\WB\UrlHandler;

function parseItems(string $path): array
{
    $urlHandler = new UrlHandler();

    $urlComponent = $urlHandler->parseBreadcrumbs($path);

    $api = Api::getInstance();

    $api->setApiPostfix(implode('/', $urlComponent));

    $handler = new Handler($api);

    $graberPoolObject = $handler->getData();

    return $graberPoolObject->products;
}

var_dump(parseItems('Обувь/Мужская/Кеды и кроссовки'));