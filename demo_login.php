<?php
error_reporting(0);
session_start();

if ($_REQUEST['act']=="Login" || $_REQUEST['act']=="FBlogin"){


        $username=$_POST['username'];
        $pass=$_POST['password'];
    $qstrurl=$_POST['qstring'];
    //echo '<br>Username '.$username;
        //echo '<br>Pass: '.$pass;


        // Create a function for escaping the data.
        function escape_data ($data) {
                if (ini_get('magic_quotes_gpc')) {
                        $data = stripslashes($data);
                }
                return $data;
        } // End of function.

        $msgalert = NULL; // Create an empty new variable.

        // Check for a username.
        if (empty($username)) {
                $u = FALSE;
                $msgalert .= 'You forgot to enter your username!\n  ';
        } else {
                $u = escape_data($username);
        }


        // Check for a password and match against the confirmed password.
        if (empty($pass)) {
                $p = FALSE;
                $msgalert .= 'You forgot to enter your password!\n';
        } else {
                $p = escape_data($pass);
        }

        if($u and $p){

                if (!filter_var($u, FILTER_VALIDATE_EMAIL)) {
                $validemail = FALSE;
                        $usr=$u;
                        $email="";
        }else{
                        $email=$u;
                        $usr="";
                }
        //echo "User: ".$u;
        //echo '<br>Email: '.$email;
                include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
                        if (!$con)
                        {
                                $msgalert= "No Connection";
                        }else{

                                include("classes/UserLoginClass.php");
                if($_REQUEST['act']=="Login"){
                    $usr1= new UserLoginServices($con,$usr,$p,'Users',$email);
                    $userdat = $usr1->login();}else{
                        $usrfb= new UserLoginServices($con,$usr,$p,'Users',$email);
                        $userdat = $usrfb->fblogin();
                        $usrfbID = $usrfb->getFBUserID();

                        if(!$usrfbID && !$userdat){
                            echo'<script> window.location="register.php?act=Fbreg'.$qstrurl.'";</script>';
                        }else{
                            if($usrfbID){
                                If($usrfb->updateFBUserID($usrfbID['ID'],$p)){
                                    $userdat=$usrfb->getFBUserID();}
                                //$userdat = $usrfb->fblogin();
                            }
                        }
                        $fblogin=TRUE;
                    }
                                if($userdat){
                                        $_SESSION['user_id'] = $userdat['ID'];
                                        $_SESSION['user_rl'] = $userdat['Role'];
                                        $_SESSION['user_ug'] = $userdat['UserGroup'];
                                        $_SESSION['user_nm'] = $userdat['UserName'];
                                        $_SESSION['loggedu'] = TRUE;

                                        //$_SESSION['start'] = time(); // taking now logged in time

                                        //if(!isset($_SESSION['expire'])){
                                                //$_SESSION['expire'] = $_SESSION['start'] + (1* 800) ; // ending a session in 15 minutes
                                                //$_SESSION['expire'] = $_SESSION['start'] + (1* 40) ; // ending a session in 1 minute
                                        //}
                                        //header("Location: index.php"); // Modify to go to the page you would like
                                        echo'<script> window.location="demo_index.php";</script>';
                                        //echo $_SESSION['loggedu'];
                                        exit;
                                        //echo "i'm in";
                                }
                                else
                                {
                                        $msgalert="You entered the wrong username or password.";
                                }

                        }

                }
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
        <meta name="apple-itunes-app" content="app-id=911116863">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!--  <meta name="viewport" content="width=320, maximum-scale=2"> -->
 <meta name="viewport" content="width=320, maximum-scale=2">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>CDX login page</title>

    <!-- Bootstrap core CSS -->
     <link href="css/demo_bootstrap.css" rel="stylesheet">
      <link href="css/demo_styles-iframe.css" rel="stylesheet">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">

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
      <form class="form-signin" action="?act=Login" method="post" id="fblogin">
        <div class="center-block reg-box">

        <h2 class="form-signin-heading">Login to</h2>
       </div>
        <div class="form-group">
        <input id="user-icon" type="username" name="username" class="form-control" placeholder="User Name" required autofocus>
      </div>
      <div class="form-group">
        <input id="pass-icon" type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group form-inline" >
         <input type="checkbox" name="forgotpass" id="forgotpass" class="css-checkbox"/> <label for="forgotpass" class="css-label-log srcheck">Keep me logged in
        </label>

         <label class="pass">
          <a class="password" href="resetpassword.php" title="Reset Password">Forgot password?</a>
        </label>

       </div>
        <button name="submit_button" class="btn btn-lg btn-login btn-block" type="submit">LOGIN</button>
      <!--   <div class="">
        <img width="292px" src="/webapp-demo/img/fb-login.png" class="fbarea" onClick="Login()">
        </div> -->
<input type="hidden" id="qstring" name="qstring" value="">
</form>

       <div class="mollie-box-fb">
        <div class="login-text">Hi, my name is Molecule, but you can call me Mollie.  I'm here to help you navigate and use MyDx, making the experience more user friendly.  New here, just click below</div>
     <!--   <img class="bot-log" src="img/mollie-trans_bg.png" /> -->
     </div>
    <div class="footer-log">
        <div class="wrapperfoot">
      <div class="footlink"><a href="register.php" style="border: 0;">+ new user:register </a></div></div>
    </div>
    </div>
    </div> <!-- /container -->



     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="js/bootstrap.min.js"></script>
    <!--<script src="js/customjs.js">-->
<!-- <script src="js/fbsdk.js"></script> -->
<script src="assets/owl-carousel/owl.carousel.js"></script>
     <script src="js/hide.js"></script>
<script>
 (function(d){
  var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement('script'); js.id = id; js.async = true;
  js.src = "//connect.facebook.net/en_US/all.js";
  ref.parentNode.insertBefore(js, ref);
  }(document));

 </script>


         <?php  if($msgalert<>""){?>
<script>
         alert('<?=$msgalert?>');

</script>
<?php
}?>
  </body>
</html>
