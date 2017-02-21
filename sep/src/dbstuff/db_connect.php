<?php
 
/**
 * Handling database connection
 *
 */
class DbConnect {
 
    private $conn;
 
    function __construct() {        
    }
 
    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include dirname(__FILE__) . '/config.php';
 
        // Connecting to mysql database
        $this->conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        // Check for database connection error
        if (mysqli_connect_error()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{
            ;
        }
 
        // returing connection resource
        return $this->conn;
    }
}
?>