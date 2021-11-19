<?php
namespace Jtrw\ApiClient;

interface ApiClientFactoryInterface
{
    public function factory(string $name = null, array $options = []): ApiClientInterface;
}