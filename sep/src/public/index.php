<?php

session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;



require '../vendor/autoload.php';
require '../db_stuff/db_handler.php';
$app = new \Slim\App(["settings" => $config]); // ?

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$app->post('/articles', function(Request $request, Response $response) use($app) {

    $body = $request->getParams(); 
	/*
		data being fetched perfectly
		foreach($body as $key => $param){
			echo $param;
		}
	*/
	$con = new Dbhandler();
	$check = $con->authenticate($body['user'], $body['pin']);
	if($check){
		$_SESSION['username'] = $body['user'];
		$_SESSION['type'] = $check;
		return $response->withRedirect('./sep-pages/pages/user.php');
	}
	else{
		return $response->withRedirect('./sep-pages/pages/login.html');
	}

});	

$app->post('/submit', function(Request $request, Response $response) use($app){
	$body = $request->getParams();
	$body['approving_auth']=''; // todo: fetch approving authority name from db
	$con = new Dbhandler();
	if($con->insert_into_applications($body)){
		$response->write('sucessfully submitted');
		return $response->withRedirect('./sep-pages/pages/user.php');
	}
	else{
		$this->logger->err('mysqli error');
		$response->write('failed');
		return $response->withRedirect('./sep-pages/pages/user.php');
	}
});
	
$app->run();
