<?php

namespace ApiGateWay;

use ApiGateWay\ValuesObject\JsonRpc;
use ApiGateWay\ValuesObject\JsonRpcInterface;

class Request implements RequestInterface
{
    protected $get;
    protected $post;
    protected $attributes;
    protected $cookies;
    protected $files;
    protected $server;
    protected $headers;
    
    public function __construct($get, $post, $attributes, $cookies, $files, $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }
    
    public function getCurrentUri()
    {
        $uri = $this->server['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);
    
        return empty($path) ? '/' : $path;
    } // end getCurrentUri
    
    public function getJsonRpcBody(): JsonRpcInterface
    {
        $body = $this->getBody();
        $data = json_decode($body, true);
        if (!array_key_exists('jsonrpc', $data)) {
            throw new RequestJsonRpcException();
        }
        return new JsonRpc($data);
    } // end getJsonRpcBody
    
    public function getBody()
    {
        return file_get_contents("php://input");
    } // end getBody
    
    public function getHeaders(): array
    {
        if ($this->headers) {
            return $this->headers;
        }
        
        if (!function_exists('getallheaders')) {
            $this->headers = $this->getAllHeaders();
            return $this->headers;
        }
        $this->headers = getallheaders();
        
        return $this->headers;
    } // end getHeaders
    
    public function hasHeader(string $name): bool
    {
        return array_key_exists($name, $this->headers);
    } // end hasHeader
    
    protected function getAllHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    } // end getAllHeaders
    
    public function getRequestMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    } // end getRequestMethod
}

class RequestException extends \Exception
{

}

class RequestJsonRpcException extends RequestException
{

}