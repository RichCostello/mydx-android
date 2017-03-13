<?php error_reporting(0);session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=320, maximum-scale=2">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title>CDX intro page</title>

<!-- Bootstrap core CSS -->

<link href="css/demo_bootstrap.css" rel="stylesheet">
<link href="css/demo_styles-iframe.css" rel="stylesheet">
<link href="css/master_2.css" rel="stylesheet">

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

<body class="gradient">
<input type="hidden" id="hdnUserID" name="hdnUserID" value="<?php echo $_SESSION['user_id']; ?>" />
<div class="container index-cont ">
  <div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="navbar-header">
      <div id="menu-toggle"> <img src="img/navbut.jpg" alt="Menu"></img> </div>
      <?php  include("includes/side_menu.php"); ?>
      <a class="navbar-brand" href="javascript:void(0);"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a> </div>
  </div>
  <!-- end nav section --> 
  <br>
  <br>
<!-- ########## page 1 ########## -->   
    <div id="page1" class="first">
    <div class="col-md-3">
      <div class="circle">1.</div>
      <div class="clearfix"></div>
    </div>
    <div class="dis">
      <h2 class="dis">Turn On MYDx  device
        with small button on 
        back.<br>
        Green power light will illuminate.</h2>
    </div>
    <div class="col-md-9 pull-right p_right_0">
      <div class="sync_box">
        <p id="showMessageFirst">I m looking for<br id="showHidebr">
          it now.</p>
        <p id="showMessageSecond">&nbsp;</p>
      </div>
      <span  class="orngBtn" id="showMessageSucess" style="display:none;"><a href="#" class="pull-right">SUCCESS!</a>
      <div class="clearfix"></div>
      </span> </div>
    <div class="clearBoth"></div>
    <div class=" subslider1"> <a data-toggle="modal" href="help_index.php" data-target="#helpModal"><img class="org-help" src="assets/images/org-help.png" align="center" alt=""></a> </div>
    
    
    
  </div>
  <!-- ########## page 2 ########## -->  
  
  <div id="page2" class="second" style="display:none">
  <div class="col-md-3">
    <div class="circle">2.</div>
    <div class="clearfix"></div>
  </div>
  <div class="dis">
         <h2 class="dis"><b>Open</b> the testing chamber by sliding button on the device. <br>
            Place sample in the <b>chamber</b>. </h2>
  </div>
  <div class="col-md-9 pull-right p_right_0"> <img src="img/2.png" class="openimg">
    <div class="sync_box">
    <p>All done?<br>
      Close the chamber.</p>
    </div>
    <span id="showMessageNext" class="orngBtn ">NEXT! <img src="img/aro.png">
    
    
    <div class="clearBoth"></div>
    </span> </div>
  <div class="clearBoth"></div>
  <div class=" subslider1"> <a data-toggle="modal" href="help_index.php" data-target="#helpModal"><img class="org-help" src="assets/images/org-help.png" align="center" alt=""></a> </div>

  
  </div>  
  <div class="clearBoth"></div>
 <!-- ########## page 3 ########## --> 
  
<div id="page3" class="third" style="display:none;">
<!--<div id="page3" class="third">-->
  <div class="col-md-3">
    <div class="circle">3.</div>
    <div class="clearfix"></div>
  </div>
  <div class="dis">
 <h2 class="dis">Place MyDx on a flat surface and click start when ready </h2>
  </div>
  <div class="col-md-12  p_right_0"> 
   <a id="disableQuickPopUp" disableclick="no" onClick="StartTesting('full')"  href="javascript:void(0);" style="text-decoration:none;">
   <img src="img/strat.png" border="0" class="startimg">
   <img src="images/imageFrame0.png" id="flash_one" alt="Flash Images..." style="display:none;">
   <img src="images/imageFrame1.png" id="flash_two" alt="Flash Images..." style="display:none;">
   </a>

   <style>
