<?php
session_start();
$postdata = $_POST['mraw'];
$getos=$_REQUEST["os"];
$getsm=$_REQUEST["sm"];
$getmp=$_REQUEST["mp"];
$getem=$_REQUEST["em"];
$getui=$_REQUEST["ui"];
$getdrs=$_REQUEST["drs"];

$_SESSION['mraw']=$postdata;
$_SESSION['os']=$getos;
$_SESSION['sm']=$getsm;
$_SESSION['mp']=$getmp;
$_SESSION['em']=$getem;
$_SESSION['ui']=$getui;
$_SESSION['drs']=$getdrs;

header('location:strain-match.php');
exit();
?>