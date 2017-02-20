<?php

require '../Slim/Slim.php';
\Slim\SLim::registerAutoloader();

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\SLim();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/hello/:name',function($name) use ($app){
	$app->response->write("hello, $name");
});

$app->get('/hi/:name',function($name) use ($app){
	$app->response->write("YO, $name");
});

$app->get('/redirectcheck', function() use($app){
	echo "Here";
	$app->response->redirect('test.php');
});

$app->get('/login', function() use($app){
	$app->setCookie('foo', 'bar', '2 days');
	$app->response->write("Cookie Set");
});

$app->get('/logout', function() use($app){
	$app-> deleteCookie('foo');
	$app->response->write("Cookie Removed");
});

$app->get('/cookie', function() use ($app){
	$cookie = $app->getCookie('foo');
	echo $cookie;
});

$app->get('/load', function() use ($app){
	$app->render('testpage.php');
});

$app->run();