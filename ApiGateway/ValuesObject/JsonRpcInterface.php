<?php
namespace ApiGateWay\ValuesObject;

interface JsonRpcInterface
{
    public function getID();
    public function getMethod();
    public function getParams();
    public function getVersion();
}