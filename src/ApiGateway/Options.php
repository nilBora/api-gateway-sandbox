<?php
namespace ApiGateWay;

use ApiGateWay\ValuesObject\Options\Url;
use ApiGateWay\ValuesObject\Options\Service;

class Options implements OptionsInterface
{
    protected $optionsValuesObject;
    protected $options;
    
    public function __construct(array $options)
    {
        $this->options = $options;
    } // end __construct
    
    public function getUrlOptions()
    {
        if ($this->optionsValuesObject) {
            return $this->optionsValuesObject;
        }
    
        $this->optionsValuesObject  = $this->getPreparedOptions();
        
        return $this->optionsValuesObject;
    } // end getOptionsValuesObject
    
    protected function getPreparedOptions()
    {
        $options = [];
        
        foreach ($this->options['urls'] as $key => $option) {
            $optionVO = new Url($option);
            if ($optionVO->isRPC()) {
                $methods = $optionVO->getRpcMethods();
                $rpcMethods = [];
                foreach ($methods as $method => $methodOptions) {
                    $rpcMethods[$method] = new Url($methodOptions);
                }
                $optionVO->setRpcMethods($rpcMethods);
            }
            $options[$key] = $optionVO;
        }
        
        return $options;
    } // end getPreparedOptions
    
    public function getServiceOptions()
    {
        $options = [];
        foreach ($this->options['services'] as $key => $item) {
            $options[$key] = new Service($item);
        }
      
        return $options;
    } // end getServiceOptions
}