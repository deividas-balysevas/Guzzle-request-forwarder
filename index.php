<?php

require './vendor/autoload.php';

const URL_API = 'http://modus.modusgroup.lt:8084/api';

use Proxy\Proxy;
use Proxy\Adapter\Guzzle\GuzzleAdapter;
use Proxy\Filter\RemoveEncodingFilter;
use Laminas\Diactoros\ServerRequestFactory;

// Create a PSR7 request based on the current browser request.
$request = ServerRequestFactory::fromGlobals();

// Create a guzzle client
$guzzle = new GuzzleHttp\Client([
    'http_errors' => false
]);

// Create the proxy instance
$proxy = new Proxy(new GuzzleAdapter($guzzle));

// Add a response filter that removes the encoding headers.
//$proxy->filter(new RemoveEncodingFilter());



// Forward the request and get the response.
$response = $proxy->forward($request)->to(URL_API);

//die(print_r($proxy->getRequest()));


// Output response to the browser.
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);