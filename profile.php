<?php
	include("includes/sessions.php");
	$userid = $_SESSION['user_id'];
	$role = $_SESSION['user_rl'];
	$userg = $_SESSION['user_ug'];
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	include("../deltarfunctions.php");
	
$TABLE_NAME = "MedicalConditions";
if (!$con) {
    $msgalert = "No DB Connection";
} else {
    $sql_stmt = "SELECT * FROM $TABLE_NAME  WHERE UserID=$userid AND `isON` =1 ORDER BY `Condition` ASC";
    $result = @mysql_query($sql_stmt);
    $num_rows = mysql_num_rows($result);
    $numAilments = $num_rows;
    $i = 0;
    $ailment = "";
    while ($row = mysql_fetch_array($result)) {
        if ($i == 0) {
            $ailment.=' <div class="row"><div class="col-xs-6 text-center buttonpf prof-btn">
               <label> <input type="checkbox" name="ailment_' . $row['ID'] . '" value="' . $row['Condition'] . '" class="buttonpf prof-btn">

                ' . $row['Condition'] . '</label></div>';
            $i++;
        } else {
            $ailment.='<div class="col-xs-6 text-center buttonpf prof-btn">

                <label><input type="checkbox" name="ailment_' . $row['ID'] . '" value="' . $row['Condition'] . '" class="buttonpf prof-btn">

                ' . $row['Condition'] . '</label></div></div>';
            $i = 0;
        }
    }
    if ($num_rows % 2 !== 0) {
        $ailment.='<div class="col-xs-6 text-center buttonpf prof-btn"><a class="profadd" href="settings.php#al1/">Add Custom Ailment</a></div></div>';
    } else {

        $ailment.='<div class="col-xs-6 text-center buttonpf prof-btn"><a class="profadd" href="settings.php#al1/">Add Custom Ailment</a></div>';
    }
    $sql_stmt = "SELECT * FROM SettingsFeelings WHERE UserID=-1 AND `isOn` =1 ";
    $result = @mysql_query($sql_stmt);
    $num_rows1 = mysql_num_rows($result);
    $numFeelings = $num_rows1;
    $i1 = 0;
    $feelings = "";
    while ($row = mysql_fetch_array($result)) {
        if ($i1 == 0) {
            $feelings.='<div class="row">
                <div class="col-xs-6 text-center buttonpf prof-btn">
                 <label> <input type="checkbox" name="feeling_' . $row['ID'] . '" value="' . $row['Feeling'] . '" class="buttonpf prof-btn">

              ' . $row['Feeling'] . '</label></div>';
            $i1++;
        } else {
            $feelings.='<div class="col-xs-6 text-center buttonpf prof-btn">
              <label>  <input type="checkbox" name="feeling_' . $row['ID'] . '" value="' . $row['Feeling'] . '" class="buttonpf prof-btn">
                ' . $row['Feeling'] . '</label></div></div>';
          $i1 = 0;
        }
    }
    if ($num_rows1 % 2 !== 0) {
        $feelings.='</div>';
    }
}
if (substr($_SERVER['QUERY_STRING'], 0, 2) == "ss") {
    echo'<script> window.location="search-results.php?id=' . $userid . '&ispublic=1&' . $_SERVER['QUERY_STRING'] . '";</script>';
}
$sql = "SELECT * FROM ChemicalProfiles where UserID=" . $userid;
if ($role == 0) {
    $sql = "SELECT cp.* , 0 as THC, 0 as CBD,0 as CBN, 0 as CBG, 0 as THCV FROM ChemicalProfiles cp ";
} else {
    $sql = "SELECT cp.id as cid, cp.StrainID as sid,cp.* , 0 as THC, 0 as CBD,0 as CBN, 0 as CBG, 0 as THCV,m.*
		FROM ChemicalProfiles cp
		LEFT OUTER JOIN Measurements  m on cp.ID=m.ChemicalProfileID   
		WHERE cp.UserID=" . $userid . " group by cp.id order by cp.DateTested desc";
    if ($userid == 730) {
        $sql = "SELECT cp.id as cid, cp.StrainID as sid,cp.* , 0 as THC, 0 as CBD,0 as CBN, 0 as CBG, 0 as THCV FROM ChemicalProfiles cp
			WHERE cp.UserID=" . $userid . " group by cp.id order by cp.Name asc";
    }
}
$result = mysql_query($sql);
$mcnt = 0;
$mydata = "";
$dbint = "";
while ($row = mysql_fetch_array($result)) {//echo $sql;
    $drstr = $row["Delta1"] .
            "," . $row["Delta2"] .
            "," . $row["Delta3"] .
            "," . $row["Delta4"] .
            "," . $row["Delta5"] .
            "," . $row["Delta6"] .
            "," . $row["Delta7"] .
            "," . $row["Delta8"] .
            "," . $row["Delta9"] .
            "," . $row["Delta10"] .
            "," . $row["Delta11"] .
            "," . $row["Delta12"] .
            "," . $row["Delta13"] .
            "," . $row["Delta14"] .
            "," . $row["Delta15"] .
            "," . $row["Delta16"];

    $strval1a = GetVisualDeltaRs($drstr);
    $thumbs = "";
    $tup = isset($row['isUP']);
    if ($tup != "") {
        if ($tup == 1) {
            $thumbs = '<div class="icoresults ico1 active"></div>';
        } else {
            $thumbs = '<div class="icoresults ico2 active"></div>';
        }
    }
    $mcnt++;
   
    if ($row["IsPublic"] == 1) {
        $dbint = " (Internal)";
    }
    $mydata.='<tr><td><a class="profile-history" href="update-strain.php?uid=' . $row["cid"] . '&sid=' . $row["sid"] . '">"<p class="strain-row">' . $row["Name"] . $dbint . '</p>
        <p class="date-row">' . $row["DateTested"] . $thumbs . '</span></p>';
    if ($strval1a != ",,,,,,,,,,,,,,,") {
        $mydata.=' <div class="mytcpchart">
                              <div id="chartProfData' . $mcnt . '"></div>
                             </div>
                             <p class="tcpmydata">Total Chemical Profile</p></a><script>var r = Raphael("chartProfData' . $mcnt . '"),
                    txtattr = { font: "12px sans-serif" };
                r.barchart(0, 0, 230, 90, [[' . $strval1a . ']], 0, {type: "sharp"}).attr({fill: "#f36f21"});
	   </script>';
    } else {
        $mydata.='</a>';
    }
    $mydata.='</td></tr>';
}
$mydata = '<table class="table table-search no-margin"><tbody>' . $mydata . '</tbody></table>';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--   <meta name="viewport" content="width=320, maximum-scale=2"> -->
        <meta id="testViewport" name="viewport" content="width=320, maximum-scale=1.5, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">
        <title>My Profile</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/styles-iframe.css" rel="stylesheet">
        <script src="js/raphael.js"></script>
        <script src="js/g.raphael-min.js"></script>
        <script src="js/g.bar-min.js"></script>
