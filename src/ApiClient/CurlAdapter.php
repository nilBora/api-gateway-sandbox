<?php

namespace Jtrw\ApiClient;

class CurlAdapter implements ApiClientInterface
{
    const REQUEST_METHOD_POST = "POST";
    
    protected $options;
    protected $lastCode;
    protected $lastError = null;
    
    public function __construct(array $options)
    {
        $this->options = $options;
    }
    
    public function request(string $method, string $url, array $options)
    {
        $this->options = array_merge($this->options, $options);
        
        $curlOptions = $this->getDefaultOptions();
        $curl = curl_init();

        $curlOptions[CURLOPT_URL] = $url;
        
        if ($this->isRequestMethodPost($method, $options)) {
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $options['params'];
        }
    
        $curlOptions[CURLOPT_HTTPHEADER] = $this->getHeaders();
      
        curl_setopt_array($curl, $curlOptions);
        
        $response = curl_exec($curl);

        if ($erNo = curl_errno($curl)) {
            $this->lastError = $erNo.': '.curl_error($curl);
        }
        
        $this->lastCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        return $response;
    } // end request
    
    protected function isRequestMethodPost(string $method, array $options): bool
    {
        return $method == static::REQUEST_METHOD_POST && !empty($options['params']);
    } // end isRequestMethodPost
    
    public function getCode(): int
    {
        return $this->lastCode;
    } // end getCode
    
    public function getError(): ?string
    {
        $this->lastError;
    } // end getError
    
    protected function getHeaders(): array
    {
        $headers = $this->options['headers'] ?? [];
        $curlHeaders = [];
        foreach ($headers as $name => $value) {
            $curlHeaders[] = $name.": ".$value;
        }
        
        return $curlHeaders;
    } // end getHeaders
    
    protected function getDefaultOptions(): array
    {
        return [
            CURLOPT_FAILONERROR    => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.15)".
                " Gecko/20110303 Firefox/3.6.15 GTB7.1",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_VERBOSE        => false,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER     => ['Expect:']
        ];
    } // end getDefaultOptions
}