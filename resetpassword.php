<?php
require '../mailer/PHPMailerAutoload.php';
$msgalert="";
function EmailResponse($emailadd,$from,$username,$pass, $name){

		// multiple recipients
		$to = $emailadd;  
		if($username<>""){
			// subject
			$subject = 'Forgotten login notification';
			
			// message
			$message1 = "
			<html>
			<head>
			  <title>User Name Notification</title>
			</head>
			<body>
			<p>Dear ".$name."</p>
			  <p>At your request, Cdxlife has sent you login information.</p>
			  <p>Your username(s): ".$username."</p>
			  <p>
			 If it was not at your request, then you can safely ignore this message as it is a list of your usernames sent to you.
			  </p>
			 
			</body>
			</html>
			";
			
			$message = "
			Forgotten login notification\r\n
			Dear ".$name." \r\n
			At your request, Cdxlife has sent you login information.\r\n
			Your username(s): ".$username." \r\n
			 If it was not at your request, then you can safely ignore this message as it is a list of your usernames sent to you..\r\n
			";
		}else{
			// subject
			$subject = 'Forgotten password notification';
		
			// message
			$message1 = "
			<html>
			<head>
			  <title>Password Notification</title>
			</head>
			<body>
			<p>Dear ".$name."</p>
			   <p>By request, Cdxlife has sent you your password information.</p>
			  <p> If it was not at your request, then you can safely ignore this warning or update your password as it is smart to do so from to time anyhow. </p>
			  <p>
			 Your password:  ".$pass.".
			  </p>
			 
			</body>
			</html>
			";
			
			$message = "
			Forgotten password notification\r\n
			Dear ".$name." \r\n
			At your request, Cdxlife has sent you your password information.\r\n
			Your password: ".$pass." \r\n
			 If it was not at your request, then you can safely ignore this message as it is a list of your usernames sent to you..\r\n
			";
		}
		
		$headers = "Organization: Cdxlife.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
			
		$emaildomain=split("@",$emailadd);
		if($emaildomain[1]=="yahoo.com" || $emaildomain[1]=="aol.com"){
			$themessage=$message;
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
		}else{
			$themessage=$message1;
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			}
		
		$headers .= "X-Priority: 3\r\n";
		$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
			
		// Additional headers
		
		$headers .= 'From: Cdxlife.com <'.$from.'>' . "\r\n";
		
		//$headers .= 'Bcc: info@cdxlife.com' . "\r\n";
		
		// Mail it
		//mail($to, $subject, $themessage, $headers);
                $mail = new PHPMailer();
				// Set PHPMailer to use the sendmail transport
				$mail->isSMTP();
				$mail->Host = "localhost";
				$mail->Port = 25;
				$mail->SMTPAuth = false;
				$mail->SMTPDebug = 0;  // Set this to 2 for max debugging.
				//Set who the message is to be sent from
				$mail->setFrom('DoNotReply@cdxlife.com', 'CDXLife');
				//Set an alternative reply-to address
				//Set who the message is to be sent to
				// $mail->addAddress('robvigillv@gmail.com');
				$mail->addAddress($to);
				
				
				//Set the subject line
				$mail->Subject = $subject;
				//Read an HTML message body from an external file, convert referenced images to embedded,

				$mail->msgHTML($themessage);	
   				$mail->send();
		}

if (isset($_POST['submit'])){
	ob_start();
	session_start();
	$u=$_REQUEST['email_add'];
		//echo $_REQUEST['RadioGroup1'];
    	require_once($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');

		if (!$con)
		{
				$msgalert= "No Connection";
		}
		else
		{
				//check if the email address is not in the DB
				
				include("classes/UserResetPasswordClass.php");
				$usr1= new UserResetPassServices($con,$u,'Users');
				$userdat = $usr1->getEmail();
				if($userdat){
					$_SESSION['user_mail'] = $userdat['Email'];
					$_SESSION['user_id'] = $userdat['ID'];
					$name=$userdat['FirstName'].' '.$userdat['LastName'];
					if($_REQUEST['RadioGroup1']=='username'){
						EmailResponse($userdat['Email'],'support@cdxlife.com',$userdat['UserName'],'',$name);
					// call email here 
					}else{
						EmailResponse($userdat['Email'],'support@cdxlife.com','',$userdat['Password'],$name);
					}
					$msgalert="Your request was sent to your email. please check your email for instruction";
				}
				else
				{
					$msgalert="Emaill address not found in our system, please try again.";
			}
			mysql_close($con);
		}
}
		
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="testViewport" name="viewport" content="width=320, maximum-scale=1.5, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>CDX login page</title>

    <!-- Bootstrap core CSS -->
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
         <?php
   include("includes/scaling.php");
   ?>

    <!-- Custom styles for this template -->
 <!--    <link href="justified-nav.css" rel="stylesheet"> -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <div class="container index-log"> 
  <div class="center-block reg-box">
<br><br>

        <h2 class="form-signin-heading" style="margin-top:30px">Password reset</h2>
       </div>
       <div class="resetpass">
     <form class="form-signin" action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div class="content" >
    <h3>Having trouble loging in?</h3><br>
    <p>
      <label>
        <input type="radio" name="RadioGroup1" value="password" id="RadioGroup1_0" >
        I don't know my password</label>
              <br>
      <label>
        <input type="radio" name="RadioGroup1" value="username" id="RadioGroup1_1">
        I don't know my username</label>
      <br>
     
     
    </p>
    <div id="mypass"  style="display:none; width:100%" >
        	To reset your password or your user name, enter the email address you use to log in, or another email address associated with your account.<br>
            <label>Email Address:</label><br>
           
            <input type="email" name="email_add" placeholder="email address" required/>
            <br><br>
                   <button type="submit" name="submit" value="submit" class="btn btn-lg btn-login btn-block" >Submit</button>
        </div>
        <?=$msgalert?>
    <br><br>
    </div>
    </form>
   </div>
    <div class="footer-reg">
     <div class="wrapperfoot">
      <div class="footlink"><a href="#" onclick="window.history.back();return false;"  style="border: 0;">Back To Login</a></div></div>
    </div> 

    
    </div> <!-- /container --> 
    
     </div>
 </div>
     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<!--<script src="js/customjs.js"></script>-->
<script src="js/owl-slide.js"></script>
<script src="assets/owl-carousel/owl.carousel.js"></script>  
<script src="js/hide.js"></script>
<script>
$(document).ready(function()
  {
  $("#RadioGroup1_0").click(function(){
    $("#mypass").show();
  });
  $("#RadioGroup1_1").click(function(){
    $("#mypass").show();
  });
});
</script>
  </body>
</html>
