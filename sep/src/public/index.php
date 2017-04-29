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
$container['mailer'] = new MailHandler();

// logger
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

// notFoundHandling
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('<h1> Error 404 - Page not found </h1>');
    };
};


//login
$app->post('/articles',function(Request $request, Response $response) use($app) {

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
		if($check == 4){
			return $response->withRedirect('./admin');
		}
		else return $response->withRedirect('./dashboard');
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
	//$body['approving_auth']='aditya1304jain@gmail.com'; // todo: fetch approving authority name from db
	$con = new Dbhandler();
	if($body['EL']=='Yes')
	{
		if($con->deduct_EL($_SESSION['username']))
		{
			$this->logger->info("EL deducted");
		}
		else
		{
			$this->logger->err('could not deduct EL');
		}		
	}
	else
	{
		$this->logger->info("Do Not Encash");
	}
	if($con->insert_into_applications($body)){
		$response->write('sucessfully submitted');
		$this->mailer->notify_rec($con->getname($body['recommending_auth']),$body['recommending_auth']);
		$this->mailer->notify_apr($con->getname($body['approving_auth']),$body['approving_auth']);
		return $response->withRedirect('./dashboard');

	}
	else{
		$this->logger->err('mysqli error');
		$response->write('failed');
		return $response->withRedirect('./dashboard');
	}
});

// view recommendations
$app->get('/view_rec', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=2){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./dashboard');
	}
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getallrec();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewrec.php", ["rec" => $res]);
});

// view an application
$app->get('/view_rec/{app_id}',  function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$res = $con->fetchapp($app_id);
	if(mysqli_num_rows($res)==0){throw new \Slim\Exception\NotFoundException($request, $response);}
	$arr = mysqli_fetch_assoc($res);
	if($arr['recommending_auth']!=$_SESSION['username']){
		$this->logger->err("invalid app rec view request");
		return $response->withRedirect('../dashboard');
	}
	$this->logger->info('app rec view request accepted');
	$data = array('app_id' => $app_id);	
	$this->view->render($response, "./view_app_rec.php", ["rec" => $arr]);
});

// recommend application -> when recommend is clicked
$app->post('/recommend_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$body = $request->getParams();
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->recommend_app($app_id, $body['comment']);
	$this->logger->info('app rec status changed for $app_id');
	return $response->withRedirect('../view_rec');
});

// reject application -> when reject button is clicked
$app->post('/reject_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$body = $request->getParams();
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->reject_app($app_id, $body['comment']);
	$this->logger->info('app rec status changed for $app_id');
	return $response->withRedirect('../view_rec');
});

// view approvals for current user
$app->get('/view_apr', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=3){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./dashboard');
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
	if(mysqli_num_rows($res)==0){throw new \Slim\Exception\NotFoundException($request, $response);}
	$arr = mysqli_fetch_assoc($res);
	if($arr['approving_auth']!=$_SESSION['username']){
		$this->logger->err("invalid app apr view request");
		return $response->withRedirect('../dashboard');
	}
	$this->logger->info('app apr view request accepted');
	$data = array('app_id' => $app_id);	
	$this->view->render($response, "./view_app_apr.php", ["rec" => $arr]);
});

// approve an application -> when approve button is pressed
$app->post('/approve_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$body = $request->getParams();
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->approve_app($app_id, $body['comment']);
	$this->logger->info('app apr status changed for $app_id');
	return $response->withRedirect('../view_apr');
});

// reject approval request -> when reject button is pressed
$app->post('/reject_apr_app/{app_id}', function(Request $request, Response $response) use ($app){
	$app_id = $request->getAttribute('app_id');
	$body = $request->getParams();
	$con = new Dbhandler();
	$app_id = (int)$app_id;
	$con->reject_apr_app($app_id, $body['comment']);
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
	if(mysqli_num_rows($res)==0){throw new \Slim\Exception\NotFoundException($request, $response);}
	$arr = mysqli_fetch_assoc($res);
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "view_app.php", ["rec" => $arr]);
});

