<?php
namespace ApiGateWay;

class Response implements ResponseInterface
{
    const TYPE_JSON = 'json';
    
    protected $type;
    protected $body;
    
    public function __construct(string $type = self::TYPE_JSON)
    {
        $this->type = $type;
    }
    
    public function send()
    {
        $content = $this->getBody();
        switch ($this->type) {
            case static::TYPE_JSON:
                header('Content-type: application/json');
    
                echo $content;
                break;
        }
    }
    
    public function getBody()
    {
        return $this->body;
    } // end getBody
    
    public function setBody(string $body): void
    {
        $this->body = $body;
    } // end setBody
    
    public function setType(string $type): void
    {
        $this->type = $type;
    } // end setType

}