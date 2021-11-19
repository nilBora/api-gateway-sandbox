<?php

namespace Jtrw\ApiClient;

interface ApiClientInterface
{
    public function request(string $method, string $url, array $options);
}