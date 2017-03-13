<?php
//-------------------------------------------------------------------------------------------------
//    @name:      UserLoginServices
//    @purpose:   Responsible for checking password and username create sessions
//    @category:  PHP Class
//    @author:    Greg E. Salivio 10/10/2014 started
//    @version:   1.0
//    @copyright: cdxlife.com
//
//-------------------------------------------------------------------------------------------------


//Module info Macros
define("UP_MODULE_NAME",            "Create an XML chemicals profiles");
define("UP_MODULE_NUMBER",          "1.0");

class UserResetPassServices
{
    protected $_email;    // using protected so they can be accessed
	protected $_user;    // using protected so they can be accessed
   
    protected $_tb;       // stores the database handler
   
    public function __construct($connect, $email, $table) 
    {
       $this->_tb = $table;
       $this->_email= mysql_real_escape_string($email);
	   $this->_user= mysql_real_escape_string($email);
    }

    public function getEmail()
    {
        $user = $this->_checkCredentials();
        if ($user) {
            $this->_user = $user; // store it so it can be accessed later
            					
			return $user;
        }
        return false;
    }

    protected function _checkCredentials()
    {
        $sql_stmt = "SELECT * FROM $this->_tb WHERE Email='$this->_email' LIMIT 1";
		$result = @mysql_query ($sql_stmt);
        if(mysql_num_rows($result) == 1){
        	$user = mysql_fetch_assoc($result);
            return $user;
        }
        return false;
    }

    public function getUser()
    {
        return $this->_user;
    }
}

				
?>