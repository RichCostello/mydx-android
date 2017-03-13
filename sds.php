<?php

    include("classes/EncryptDecryptClass.php");
    $encryptme= new EncryptDecrypt();
    ob_start();
    session_start();

    if($_SESSION['loggedu']){
        $logged=true;
        $userid=$_SESSION['user_id'];
    }

include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
    $strefr=explode("?",$_SERVER['HTTP_REFERER']);
    if($strefr[1]!='act=Save'){
        $_SESSION['strainLP']=$_SERVER['HTTP_REFERER'];
    }

    $fid=$_REQUEST['uid'];
    $qstr=($_SERVER["QUERY_STRING"]);
    $fbSURL="/webapp-demo/sds.php?uid=".$fid;


    if($fid!=""){
        $profileid=$encryptme->decode($_REQUEST['uid']);

        $sql_sel="SELECT * FROM `FBStrain` WHERE `ChemicalProfileID`=".$profileid;
        $result=mysql_query($sql_sel,$con);
        $row=mysql_fetch_array($result);

        $strain_id=$row['StrainID'];
        $graphval=$row['Val1'].",".$row['Val2'].",".$row['Val3'].",".
        $row['Val4'].",".$row['Val5'].",".$row['Val6'].",".$row['Val7'].",".
        $row['Val8'].",".$row['Val9'].",".$row['Val10'].",".$row['Val11'].",".
        $row['Val12'].",".$row['Val13'].",".$row['Val14'].",".$row['Val15'].",".$row['Val16'];
        $strainname=$row['StrainName'];

        if($_REQUEST['act']=="SaveFb"){

            $sql_sel="SELECT COUNT(*) AS NumberOfrec  FROM `FBStrain` WHERE `ChemicalProfileID`=".$profileid;
            $result=mysql_query($sql_sel,$con);
            $row=mysql_fetch_array($result);
            $created_date = date("Y-m-d H:i:s");

            if($row["NumberOfrec"]==0){

                $sql_insert="INSERT INTO `FBStrain`(`ChemicalProfileID`,`Val1`, `Val2`, `Val3`, `Val4`, `Val5`, `Val6`, `Val7`, `Val8`, `Val9`, `Val10`, `Val11`, `Val12`, `Val13`, `Val14`, `Val15`, `Val16`, `ItemName`, `StrainID`, `StrainName`,`ShortUrl`) VALUES ($profileid,$expval[0],$expval[1],$expval[2],$expval[3],$expval[4],$expval[5],$expval[6],$expval[7],$expval[8],$expval[9],$expval[10],$expval[11],$expval[12],$expval[13],$expval[14],$expval[15],'".$strainname."','".$strain_id."','".$strainname."','".$tempenc."')";

                $result=mysql_query($sql_insert,$con);
            }

            $sql_insert1="INSERT INTO `FBSharedStrain`(`ChemicalProfileID`, `DateShared`, `StrainID`, `UserID`, `StrainName`) VALUES ($profileid,'".$created_date."','".$strain_id."','".$userid."','".$strainname."')";
            $result=mysql_query($sql_insert1,$con);
        }
    }

    $sql="select * from ChemicalProfiles where ID=" . $profileid;


    $result=mysql_query($sql,$con);
    $userid="";
    while($row=mysql_fetch_array($result)){
        $userid=$row["UserID"];
        $strain_id=$row["StrainID"];
        $strainname=$row["Name"];

        $comments=$row["Comments"];
        $intmethod=$row["MethodIntake"];
        $howfeel=$row["FeelBefore"];
        $qtytake=0;


        if(($row["QtyIntake"]>=2.5)&&($row["QtyIntake"]<=5)){
            $qtytake=1;
        }

        if(($row["QtyIntake"]>5)&&($row["QtyIntake"]<=20)){
            $qtytake=2;                            }
        if($row["QtyIntake"]>20){
            $qtytake=3;                            }

        $LOL=$row["EffectsLasted"];
        if($LOL<30){
            $LOLindex=0;
        }

        if(($LOL>=30)&&($LOL<60)){
            $LOLindex=1;                            }
        if(($LOL>=60)&&($LOL<120)){
            $LOLindex=2;                            }
        if($LOL>=120){
            $LOLindex=3;
        }                            }


    $sql="SELECT * from StrainChemicals where StrainID='" . $strain_id

    . "' ";

    $result = mysql_query($sql,$con) ;
    $isfound=false;
    if(mysql_num_rows($result)>0)
    $isfound=true;
    if($isfound){
        $row=mysql_fetch_array($result);
        if($row["UserID"]==$userid)
            $isfound=false;
    }


    function doStrainGraph($id,$qtc,$denom){
        if($denom==0){
            return 0;
        }else{

            return $qtc/$denom;
        }
    }
    $sql="SELECT SampleID as StrainID  FROM AppStrains WHERE StrainName = '$strainname'";


    $query = mysql_query($sql);
    if(mysql_num_rows($query)>0){
        $row = mysql_fetch_array($query);
        $strain_id=$row["StrainID"];
    }


    $sql="SELECT c.*,IFNULL(sc.value,'') as Value,IFNULL   (sc.Variance,'') as Variance FROM Chemicals c LEFT  JOIN StrainChemicals sc on c.ID=sc.ChemicalID and   sc.StrainID='" . $strain_id ."' order by Type,ID";


    $result = mysql_query($sql,$con) ;
    // Check connection


    while($row = mysql_fetch_array($result))
    {

        if($type!=$row["Type"])

            $straincontent.='<div class="col-xs-12 text-center details-gray">'.$row["Type"].'</div>';

        $type=$row["Type"];

        $straincontent.= '<div class="form-content"> <div class="col-xs-offset-1 col-xs-7 "><h5>'.$row["Name"].'</h5></div>';

        $straincontent.= '<div class="col-xs-3 form-content">'. $row["Value"] . '</div><label for="percent" class="col-xs-1 clabel-details">'. $row['Unit']  .'</label> </div>';


    }


    $sql="select * from StrainFeelings where ChemicalProfileID=".$profileid;

    $result=mysql_query($sql,$con);
    while($row=mysql_fetch_array($result)){

        $sfArraylist= Array(
                           'happy' => $row["Happy"],
                                'energetic' => $row["Energetic"],
                                'focused' => $row["Focused"],
                                'relaxed' => $row["Relaxed"],
                                'creative' => $row["Creative"],
                                'social' => $row["Social"],
                                'sexual' => $row["Sexual"]
                            //'intelligent' => $row["Intelligent"]
                            );
    }



    $sql="select * from StrainRelief where ChemicalProfileID=".$profileid;
    $result=mysql_query($sql,$con);
    while($row=mysql_fetch_array($result)){

        $migranes=$row["Migraines"];
        $siezure=$row["Siezures"];
        $pain=$row["Pain"];
    }


    $sql="select * from ProfileMedical where ChemicalProfileID=".$profileid;
    $result=mysql_query($sql,$con);
    $i=0;
    while($row=mysql_fetch_array($result))
    {
        if($row['Value']==0){

            $condition=$row["Condition"];
            $rvalue=$row["Value"];

            $relieve.='<div class="row">

            <div class="pagination btn-group" data-toggle="buttons">
            <label class="btn btn-middle-top-detail ">
            <input name="" value="'.$rvalue.'" type="radio">'.$condition.'
            <svg class="stico-add gly-right gly-right-d"><use xlink:href="#icon-add"></use></svg>
            </label>
            <label class="btn btn btn-medium-det">
            <input name="" value="better" class="active" type="radio">
            </label>
            </div>
            </div> ';
            $condtemp.=$condition.',';
        }
        $i++;
    }
    $relieve.='<input type="hidden" value="'.substr($condtemp,0,-1).'" name="relieveval">';
    $fbCond=substr($condtemp,0,-1);
    mysql_close($con);



    ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
