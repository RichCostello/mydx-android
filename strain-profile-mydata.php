<?php
	
	include("includes/sessions.php");      
        //Added for back button issues By Empower Team
	header("Cache-Control: max-age=200000");
        
	$userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl'];
	$userg=$_SESSION['user_ug'];
	
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	//include("configdb.php");
 
     include("../deltarfunctions.php");
	
	$ss="";$ui="";$sm="";$mp="";$em="";
	$graphval="";$mraw="";$action="";$ispublicval=0;
	$profileid="";$xvalue=16;$strain_id="";
	$updateStrn="";	$issaved="";$strainname="";$sfArraylist="";
	$intmethod="";$howfeel="";$qtytake="";$LOLindex="";$siezure="";
	$pain="";$migranes="";$feelSocial="";$feelFocused="";$feelSexual="";


	if(isset($_REQUEST['measurementsraw'])){
		$mraw=$_REQUEST['measurementsraw'];}
	if(isset($_REQUEST['act'])){
		$updateStrn=$_REQUEST['act'];}
	if(isset($_REQUEST['drs'])){
		$graphval=$_REQUEST['drs'];}
	if(isset($_REQUEST['s'])){
		$ss=$_REQUEST['s'];}
	if(isset($_REQUEST['ui'])){
		$ui=$_REQUEST['ui'];}
	if(isset($_REQUEST['sm'])){
		$sm=$_REQUEST['sm'];}
	if(isset($_REQUEST['mp'])){
		$mp=$_REQUEST['mp'];}
	if(isset($_REQUEST['em'])){
		$em=$_REQUEST['em'];}
	$param=$ss.",".$ui.",".$sm.",".$mp.",".$em;
	
	$graphvalg=GetVisualDeltaRs($graphval);
			
			
	
