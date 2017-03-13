<?php

	include("includes/sessions.php");
	$userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl']; 
	$userg=$_SESSION['user_ug'];
        include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	
    $strefr=explode("?",$_SERVER['HTTP_REFERER']);
	if($strefr[1]!='act=Save'){
		$_SESSION['strainproLP']=$_SERVER['HTTP_REFERER'];
	}
	$STrainID = $_POST['dsid'];
	$STrainName = $_POST['dsid'];
//echo $_POST['dsid']."<br>";	
//echo $_POST['duid']."<br>";	
//echo $_POST['dstrainname']."<br>";
if($_POST['duid']<>""){
	
	$PRofileID=$_POST['duid'];
	
//delete	chemical profile here
	$sql="DELETE FROM `ChemicalProfiles` WHERE `ID`=" . $PRofileID ;
	mysql_query($sql,$con);
//delete strain feelings here	
	$sql1="DELETE FROM `StrainFeelings` WHERE `ChemicalProfileID`=" . $PRofileID ;
	mysql_query($sql1,$con);
//delete profile medical here
	$sql2="DELETE FROM `ProfileMedical` WHERE `ChemicalProfileID`=" . $PRofileID ;
	mysql_query($sql2,$con);
}
//echo $sql."<br>"; 
//echo $sql1."<br>";
//echo $sql2."<br>";
//exit;
header("Location: profile.php#search/");
?>