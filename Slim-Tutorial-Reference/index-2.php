<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "user";
$config['db']['pass']   = "password";
$config['db']['dbname'] = "exampleapp";
require './vendor/autoload.php';

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("./logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};


$app->get('/tickets', function(Request $request, Response $response) use ($app){
	$this->logger->addInfo("Ticket list");
	$response->getBody()->write("LOLOL");
	return $response;
});

$app->get('/addLog/{name}', function(Request $request, Response $response){
	$name = $request->getAttribute('name');
	$this->logger->addInfo($name);
	$response->getBody()->write("success");
});

$app->get('/lol/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->run();