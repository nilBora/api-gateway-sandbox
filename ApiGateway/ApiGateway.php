<?php
namespace ApiGateWay;

use Jtrw\ApiClient\ApiClientFactoryInterface;
use ApiGateWay\ValuesObject\Options\ServiceInterface;
use ApiGateWay\ValuesObject\Options\UrlInterface;
use nilBora\Utils\Guid;

//use ApiGateWay\ValuesObject\JsonRpcInterface;

class ApiGateway
{
    const VERSION = "1.0";
    
    protected $urlOptions;
    protected $serviceOptions;
    protected $request;
    protected $apiClientFactory;
    
    public function __construct(RequestInterface $request, OptionsInterface $options, ApiClientFactoryInterface $apiClientFactory)
    {
        $this->request = $request;
        $this->urlOptions = $options->getUrlOptions();
        $this->serviceOptions = $options->getServiceOptions();
        $this->apiClientFactory = $apiClientFactory;
    }
    
    public function run(): ResponseInterface
    {
        $currentOptionVO = $this->getCurrentOption();
        
        if (!$currentOptionVO->isCurrentMethodRequest($this->request->getRequestMethod())) {
            throw new ApiGatewayException("Request Methods Not Equals");
        }
        
        if ($currentOptionVO->isRPC()) {
            $methods = $currentOptionVO->getRpcMethods();
            $jsonRpcVO = $this->request->getJsonRpcBody();
            
            $method = $jsonRpcVO->getMethod();
            if (array_key_exists($method, $methods)) {
                $currentRpcOption = $methods[$method];
                $apiClient = $this->apiClientFactory->factory();
                
                $serviceVO = $this->getService($currentRpcOption->getServiceName());
                $url = $serviceVO->getHost().$currentRpcOption->getPath();
                $requestMethod = $currentRpcOption->getRequestMethod();
                $headers = $this->getHeaders();
                
                $options = [
                    'headers' => $headers
                ];
                $result = $apiClient->request($requestMethod, $url, $options);
                $response = new Response();
                $response->setBody($result);
                return $response;
            }
            throw new ApiGatewayException("Need Implementation");
        }
    
        throw new ApiGatewayException("Need Implementation");
    }
    
    protected function getCurrentOption(): UrlInterface
    {
        $currentUri = $this->request->getCurrentUri();
    
        if (!array_key_exists($currentUri, $this->urlOptions)) {
            throw new ApiGatewayException();
        }
    
        return $this->urlOptions[$currentUri];
    } // end getCurrentOption
    
    protected function getService(string $serviceName): ServiceInterface
    {
        if (!array_key_exists($serviceName, $this->serviceOptions)) {
            throw new ApiGatewayException(sprintf("Service: %s Not Found", $serviceName));
        }
        
        return $this->serviceOptions[$serviceName];
    } // end getService
    
    protected function getHeaders()
    {
        $headers = $this->request->getHeaders();
        $headers['API-GATEWAY-VERSION'] = static::VERSION;
        //replace to ramsy uuid
        $headers['API-GATEWAY-TOKEN'] = (new Guid())->create();
        unset($headers['Content-Length']);
        unset($headers['Host']);
        
        return $headers;
    } // end getHeaders
}

class ApiGatewayException extends \Exception
{
}