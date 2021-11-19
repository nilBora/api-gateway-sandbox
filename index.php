<?php

require_once "vendor/autoload.php";

use ApiGateWay\ApiGateway;
use ApiGateWay\OptionValuesObject;

//use Nyholm\Psr7\Factory\Psr17Factory;
//use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
//use Symfony\Component\HttpFoundation\Request;
//
//$symfonyRequest = new Request($_GET,
//    $_POST,
//    $_REQUEST,
//    $_COOKIE,
//    $_FILES,
//    $_SERVER
//);
//// The HTTP_HOST server key must be set to avoid an unexpected error
//
//$psr17Factory = new Psr17Factory();
//$psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
//$psrRequest = $psrHttpFactory->createRequest($symfonyRequest);



$options = [
    'urls' => [
        '/users' => [ //Url
            'service'   => 'userService',
            'method'    => 'POST',
            'path'      => 'users',
            'critical'  => true,
            'isJsonRPC' => true,
            'methods'   => [
                'users.list' => [
                    'method'    => 'GET',
                    'service'   => 'userService',
                    'path'      => '/users',
                    'async'     => false,
                ],
                'users.create' => [
                    'method'    => 'POST',
                    'service'   => 'userService',
                    'path'      => '/users',
                    'async'     => true,
                ],
                'users.getItem' => [
                    'method'    => 'GET',
                    'service'   => 'userService',
                    'path'      => '/users/{id}',
                    'async'     => false,
                ]
            ]
        ],
        '/posts' => [
            'service'   => 'postService',
            'method'    => 'GET',
            'path'      => 'posts',
        ]
    ],
    'services' => [
        'userService' => [
            'name' => 'userService',
            'host' => 'http://172.27.0.3',
            'auth' => [
                'type'  => 'api_key',
                'key'   => 'Access-Token',
                'value' => '123'
            ]
        ],
        'postService' => [
            'name' => 'postService',
            'host' => 'http://172.27.0.3',
            'auth' => false
        ]
    ]
    
];
$request = new \ApiGateWay\Request(
    $_GET,
    $_POST,
    $_REQUEST,
    $_COOKIE,
    $_FILES,
    $_SERVER
);

$optionsObject = new \ApiGateWay\Options($options);

$apiGateway = new ApiGateway($request, $optionsObject, new \Jtrw\ApiClient\ApiClientFactory());
$response = $apiGateway->run();
$response->send();
