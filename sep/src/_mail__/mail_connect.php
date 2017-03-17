<?php
 
/**
 * Handling PHPMailer SMTP connection
 *
 */
class MailConnect {
 
    private $mail;
 
    function __construct() {      
        include dirname(__FILE__) . '/config.php';
        require_once "../vendor/autoload.php";

        $this->mail = new PHPMailer;
        $this->mail->IsSMTP();
        $this->mail->Host = SMTP_HOST;

        // optional
        // used only when SMTP requires authentication  
        $this->mail->SetFrom('office@domain.pl',SMTP_FROMNAME);
        $this->mail->SMTPAuth = true;
        $this->mail->Username = SMTP_USERNAME;
        $this->mail->Password = SMTP_PASSWORD;
         
    }
 
    /**
     * Establishing SMTP connection
     * @return ] = > connection handler
     */
    function connect() {
        return $this->mail;
    }
}


?>
