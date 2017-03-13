<?php
include("includes/sessions.php");
$userid = $_SESSION['user_id'];
$role = $_SESSION['user_rl'];
$userg = $_SESSION['user_ug'];
include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
$strefr = explode("?", $_SERVER['HTTP_REFERER']);
if ($strefr[1] != 'act=Save') {
    $_SESSION['strainLP'] = $_SERVER['HTTP_REFERER'];
}
include("includes/deltarfunction.php");
$strain_id = $_REQUEST['sid'];
$profileid = $_REQUEST['uid'];
$graphval = $_REQUEST['val'];
$graphval1 = GetVisualDeltaRs($graphval);
$created_date = date("Y-m-d H:i:s");
include("classes/EncryptDecryptClass.php");
$encryptme = new EncryptDecrypt();
$qstr = ($_SERVER["QUERY_STRING"]);
$tempenc = $encryptme->encode("$profileid");
$fbSURL = "/webapp-demo/sds.php?uid=" . $tempenc;
if (isset($_REQUEST['act']) == "SaveFb") {
    $sql_sel = "SELECT COUNT(*) AS NumberOfrec  FROM `FBStrain` WHERE `ChemicalProfileID`=" . $profileid;
    $result = mysql_query($sql_sel, $con);
    $row = mysql_fetch_array($result);
    if ($row["NumberOfrec"] == 0) {
        $sql_insert = "INSERT INTO `FBStrain`(`ChemicalProfileID`,`Val1`, `Val2`, `Val3`, `Val4`, `Val5`, `Val6`, `Val7`, `Val8`, `Val9`, `Val10`, `Val11`, `Val12`, `Val13`, `Val14`, `Val15`, `Val16`, `ItemName`, `StrainID`, `StrainName`,`ShortUrl`) VALUES ($profileid,$expval[0],$expval[1],$expval[2],$expval[3],$expval[4],$expval[5],$expval[6],$expval[7],$expval[8],$expval[9],$expval[10],$expval[11],$expval[12],$expval[13],$expval[14],$expval[15],'" . $_REQUEST['sn'] . "','" . $strain_id . "','" . $_REQUEST['sn'] . "','" . $tempenc . "')";
        $result = mysql_query($sql_insert, $con);
    }
    $sql_insert1 = "INSERT INTO `FBSharedStrain`(`ChemicalProfileID`, `DateShared`, `StrainID`, `UserID`, `StrainName`) VALUES ($profileid,'" . $created_date . "','" . $strain_id . "','" . $userid . "','" . $_REQUEST['sn'] . "')";
    $result = mysql_query($sql_insert1, $con);
}
$sql = "select * from ChemicalProfiles where ID=" . $profileid;
$result = mysql_query($sql, $con);
$userid = "";
while ($row = mysql_fetch_array($result)) {
    $userid = $row["UserID"];
    $strain_id = $row["StrainID"];
    $strainname = $row["Name"];
    $straintype = $row['StrainType'];
    $comments = $row["Comments"];
    $intmethod = $row["MethodIntake"];
    $howfeel = $row["FeelBefore"];
    $qtytake = 0;
    if (($row["QtyIntake"] >= 2.5) && ($row["QtyIntake"] <= 5)) {
        $qtytake = 1;
    }
    if (($row["QtyIntake"] > 5) && ($row["QtyIntake"] <= 20)) {
        $qtytake = 2;
    }
    if ($row["QtyIntake"] > 20) {
        $qtytake = 3;
    }
    $LOL = $row["EffectsLasted"];
    if ($LOL < 30) {
        $LOLindex = 0;
    }
    if (($LOL >= 30) && ($LOL < 60)) {
        $LOLindex = 1;
    }
    if (($LOL >= 60) && ($LOL < 120)) {
        $LOLindex = 2;
    }
    if ($LOL >= 120) {
        $LOLindex = 3;
    }
}
$sql = "SELECT * from StrainChemicals where StrainID='" . $strain_id       . "' ";
$result = mysql_query($sql, $con);
$isfound = false;
if (mysql_num_rows($result) > 0)
    $isfound = true;
