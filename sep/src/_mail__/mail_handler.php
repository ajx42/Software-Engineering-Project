<?php
session_start();

require_once "../vendor/autoload.php";

class EmailFormat{
	public $subject, $body, $altbody;
	function __construct(){
		$subject = "Automatically Generated Subject";
		$body = "No Content";
		$altbody = "No Content";
	}
}

class MailHandler{
	private $mail;
	function __construct(){
		require_once dirname(__FILE__).'/mail_connect.php';
		$sendmail = new MailConnect();
		$this->mail = $sendmail->connect();
	}
	private function Send($content, $to_name, $to_add){
		$this->mail->ClearAllRecipients( );
		$this->mail->addAddress($to_add, $to_name);
		$this->mail->isHTML(true);
		$this->mail->Subject = $content->subject;
		$this->mail->Body = $content->body;
		$this->mail->AltBody = $content->altbody;
		if(!$this->mail->send()) {
    		return 0;
		} 
		else {
    		return 1;
		}
	}
	public function notify_rec($to_name, $to_add){
		$email = new EmailFormat();
		$email->subject = "new recommendation request";
		$email->body = "<b>Hi $to_name </b> <br> You have a new recommendation request. Please log into IITI LPS to take action. <br> <i>Thanks</i>";
		return $this->Send($email, $to_name, $to_add);
	}
	public function notify_apr($to_name, $to_add){
		$email = new EmailFormat();
		$email->subject = "new approval request";
		$email->body = "<b>Hi $to_name </b> <br> You have a new approval request. Please log into IITI LPS to take action. <br> <i>Thanks</i>";
		return $this->Send($email, $to_name, $to_add);
	}

}

?>
