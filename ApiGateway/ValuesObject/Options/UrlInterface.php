<?php

namespace ApiGateWay\ValuesObject\Options;

interface UrlInterface
{
    public function isRPC(): bool ;
    public function getRpcMethods(): array;
    public function getRequestMethod(): string;
    public function setRpcMethods(array $methods);
    public function isCurrentMethodRequest(string $methodName): bool;
    public function getPath(): string ;
    public function getServiceName(): string;
    
}