if ($isfound) {
    $row = mysql_fetch_array($result);
    if ($row["UserID"] == $userid)
        $isfound = false;
}
function doStrainGraph($id, $qtc, $denom) {
    if ($denom == 0) {
        return 0;
    } else {
        return $qtc / $denom;
    }
}
$sql = "SELECT SampleID as StrainID  FROM AppStrains WHERE StrainName = '$strainname'";
$query = mysql_query($sql);
if (mysql_num_rows($query) > 0) {
    $row = mysql_fetch_array($query);
    $strain_id = $row["StrainID"];
}
$sql = "SELECT c.*,IFNULL(sc.value,'') as Value,IFNULL
    (sc.Variance,'') as Variance FROM Chemicals c
    LEFT  JOIN StrainChemicals sc on c.ID=sc.ChemicalID and
    sc.StrainID='" . $strain_id . "' order by Type,ID";
$result = mysql_query($sql, $con);
// Check connection
$type = "";
$straincontent = "";
while ($row = mysql_fetch_array($result)) {
    if ($type != $row["Type"])
        $straincontent.='<div class="col-xs-12 text-center details-gray">' . $row["Type"] . '</div>';
    $type = $row["Type"];
    $straincontent.= '<div class="form-content"> <div class="col-xs-offset-1 col-xs-7 "><h5>' . $row["Name"] . '</h5></div>';
    $straincontent.= '<div class="col-xs-3 form-content">' . $row["Value"] . '</div><label for="percent" class="col-xs-1 clabel-details">' . $row['Unit'] . '</label> </div>';
}
$straincontent = '<div class="form-content"> <div class="col-xs-offset-1 col-xs-7 "><h5>Strain Type</h5></div><div class="col-xs-3 form-content">' . $row["Value"] . '</div><label for="percent" class="col-xs-1 clabel-details">' . $straintype . '</label> </div>' . $straincontent;
include("includes/linechart-sql.php");
$sql = "select * from StrainFeelings where ChemicalProfileID=" . $profileid;
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result)) {
    $sfArraylist = Array(
        'happy' => $row["Happy"],
        'energetic' => $row["Energetic"],
        'focused' => $row["Focused"],
        'relaxed' => $row["Relaxed"],
        'social' => $row["Social"],
        'creative' => $row["Creative"],
        'sexual' => $row["Sexual"]
    );
}
$sql = "select * from StrainRelief where ChemicalProfileID=" . $profileid;
$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result)) {

    $migranes = $row["Migraines"];
    $siezure = $row["Siezures"];
    $pain = $row["Pain"];
}
$sql = "select * from ProfileMedical where ChemicalProfileID=" . $profileid . " order by `Condition`";
$result = mysql_query($sql, $con);
$i = 0;
$relieve = "";
$condtemp = "";
while ($row = mysql_fetch_array($result)) {
    if ($row['Value'] == 0) {
        $condition = $row["Condition"];
        $rvalue = $row["Value"];
        $relieve.='<div class="row">

                        <div class="pagination btn-group" data-toggle="buttons">
                        <label class="btn btn-middle-top-detail ">
                        <input name="" value="' . $rvalue . '" type="radio">' . $condition . '
                        <svg class="stico-add gly-right gly-right-d"><use xlink:href="#icon-add"></use></svg>
                        </label>
                        <label class="btn btn btn-medium-det">
            <input name="" value="better" class="active" type="radio">
                        </label>
                        </div>
                        </div> ';
        $condtemp.=$condition . ',';
    }
    $i++;
}
$relieve.='<input type="hidden" value="' . substr($condtemp, 0, -1) . '" name="relieveval">';
$fbCond = substr($condtemp, 0, -1);
mysql_close($con);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="testViewport" name="viewport" content="width=320, maximum-scale=1.5, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Cdxlife">
        <link rel="icon" href="../../favicon.ico">
        <title><?= $strainname ?> Strain Profile</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/styles-iframe.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <!--    <link href="justified-nav.css" rel="stylesheet"> -->

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php
include("includes/scaling.php");
?>
        <style type="text/css">
            .FB_UI_Dialog {
                width: 320px !important;
            }

            .stlocat {
                font-family: ClearSans;
                color: #6d6e70;
                text-decoration: none;
                font-size: 16px;
                display: block;
                padding-top: 12px;
            }

        </style>
    </head>
    <body>
        <div id="fb-root"></div>
        <form class="form" action="strain-profile.php?act=update" method="post" id="strainForm" name="strainForm">
            <input type="hidden" value="<?= $graphval ?>" name="strainval">
            <input type="hidden" value="<?= $strain_id ?>" name="sid">
            <input type="hidden" value="<?= $profileid ?>" name="uid">
            <input type="hidden" value="<?= $strainname ?>" name="strainname">
            <svg display="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
            <symbol id="icon-add" viewBox="0 0 1024 1024">
                <title>add</title>
                <path class="path1" d="M810.667 554.667h-256v256h-85.333v-256h-256v-85.333h256v-256h85.333v256h256v85.333z" />
            </symbol>
            <symbol id="icon-remove" viewBox="0 0 1024 1024">
                <title>remove</title>
                <path class="path1" d="M810.667 554.667h-597.333v-85.333h597.333v85.333z" />
            </symbol>
            </defs>
            </svg>
            <div class="container index-cont gradient">
                <div class="navbar navbar-inverse navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <h4 class="backnav"><a href="#" onclick="window.history.back();
                  return false;"  ><span class="arrow"></span> BACK </a></h4>
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
                            <a href=""><img class="share-button" src="assets/images/share.png"></a>
                        </div>
                        <div class=" col-xs-4 text-left detailsbuffer">
                            <h2><?= $strainname ?></h2>
                        </div>
                        <div class="col-xs-5  ratebuffer">
                            <p class="ratelabel">Rate</p>
                            <ul  id="ratings">
                                <li id="cl1" class="ico ico1"><a href="#"></a></li>
                                <li id="cl2" class="ico ico2"><a href="#"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end sub header section -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-pills pillsbg">
                                <li class="text-center active prof-pill"><a class="White" href="#one" data-toggle="tab">Feeling</a></li>
                                <li class="text-center prof-pill pillbord"><a class="White" href="#two" data-toggle="tab">Content</a></li>
                                <li class="text-center prof-pill-end"><a class="White" href="#twee" data-toggle="tab">Intake Info</a></li>
                            </ul>
                            <div class="tab-content tabstyle" >
                                <!-- start tab pane -->
                                <div class="tab-pane active" id="one">
                                    <div class="container">
                                        <div class="row">
                                            <div class="center-block str-details-feeling text-center" >
                                                <h4 class="text-center"><span class="ccbold">Helps People Relieve</span></h4>                    <!-- start buttons -->
                                                <!--group top row -->
