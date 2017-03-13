<?php
// 03302015 as per request by JP email,username are required
// one email can have multiple accounts

$saveit="";
$msgalert="";
$fid="";
$fname="";
$lname="";
$ename="";
$upass="";
$ugroup="";
$news="";
$klogin="";
$tos="";
$uname="";
$numusr=0;
$numeml=0;

date_default_timezone_set('UTC');

if(isset($_GET['act'])){
$saveit=$_GET['act'];}
    
if(isset($_REQUEST['act'])=="Fbreg"){
	if(isset($_REQUEST['fn'])){
	$fname=$_REQUEST['fn'];}
	if(isset($_REQUEST['ln'])){
	$lname=$_REQUEST['ln'];}
	if(isset($_REQUEST['fid'])){
	$fid=$_REQUEST['fid'];}
	if(isset($_REQUEST['eml'])){
	$ename=$_REQUEST['eml'];}
	
	$upass=$fid;
	$uname=$fname.date("Y");
}

if($saveit=='Save'){
	
	$fname=$_POST['first_name'];
	$lname=$_POST['last_name'];
	$uname=$_POST['user_name'];
	$ename=$_POST['user_email'];
	$upass=$_POST['user_pass'];
	echo $uname."<br>";
	if(isset($_REQUEST['user_grp'])){
	$ugroup=$_POST['user_grp'];}
    $fid=$_POST['fid'];
	if(isset($_REQUEST['newsletter'])){
    $news=$_POST['newsletter'];}
	if(isset($_REQUEST['keepmelogin'])){
	$klogin=$_POST['keepmelogin']; }
	if(isset($_REQUEST['tos'])){
	$tos=$_POST['tos'];}
	
	if($ugroup>5 || $ugroup==""){
		$ugroup=0;
	}
    
    if ($news=='on') {
		$news=1;
	}
   
	
	// Create a function for escaping the data.
	function escape_data ($data) {
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return $data;
	} // End of function.
	
	$msgalert = NULL; // Create an empty new variable.
	
	// Check for a username.
	if (empty($uname)) {
		$u = FALSE;
		$msgalert .= 'Please enter your username!<br>  ';
	} else {
		$u = escape_data($uname);
	}
	
	
	// Check for a email.
	if (empty($ename)) {
		$e = FALSE;
		$msgalert .= 'Please enter your email!<br>  ';
	} else {
		$e = escape_data($ename);
	}
	
		
	// Check for a password and match against the confirmed password.
	if (empty($upass)) {
		$p = FALSE;
		$msgalert .= 'Please enter your password!<br>';
	} else {
		$p = escape_data($upass);
	}
	
	// Check for a username.
	if ($tos<>'on') {
		$tos = FALSE;
		$msgalert .= 'Must accept TOS and be 18 or older.  ';
	} 
	if($tos and $p and $u and $e){
               
	require_once($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	//include("configdb.php");
	
			if (!$con)
			{
				$msgalert= "No Connection";
			}
			else
			{
				//check if the username address is not in the DB
				$sqlusr="SELECT COUNT(*) as unum FROM `Users` WHERE `UserName`='$u'";
				
				$result = mysql_query($sqlusr);
				if($result != false){
					$num_rows = mysql_fetch_assoc($result);
					$numusr=$num_rows['unum'];
				}
				
				//check if the user in the DB
				$sqlemail="SELECT COUNT(*) as enum FROM `Users` WHERE `Email`='$e' and `Password`='$p' and `UserName`='$uname'";
				
				$result = mysql_query($sqlemail);
				if($result != false){
				$num_rowse = mysql_fetch_assoc($result);
				$numeml=$num_rowse['enum'];}
			
				if(($numusr==0) && ($numeml==0)){
					
					$tdate=date("Y-m-d");				
					if($fid!=""){		
					$sql="INSERT INTO `Users`(`Email`, `Password`, `FirstName`,`created_at`, `LastName`, `UserName`, `FBuid`, `WantsNewsLetters`, `UserGroup`,Role)
					VALUES ('$ename','$upass','$fname','$tdate','$lname','$uname',$fid,'$news',$ugroup,1)";}else{
					$sql="INSERT INTO `Users`(`Email`, `Password`, `FirstName`,`created_at`, `LastName`, `UserName`, `WantsNewsLetters`, `UserGroup`,Role)
					VALUES ('$ename','$upass','$fname','$tdate','$lname','$uname','$news',$ugroup,1)";
					}
					$retval = mysql_query( $sql);
					
					if (!$retval) {
						die('Could not enter data: ' . mysql_error());
					}else{
					
					ob_start();
					session_start();
					
					$sql_stmnt="SELECT * FROM `Users` WHERE `Email`='$ename' and `Password`='$upass'";
					$result = @mysql_query ($sql_stmnt);
					if(mysql_num_rows($result) == 1) {
						$row1 = mysql_fetch_array($result);
						$_SESSION['user_id'] = $row1['ID'];
						$_SESSION['user_rl'] = $row1['Role'];
						$_SESSION['user_ug'] = $row1['UserGroup'];
					}
					
						$_SESSION['loggedu'] = TRUE;
						$_SESSION['start'] = time(); // taking now logged in time
						//if(!isset($_SESSION['expire'])){
						//	$_SESSION['expire'] = $_SESSION['start'] + (1* 600) ; // ending a session in 30 seconds
						//}
						//$msgalert="1 record added";
						header("Location: settings.php");
						exit;
					}
			
					
				}
				else
				{
					if($numusr!=0){
						$msgalert="Username is already in used please try again.";}
					else{
						$msgalert="User is already registered please try again.";
					}
			}
						
		mysql_close();
		}
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

    <title>CDX register page</title>

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
        <div class="reg-back">
      <h4><a href="#" onclick="window.history.back();return false;" ><span class="reg-arrow"></span>BACK </a></h4>
      </div>
        <h2 class="form-register-heading">Register </h2>
       </div>
      

       <form class="form-register" action="?act=Save" method="post" name="registerme">
      <input type="hidden" name="fid" value="<?=$fid?>">
<div class="form-group">
        <input type="fname" name="first_name" class="form-control" placeholder="first name" value="<?=$fname?>" required autofocus>
</div>
<div class="form-group">
<input type="lname" name="last_name" class="form-control" placeholder="last name" value="<?=$lname?>" required>
</div>
<div class="form-group">
<input type="username" name="user_name" class="form-control" placeholder="user name (required)" value="<?=$uname?>" required>
</div>
<div class="form-group">
<input type="email" name="user_email" class="form-control" placeholder="email address" value="<?=$ename?>" required>
</div>
      <div class="form-group">
        <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="password (required)" required>
      </div>
      <div class="form-group regport">
        <input type="password" id="passwordconf" name="passwordconf" oninput="checkconfirm(this)" class="form-control" placeholder="confirm password (required)" required>
      </div>
      <script language='javascript' type='text/javascript'>
      function checkconfirm(input) {
    if (input.value != document.getElementById('user_pass').value) {
        input.setCustomValidity('The two passwords must match.');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
   }
}
</script>
         <div class="register-col">
         <div class="form-group">
         <input type="checkbox" name="keepmelogin" id="forgotpass" class="css-checkbox "/> <label for="forgotpass" class="css-label registerl">Keep me logged in
        </label>
         <input type="checkbox" name="newsletter" id="newsletter" class="css-checkbox" /> <label for="newsletter" class="css-label registerl">Sign Me Up For MyDX News
        </label>
           <input type="checkbox" name="tos" id="tos" class="css-checkbox"/> <label for="tos" class="css-label registerl">I'm 18 years or older and agree to the <strong><a class="register" data-toggle="modal" href="https://cdxlife.com/terms-of-use" data-target="#helpModal">Terms of Service</a></strong> and <strong><a class="register" data-toggle="modal" href="https://cdxlife.com/privacy-policy" data-target="#helpModal">Privacy Policy</a></strong>
        </label>
      </div>
      <div class="form-group usergrp" >
       <input type="confirmpass" class="form-control" placeholder="user group id" >
      </div>
    
      </div>
</form>
        <!-- modal message -->

<!-- Modal -->

<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-dialog">

<div class="modal-content1">

<div class="modal-body">

<div class="help-modal">

</div>

</div>

<div class="modal-footer">

<button class="btn-modal" data-dismiss="modal">Close</button>

</div>

</div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<!-- end modal message -->
<!-- error modal -->
   <div class="modal ercustom" id="errorModal">
  <div class="modal-dialog">
    <div class="modal-canna">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
           <h4 class="modal-title text-center errorm" >Registration</h4>
           <div class="text-center errorp">
              <p><?php echo $msgalert; ?></p>
            </div>
        </div>
       
      
      </div>
    </div>
</div>
<!-- error modal -->


    <div class="footer-reg">
        <div class="wrapperfoot">
      <div class="footlink-reg"><a onClick="javascript:document.registerme.submit();" href="#" style="border: 0;">register ></a></div></div>
    </div> 
    </div> 

     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="js/bootstrap.min.js"></script>
   <script src="js/customjs.js"></script>
  
     <script src="js/hide.js"></script>
     <?php  if($msgalert<>""){?>
<script>
$('#errorModal').modal();
// alert('<?=$msgalert?>');
  
</script>
<?php	
}?>
  </body>
</html>
