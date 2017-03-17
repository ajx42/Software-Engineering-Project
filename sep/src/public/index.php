<?php

session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;



require '../vendor/autoload.php';
require '../db_stuff/db_handler.php';
require '../_mail__/mail_handler.php';

$app = new \Slim\App(["settings" => $config]); 

$container = $app->getContainer();

// views
$container['view'] = new \Slim\Views\PhpRenderer("./");
// PHPMailer
$container['mailer'] = new MailHandler();

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
		$this->mailer->notify_rec($con->getname($body['recommending_auth']),$body['recommending_auth']);
		$this->mailer->notify_apr($con->getname($body['approving_auth']),$body['approving_auth']);
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

// view approvals for current user
$app->get('/view_apr', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=3){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./user.php');
	}
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getallapr();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewapr.php", ["rec" => $res]);
});

// view particular application for approval
$app->get('/view_apr/{app_id}',  function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$res = $con->fetchapp($app_id);
	$arr = mysqli_fetch_assoc($res);
	if($arr['approving_auth']!=$_SESSION['username']){
		$this->logger->err("invalid app apr view request");
		return $response->withRedirect('../user.php');
	}
	$this->logger->info('app apr view request accepted');
	$data = array('app_id' => $app_id);	
	$this->view->render($response, "./view_app_apr.php", ["rec" => $arr]);
});

// approve an application -> when approve button is pressed
$app->get('/approve_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->approve_app($app_id);
	$this->logger->info('app apr status changed for $app_id');
	return $response->withRedirect('../view_apr');
});

// reject approval request -> when reject button is pressed
$app->get('/reject_apr_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->reject_apr_app($app_id);
	$this->logger->info('app apr status changed for $app_id');
	return $response->withRedirect('../view_apr');
});

// view your leave history
$app->get('/my_leaves', function(Request $request, Response $response) use ($app){
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getmyapp();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewleaves.php", ["rec" => $res]);
});

$app->get('/my_leaves/{app_id}', function(Request $request, Response $response) use ($app){
	$user = $_SESSION['username'];
	$app_id = $request->getAttribute('app_id');
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getthatapp($app_id);
	$arr = mysqli_fetch_assoc($res);
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "view_app.php", ["rec" => $arr]);
});

$app->get('/balance', function (Request $request, Response $response) use ($app){
	$user = $_SESSION['username'];
	$this->logger->info("balance enquiry request : $user");
	$con = new Dbhandler();
	$res = $con->getbalance();
	$arr = mysqli_fetch_assoc($res);
	$this->view->render($response, "view_bal.php", ["rec" => $arr]);
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
	
$app->run();