<?php echo $relieve ?>
                                                <!-- end group top row -->
                                                <h4 class="text-center tenbuffer"><span class="ccbold">Helps People Feel</span></h4>
                                                <!--group bottom row -->
                                                <?php
                                                foreach ($sfArraylist as $key => $value) {
                                                    //echo "Key: $key, Value: $value\n";
                                                    if ($value < 5) {
                                                        echo' <div class="row">
                        <div class="pagination btn-group" data-toggle="buttons">
                        <label class="btn btn-middle-top-detail">
                        <input name="' . $key . '" value="' . $value . '" type="radio" checked>More ' . ucfirst($key) . '
                        <svg class="stico-add gly-right gly-right-d"><use xlink:href="#icon-add"></use></svg>
                        </label>
                        <label class="btn btn btn-medium-det-feel">
                        <input name="' . $key . '" value="' . $value . '" class="active" type="radio">
                        </label>
                        </div>
                        </div>';
                                                    }
                                                }
                                                ?>
                                                <br><br>
                                                <!-- end group bottom row -->
                                                <!-- end buttons -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <!-- start tab pane -->
                                <div class="tab-pane" id="two"><div class="top-buffer"></div>
                                    <div class="container setcol-content fcontent">
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <h3 class="tcph3">Total Chemical Profile</h3>
                                                <div class="detailchart">
                                                    <div id="tcprofile"></div>
                                                </div></div>
<?php
echo $straincontent;
?>
                                        </div>
