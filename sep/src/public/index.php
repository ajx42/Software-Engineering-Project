<?php

session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;



require '../vendor/autoload.php';
require '../db_stuff/db_handler.php';
$app = new \Slim\App(["settings" => $config]); 

$container = $app->getContainer();

// views
$container['view'] = new \Slim\Views\PhpRenderer("./");


// logger
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

//login
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
		$user = $body['user'];
		$this->logger->info("login true : $user");
		$_SESSION['username'] = $body['user'];
		$_SESSION['type'] = $check;
		$_SESSION['myname'] = $con->getname($body['user']);
		return $response->withRedirect('./user.php');
	}
	else{
		return $response->withRedirect('./login.html');
	}

});	

// first page redir.
$app->get('/', function(Request $request, Response $response) use ($app){
	session_destroy();
	return $response->withRedirect('./login.html');
});

// submit application form
$app->post('/submit', function(Request $request, Response $response) use($app){
	$body = $request->getParams();
	$body['approving_auth']=''; // todo: fetch approving authority name from db
	$con = new Dbhandler();
	if($con->insert_into_applications($body)){
		$response->write('sucessfully submitted');
		return $response->withRedirect('./user.php');
	}
	else{
		$this->logger->err('mysqli error');
		$response->write('failed');
		return $response->withRedirect('./user.php');
	}
});

// view recommendations
$app->get('/view_rec', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=2){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./user.php');
	}
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getallrec();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewrec.php", ["rec" => $res]);
});

$app->get('/view_rec/{app_id}',  function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$res = $con->fetchapp($app_id);
	$arr = mysqli_fetch_assoc($res);
	if($arr['recommending_auth']!=$_SESSION['username']){
		$this->logger->err("invalid app rec view request");
		return $response->withRedirect('../user.php');
	}
	$this->logger->info('app rec view request accepted');
	$data = array('app_id' => $app_id);	
	$this->view->render($response, "./view_app_rec.php", ["rec" => $arr]);
});

$app->get('/recommend_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->recommend_app($app_id);
	$this->logger->info('app rec status changed for $app_id');
	return $response->withRedirect('../view_rec');
});

$app->get('/reject_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->reject_app($app_id);
	$this->logger->info('app rec status changed for $app_id');
	return $response->withRedirect('../view_rec');
});

/*
$app->get('/tickets', function (Request $request, Response $response) {
    $this->logger->addInfo("Ticket list");
    $mapper = new TicketMapper($this->db);
    $tickets = $mapper->getTickets();
    
    $response = $this->view->render($response, "tickets.phtml", ["tickets" => $tickets]);
    return $response;
});
*/

/*
Crack
*/
$app->get('/fun', function(Request $request, Response $response) use($app){
	$param = "Why is everything so heavy?";

	return $response->withRedirect('https://www.youtube.com/watch?v=FM7MFYoylVs');
});

	
$app->run();
