<?php

namespace ApiGateWay\ValuesObject\Options;

use nilBora\Utils\ValuesObject;


class Url extends ValuesObject implements UrlInterface
{
    public function isRPC(): bool
    {
        return $this->has('isJsonRPC') && $this->get('isJsonRPC'); //add condition for isset method
    } // end isRPC
    
    public function getRpcMethods(): array
    {
        return $this->get('methods');
    } // end getRpcMethods
    
    public function setRpcMethods(array $methods)
    {
        $this->set('methods', $methods);
    } // end setRpcMethods
    
    public function getRequestMethod(): string
    {
        return $this->get('method');
    } // end getRequestMethod
    
    public function isCurrentMethodRequest(string $methodName): bool
    {
        return $this->getRequestMethod() == $methodName;
    } // end isCurrentMethodRequest
    
    public function getPath(): string
    {
        return $this->get('path');
    } // end getPath
    
    public function getServiceName(): string
    {
        return $this->get('service');
    } // end getServiceName
    
    
}

