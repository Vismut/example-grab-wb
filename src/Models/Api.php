<?php
namespace Src\Models;

interface Api
{
    public static function getInstance();

    public function getClient();

    public function getHost();

    public function setApiPostfix(string $postfix);
}