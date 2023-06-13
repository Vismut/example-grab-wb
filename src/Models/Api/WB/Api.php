<?php

namespace Src\Models\Api\WB;

use GuzzleHttp\Client;
use Src\Models\Api as ApiInterface;

final class Api implements ApiInterface
{
    protected string $apiPrefix = 'https://www.wildberries.ru/webapi/catalogdata/';

    protected ?string $apiPostfix = null;

    protected $headers = [
        'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/113.0',
        'Accept' => '*/*',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'Origin' => 'https://www.wildberries.ru',
        'Pragma' => 'no-cache',
        'Referer' => 'https://www.wildberries.ru/',
        'Sec-Fetch-Mode' => 'cors',
        'Sec-Fetch-Site' => 'cross-site',

    ];

    protected static ?self $instance = null;

    protected Client $client;

    private function __construct()
    {
        $this->client = new Client([
            'timeout' => 15,
            'headers' => $this->headers,
        ]);
    }


    public static function getInstance(): ApiInterface
    {
        if (is_null(static::$instance)) {
            self::$instance = new self();
        }

        return static::$instance;
    }

    public function setApiPostfix(string $postfix): void
    {
        $this->apiPostfix = $postfix;
    }

    public function getHost(): string
    {
        if (is_null($this->apiPostfix)) {
            throw new \Exception('Postfix is empty');
        }
        return $this->apiPrefix . $this->apiPostfix;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    private function __clone()
    {

    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}