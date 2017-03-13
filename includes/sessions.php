<?php	
    ob_start();
	session_start();
	//echo $_SESSION['loggedu'];
	
	$logme="";
	if(isset($_SESSION['loggedu'])){
		$logme=$_SESSION['loggedu'];
	}
	
	if(!$logme){
		header("Location: login.php");
		exit;
	}
	
	/*
	else{
	
	$now=time();
	//echo $now;
	//echo "<br>".$_SESSION['expire'];
	//exit;
	if($now > $_SESSION['expire'])
	{
	//  echo 'var agree=confirm("Your online session is about to be timed out. Click OK to continue your current session.");
	//if (!agree)';
	//session_destroy();
	//echo "Your session has expire !  <a href='logout.php'>Click Here to Login</a>";
	header("Location: logout.php");
	exit;
	//echo "}";
	}else{
	$_SESSION['expire'] = $now + (1* 800) ; 
	}
	}*/

?>
	