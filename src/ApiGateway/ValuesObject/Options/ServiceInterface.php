<?php
namespace ApiGateWay\ValuesObject\Options;

interface ServiceInterface
{
    public function getName(): string;
    public function getHost(): string;
    public function getAuth(): ?array;
}