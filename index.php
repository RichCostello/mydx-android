<?php
        include("includes/sessions.php");

        $username=$_SESSION['user_nm'];
        //echo "User:".$username;
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

    <title>CDX intro page</title>

    <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="css/owl.carousel.css">
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">
        <script src="assets/owl-carousel/owl.carousel.min.js"></script>
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

    <div class="container index-cont gradient">
     <div class="navbar navbar-inverse navbar-static-top" role="navigation">

       <div class="navbar-header">
        <div id="menu-toggle">
    <img src="img/navbut.jpg" alt="Menu"></img>
  </div>
    <?php
   include("includes/side_menu.php");
   ?>
          <a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
        </div>
    </div>
   <!-- end nav section -->
  <div class="begintest">
        <h2>Begin Testing </h2>
        <h2>And Tracking..</h2>
  </div>

   <div class="owl-carousel owl-theme owl-center owl-loaded loop">
                <div class="item">
                  <!-- <a href="profile.php"><img class="slider" src="assets/images/menucanna.png"  alt="cann"></a> -->
                  <a data-toggle="modal" href="" data-target="#shareModal"><img class="slider" src="assets/images/menucanna.png"  alt="cann"></a>
                </div>
                <div class="item">
                   <div class="details">
                  <a href="#"><h3>Coming Soon</h2></a>
                  </div>
                  <img class="slider" src="assets/images/menuorganna.png"  alt="aero">
                </div>
                  <div class="item">
                  <div class="details">
                  <a href="#"><h3>Coming Soon</h2></a>
                  </div>
                  <img src="assets/images/menuaero.png"  alt="aero"></div>
                   <div class="item">
                   <div class="details">
                  <a href="#"><h3>Coming Soon</h2></a>
                  </div>
                  <img src="assets/images/menuaqua.png"  alt="aqua"></div>
              </div>
                  <div class=" subslider">
             <a data-toggle="modal" href="help_index.php" data-target="#helpModal"><img class="org-help" src="assets/images/org-help.png" align="center" alt=""></a>
             <div class="molli-text">Just flip to the <br> type of sample you want to track<br> to get started...</div>
</div>

<!-- modal message -->
         <!-- modal share -->
        <div class="modal fade" id="shareModal">
  <div class="modal-dialog">
    <div class="modal-canna">
      <div class="modal-header-canna">

        <h4 class="modal-title-share text-center"></h4>
      </div>
      <div class="modal-body">
 <p class="sharel text-center"><a href="quicktest.php">Analyze With MyDx</a></p>
 <br>

        <p class="sharel text-center"><a href="profile.php" >Recommend Strain</a></p>
      </div>
      <div class="shares-modal-footer">
        <button type="button" class="btn btn-shares" data-dismiss="modal">Cancel</button>

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
      <!--  end modal share -->


 <!-- modal message -->
         <!-- modal share -->
        <div class="modal fade" id="testModal">
  <div class="modal-dialog">
    <div class="modal-canna">
      <div class="modal-header-canna">
       <div class="text-center addsttxt">Add Strain</div>

      </div>
      <div class="modal-body">
 <p class="sharel text-center"><a href="quicktest.php">Use MyDx</a></p>
 <br>

        <p class="sharel text-center"><a href="add-strain.php" >Add Manually</p>
      </div>
      <div class="shares-modal-footer">
        <button type="button" class="btn btn-shares" data-dismiss="modal">Cancel</button>

      </div>
    </div>
  </div>
</div>


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

 <!-- end main content -->
  <div class="footer">
  <div class="wrapperfoot">
    <div class="footlink"><!-- <a href="add-strain.php"> --><a data-toggle="modal" href="" data-target="#testModal">Add strain profile +</a></div>
    <div class="containerfoot">
        <div id="buttonfoot"><a></a></div>
        <div class="border-test"></div>
        <div class="contentfoot">
           <ul class="list-inline">
            <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
            <li class="rlist"><a href="profile.php" class="text-right" href="" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a></li>

          </ul>
        </div>
  </div>
</div>



     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="assets/owl-carousel/owl.carousel.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="js/bootstrap.min.js"></script>
    <script src="js/customjs.js"></script>
     <script src="js/owl-slide.js"></script>
     <script src="js/hide.js"></script>
  </body>
</html>
