<?php

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

		$username = $res['username'];
		$name = $res['name'];
		$nature = $res['nature'];
		$designation = $res['designation'];
		$department = $res['department'];
		$period_from = $res['period_from'];
		$period_to = $res['period_to'];
		/////
		$prefix_holidays = $res['prefix_holidays'];
		$sufix_holidays = $res['sufix_holidays'];
		$LTC = $res['LTC'];
		/////
		$address = $res['address'];
		$contact = $res['contact'];
		$status = 'Awaiting Recommendation';
		$recommending_auth = $res['recommending_auth'];
		///// Approving Authority name to be decided automatically
		$approving_auth = 'newhere';
		///// 
		$cur_date = $res['cur_date'];
		///// if prefix and suffix are not set i.e. application was posted as a CL
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

}

?>