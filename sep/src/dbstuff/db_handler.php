<?php
session_start();
class Dbhandler{
	private $conn;
	function __construct(){
		require_once dirname(__FILE__).'/db_connect.php';
		$db = new DbConnect();
		$this->conn = $db->connect();
	}
	public function authenticate($username, $password){
		$qry = "SELECT * from accounts where username = '$username' and password = '$password'";
		$response = 0;
		if($result = mysqli_query($this->conn, $qry)){
			if(mysqli_num_rows($result)>0){
        		$row = mysqli_fetch_assoc($result);
        		$response = $row['type'];
        	}
		}
		else{
			echo mysqli_error($this->conn);
		}
        return $response;
	}
	public function insert_into_applications($res){

		$username = $_SESSION['username'];
		$name = $res['name'];
		$nature = $res['nature'];
		$designation = $res['designation'];
		$department = $res['department'];
		$period_from = $res['period_from'];
		$period_to = $res['period_to'];
		
		$prefix_holidays = $res['prefix_holidays'];
		$sufix_holidays = $res['sufix_holidays'];
		$LTC = $res['LTC'];
		$address = $res['address'];
		$contact = $res['contact'];
		$status = 'Awaiting Recommendation';
		$recommending_auth = $res['recommending_auth'];
		
		///// Approving Authority name to be decided automatically
		$approving_auth = 'newhere';
		
		$cur_date = $res['cur_date'];
		if($prefix_holidays==NULL) $prefix_holidays = 'NULL';
		if($sufix_holidays==NULL) $sufix_holidays = 'NULL';
		if($LTC==NULL) $LTC = 'NULL';
		
		$qry = "INSERT into application(username,name,nature,designation,department,period_from,period_to,prefix_holidays,sufix_holidays,LTC,address,contact,status,recommending_auth,approving_auth,cur_date) values('$username', '$name', '$nature', '$designation', '$department','$period_from', '$period_to', $prefix_holidays, $sufix_holidays, '$LTC', '$address', '$contact', '$status', '$recommending_auth', '$approving_auth', '$cur_date' )";
		if($result = mysqli_query($this->conn, $qry)){
			return 1;
		}
		else{
			echo mysqli_error($this->conn);
			return 0;
		}
	}
	public function getname($userid){
		$qry = "SELECT name from accounts where username = '$userid'";
		if($result = mysqli_query($this->conn, $qry)){
			$arr = mysqli_fetch_assoc($result);
			return $arr['name'];
		} 
	}

	public function getallrec(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where recommending_auth = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result; 
	}

	public function fetchapp($app_id){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where application_id = '$app_id'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function recommend_app($app_id){
		$qry = "SELECT status FROM application WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		if($rec['status'] == 'Rejected' || $rec['status'] == 'Approved') return;
		$qry = "UPDATE application SET status = 'Recommended' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}

	public function reject_app($app_id){
		$qry = "SELECT status FROM application WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		if($rec['status'] == 'Rejected' || $rec['status'] == 'Approved') return;
		$qry = "UPDATE application SET status = 'Rejected' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}
	public function getallapr(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where approving_auth = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function approve_app($app_id){
		$qry = "UPDATE application SET status = 'Approved' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}

	public function reject_apr_app($app_id){
		$qry = "UPDATE application SET status = 'Rejected' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}

	public function getmyapp(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where username = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function getthatapp($app_id){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application WHERE username = '$myself' and application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}
	
	public function getbalance(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from leave_balance WHERE username = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}
	public function joining($details){
		$myself = $_SESSION['username'];
		$from_date =  new DateTime($details['period_from']);
		$to_date = new DateTime($details['period_to']);
		$number_of_days = $to_date->diff($from_date)->format("%a")+1;;
		if($details['nature'] == "HPL"){
			$qry = "UPDATE leave_balance SET HPL = HPL - 2*$number_of_days WHERE username = '$myself'";
		}
		else if($details['nature'] == "CL"){
			$qry = "UPDATE leave_balance SET CL = CL - $number_of_days WHERE username = '$myself'";
		}
		else if($details['nature'] == "Vacation"){
			$qry = "UPDATE leave_balance SET Vacation = Vacation - $number_of_days WHERE username = '$myself'";
		}
		if(mysqli_query($this->conn, $qry)) return 1;
		else return 0;
	}
	
	public function modify_email_notify($body){
		$myself = $_SESSION['username'];
		if($body['email_notify']=="enable"){
			$qry = "UPDATE accounts SET notifications = 1 WHERE username = '$myself'";
		}
		else{
			$qry = "UPDATE accounts SET notifications = 0 WHERE username = '$myself'";
		}
		mysqli_query($this->conn, $qry);
	}
	public function check_email_notifications($user){
		$qry = "SELECT notifications FROM accounts WHERE username = '$user'";
		$res = mysqli_query($this->conn, $qry);
		$ret = mysqli_fetch_assoc($res);
		return $ret['notifications'];
	}

	public function change_password($body){
		if($body['new_pass']!=$body['confirm_new_pass']) return 0;
		$myself = $_SESSION['username'];
		$pswrd = $body['old_pass'];
		if(!$this->authenticate($myself, $pswrd)){
			return 0;
		}
		$new_pass = $body['new_pass'];
		$qry = "UPDATE accounts SET password = '$new_pass' WHERE username = '$myself'";
		if(mysqli_query($this->conn, $qry)){
			return 1;
		}
		else return 0;
	}
}

?>
