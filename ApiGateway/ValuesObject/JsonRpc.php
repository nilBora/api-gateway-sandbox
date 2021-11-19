<?php
namespace ApiGateWay\ValuesObject;

use nilBora\Utils\ValuesObject;

class JsonRpc extends ValuesObject implements JsonRpcInterface
{
    public function getID()
    {
        return $this->get('id');
    } // end getID
    
    public function getMethod()
    {
        return $this->get('method');
    } // end getMethod
    
    public function getParams()
    {
        return $this->get('params');
    } // end getParams
    
    public function getVersion()
    {
        return $this->get('jsonrpc');
    } // end getVersion
}