<meta name="description" content="MyDx (My Diagnostic) is the world's first portable analyzer for everyone - a simple and affordable device that can detect the chemicals we cannot see.">
<meta name="author" content="Cdxlife">
<link rel="icon" href="../../favicon.ico">

<title><?=$strainname?> Strain Profile</title>

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
<script src="js/raphael.js"></script>
<script src="js/g.raphael-min.js"></script>
<script src="js/g.bar-min.js"></script>
<script>
function showGraph(){
    var r = Raphael("tcprofile");
    txtattr = { font: "12px sans-serif" };
    r.barchart(10, 10, 315, 140, [[<?php echo $graphval ?>]], 0, {type: "sharp"}).attr({fill: "#ff0000"});
};
</script>
<style type="text/css">
.FB_UI_Dialog {
width: 320px !important;
}

</style>
</head>

<body>
<div id="fb-root"></div>

<form class="form" action="strain-profile.php?act=update" method="post" id="strainForms1" name="strainForms1">
<input type="hidden" value="<?=$strain_id?>" name="sid">
<input type="hidden" value="<?=$profileid?>" name="uid">
<input type="hidden" value="<?=$strainname?>" name="strainname">
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

<div id="menu-toggle">

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
<a data-toggle="modal" href="" data-target="#shareModal"><img class="share-button" src="assets/images/share.png"></a>
</div>
<div class=" col-xs-4 text-left socialbuffer">
<h2>Strain Profile For:</h2>
<h2 class="strainsocial"><?=$strainname?></h2>
</div>
<div class="col-xs-5  ratebuffer">

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
<?php
    echo $relieve

    ?>
