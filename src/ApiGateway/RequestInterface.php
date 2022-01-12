<?php
namespace ApiGateWay;

use ApiGateWay\ValuesObject\JsonRpcInterface;

interface RequestInterface
{
    public function getCurrentUri();
    public function getJsonRpcBody(): JsonRpcInterface;
    public function getHeaders(): array;
    public function getRequestMethod(): string;
}