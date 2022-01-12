<?php
namespace Jtrw\ApiClient;

class ApiClientFactory implements ApiClientFactoryInterface
{
    const DEFAULT_ADAPTER_NAME = "curl";
    
    public function factory(string $name = null, array $options = []): ApiClientInterface
    {
        if (!$name) {
            $name = static::DEFAULT_ADAPTER_NAME;
        }
        
        $className = __NAMESPACE__.'\\'.ucfirst(strtolower($name)).'Adapter';
        
        //return new CurlAdapter($options);
        if (class_exists($className)) {
            return new $className($options);
        }
        
        throw new ApiClientFactoryException("Api Client Adapter Not Found");
    } // end factory
}

class ApiClientFactoryException extends \Exception
{}