<?php
	include("includes/sessions.php");
	$userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl'];
	$userg=$_SESSION['user_ug'];
	
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	//include("configdb.php");
	$graphvalg="";
	$srating="";
	$action="";
	include("includes/update-strain.inc.php");
	
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

<title>Update Strain</title>

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
<script src="js/g.line-min.js"></script>

   <?php
   include("includes/scaling.php");
   ?>
<script>
function deleteStrain(){
	
    if (confirm("Are you sure you want to delete?","Delete Strain") == true) {
		document.deleteStrn.submit();}
    
}

function setRatings(id){
	var ratng = document.getElementById('rating');
	if(id=='cl1'){ratng.value=1;}
	if(id=='cl2'){ratng.value=0;}
}
<?php
 function gobackto(){
	 
	 echo '<script>window.history.back();return false;</script>';
 }
?>
</script>
</head>

<body>
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

<h4 class="backnav"><a href="#" onclick="window.history.back();return false;"  ><span class="arrow"></span> BACK </a></h4>

<div id="menu-toggle">

<img src="img/navbut.jpg" alt="Menu"></img>

</div>

<?php
    
    include("includes/side_menu.php");
    
    ?>

<a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>

</div>

</div>

<form class="form" action="update-strain.php?act=Save" method="post" id="strainPForm" name="strainPForm">
<input type="hidden" value="<?=$strain_id?>" name="sid">
<input type="hidden" value="<?=$profileid?>" name="uid">
<input type="hidden" value="<?=$strainname?>" name="strainname">
<input type="hidden" name="rating" id="rating" value="-1">
<!-- end navbar and slide out menu -->

<!-- start sub header section -->

<div class="container top-white">

<div class="row">

<div class="col-xs-3  helpimg">

<a data-toggle="modal" href="apphelp.php" data-target="#helpModal"><img class="no-resize" src="assets/images/need_help.png"></a>

</div>

<div class=" col-xs-4 text-left sprofbufferup">

<input class="form-sprofile" id="demo" placeholder="Strain Profile Name" name="strainname" type="text" value="<?=$strainname?>" >

</div>

<?php
    
	$cl1="";
	$cl2="";
	if($srating!=""){
		if($srating==1){
			$cl1="active";
		}
		if($srating==0){
			$cl2="active";
		}
	}
	
?>
<div class="col-xs-5 ratebuffer">
<p class="ratelabel">Rate</p>
<ul  id="ratings">

<li id="cl1" onClick="setRatings(this.id);" class="ico ico1  <?=$cl1?>"><a href="#"></a></li>

<li id="cl2" onClick="setRatings(this.id);" class="ico ico2  <?=$cl2?>"><a href="#"></a></li>

</ul>

</div>

</div>

</div>

<!-- end sub header section -->

<div class="container">

<div class="row">

<div class="col-xs-12">

<ul class="nav nav-pills pillsbg">

<li class="text-center active prof-pill"><a class="White " href="#one" data-toggle="tab">Feeling</a></li>

<li class="text-center prof-pill pillbord"><a class="White" href="#two" data-toggle="tab">Content</a></li>

<li class="text-center prof-pill-end"><a class="White" href="#twee" data-toggle="tab">Intake Info</a></li>

</ul>

<div class="tab-content tabstyle" >

<!-- start tab pane -->

<div class="tab-pane active" id="one">



<div class="container setcol-feel">

<div class="row">

<div class="center-block strain-col text-center" >

<!-- start buttons -->

<h4 class="text-center"><span class="ccbold">Helps You Relieve</span> (rate each symptom)<a href="settings.php"><img class="setting-profile" src="assets/images/setting-small.png"></a></span></h4>



<!--group top row -->

<?php
    echo $relieve;
?>

<!-- end group top row -->

<h4 class="text-center tenbuffer"><span class="ccbold">Helps You Feel</span> (rate each feeling)</h4>

<!--group bottom row -->
<?php
if(is_array($sfArraylist)){
	foreach ( $sfArraylist as $key => $value ){
        $chkM="";
		$chkL="";
		$chkN="";
		$actvM="";
		$actvN="";
		$actvL="";
		if($value<5){
			$chkM="checked";
			$actvM="active";
		}
		if($value==5){
			$chkN="checked";
			$actvN="active";
		}
		if($value>5){
			$chkL="checked";
			$actvL="active";
		}
        echo'<div class="row">
        <div class="pagination btn-group" data-toggle="buttons">
        <label class="btn btn-st-left-bot '.$actvL.'">
        <svg class="stico-remove gll"><use xlink:href="#icon-remove"></use></svg>
        <input name="'.$key.'" value="10" type="radio" '.$chkL.'>Less '.ucfirst($key).'
        </label>
        <label class="btn btn-middle-bot '.$actvN.'">
        <input name="'.$key.'" value="5" type="radio" '.$chkN.'>
        </label>
        <label class="btn btn-medium-bot '.$actvM.'" >
        <svg class="stico-remove glr"><use xlink:href="#icon-add"></use></svg>
        <input name="'.$key.'" value="0" type="radio" '.$chkM.'>More '.ucfirst($key).'
        </label>
        </div>
        </div>';
        
    }
}
    ?>