if(isset($_REQUEST['action'])=="Save"){
    $measurements=$_REQUEST['mraws'];
    $ratings=$_REQUEST['rating'];
    $val=$_REQUEST['deltar'];
    $USER_ID=$userid;
	if(isset($_POST["strainid"])){
    $strain_id=$_POST["strainid"];}
	
    $roleid=$role;
    $error="";
    
	//this is the s,ui,sm,mp,em
	$strparam=explode(",",$_REQUEST['qstrmatch']);
	$sampid=$strparam[0];	
	$uid=$strparam[1];
	
	$isfound=false;
	if($strain_id!=""){
		$sql="SELECT * from StrainChemicals where StrainID='" . $strain_id . "' ";
		
		$result = mysql_query($sql,$con) ;
		
		if(mysql_num_rows($result)>0)
			$isfound=true;
	}
	
	
	if(isset($_POST["energetic"])){
	$feelEnergetic=$_POST['energetic'];}
	if($feelEnergetic==""){
		$feelEnergetic=5;
	}
	if(isset($_POST["social"])){
	$feelSocial=$_POST['social'];}
	if($feelSocial==""){
		$feelSocial=5;
	}
	if(isset($_POST["focused"])){
	$feelFocused=$_POST['focused'];}
	if($feelFocused==""){
		$feelFocused=5;
	}
	
	if(isset($_POST["happy"])){
	$feelHappy=$_POST['happy'];}
	if($feelHappy==""){
		$feelHappy=5;
	}
	
	if(isset($_POST["creative"])){
	$feelCreative=$_POST['creative'];}
	if($feelCreative==""){
		$feelCreative=5;
	}
	
	if(isset($_POST["sexual"])){
	$feelSexual=$_POST['sexual'];}
	if($feelSexual==""){
		$feelSexual=5;
	}
	
	if(isset($_POST["relaxed"])){
	$feelRelaxed=$_POST['relaxed'];}
	if($feelRelaxed==""){
		$feelRelaxed=5;
	}
	
	$comments=$_POST['comments'];
	$comments=str_replace("'","''",$comments);
	$comments=str_replace("--","-",$comments);
	
	
	$STRAIN_NAME=$_POST['strainname'];
	
	if($strain_id==""){
		$strain_id= time();}
	else{
		$strain_id=str_replace(" ","_",$strain_id);}
		
	$straintype=$_POST["straintype"];
	
	$HOWMUCH=$_POST['howmuch'];
	$HOWLONG=$_POST['howlong'];
	if($HOWMUCH=="")
		$HOWMUCH=0;
	if($HOWLONG=="")
		$HOWLONG=0;
	$FEELINGSBEFORE=$_POST['feelingsbefore'];
	$INTAKEMETHOD=$_POST['intake'];
	
	$ispublic=$_REQUEST['savetodb'];
	
	if($ispublic==""){
		$ispublic=0;}
	
	$STRAIN_NAME=str_replace("'","''",$STRAIN_NAME);
        
        $sql="INSERT INTO  ChemicalProfiles (Name,StrainID,UserID,MethodIntake,FeelBefore,QtyIntake,EffectsLasted,DateTested,Comments,IsPublic,StrainType) values ('" . $STRAIN_NAME . "','" . $strain_id . "'," . $USER_ID . ",'" .
        $INTAKEMETHOD . "','" . $FEELINGSBEFORE . "','" . $HOWMUCH . "','" . $HOWLONG . "',now(),'" . $comments . "'," . $ispublic . ",'" . $straintype . "')";
        
        
        mysql_query($sql);
        if($profileid=="")
            $PROFILE_ID=mysql_insert_id();
        else
            $PROFILE_ID=$profileid;
			
        
        $sql="INSERT INTO StrainFeelings (ChemicalProfileID,Energetic,Social,Focused,Relaxed,Happy,Creative,Sexual)
        values
        (" . $PROFILE_ID . "," . $feelEnergetic . "," . $feelSocial . "," . $feelFocused . "," . $feelRelaxed . ","   . $feelHappy . "," . $feelCreative . "," . $feelSexual . ")";
        
        
        
        mysql_query($sql);
        
        $thc="";
        $cbd="";
        $cbn="";
        $cbg="";
        $thcv="";
        
        if(!$isfound ||$roleid==0){
            $sql="delete from StrainChemicals where StrainID='" . $strain_id . "'";
            
            mysql_query("delete from StrainChemicals where StrainID='" . $strain_id . "'");
            
            
            $sql="SELECT * FROM Chemicals ORDER BY `Type` ASC";
            
            $result = mysql_query($sql,$con) ;
            
            if ($result !== false){
            
            while($row = mysql_fetch_array($result))
            {
                
                
                if($_POST['FIELD_' . $row["ID"]]!=""){
                    
                    if($row["ID"]=="2")
                        $thc=$_POST['FIELD_' . $row["ID"]];
                    if($row["ID"]=="3")
                        $cbd=$_POST['FIELD_' . $row["ID"]];
                    if($row["ID"]==4)
                        $cbn=$_POST['FIELD_' . $row["ID"]];
                    if($row["ID"]==5)
                        $cbg=$_POST['FIELD_' . $row["ID"]];
                    if($row["ID"]==6)
                        $thcv=$_POST['FIELD_' . $row["ID"]];
                    $sql="insert into StrainChemicals (ChemicalID,StrainID,Value) values (" . $row["ID"] . ",'" . $strain_id . "'," . $_POST['FIELD_' . $row["ID"]].")";
                    mysql_query($sql);
                }
                
            }
			}
            
        }
		
		
		$timestmp= date('Y-m-d H:i:s');
				
         $sql1="INSERT INTO `Measurements`(`ChemicalProfileID`, `TimeStamp`, `Delta1`, `Delta2`, `Delta3`, `Delta4`, `Delta5`, `Delta6`, `Delta7`, `Delta8`, `Delta9`, `Delta10`, `Delta11`, `Delta12`, `Delta13`, `Delta14`, `Delta15`, `Delta16`,`StrainID`, `UserID`) 
		 VALUES (" . $PROFILE_ID . ",'". $timestmp."',". $val.",'".$strain_id."','".$USER_ID."')";
    
        mysql_query($sql1);
		
		
		
		$sensorarr=explode("\n",$measurements);
		if($measurements!=""){
			for($x=0;$x<sizeof($sensorarr);$x++){
				$columnnames="";
				$valuenames="";
				$rowstr=$sensorarr[$x];
				$rowarr=explode(",",$rowstr);
			
				for($y=0;$y<sizeof($rowarr);$y++){
					if($columnnames!="")
					{
						$columnnames.=",";
						$valuenames.=",";
					}
					$colname="Sensor" . ($y+1);
					$columnnames.=$colname;
					$valuenames.=$rowarr[$y];
				}
			
				if($columnnames!=""){
					$columnnames="(ChemicalProfileID," . $columnnames . ")";
					$valuenames="(" . $PROFILE_ID . "," . $valuenames . ")";
					$sql="INSERT INTO MeasurementsRaw " . $columnnames . " VALUES " . $valuenames;		
					//echo($sql."<BR>");
					mysql_query($sql);
				
				}
			}
		}
		
        $sql="update ChemicalProfiles set THC='" . $thc . "',CBD='" . $cbd . "',CBN='" . $cbn . "',CBG='" . $cbg . "',THCV='" . $thcv . "' where ID=" . $PROFILE_ID;
        mysql_query($sql);
        
        $i =0;
       if(isset($_POST['conditionname'])){
        $t = count($_POST['conditionname']);}
        
        mysql_query("delete from ProfileMedical where ChemicalProfileID="  . $PROFILE_ID);
        
        $i =0;
        $ail=substr($_POST['aidcount'],0,-1);
        $t =explode(",", $ail);
        
        for($x=1;$x<sizeof($t);$x++){
            $aid="ailment_".$x;
            $strval=$_POST[$aid];
            if($strval==""){
                $strval=5;
            }
            $str=str_replace("'","''",$t[$x]);
            $sql="insert into ProfileMedical (ChemicalProfileID,`Condition`,`Value`) values (" .  $PROFILE_ID . ",'" . $str . "'," .$strval. ")";
            
            mysql_query($sql);
            
            $i++;         }
        
       
       if(isset($_POST['migraines'])){
			$migranes=$_POST['migraines'];
			}
			
		if(isset($_POST['siezures'])){
			$siezure=$_POST['siezures'];
			}
		if(isset($_POST['pain'])){
			$pain=$_POST['pain'];
			}
			
        $sqlfields="UserID,ChemicalProfileID,Migraines,Siezures,Pain";
        $sqlvalues=$USER_ID. ',' . $profileid . "," . $migranes . "," . $siezure . "," . $pain;
        
    
        $sqlrelieves="insert into StrainRelief (" . $sqlfields . ") VALUES (" . $sqlvalues . ")";
		//echo $sqlfields."<br>";
		mysql_query($sqlrelieves);
        
        if($ratings!=-1){
            $sqlrating="INSERT INTO `StrainRating`(`Name`, `ChemicalProfileID`, `UserID`, `isUP`) VALUES ('".$STRAIN_NAME."','".$PROFILE_ID."','".$USER_ID."',".$ratings.")";
            mysql_query($sqlrating);
        }
    
    mysql_close($con);
        
        
        header("Location: profile.php#search/");
    }
    //end save here
	$strain_id="";
	$profileid="";
	$strainname="";
	
    if(isset($_REQUEST['sid'])){
    $strain_id=$_REQUEST['sid'];}
	if(isset($_REQUEST['uid'])){
    $profileid=$_REQUEST['uid'];}
	//echo "filed 46=".$_REQUEST['FIELD_46'];
	//echo "<br>filed 2=".$_GET['FIELD_2'];
    if( $profileid!=""){
        $sql="select * from ChemicalProfiles where ID=" . $profileid;
        
    }else{
        $sql="select * from ChemicalProfiles where UserID=" . $userid;
        $profileid="";
    }
    
    $result=mysql_query($sql);
    if ($result !== false){
    while($row=mysql_fetch_array($result)){
		$useridC=$row["UserID"];
		$strain_id=$row["StrainID"];
		$strainname=$row["Name"];
		$profileid=$row["ID"];
		$ispublicval=$row['IsPublic'];
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
    
	}
    
    $sql="SELECT * from StrainChemicals where StrainID='" . $strain_id
    
    . "' ";
    
    $result = mysql_query($sql) ;
    $isfound=false;
	
	if ($result !== false){
		if(mysql_num_rows($result)>0)
		$isfound=true;
		if($isfound){
			$row=mysql_fetch_array($result);
			if($row["UserID"]==$userid)
				$isfound=false;
		}
	}
    
    
    
    $sql="SELECT SampleID as StrainID  FROM AppStrains WHERE StrainName = '$strainname'";
    
    $query = mysql_query($sql);
	if ($query !== false){
		if(mysql_num_rows($query)>0){
			$row = mysql_fetch_array($query);
			$strain_id=$row["StrainID"];
		}
	}
    
    $sql="SELECT c.*,IFNULL(sc.value,'') as Value,IFNULL
    (sc.Variance,'') as Variance FROM Chemicals c
    LEFT  JOIN StrainChemicals sc on c.ID=sc.ChemicalID and
    sc.StrainID='" . $strain_id ."' order by Type,ID";
    
    
    $result = mysql_query($sql) ;
    // Check connection
    
    $type="";
	$straincontent="";
	$updateStrn="";
	$tempval="";
	if ($result !== false){
    while($row = mysql_fetch_array($result))
    {
		
		if($type!=$row["Type"])
            
            $straincontent.='<div class="col-xs-2 col-xs-offset-5">'.$row["Type"].'</div>';
        
		$type=$row["Type"];
        
		$straincontent.= '
		<div class="form-content">
        
        <div class="col-xs-offset-1 col-xs-8 ">
        
        <h5>'.$row["Name"].'</h5>
        
        </div>';
        
		$straincontent.= '
		<div class="col-xs-2 form-content">';
        if($updateStrn=='update'){
            $straincontent.= '<input class="form-content1 input-md" id="" type="text" value="'. $row["Value"] . '" name="FIELD_'.$row["ID"].'">';
		}else{
			$gvalid='FIELD_'.$row["ID"];
			//$tempval=$_GET[$gvalid];
			if(isset($_REQUEST[$gvalid])){
			$tempval=$_REQUEST[$gvalid];}
			//echo 
            $straincontent.= '<input class="form-content1 input-md" id="" type="text" value="'.$tempval.'" name="FIELD_'.$row["ID"].'">';
		}
        
        $straincontent.= '</div><label for="percent" class="col-xs-1 clabel-end">'. $row["Unit"] . '</label>
        
        </div>';
    }
	}
    
    if($updateStrn=='update'){
        $sql="select * from StrainFeelings where ChemicalProfileID=".$profileid;
        
        $result=mysql_query($sql);
		if ($result !== false){
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
		}
    }else{
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
    $result=mysql_query($sql);
   if ($result !== false){
		while($row=mysql_fetch_array($result)){
			
			$migranes=$row["Migraines"];
			$siezure=$row["Siezures"];
			$pain=$row["Pain"];
		}
	}
    $sql="SELECT  `Value`,  `Condition` FROM  `ProfileMedical` WHERE  `ChemicalProfileID`=".$profileid;
   	$result=mysql_query($sql);
   	$arrayAilment=array();
	//echo $sql."<br>";
	 if ($result !== false){
		while($row = mysql_fetch_assoc($result))
		{
			$arrayAilment[]=$row;
		}
	 }
	 
	function strMatchCondition($cond,$arrail){
		
		foreach ( $arrail as $key => $value ){
			if($cond===$value[Condition]){
				return $value[Value];
			}
		}
	}
    
    $sql="select * from MedicalConditions where UserID=".$userid." AND IsON=1 order by `Condition`";
    $result=mysql_query($sql);
    
    $i=0;
    
	//$strainfeel=explode(",", $_REQUEST['relieveval']);
	$ailArr="";
	$relieve="";
	$ratings=0;
	if ($result !== false){
    while($row=mysql_fetch_array($result))
    {
		
        $i++;
		$act1="";
		$act0="";
		$chkb='';
		$chkl='';
		$ailment=$row["Condition"];
        if($updateStrn=='update'){
			$tempval=strMatchCondition($ailment,$arrayAilment);
			
			if($tempval<5){
                $act1="active";
                $chkb='checked';
            }
            if($tempval>9){
                $act0="active";
                $chkl='checked';
            }
		}
        
        $ailArr.=$ailment.",";
		
        $relieve.=' <div class="row">
        <div class="pagination btn-group" data-toggle="buttons">
        <label class="btn btn-st-left">
        <input name="ailment_'.$i.'" value="10" type="radio"  '.$chkl.'>Worse
        </label>
        <label class="btn btn-middle-top ">
        <svg class="stico-remove gly-left"><use xlink:href="#icon-remove"></use></svg>
        <input name="ailment_'.$i.'" value="5" type="radio">'.$ailment.'
        <svg class="stico-remove gly-right"><use xlink:href="#icon-add"></use></svg>
        </label>
        <label class="btn btn-medium  '.$act1.'">
        <input name="ailment_'.$i.'" value="0" class="active" type="radio"  '.$chkb.'>Better
        </label>
        </div>
        </div>';
        
        
    }
	}
    $relieve.='<input type="hidden" name="aidcount" value="'.$ailArr.'" />';
    
	if($ratings!=-1){
        $sqlrating="INSERT INTO `StrainRating`(`Name`, `ChemicalProfileID`, `UserID`, `isUP`) VALUES ('".$strainname."','".$profileid."','".$userid."',".$ratings.")";
        mysql_query($sqlrating);
    }
	
	include("includes/linechart-sql.php");	
	
    mysql_close();
    
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

<title>Strain Profile Save to Data</title>

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
   <?php
   include("includes/scaling.php");
   ?>
<script>
function submitFrm(){
    var cl1val=document.getElementById('cl1').className;
	var cl1va2=document.getElementById('cl2').className;
	if(cl1val=='ico ico1 active icotoggle' || cl1va2=='ico ico2 active icotoggle2'){
		document.getElementById('rating').value=-1;
    }	if(document.getElementById('strainname').value!=""){
		document.strainPForm.submit();
	}else{
		var inermsg=document.getElementById('errcont');
        inermsg.innerHTML='Strain Profile Name is required.';
        //alert('Strain Profile Name is required.');
        document.getElementById('strainname').focus();
        $('#errorModal').modal();
        
	}
	
}
function setRatings(id){
	var ratng = document.getElementById('rating');
	
	if(id=='cl1'){ratng.value=1;}
	if(id=='cl2'){ratng.value=0;}
	
}
</script>  </head>

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

<h4 class="backnav"><a href="#" onclick="window.history.back();return false;" ><span class="arrow"></span> BACK </a></h4>

<div id="menu-toggle">

<img src="img/navbut.jpg" alt="Menu"></img>

</div>

<?php
    
    include("includes/side_menu.php");
    
    ?>

<a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>

</div>

</div>

<form class="form" action="?action=Save" method="post" id="strainPForm" name="strainPForm">
<input type="hidden" name="rating" id="rating" value="-1">
<input type="hidden" name="deltar"  value="<?=$graphval?>">
<input type="hidden" name="qstrmatch"  value="<?=$param?>">
<input type="hidden" name="mraws"  value="<?=$mraw?>">
<!-- end navbar and slide out menu -->

<!-- start sub header section -->

<div class="container top-white">

<div class="row">

<div class="col-xs-3  helpimg">

<a data-toggle="modal" href="apphelp.php" data-target="#helpModal"><img src="assets/images/need_help.png"></a>

</div>

<div class=" col-xs-4 text-left sprofbuffer">
<?php
    if($updateStrn!="update"){
        $strainname="";
    }
    ?>
<input class="form-sprofile" name="strainname" id="strainname" autofocus placeholder="Strain Profile Name" type="text"  value="<?=$strainname?>">

</div>

<div class="col-xs-5 ratebuffer">
<p class="ratelabel">Rate</p>
<ul  id="ratings">

<li id="cl1" class="ico ico1" onClick="setRatings(this.id);"><input type="hidden" value="0"><a href="#"></a></li>

<li id="cl2" class="ico ico2" onClick="setRatings(this.id);"><a href="#"><input type="hidden" value="1"></a></li>

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
    
    ?><!-- end group top row -->





<h4 class="text-center tenbuffer"><span class="ccbold">Helps You Feel</span> (rate each feeling)</h4>

<!--group bottom row -->
<?php
    //	echo sizeof($sfArraylist);
	
	
    if($updateStrn!="update"){
        foreach ( $sfArraylist as $key => $value ){
            
            
            echo'
            <div class="row">
            <div class="pagination btn-group" data-toggle="buttons">
            <label class="btn btn-st-left-bot">
            <svg class="stico-remove gll"><use xlink:href="#icon-remove"></use></svg>
            <input name="'.$key.'" value="10" type="radio">Less '.ucfirst($key).'
            </label>
            <label class="btn btn-middle-bot active">
            <input name="'.$key.'" value="5" type="radio">
            </label>
            <label class="btn btn-medium-bot">
            <svg class="stico-remove glr"><use xlink:href="#icon-add"></use></svg>
            <input name="'.$key.'" value="0" type="radio">More '.ucfirst($key).'
            </label>
            </div>
            </div> ';
            
        }
    }else{
        
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

<div class="tab-pane" id="two"><div class="top-buffer-feel"></div>

<div class="container setcol-mydata fcontent">
<div class="row">
<div class="col-xs-12 text-center">
<?php
$topval=0;
$botval=0;
if ($action != "new") {
    if ($graphvalg != "") {
        $lht = sortarray($graphvalg);
        $tlht = explode(",", $lht);
    } 
 
 $topval=number_format((float)$tlht[1], 5);
 $botval=number_format((float)$tlht[0], 5);
?>
<div class="sidenumtop"><?= $topval?></div>
<div class="sidenumbot"><?= $botval?></div>
<h3 class="tcpdata">Total Chemical Profile</h3>
<div class="mydatachart">
    <div id="savedataHolder"></div>
</div>
<?php } ?>
 <div class="savetodata"><p class="bot-result-text">Help Us Improve Our Database</p> </div>
</div>

<!-- strain type -->

<div class="form-content">

<div class="col-xs-offset-1 col-xs-8 ">

<h5> Strain Type</h5>

</div>


<div class="col-xs-3 selectstrain">

<select name="straintype">
<option value="Hybrid"></option>

<option value="Hybrid">Hybrid</option>

<option value="Indica">Indica</option>

<option value="Sativa">Sativa</option>

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
<?php
    if($updateStrn!='update'){
        $comments="";
    }
    ?>
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

<!-- /container -->

<!-- /container -->

<!-- error modal -->
<div class="modal ercustom" id="errorModal">
<div class="modal-dialog">
<div class="modal-canna">
<div class="modal-header-canna">
<button type="button" class="close" data-dismiss="modal"></button>
<h4 class="modal-title text-center errorm" >Strain Profile</h4>
<div class="text-center errorp">
<p id="errcont"></p>
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
<!-- error modal -->

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

<div class="footmydata"><a href="#" onClick="submitFrm();" style="border: 0;">Save To MyData +</a></div>

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
<script src="js/raphael.js"></script>
<script src="js/g.raphael-min.js"></script>
<script src="js/g.bar-min.js"></script>
<script src="js/g.line-min.js"></script>

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