<?php include("includes/scaling.php"); ?>
        <!-- Custom styles for this template -->
        <!--    <link href="justified-nav.css" rel="stylesheet"> -->
        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <script language="javascript" type="text/javascript">
            function submitMe() {
                var isempty = 0;
                var oChecbox = document.getElementsByTagName('input');
                var nr_inpfields = oChecbox.length;
                var condition = "";
                var feeling = "";
                var istr = "";
                var cquote = "";
                var fquote = "";
                var afname = "";    //alert(document.getElementById('rpgo').text);
                var aname = document.getElementById('rpgo').text;
                if (aname == "Add Strain Profile +") {
                    document.location = "add-strain.php";
                } else {
                    for (var i = 0; i < nr_inpfields; i++) {
                        if (oChecbox[i].type == 'checkbox' && oChecbox[i].checked == true) {
                            istr = oChecbox[i].name;
                            afname += istr + ",";
                            istr = istr.substr(0, 7);
                            if (istr == 'ailment') {
                                cquote = oChecbox[i].value;
                                condition += cquote + ",";
                            }
                            if (istr == 'feeling') {
                                fquote = oChecbox[i].value;
                                feeling += fquote + ",";

                            }
                            isempty = 1;
                        }
                    }
                    if (isempty != 1) {
                        alert('No selection made, please select at least 1 ailment.');
                    } else {
                       document.location = "search-results.php?id=<?= $userid ?>&ispublic=1&condition=" + condition + "&feeling=" + feeling + "&vid=" + afname;
                    }
                }
            }
            function SendSearch() {
                var searchval = document.getElementById('searchhist').value;
                if (searchval != "") {
                    document.location = "search-results.php?id=<?= $userid ?>&ispublic=1&ss=" + searchval;
                }
                else {
                    alert('Please fill out the search field');
                    document.getElementById('searchhist').focus();
                }
            }
        </script>
   </head>
    <body class="profilePage">
        <!-- end sub header section -->  
        <div class="container index-cont gradient"> 
            <div class="navbar navbar-inverse navbar-static-top" role="navigation"> 
                <div class="navbar-header"> 
                    <h4 class="backnav"><span class="arrow"></span><a href="index.php"> HOME </a></h4>
                    <div id="menu-toggle">
                        <img src="img/navbut.jpg" alt="Menu"></img>
                    </div>
