<?php
namespace ApiGateWay\ValuesObject\Options;

use nilBora\Utils\ValuesObject;

class Service extends ValuesObject implements ServiceInterface
{
    public function getName(): string
    {
        return $this->get('name');
    } // end getName
    
    public function getHost(): string
    {
        return $this->get('host');
    }
    
    public function getAuth(): ?array
    {
        return $this->get('auth');
    } // end getAuth
}