<?php
if ($countm > 0) {
    echo '<br>';
    echo $divgraph;
}
?>

                                    </div>
                                    <br><br>
                                </div>
                                <!-- end tab pane -->
                                <!-- start tab pane -->
                                <div class="tab-pane" id="twee">
                                    <div class="container setcol-intake">
                                        <div class="row">
                                            <div class="center-block profile-box">

                                                <h5>Comments</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12">
                                                            <textarea class="intake" rows="4" readonly><?= $comments ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5>Intake Method</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 styled-select">
                                                            <select id="inmethod"  name="intake">
                                                                <option>Vaporizer [Flower]</option>
                                                                <option>Vaporizer [Oil]</option>
                                                                <option>Glass Device</option>
                                                                <option>Cigarette</option>
                                                                <option>Sublingal</option>
                                                                <option>Edible</option>
                                                                <option>Beverage</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5>How You Felt Before</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 styled-select">
                                                            <select  id="fbefore" name="feelingsbefore">
                                                                <option>Positive</option>
                                                                <option selected>Neutral</option>
                                                                <option>Negative</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5>Save To (Data Is Anonymous)</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 styled-select">
                                                            <select  id="dbsave" name="savetodv">
                                                                <option>Community Database</option>
                                                                <option selected >Internal Database</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5>How Much Did I Intake(mg):</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 styled-select">
                                                            <select id="intakeval"  name="howmuch">
                                                                <option value="0">Not Sure</option>
                                                                <option value="5">Beginners: 2.5-5 mg THC</option>
                                                                <option value="20">Experienced: 10-20 mg THC</option>
                                                                <option value="25">Heavy: 25mg +</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5>Length Of Effect</h5>
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <div class="col-xs-12 styled-select">
                                                            <select  id="leneffect" name="howlong">
                                                                <option value="0">0-30</option>
                                                                <option value="30" >30 min - 1 hr</option>
                                                                <option value="60">1 hr - 2 hrs</option>
                                                                <option value="120">>2 hrs</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>

                                </div>
                                <!-- end tab pane -->
                            </div>
                        </div>
                    </div>
                    <!-- modal share -->
                    <div class="modal fade" id="shareModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header-share">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title-share text-center">Share</h4>
                                </div>
                                <div class="modal-body">
                                    <p class="sharel text-center"><a id="share_button"  href="#">Facebook</a></p>
                                   <!--<p class="sharel text-center"><a  href="javascript:fbShareGs('<?= $fbSURL ?>', 'MyDx Share', 'A Device for a better life', '/webapp_ges/assets/images/menucanna.png', 520, 350)">Facebook</a></p>-->
                                    <p class="sharel text-center"><a href="mailto:?subject=Please check out this strain&amp;body=Check out this site <?= $fbSURL ?>." title="Share by Email">Email</p>
                                </div>
                                <div class="shares-modal-footer">
                                    <button type="button" class="btn btn-shares" data-dismiss="modal">Cancel</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <!--  end modal share -->                    
                    <!-- end modal message -->
                    <div class="footer">
                        <div class="wrapperfoot">
                            <div class="footlink"><a href="#" onClick="javascript:document.strainForm.submit();" style="border: 0;"> Add to my profile</a></div>
                            <div class="containerfoot">
                                <div id="buttonfoot"><a></a></div>
                                <div class="border-test"></div>
                                <div class="contentfoot">
                                    <ul class="list-inline">
                                        <li class="llist"><a class="text-left" href="quicktest.html" ><span class="qtest-icon"></span>Quick TEST</a></li>
                                        <li class="rlist"><a class="text-right" href="profile.php" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
                        <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
                     <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
                        <!-- Include all compiled plugins (below), or include individual files as needed -->
                        <script src="js/bootstrap.min.js"></script>
                        <script src="js/customjs.js"></script>
                        <script src="js/hide.js"></script>
                        <script src="js/raphael.js"></script>
                        <script src="js/g.raphael-min.js"></script>
                        <script src="js/g.bar-min.js"></script>
                        <script src="js/fbsdk.js"></script>
                        <script src="js/g.line-min.js"></script>
                        <script>
                                var r = Raphael("tcprofile");
                                txtattr = {font: "12px sans-serif"};
                                r.barchart(10, 10, 315, 105, [[<?php echo $graphval1 ?>]], 0, {type: "sharp"}).attr({fill: "#f36f21"});
                                var id = 'inmethod';
                                var val = '<?php echo $intmethod ?>';
                                document.getElementById(id).value = val;
                                var id = 'fbefore';
                                var val = '<?php echo $howfeel ?>';
                                document.getElementById(id).value = val;
                                var id = 'intakeval';
                                var val = '<?php echo $qtytake ?>';
                                document.getElementById(id).selectedIndex = val;
                                var id = 'leneffect';
                                var val = '<?php echo $LOLindex ?>';
                                document.getElementById(id).selectedIndex = val;
<?php include("includes/linechart-js.php");?>

                        </script>
                        </body>
                        </html>
