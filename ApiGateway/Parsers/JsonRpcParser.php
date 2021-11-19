<?php
namespace ApiGateWay\Parsers;

class JsonRpcParser
{
    protected $body;
    
    public function __construct(string $body)
    {
        $this->body = $body;
    } // end __construct
    
    public function parse()
    {
        $data = json_decode($this->body);
    }
    
    
    
}