<?php
	
	include("includes/sessions.php");
	$userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl']; 
	$userg=$_SESSION['user_ug'];

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

    <title>My Profile</title>

    <!-- Bootstrap core CSS -->
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">
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
    <div class="container index-cont plant"> 
    <div class="navbar navbar-inverse navbar-static-top" role="navigation"> 
      
       <div class="navbar-header"> 
          <h4 class="backnav"><span class="arrow"></span><a href="#" onclick="window.history.back();return false;" > BACK</a></h4>
        <div id="menu-toggle">
    <img src="img/navbut.jpg" alt="Menu"></img>
  </div>
      <?php
   include("includes/side_menu.php");
   ?>
          <a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
        </div> 
    </div> 
 
<!-- end navbar and slide out menu -->
<!-- start sub header section -->
     <div class="container top-white">
      <div class="row">
        <div class="col-xs-3 helpimg">
       <a class="" data-toggle="modal" href="apphelp.php" data-target="#helpModal"><img src="assets/images/need_help.png"></a>
        </div>
        <div class="col-xs-8 text-left addbuffer"><h2>Add Strain Profile</h2>
        </div>
        <div class="col-xs-1 text-right"></div>
      </div>
       
     </div>
     
 <!-- search results -->
 <div class="container setcol-add">
    <div class="center-block usage-box addstrain-buffer st-pad">
      <h3>Do you have a <span class="boldstrain">Sample ID</span> ?</h3>
     <form role="form"  method="post" action="strain-profile.php?act=new" name="strain-intro" id="strain-intro">
     
         <div class="radio aspad">
           <label class="radio-inline control-label">
            <input type="radio" id="sampleStrain" name="owner" value="Yes">
              Yes
           </label>
       </div>
      <input placeholder="Sample ID" type="text" class="form-control st-text" id="amount_actual" name="amount_actual">

      <div class="radio">
          <label>
            <input type="radio" name="owner" value="no" checked>
            No
          </label>
        </div>
     
   </div>
 
 <!--end results -->
 </div>
<!-- modal message -->
        <!-- Modal -->
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
  <div class="footer">
  <div class="wrapperfoot">
    <div class="footlink-strain text-right"><a id="addstrain"  href="strain-profile.php?act=new">NEXT ></a></div>
     </form>
    <div class="containerfoot">
        <div id="buttonfoot"><a></a></div>
        <div class="border-test"></div>
       <div class="contentfoot">
           <ul class="list-inline">
             <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
            <li class="rlist"><a class="text-right" href="profile.php" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a></li>
          
          </ul>
        </div>  
  </div>
</div>

 

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/customjs.js"></script>
    <script src="js/hide.js"></script>
     <script>
		
		$('input[type=radio]').change( function() {
   
   			var link = document.getElementById("addstrain");
			var owner = document.getElementsByName('owner');
			var own_value;
			var urlval;
			
			
			if(owner[0].checked){
				own_value=owner[0].value;
				urlval=document.getElementById('amount_actual').value;
			}else{
				own_value=owner[1].value;
				urlval='';
			}
			
			var url='strain-profile.php?sid='+urlval+'&sel='+own_value;
			//alert(url);
			link.setAttribute("href", url);
});
	</script>
  </body>
</html>