$app->get('/balance', function (Request $request, Response $response) use ($app){
	$user = $_SESSION['username'];
	$this->logger->info("balance enquiry request : $user");
	$con = new Dbhandler();
	$res = $con->getbalance($user);
	$arr = mysqli_fetch_assoc($res);
	$this->view->render($response, "view_bal.php", ["rec" => $arr]);
});

// View for Joining Report - Form
/*$app->get('/join', function (Request $request, Response $response) use ($app){
	$arr['user'] = $_SESSION['username'];
	$arr['name'] = $_SESSION['myname'];
	$this->view->render($response, "joining_report.php", ["rec" => $arr]);
});
*/
$app->get('/join', function (Request $request, Response $response) use ($app){
	//$arr['user'] = $_SESSION['username'];
	//$arr['name'] = $_SESSION['myname'];
	$con = new Dbhandler();
	$user = $_SESSION['username'];
	$res = $con->get_pending_joining($user);
	$this->view->render($response, "pending_joining.php", ["rec" => $res]);
});

$app->get('/fill-joining-report/{app_id}', function (Request $request, Response $response) use ($app){
	//$arr['user'] = $_SESSION['username'];
	//$arr['name'] = $_SESSION['myname'];
	$app_id = $request->getAttribute('app_id');
	$con = new Dbhandler();
	$valid = $con->validate_for_joining_report($app_id, $user);
	if(!$valid) throw new \Slim\Exception\NotFoundException($request, $response);
	$arr['id'] = $app_id;
	$arr['user'] = $_SESSION['username'];
	$arr['name'] = $_SESSION['myname'];
	$res = $con->fetchapp($app_id);
	$rec = mysqli_fetch_assoc($res);
	$dep = $con->get_all_deps();

	$this->view->render($response, "joining_report.php", ["rec" => $rec, "dep" => $dep]);
});


//add new account holder- form
$app->get('/add_new_account_holder', function (Request $request, Response $response) use ($app){
	if($_SESSION['type']!=4) throw new \Slim\Exception\NotFoundException($request, $response); 
	$con = new Dbhandler();
	$dep = $con->get_all_deps();
	$apr = $con->get_all_approvers();
	$this->view->render($response, "add_new_account.php", ["dep" => $dep, "apr" => $apr]);
});
//add_news
$app->get('/add_news', function (Request $request, Response $response) use ($app){
	$this->view->render($response, "add_site_news.php");
});
//dashboard
$app->get('/dashboard', function (Request $request, Response $response) use ($app){
	if(!$_SESSION['type'] or $_SESSION['type']==4){throw new \Slim\Exception\NotFoundException($request, $response);}
	$con = new Dbhandler();
	$ret = $con->display_news();
	//return $response->withRedirect('./dashboard');
	$this->view->render($response, "display_news.php", ["ret" => $ret]);
	
});
/*
$app->get('/view_all_users', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$rec = $con->get_all_users();
	$this->view->render($response, "view_users.php", ["rec" => $rec]);
});
*/
//submit new news
/*
$app->post('/submit_add_new_member', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$this->logger->info("new member added successfully : $user");
	$con = new Dbhandler();
	$status = $con->insert_new_member($body);
	//$this->mailer->join_notify($status);	
	//$this->logger->info($con->joining($body));
	return $response->withRedirect('./admin');
});
*/

$app->post('/submit_add_new_member', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$this->logger->info("new member added successfully : $user");
	$con = new Dbhandler();
	if($body['type'] == "General User") $body['type'] = 1;
	else if($body['type'] == "Recommending Authority") $body['type'] = 2;
	else if($body['type'] == "Approving Authority") $body['type'] = 3;
	else if($body['type'] == "Administrator") $body['type'] = 4;
	$body['password'] = $pwd = bin2hex(openssl_random_pseudo_bytes(4));
	$status = $con->insert_new_member($body);
	if($status) $this->mailer->account_created_notification($body['username'], $body['name'], $body['password']);
	$this->logger->info("$status");
	//$this->mailer->join_notify($status);	
	//$this->logger->info($con->joining($body));
	return $response->withRedirect('./admin');
});