#flash_one{
    margin: 100px;
    position: absolute;
    z-index: 9999 !important;
    left: 14px;
    top: 94px;
}
#flash_two{
    margin: 100px;
    position: absolute;
    z-index: 9999 !important;
    left: 14px;
    top: 94px;
}
   </style>
 <!--    Bar div-->
<div class="timer">
<div id="divSeconds"></div>
<div id="progressBar">
<div></div>
</div>

   </div>
  <div class="clearBoth"></div>
  <div class=" subslider1"> <a data-toggle="modal" href="help_index.php" data-target="#helpModal"><img class="org-help" src="assets/images/org-help.png" align="center" alt=""></a> </div>

</div>

<!-- popup -->
<!--<div id="quickpopup"  class="well">
     <div onclick="StartTesting('quick');" class="choice">Quick Analysis - Low Accuracy</div>
     <div onclick="StartTesting('full');" class="choice">Full Length Analysis - High Accuracy</div>
   </div>
<br>-->
<!-- popup --> 
</div>

<div class="wrapperfoot">
  <div class="footlink"><a data-toggle="modal" href="" data-target="#testModal"></a></div>
  <div class="containerfoot">
    <div id="buttonfoot"><a></a></div>
    <div class="border-test"></div>
    <div class="contentfoot">
      <ul class="list-inline">
        <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
        <li class="rlist"> <a href="profile.php" class="text-right" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a> </li>
      </ul>
    </div>
  </div>
</div>

<!-- /container --> 
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
<!-- jQuery (necessary for Bootstraps JavaScript plugins) --> 
<script src="libs/cordova.js"></script> 
<script src="libs/evothings/evothings.js"></script> 
<script src="libs/evothings/easyble/easyble.js"></script> 
<script src="libs/jquery/jquery.js"></script> 
<script src="js/customjs.js"></script>
<script type="text/javascript" src="http://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
<script type="text/javascript" charset="utf-8" src="phonegap.0.9.5.js"></script>
<script src="app.js"></script> 
<script src="js/bootstrap.min.js"></script> 


<script type="text/javascript">
window.onload = function(){
document.addEventListener("deviceready", onDeviceReady, false);
}

function onDeviceReady() {
app.startScan();
} 

function onBackKey() {
console.log("disable back button...");
alert('disable back button...');
} 

function StartTesting(calltype) {
 var getDisableButton = $('#disableQuickPopUp').attr('disableclick');
 alert(getDisableButton);
 if(getDisableButton == 'yes'){
	 return false;
	 }
	
	 $('#flash_one').show();
	 $('#flash_two').show();

	app.sendData([0x01],calltype);
	 if (calltype == "quick") {
		progress(0, 70, $('#progressBar'));
	/*Rotating Image.. functionality*/
		var angle = 0;
		var angle_rev= 0;
		setInterval(function(){
		angle+=12;
		angle_rev +=-12;
		$("#flash_one").rotate(angle);
		$("#flash_two").rotate(angle_rev);
		},50);
	}
	else {
		progress(0, 190, $('#progressBar'));
		/*Rotating Image.. functionality*/
		var angle = 0;
		var angle_rev= 0;
		setInterval(function(){
		angle+=12;
		angle_rev +=-12;
		$("#flash_one").rotate(angle);
		$("#flash_two").rotate(angle_rev);
		},50);
	}
document.addEventListener("backbutton", onBackKey, false);	
$("#disableQuickPopUp").attr("disableclick", "yes");
}	

$(document).ready(function(){
	$('#showMessageNext').click(function(){
			$('#page2').hide();
	        $('#page3').show();
		});
	});

        function progress(timepassed, timetotal, $element) {
            var timeleft = timetotal - timepassed;
            var progressBarWidth = timepassed * $element.width() / timetotal;

            $element.find('div').animate({ width: progressBarWidth }, timepassed == timetotal ? 0 : 1000, 'linear').html();

            $("#divSeconds").html(timeleft + " seconds");
            if (timeleft > 0) {
                setTimeout(function () {
                    progress(timepassed + 1, timetotal, $element);
                }, 1000);
            }
        };
       
</script>
</body>
</html>
