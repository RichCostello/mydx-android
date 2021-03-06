<?php session_start(); ?>
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

        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/styles-iframe.css" rel="stylesheet">
        <link href="css/master.css" rel="stylesheet">
        <?php
        include("includes/scaling.php");
        ?>
    </head>

    <body>
        <?php
//Detect devices
        $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
        $webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");
        if ($iPod || $iPhone) {
            ?>
            <script src="cordova.js"></script><?php } else if ($iPad) {
            ?>
            <script src="cordova.js"></script><?php } else if ($Android) { 
            ?>
            <script src="libs/cordova.js"></script><?php
        } else if ($webOS) {
            
        }
        ?>

        <input type="hidden" id="hdnUserID" name="hdnUserID" value="<?php echo $_SESSION['user_id']; ?>" />
        <div class="container index-cont gradient">
            <div class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <div id="menu-toggle"> <img src="img/navbut.jpg" alt="Menu"></img> </div>
                    <?php include("includes/side_menu.php"); ?>
                    <a class="navbar-brand" href="javascript:void(0);"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a> </div>
            </div>
            <!-- end nav section --> 
            <br>
            <br>
            <!--  page 1  -->   
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
                        <p id="showMessageFirst" class="blink_me">I'm looking for<br id="showHidebr">
                            it now.</p>
                        <p id="showMessageSecond">&nbsp;</p>
                        <small id="deviceProcess" style="display: none;">Tap the device to process..</small>
                        <!-- List of Devices-->
                        <div id="list_of_devices" style="display: none">        </div>                                                                                                                                                                                                 

                    </div>
                    <span  class="orngBtn" id="showMessageSucess" style="display:none;"><a href="#" class="pull-right">SUCCESS!</a>
                        <div class="clearfix"></div>
                    </span> </div>
                <div class="clearBoth"></div>
                <div class=" subslider1"> <a data-toggle="modal" href="help_index.php" data-target="#helpModal"><img class="org-help" src="assets/images/org-help.png" align="center" alt=""></a> </div>



            </div>
            <!--  page 2  -->  

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
            <!--  page 3 --> 

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
            <form action="" method="POST" id="frmSbmit">
                <input type="hidden" name="mraw" id="strDataHidden">
            </form>
            
            <!-- error modal showing the Network status... -->
            <div class="modal ercustom" id="errorModal">
                <div class="modal-dialog">
                    <div class="modal-canna">
                        <div class="modal-header">
                            <button id="networkCloseBtn" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title text-center errorm" >You are Offline</h4>
                            <div class="text-center errorp">
                                <p id="modelMessage"></p>
                                <p id="networkLoadingImage"><img src="img/newtowk.gif"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- error modal -->
            
            <!-- /container --> 
<script src="libs/evothings/evothings.js"></script>
<script src="libs/evothings/easyble/easyble.js"></script>
<script src="libs/jquery/jquery.js"></script>
<script src="js/customjs.js"></script>
<script type="text/javascript" src="https://jqueryrotate.googlecode.com/svn/trunk/jQueryRotate.js"></script>
<script type="text/javascript" charset="utf-8" src="phonegap.0.9.5.js"></script>
<script src="app.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    /*function to check Network status...*/
    function NetworkStatus() {
        if (navigator.onLine) {
            console.log("you are online");
            return true;
        } else {
            return false;
        }
    }


    window.onload = function() {
        if (NetworkStatus() == false) {
            document.getElementById("showMessageSecond").innerHTML = "You are Offline";
            $("#showMessageFirst").removeClass("blink_me");
            $("#showMessageSecond").addClass("blink_me");
            return false;
        }
        document.addEventListener("deviceready", onDeviceReady, false);
    }

    /*Check the device type*/
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    function onDeviceReady() {
        app.startScan();
    }

    function onBackKey() {
        /* function call on clicking back button... */
    }

    function StartTesting(calltype) {
        var getDisableButton = $('#disableQuickPopUp').attr('disableclick');
        if (getDisableButton == 'yes') {
            return false;
        }
        if (NetworkStatus() == false) {
            console.log('You are Offline');
        }


        $('#flash_one').show();
        $('#flash_two').show();

        if (isMobile.iOS()) {
            app.sendData([0x01], calltype);
            app.sendData([0x01], calltype);
        } else {
            app.sendData([0x01], calltype);
        }

        if (calltype == "quick") {
            progress(0, 70, $('#progressBar'));
            /*Rotating Image.. functionality*/
            var angle = 0;
            var angle_rev = 0;
            setInterval(function() {
                angle += 12;
                angle_rev += -12;
                $("#flash_one").rotate(angle);
                $("#flash_two").rotate(angle_rev);
            }, 50);
        } else {
            progress(0, 190, $('#progressBar'));
            /*Rotating Image.. functionality*/
            var angle = 0;
            var angle_rev = 0;
            setInterval(function() {
                angle += 12;
                angle_rev += -12;
                $("#flash_one").rotate(angle);
                $("#flash_two").rotate(angle_rev);
            }, 50);
        }
        document.addEventListener("backbutton", onBackKey, false);
        $("#disableQuickPopUp").attr("disableclick", "yes");
    }

    $(document).ready(function() {
        $('#showMessageNext').click(function() {
            $('#page2').hide();
            $('#page3').show();
        });
    });

    function progress(timepassed, timetotal, $element) {
        var timeleft = timetotal - timepassed;
        var progressBarWidth = timepassed * $element.width() / timetotal;

        $element.find('div').animate({
            width: progressBarWidth
        }, timepassed == timetotal ? 0 : 1000, 'linear').html();

        $("#divSeconds").html(timeleft + " seconds");
        if (timeleft > 0) {
            setTimeout(function() {
                progress(timepassed + 1, timetotal, $element);
            }, 1000);
        }
    };
</script>
    </body>
</html>