//submit_news
$app->post('/submit_news', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$this->logger->info("new news added successfully : $user");
	$con = new Dbhandler();
	$status = $con->insert_new_mews($body);
	//$this->mailer->join_notify($status);	
	//$this->logger->info($con->joining($body));
	return $response->withRedirect('./admin');
});
// Post Joining Report Information
$app->post('/submit_join', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$this->logger->info("Joining Report Submitted : $user");
	$con = new Dbhandler();
	$status = $con->joining($body);
	$this->mailer->join_notify($status);	
	//$this->logger->info($con->joining($body));
	return $response->withRedirect('./dashboard');
});

$app->get('/settings', function (Request $request, Response $response) use ($app){
	//$error = $request->getHeader('status');
	//$headers = $request->getHeaders();
	//foreach ($headers as $name => $values) {
    //	$this->logger->info( $name . ": " . implode(", ", $values));
	//}
	//$this->logger->info("Joining Report Submitted : $errors");
	$con = new Dbhandler();
	$ret = $con->fetch_all_approvers();
	if($_SESSION['type']==4)
	{
       $this->view->render($response, "adminsettings.php", ["rec" => $ret]);
	}
	else
	{
		$this->view->render($response, "settings.php", ["rec" => $ret]);
	}
	
});
/*$app->get('/add_new_account_holder', function (Request $request, Response $response) use ($app){
	//$error = $request->getHeader('status');
	//$headers = $request->getHeaders();
	//foreach ($headers as $name => $values) {
    //	$this->logger->info( $name . ": " . implode(", ", $values));
	//}
	//$this->logger->info("Joining Report Submitted : $errors");
	/*$con = new Dbhandler();
	$ret = $con->fetch_all_approvers();
	//$this->view->render($response, "add_new_account_holder.php", ["rec" => $ret]);
	
});*/

$app->post('/email_notify', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$con = new Dbhandler();
	$con->modify_email_notify($body);
	return $response->withRedirect('./settings');
});

$app->post('/change_password', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$con = new Dbhandler();
	$status = $con->change_password($body);
	//$newResponse = $response->withHeader('Content-type', $status);
	return $response->withRedirect('./settings');
});

$app->post('/forward', function (Request $request, Response $response) use ($app){
	$body = $request->getParams();
	$con = new Dbhandler();
	if($body['to_forward'] == "Do not Forward") $body['to_forward'] = $_SESSION['username'];
	$con->set_to_forward($_SESSION['username'], $body['to_forward']); 
	return $response->withRedirect('./settings');
});

$app->get('/pending_approvals', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=3){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./dashboard');
	}
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getpenapr();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewapr.php", ["rec" => $res]);
});

$app->get('/pending_recommendations', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=2){
		$this->logger->err('invalid view request');
		return $response->withRedirect('./dashboard');
	}
	$user = $_SESSION['username'];
	$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getpenrec();
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "viewrec.php", ["rec" => $res]);
});

$app->get('/apply', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username'])) return $response->withRedirect('./');
	$con = new Dbhandler();
	$rec = $con->get_recommenders($_SESSION['username']);
	$dep = $con->getmydep($_SESSION['username']);
	$apr = $con->get_fin_approver($con->getapprover($_SESSION['username']));
	//$dep = $con->get_departments();
	$this->view->render($response, "forms.php", ["rec" => $rec, "dep" => $dep, "appr" => $apr]);
});

$app->get('/admin', function(Request $request, Response $response) use ($app){
	$con = new Dbhandler();
	$ret = $con->display_news();
	//return $response->withRedirect('./dashboard');
	//$this->view->render($response, "display_news.php", ["ret" => $ret]);
	if(!isset($_SESSION['username'])) return $response->withRedirect('./');
	$this->view->render($response, "admin.php", ["ret" => $ret]);
});

$app->get('/view_all_apps', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$rec = $con->get_all_apps();
	$this->view->render($response, "all_apps.php", ["rec" => $rec]);
});