<!-- end group top row -->
<h4 class="text-center tenbuffer"><span class="ccbold">Helps People Feel</span></h4>
<!--group bottom row -->
<?php


    foreach ( $sfArraylist as $key => $value ){
        //echo "Key: $key, Value: $value\n";
        if($value<5){
            echo' <div class="row">
            <div class="pagination btn-group" data-toggle="buttons">
            <label class="btn btn-middle-top-detail">
            <input name="'.$key.'" value="'.$value.'" type="radio" checked>More '.ucfirst($key).'
            <svg class="stico-add gly-right gly-right-d"><use xlink:href="#icon-add"></use></svg>
            </label>
            <label class="btn btn btn-medium-det-feel">
            <input name="'.$key.'" value="'.$value.'" class="active" type="radio">
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
</div>                    </div>
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
<textarea class="intake" rows="4" readonly><?=$comments?></textarea>
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


<p class="sharel text-center"><a href="mailto:?subject=Please check out this strain&amp;body=Check out this site <?=$fbSURL?>." title="Share by Email">Email</p>
</div>
<div class="shares-modal-footer">
<button type="button" class="btn btn-shares" data-dismiss="modal">Cancel</button>

</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  end modal share -->
<!--  end modal share -->

<!-- modal message -->
<!-- Modal -->
<!--   <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content1">
<div class="modal-body">
<div class="help-modal">
</div>
</div>
<div class="modal-footer">
<button class="btn-modal" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>  -->
<!-- end modal message -->
<div class="footer">
<div class="wrapperfoot"><div class="footlink-social">
<?php
    if($logged){?>
<a href="#" onClick="javascript:document.strainForms1.submit();" style="border: 0;"> ADD TO MY PROFILE +</a>
<?php }else{?>
<a href="register.php" > + NEW USER:REGISTER</a>
<?php }

    ?>
</div>
<div class="containerfoot">


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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/customjs.js"></script>
<script src="js/hide.js"></script>
<script src="js/raphael.js"></script>
<script src="js/g.raphael-min.js"></script>
<script src="js/g.bar-min.js"></script>
<script src="js/fbsdk.js"></script>

<script>


(function() {
 var e = document.createElement('script'); e.async = true;
 e.src = document.location.protocol +
 '//connect.facebook.net/en_US/all.js';
 document.getElementById('fb-root').appendChild(e);
 }());

$(document).ready(function(){
                  $('#share_button').click(function(e){
                                           e.preventDefault();

                                           FB.ui(
                                                 {
                                                 method: 'feed',
                                                 name: '<?=$strainname?> Strain Profile',
                                                 link: '<?=$fbSURL?>',
                                                 picture: '/webapp-demo/assets/images/cdxfbthumb.jpg',
                                                 caption: 'Helps People Relieve <?=$fbCond?>',
                                                 description: '',
                                                 message: ''
                                                 },
                                                 function(response) {
                                                 if (response && response.post_id) {
                                                 console.log('Post was published.');
                                                 window.location.replace("sds.php?act=SaveFb&<?=$qstr?>");
                                                 } else {
                                                 console.log('Post was not published.');
                                                 }
                                                 });

                                           });
                  });

var id='inmethod';
var val='<?php echo $intmethod ?>';
//function setSelectValue (id, val) {
document.getElementById(id).value = val;
//}
var id='fbefore';
var val='<?php echo $howfeel ?>';
document.getElementById(id).value = val;

var id='intakeval';
var val='<?php echo $qtytake ?>';
document.getElementById(id).selectedIndex=val;

var id='leneffect';
var val='<?php echo $LOLindex ?>';
document.getElementById(id).selectedIndex=val;

showGraph();

</script>
</body>
</html>
