<?php
//-------------------------------------------------------------------------------------------------
//    @name:      GetSettingsAilments
//    @purpose:   Responsible for sending Settings Ailment data
//    @category:  PHP Class
//    @author:    Greg E. Salivio 10/15/2014 started
//    @version:   1.0
//    @copyright: cdxlife.com
//
//-------------------------------------------------------------------------------------------------


//Module info Macros
define("GS_MODULE_NAME",            "Return Settings Ailments Data");
define("GS_MODULE_NUMBER",          "1.0");

class GetSettingsAilments
{
    protected $_userid;    // using protected so they can be accessed
	protected $_role; // and overidden if necessary

    protected $_tb;       // stores the database handler
   
    public function __construct($connect, $userid, $role) 
    {
       //$this->_tb = $table;
       $this->_userid= mysql_real_escape_string($userid);
	   $this->_role = mysql_real_escape_string($role);
    }

    public function getAllAilmentsPerUserid()
    {
        $sql_stmt = "SELECT * FROM  SettingsAilments WHERE  `UserID` = $this->_userid";
		$result = @mysql_query ($sql_stmt);
		$num_rows = mysql_num_rows($result);
        if($num_rows > 1){
        	$ailments = mysql_fetch_array($result);
            return $ailments;
        }
        return false;
    }

    public function getDefaultAilments()
    {
        $sql_stmt = "SELECT * FROM  SettingsAilments WHERE  `UserID` = -1 AND  `isOn` =1";
		$result = @mysql_query ($sql_stmt);
        if(mysql_num_rows($result) > 1){
        	$default_ailments  = mysql_fetch_array($result);
            return $default_ailments;
        }
        return false;
    }

    public function getAllAilments()
    {
        $sql_stmt = "SELECT * FROM  SettingsAilments WHERE 1";
		$result = @mysql_query ($sql_stmt);
		//$row = mysql_fetch_array($result);
        if(mysql_num_rows($result) > 1){
        	$all_ailments = mysql_fetch_array($result);
            return $all_ailments;
        }
        return false;
    }
}

				
?>