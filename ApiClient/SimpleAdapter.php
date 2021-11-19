<?php
namespace Jtrw\ApiClient;

class SimpleAdapter implements ApiClientInterface
{
    protected $options;
    
    public function request(string $method, string $url, array $options)
    {
        $opts = [
            "http" => [
                "method"        => $method,
                "header"        => $this->getHeaders(),
                'ignore_errors' => true
            ]
        ];
    
        $context = stream_context_create($opts);
        
        return file_get_contents($url, false, $context);
    }
    
    protected function getHeaders(): array
    {
        $headers = $this->options['headers'] ?? [];
        $curlHeaders = [];
        foreach ($headers as $name => $value) {
            $curlHeaders[] = $name.": ".$value;
        }
        
        return $curlHeaders;
    } // end getHeaders
}