<?php include("includes/side_menu.php");?>
                    <a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
                </div> 
            </div> 
            <!-- end navbar and slide out menu -->
            <!-- start sub header section -->
           <div class="container">
                <div class="row">
                    <div class="col-xs-3 helpimg">
                        <a data-toggle="modal" href="help_myprofilenew.php" data-target="#helpModal"><img src="assets/images/need_help.png"></a>
                    </div>
                    <div class="col-xs-7 text-center titlebuffer"><h2>MyDx Profile</h2></div>
                    <div class="col-xs-1 text-right detailimg"> <a href="settings.php"><img class="settingsize" src="assets/images/settings.png"></a>
                    </div>
                </div>
            </div>
            <form action="search-results.php"  method="post" name="myProfile" id="myFProfile">
                <input type="hidden" name="cntailments" value="<?= $numAilments ?>">
                <input type="hidden" name="cntfeelings" value="<?= $numFeelings ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="center-block">
                                <div>
                                    <ul class="nav nav-pills pillsbg" >
                                        <li class="text-center active prof-pill"><a class="White ail" href="#one" data-toggle="tab">Ailments</a></li>
                                        <li class="text-center prof-pill pillbord"><a class="White feel" href="#feeling" data-toggle="tab">Side Effects</a></li>
                                        <li class="text-center prof-pill-end"><a class="White mydata" href="#search" data-toggle="tab">My Data</a></li>
                                    </ul>
                                    <div class="tab-content tabstyle" >
                                        <div class="tab-pane active" id="one"><p class="text-center prof-top-buffer">What would you like to relieve?</p>
                                            <p class="text-center prof-sub-buffer">(Choose One or More and Click Recommend)</p>
                                            <div class="container p-button-col">

<?= $ailment ?>                                            </div>
                                        </div>
                                        <div class="tab-pane" id="feeling"><p class="text-center prof-top-buffer">How would you like to feel?</p>
                                            <p class="text-center prof-sub-buffer">(Choose One or More and Click Recommend)</p>
                                            <div class="container p-button-col">

<?= $feelings ?>                                            </div>
                                        </div>
                                        </form> 
                                        <div class="tab-pane" id="search"><p class="text-center search-buffer">Search / History</p>
                                            <div class="search-f">
                                                <input class="form-search" type="text" id="searchhist" name="ss" required>
                                                <button value="send" class="btn btn-search" type="button" onClick="SendSearch();"  id="submit">Search</button>
                                            </div>
                                            <div class="container p-button-search">
                                                <div class="table-responsive" id="profile-search">

                                                    <!-- end test code for chart -->
<?= $mydata ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <!-- /container -->
                <!-- error modal -->
                <div class="modal ercustom" id="errorModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                                <h4 class="modal-title text-center errorm" >Search Results</h4>
                                <div class="text-center errorp">
                                    <p>
									<?php
if(isset($_REQUEST['errmsg'])){
echo $_REQUEST['errmsg'];
}?></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <?php
$goback="";
if(isset($_SESSION['searchLP'])){
	$goback=$_SESSION['searchLP'];
}
?>
<button class="btn-modal" href="<?=$goback?>" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- errormodal -->
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
                        <div class="footlink-prof"><a  id="rpgo" href="#" onClick="submitMe()" style="border: 0;">Recommend Profiles ></a></div>
                        <div id="spinner" class="spinner" style="display:none;">
                            <img id="img-spinner" src="assets/images/712.gif" alt="Loading"/>
                        </div>
                        <div class="containerfoot">
                            <div id="buttonfoot"><a></a></div>
                            <div class="border-test"></div>
                            <div class="contentfoot">
                                <ul class="list-inline">
                                    <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
                                    <li class="rlist"><a class="text-right" href="" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a></li>
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
                    <script>
                     window.addEventListener('load', function () {
                setTimeout(function () {
                    // hide the address bar in iPhone Safari
                    window.scrollTo(0, 1);
                });
                // fast click library is used to remove 300ms delay
                // on click events for mobile touch based browsers
                if ('ontouchstart' in document.documentElement && window.FastClick) {
                    window.FastClick.attach(document.body);
                }
            }, false);

                    </script>
                    <script src="js/raphael.js"></script>
                    <script src="js/g.raphael-min.js"></script>
                    <script src="js/g.bar-min.js"></script>
<?php
if (isset($_REQUEST['errmsg']) != "") {
    echo "<script>$('#errorModal').modal();</script>";
}
if (isset($_SESSION['profile_settings']) != "") {
    $spstng = $_SESSION['profile_settings'];
    $actAF = substr($spstng, 0, -1);
    $arrAF = explode(",", $actAF);
    $lenAF = sizeof($arrAF);
    if ($lenAF > 0) {
        echo "<script>";
        for ($i = 0; $i < $lenAF; $i++) {
            echo 'document.getElementsByName("' . $arrAF[$i] . '").item(0).click();';
        }
        echo "</script>";
    }
}?>
                    <script>
                            if (window.location.hash != "") {
                                $(function() {
                                    $('a[href="' + window.location.hash + '"]').click();
                                })
                            }
                            $(document).ready(function() {
                                $('.buttonpf label').find("input:checked").parent("label").addClass("check");
                                $('.buttonpf label input').click(function() {
                                    $(this).parent("label").toggleClass('check');
                                });
                            });
                    </script>
                    </body>
                    </html>

