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
		$pass_md5=md5($password);
		$qry = "SELECT * from accounts where username = '$username'";
		$response = 0;
		if($result = mysqli_query($this->conn, $qry)){
			if(mysqli_num_rows($result)>0){
        		$row = mysqli_fetch_assoc($result);
        		if($pass_md5 == md5($row['password'])){
        			$response = $row['type'];
        		}
        		
        	}
		}
		else{
			echo mysqli_error($this->conn);
		}
        return $response;
	}
	public function insert_new_mews($res){
		$news=$res['news'];
		$heading = $res['heading'];
		$date=	date("Y/m/d");
		$qry = "INSERT into add_news(heading, news, date) values('$heading', '$news','$date' )";
		if($result = mysqli_query($this->conn, $qry)){
			return 1;
		}
		else{
			echo mysqli_error($this->conn);
			return 0;
		}
	}

	public function insert_into_applications($res){

		$username = $_SESSION['username'];
		$name = $_SESSION['myname'];
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
		$approving_auth = $this->get_fin_approver($res['approving_auth']);
		
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
	//display news
	public function display_news(){
		$qry = "SELECT * from add_news order by date desc";
		$result = mysqli_query($this->conn, $qry);
		return $result;
		
	}
	//insert new member
	public function insert_new_member($res){
		$username=$res['username'];
		$cl=$res['cl'];
		$hpl=$res['hpl'];
		$vacation=$res['vacation'];
		$el=$res['el'];		
		$qry = "INSERT into leave_balance(username,CL,HPL,Vacation,el) values('$username',
		                    '$cl','$hpl','$vacation','$el' )";
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

	public function recommend_app($app_id, $comment){
		$qry = "SELECT status FROM application WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		if($rec['status'] == 'Rejected' || $rec['status'] == 'Approved') return;
		$qry = "UPDATE application SET status = 'Recommended', recommender_comments = '$comment' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}

	public function reject_app($app_id, $comment){
		$qry = "SELECT status FROM application WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		if($rec['status'] == 'Rejected' || $rec['status'] == 'Approved') return;
		$qry = "UPDATE application SET status = 'Not Recommended', recommender_comments = '$comment' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
	}

	public function getallapr(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where approving_auth = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function approve_app($app_id, $comment){
		$qry = "UPDATE application SET status = 'Approved', approver_comments = '$comment' WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$qry = "SELECT * from application where application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		if($rec['nature'] == "CL"){
			$usr = $rec['username'];
			$to_date = new DateTime($rec['period_to']);
			$from_date = new DateTime($rec['period_from']);
			$number_of_days = $to_date->diff($from_date)->format("%a")+1;;
			$qry = "UPDATE leave_balance SET CL = CL - $number_of_days WHERE username = '$usr'";
			mysqli_query($this->conn, $qry);
		}
	}

	public function reject_apr_app($app_id, $comment){
		$qry = "UPDATE application SET status = 'Rejected', approver_comments = '$comment' WHERE application_id = $app_id";
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

	public function getthatappforadmin($app_id){
		$myself = $_SESSION['username'];
		if($_SESSION['type']!=4) return $result;
		$qry = "SELECT * from application WHERE application_id = $app_id";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function getbalance($myself){
		//$myself = $_SESSION['username'];
		$qry = "SELECT * from leave_balance WHERE username = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function joining($details){
		$myself = $_SESSION['username'];
		$from_date =  new DateTime($details['period_from']);
		$to_date = new DateTime($details['period_to']);
		$nature = $details['nature'];
		$report_from = $details['report_from'];
		$number_of_days = $to_date->diff($from_date)->format("%a")+1;;
				$from = $details['period_from'];
		$to = $details['period_to'];
		$cur_date = date("Y-m-d");
		$app_id = $details['for_app_id'];
		$pec = "INSERT into Joining_Reports(application_id,Username,Nature,Period_From,Period_To,Report_From,Date) values($app_id,'$myself', '$nature', '$from', '$to', '$report_from', '$cur_date')";
		mysqli_query($this->conn, $pec);
		$mec = (int)mysqli_insert_id($this->conn);
		$qec = "UPDATE application SET joining_report = $mec WHERE application_id = $app_id";
		mysqli_query($this->conn, $qec);

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
		$new_pass_md5=md5($body['new_pass']);
		$qry = "UPDATE accounts SET password = '$new_pass_md5' WHERE username = '$myself'";
		if(mysqli_query($this->conn, $qry)){
			return 1;
		}
		else return 0;
	}

	public function getpenapr(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where approving_auth = '$myself' AND status != 'Rejected' AND status != 'Approved'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function getpenrec(){
		$myself = $_SESSION['username'];
		$qry = "SELECT * from application where recommending_auth = '$myself' AND status = 'Awaiting Recommendation'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function getmydep($user){
		$qry = "SELECT department from accounts where username = '$user'";
		$result = mysqli_query($this->conn, $qry);
		$arr = mysqli_fetch_assoc($result);
		return $arr['department'];
	}

	public function get_recommenders($user){
		$mydep = $this->getmydep($user);
		$qry = "SELECT username, name from accounts where department = '$mydep' and username != '$user'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function get_all_apps(){
		$qry = "SELECT * from application";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function get_all_users(){
		$qry = "SELECT * from accounts";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}
	public function get_user_details($username){
		$qry = "SELECT * from accounts WHERE username = '$username'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}
	public function getusertype($user){
		$qry = "SELECT * from accounts where username = '$user'";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		return $rec['type'];


	}
	public function change_type($type, $myself){
		if($type != 'General User' and $type != 'Recommending Authority' and $type != 'Approving Authority' and $type != 'LPS Administrator') return;
		if($this->getusertype($myself) == $type) return;
		if($this->getusertype($myself) == 3){
			$qry = "UPDATE forward_approving_auth SET forwarded_to = forward_approving_auth.username WHERE forwarded_to = '$myself'";
			mysqli_query($this->conn, $qry);
			$qry = "DELETE FROM forward_approving_auth WHERE username = '$myself'";
			mysqli_query($this->conn, $qry);
		}
		if($type == 'General User') $type = 1;
		else if($type == 'Recommending Authority') $type = 2;
		else if($type == 'Approving Authority') $type = 3;
		else if($type == 'LPS Administrator') $type = 4;
		$fdsa =  $this->getusertype($myself)*4;
		$qry = "UPDATE accounts SET type = $type WHERE username = '$myself'";
		mysqli_query($this->conn, $qry);
		if($type == 3){
			$qry = "INSERT into forward_approving_auth values('$myself', '$myself')";
			mysqli_query($this->conn, $qry);
		}
	}

	public function change_name($name, $myself){
		$qry = "UPDATE accounts SET name = '$name' WHERE username = '$myself'";
		mysqli_query($this->conn, $qry);
	}

	public function change_notify($email_notify, $myself){
		if($email_notify=="Enable"){
			$qry = "UPDATE accounts SET notifications = 1 WHERE username = '$myself'";
		}
		else{
			$qry = "UPDATE accounts SET notifications = 0 WHERE username = '$myself'";
		}
		mysqli_query($this->conn, $qry);
	}

	public function change_leaves($body, $username){
		$el = $body['el'];
		$cl = $body['cl'];
		$hpl = $body['hpl'];
		$vac = $body['vacation'];
		$qry = "UPDATE leave_balance SET EL = $el, CL = $cl, HPL = $hpl, Vacation = $hpl WHERE username = '$username'";
		mysqli_query($this->conn, $qry);
	}

	public function get_fin_approver($appr){
		$iter = 0;
		while(1){
			$iter += 1;
			$qry = "SELECT * from forward_approving_auth WHERE username = '$appr'";
			$res = mysqli_query($this->conn, $qry);
			$rec = mysqli_fetch_assoc($res);
			if($rec['username'] == $rec['forwarded_to']) return $appr;
			$appr = $rec['forwarded_to'];
			
			if($iter > 1000000) return $appr; // to save the system from a possible infinite loop 
			
		}
	}

	public function getapprover($user){
		$qry = "SELECT * from accounts where username = '$user'";
		$result = mysqli_query($this->conn, $qry);
		$rec = mysqli_fetch_assoc($result);
		return $rec['approving_authority'];
	}

	public function fetch_all_approvers(){
		$qry = "SELECT accounts.username as username, accounts.name as name from accounts INNER JOIN forward_approving_auth ON accounts.username = forward_approving_auth.username";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function set_to_forward($myself, $to){
		$qry = "UPDATE forward_approving_auth SET forwarded_to = '$to' WHERE username = '$myself'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}


	public function deduct_EL($user){
		$qry="UPDATE leave_balance set EL=EL-10 where username='$user'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function get_all_joining_reports(){
		$qry="SELECT * FROM Joining_Reports";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function get_pending_joining($user){
		$qry="SELECT * FROM application WHERE username = '$user' and joining_report = 0 and nature != 'CL' and status = 'Approved'";
		$result = mysqli_query($this->conn, $qry);
		return $result;
	}

	public function validate_for_joining_report($app_id, $user){
		$qry="SELECT * FROM application WHERE username = '$user' and application_id = '$app_id' and nature != 'CL' and status = 'Approved' and joining_report = 0";
		$result = mysqli_query($this->conn, $qry);
		$ok = 1;
		//if(mysqli_num_rows($result) == 0) $ok = 0;
		$rec = mysqli_fetch_assoc($result);
		$to_date = new DateTime();
		$from_date = new DateTime($rec['period_from']);

		//$number_of_days = $to_date->diff($from_date)->format("%a")+1;;
		//if($to_date < $from_date) $ok = 0;
		return $ok;	
	}
}

?>
