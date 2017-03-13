<?php
//-------------------------------------------------------------------------------------------------
//    @name:      UserLoginServices
//    @purpose:   Responsible for checking password and username create sessions
//    @category:  PHP Class
//    @author:    Greg E. Salivio 10/10/2014 started
//    @version:   1.2
//    @copyright: cdxlife.com
//
//    Note: addedd fb login 26 DEC 2014
//-------------------------------------------------------------------------------------------------


//Module info Macros
define("UL_MODULE_NAME",            "Create an XML chemicals profiles");
define("UL_MODULE_NUMBER",          "1.2");

class UserLoginServices
{
    protected $_email;    // using protected so they can be accessed
	protected $_password; // and overidden if necessary
	protected $_username; // and overidden if necessary
    protected $_tb;       // stores the database handler
   
    public function __construct($connect, $usrname, $password, $table,$email) 
    {
       $this->_tb = $table;
	   $this->_username = mysql_real_escape_string($usrname);
       $this->_email= mysql_real_escape_string($email);
	   $this->_password = mysql_real_escape_string($password);
    }

    public function login()
    {
        $user = $this->_checkCredentials();
        if ($user) {
           					
			return $user;
        }
        return false;
    }

    public function fblogin()
    {
        $user = $this->_checkFBCredentials();
        if ($user) {
            
			return $user;
        }
        return false;
    }
	
	public function getFBUserID()
    {
        $user = $this->_getFBCredentials();
        if ($user) {
            
			return $user;
        }
        return false;
    }
	
	public function updateFBUserID($id,$fid)
    {
        $user = $this->_updateFBCredentials($id,$fid);
        if ($user) {
            
			return $user;
        }
        return false;
    }
	
	protected function _checkCredentials()
    {
//        If($this->_email<>""){
//			$sql_stmt = "SELECT * FROM $this->_tb WHERE Email='$this->_email' AND Password='$this->_password' LIMIT 1";
//		}else{
//			$sql_stmt = "SELECT * FROM $this->_tb WHERE UserName='$this->_username' AND Password='$this->_password' LIMIT 1";
//		}
            $sql_stmt = "SELECT * FROM $this->_tb WHERE UserName='$this->_username' AND Password='$this->_password' LIMIT 1";
		$result = @mysql_query ($sql_stmt);
        if(mysql_num_rows($result) == 1){
        	$user = mysql_fetch_assoc($result);
            return $user;
        }
        return false;
    }
    
	protected function _checkFBCredentials()
    {
        If($this->_email<>""){
			$sql_stmt = "SELECT * FROM $this->_tb WHERE Email='$this->_email' AND `FBuid`=$this->_password LIMIT 1";
		}
		$result = @mysql_query ($sql_stmt);
        if(mysql_num_rows($result) == 1){
        	$user = mysql_fetch_assoc($result);
            return $user;
        }
        return false;
    }
	
	protected function _getFBCredentials()
    {
		$sql_stmt = "SELECT * FROM $this->_tb WHERE Email='$this->_email' LIMIT 1";
		$result = @mysql_query ($sql_stmt);
        if(mysql_num_rows($result) > 0){
        	$user = mysql_fetch_assoc($result);
            return $user;
        }
        return false;
    }
	
	protected function _updateFBCredentials($uid,$fbuid)
    {
		
		$sql_stmt = "UPDATE $this->_tb SET `FBuid`=$fbuid WHERE `ID`=$uid";
		$result = @mysql_query ($sql_stmt);
        if($result){
        	
            return true;
        }
        return false;
    }
	
    public function getUser()
    {
        return $this->_user;
    }
}

				
?>