<!-- end group bottom row -->

<!-- end buttons -->

</div>

</div>

</div>

<br><br>

</div>

<!-- end tab pane -->

<!-- start tab pane -->

<div class="tab-pane" id="two"><div class="top-buffer"></div>

<div class="container setcol-content fcontent">


<div class="row">
<div class="col-xs-12 text-center">
<?php
$topval="";
$botval="";
if($graphvalg!=""){
	$lht=sortarray($graphvalg);
	$tlht=explode(",",$lht);
	if(array_key_exists('1',$tlht)){
$topval=number_format((float)$tlht[1],5);
$botval=number_format((float)$tlht[0],5);
	}
}
?>
<div class="sidenumtop"><?=$topval?></div>
<div class="sidenumbot"><?=$botval?></div>
<h3 class="tcpdata">Total Chemical Profile</h3>

<div class="mydatachart">
     <div id="savedataHolder"></div>


</div>
</div>

<!-- strain type -->

<div class="form-content">

<div class="col-xs-offset-1 col-xs-8 ">

<h5> Strain Type</h5>

</div>


<div class="col-xs-3 selectstrain">
<?php
if($straintype=="Indica"){
	$ind="selected";
}else{$ind=" ";}
if($straintype=="Sativa"){
	$sat="selected";
}else{$sat=" ";}
?>
<select name="straintype">

<option  value="Hybrid">Hybrid</option>

<option <?=$ind?> value="Indica">Indica</option>

<option <?=$sat?> value="Sativa">Sativa</option>

</select>

</div>

</div>

<!-- strain type -->


<?=$straincontent?>


</div>
<!-- Code for Sensor Chart Goes Here  -->

<?php
if($countm>0){
	echo '<div class="sensorchartarea">';
	echo $divgraph;
	echo '</div>';
}

?>
        <!-- End Sensor Chart Code -->

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

<textarea name="comments" class="intake" rows="4" required><?=$comments?></textarea>

</div>

</div>

</div>

<h5>Intake Method</h5>

<div class="form-horizontal">

<div class="form-group">

<div class="col-xs-12 styled-select">

<select id='inmethod' name="intake">

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

<select id='fbefore' name="feelingsbefore">

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
<?php
$s1='';
if($ispublicval==1){
	$s1='selected';
}

?>
<div class="col-xs-12 styled-select">

<select name="savetodb">

<option value="0">Community Database</option>

<option value="1" <?=$s1?>>Internal Database</option>

</select>

</div>

</div>

</div>

<h5>How Much Did I Intake(mg):</h5>

<div class="form-horizontal">

<div class="form-group">

<div class="col-xs-12 styled-select">

<select id='intakeval' name="howmuch">

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

<select id='leneffect' name="howlong">

<option value="0">0-30</option>

<option value="30" >30 min - 1 hr</option>

<option value="60">1 hr - 2 hrs</option>

<option value="120">>2 hrs</option>

</select>

</div>

</div>

</div>



</div>

</div>

</div>

</div>

<!-- end tab pane -->

</div>

</div>

</div>

</div>



</form>

<form id="deleteStrn" method="post" action="deletestrain.php" name="deleteStrn">
<input type="hidden" value="<?=$strain_id?>" name="dsid">
<input type="hidden" value="<?=$profileid?>" name="duid">
<input type="hidden" value="<?=$strainname?>" name="dstrainname">

</form>





<!-- /container -->

<!-- /container -->

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

<div class="footlink"><a href="#" style="border: 0;"><img onClick="deleteStrain();" class="trash" src="assets/images/trash.png"></img></a><a href="#" onClick="javascript:document.strainPForm.submit();">Update Strain </a></div>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->

<script src="js/bootstrap.min.js"></script>

<script src="js/customjs.js"></script>

<script src="js/hide.js"></script>

<script>

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
</script>
<script>
	window.onload = function () {

 // Total Chemical Profile Chart
  var r = Raphael("savedataHolder"),
  txtattr = { font: "12px sans-serif" };
 r.barchart(0, 0, 250, 90, [[<?php echo $graphvalg ?>]], 0, {type: "sharp"}).attr({fill: "#f36f21"});

 // End Total Chemical Profile Chart
};

<?php
//linechart js here
include("includes/linechart-js.php");

?>
</script>

</body>

</html>