$app->get('/view_all_users', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$rec = $con->get_all_users();
	$this->view->render($response, "view_users.php", ["rec" => $rec]);
});


$app->get('/user_details/{username}', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$username = $request->getAttribute('username');
	$rec = $con->get_user_details($username);
	if(mysqli_num_rows($rec)==0){throw new \Slim\Exception\NotFoundException($request, $response);}
	$bal = $con->getbalance($username);
	$dep = $con->get_all_deps();
	$this->view->render($response, "view_user_info.php", ["rec" => $rec, "balance" => $bal, "dep" => $dep]);
});


$app->post('/user_details/{username}/updatebasics', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$username = $request->getAttribute('username');
	$body = $request->getParams();
	$con->change_name($body['name'], $username);
	$con->change_type($body['type'], $username);
	$con->change_notify($body['email_notify'], $username);
	$con->change_dep($body['department_select'], $username);
	return $response->withRedirect('../'.$username);
});

$app->post('/user_details/{username}/updateleave', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$username = $request->getAttribute('username');
	$body = $request->getParams();
	$con->change_leaves($body, $username);
	return $response->withRedirect('../'.$username);
});

$app->get('/view-all-joining', function(Request $request, Response $response) use ($app){
	if(!isset($_SESSION['username']) or $_SESSION['type']!=4) return $response->withRedirect('./');
	$con = new Dbhandler();
	$rec = $con->get_all_joining_reports();
	$this->view->render($response, "all_joining.php", ["rec" => $rec]);
});


$app->get('/view-application/{app_id}', function(Request $request, Response $response) use ($app){
	//$user = $_SESSION['username'];
	$app_id = $request->getAttribute('app_id');
	//$this->logger->info("view request accepted : $user");
	$con = new Dbhandler();
	$res = $con->getthatappforadmin($app_id);
	if(mysqli_num_rows($res)==0){throw new \Slim\Exception\NotFoundException($request, $response);}
	$arr = mysqli_fetch_assoc($res);
	$this->logger->info(mysqli_num_rows($res));
	$this->view->render($response, "view_app.php", ["rec" => $arr]);
});

$app->get('/remove-news/{news_id}', function(Request $request, Response $response) use ($app){
	$news_id = $request->getAttribute('news_id');
	if($_SESSION['type']!=4){throw new \Slim\Exception\NotFoundException($request, $response);}
	$con = new Dbhandler();
	$res = $con->remove_news($news_id);
	return $response->withRedirect('../admin');
	//$this->view->render($response, "view_app.php", ["rec" => $arr]);
});

$app->get('/departments', function(Request $request, Response $response) use ($app){
	if($_SESSION['type']!=4){throw new \Slim\Exception\NotFoundException($request, $response);}
	$con = new Dbhandler();
	$res = $con->get_all_deps();
	//return $response->withRedirect('../admin');
	$this->view->render($response, "all_deps.php", ["res" => $res]);
});

$app->post('/add-department', function(Request $request, Response $response) use ($app){
if($_SESSION['type']!=4){throw new \Slim\Exception\NotFoundException($request, $response);}
	$con = new Dbhandler();
	$body = $request->getParams();
	if($body['depname'])$con->add_new_department($body);
	return $response->withRedirect('./departments');
});

/*$app->get('/remove-department/{depname}', function(Request $request, Response $response) use ($app){
if($_SESSION['type']!=4){throw new \Slim\Exception\NotFoundException($request, $response);}
	$con = new Dbhandler();
	$dep = $request->getAttribute('depname');
	if($body['depname'])$con->delete_department($dep);

	return $response->withRedirect('../departments');
});
*/

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



$app->get('/yo', function(Request $request, Response $response) use($app){
	$this->mailer->notify_rec('Aditya', 'cse150001001@iiti.ac.in');
});



$app->get('/fun', function(Request $request, Response $response) use($app){
	$param = "Why is everything so heavy?";

	return $response->withRedirect('https://www.youtube.com/watch?v=FM7MFYoylVs');
});


	
$app->run();
