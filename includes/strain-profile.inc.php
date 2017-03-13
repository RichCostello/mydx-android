<?php

//-------------------------------------------------------------------------------------------------
//    @name:      Strain-Profile.inc.php
//    @purpose:   backend of Strain-Profile.php page
//    @category:  Include
//    @author:    Greg E. Salivio 03/10/2015 started
//    @version:   1.0
//    @copyright: cdxlife.com
//
//-------------------------------------------------------------------------------------------------
//
$updateStrn="";	
$issaved="";
$strainname="";
$sfArraylist="";
$ispublicval="";
$intmethod="";
$howfeel="";
$qtytake="";
$LOLindex="";
$siezure="";
$pain="";
$migranes="";
$action="";
$graphval="";

	if(isset($strefr[1])!='act=Save'){
		if(isset($_SERVER['HTTP_REFERER'])){
		$_SESSION['strainproLP']=$_SERVER['HTTP_REFERER'];}
	}
	
	$issaved="";
	
    include("../deltarfunctions.php");
	if(isset($_REQUEST['act'])){
	$updateStrn=$_REQUEST['act'];}
	$ratings=0;
	$STRAIN_NAME="";
	$USER_ID="";

if(isset($_REQUEST['action'])=="Save"){
    
    $ratings=$_REQUEST['rating'];
    
    $USER_ID=$userid;
    $strain_id=$_REQUEST["sid"];
	
	$val=$_REQUEST["deltar"];
   	
	$roleid=$role;
    $error="";
    
   		if($strain_id=="")
			$strain_id= time();
		$isfound=false;
		if($strain_id!=""){
			$sql="SELECT * from StrainChemicals where StrainID='" . $strain_id . "' ";
            
			$result = mysql_query($sql,$con) ;
            
			if(mysql_num_rows($result)>0)
				$isfound=true;
		}
        
        
        
        $feelEnergetic=$_POST['energetic'];
        if($feelEnergetic==""){
            $feelEnergetic=5;
        }
        
        $feelSocial=$_POST['social'];
        if($feelSocial==""){
            $feelSocial=5;
        }
		
        $feelFocused=$_POST['focused'];
        if($feelFocused==""){
            $feelFocused=5;
        }
        
        
        $feelHappy=$_POST['happy'];
        if($feelHappy==""){
            $feelHappy=5;
        }
		
        
        $feelCreative=$_POST['creative'];
        if($feelCreative==""){
            $feelCreative=5;
        }
		
        
        $feelSexual=$_POST['sexual'];
        if($feelSexual==""){
            $feelSexual=5;
        }
        
		
        $feelRelaxed=$_POST['relaxed'];
        if($feelRelaxed==""){
            $feelRelaxed=5;
        }
		
        $comments=$_POST['comments'];
		$comments=str_replace("'","''",$comments);
		$comments=str_replace("--","-",$comments);
        
        
		$STRAIN_NAME=$_POST['strainname'];
		$strain_id=$_POST['sid'];
		if($strain_id=="")
			$strain_id= time();
		else
			$strain_id=str_replace(" ","_",$strain_id);
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
        
       // echo $sql."<br>";
        mysql_query($sql);
       // if($profileid=="")
            $profileid=mysql_insert_id();
        //else
        //    $profileid=$profileid;
        
        
        $sql="INSERT INTO StrainFeelings (ChemicalProfileID,Energetic,Social,Focused,Relaxed,Happy,Creative,Sexual)
        values
        (" . $profileid . "," . $feelEnergetic . "," . $feelSocial . "," . $feelFocused . "," . $feelRelaxed . ","   . $feelHappy . "," . $feelCreative . "," . $feelSexual . ")";
        
        //echo $sql."<br>";
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
            
             // echo $sql."<br>";
            
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
        $sql="update ChemicalProfiles set THC='" . $thc . "',CBD='" . $cbd . "',CBN='" . $cbn . "',CBG='" . $cbg . "',THCV='" . $thcv . "' where ID=" . $profileid;
        //echo $sql."<br>";
	    mysql_query($sql);
        
		$timestmp= date('Y-m-d H:i:s');
				
         $sql1="INSERT INTO `Measurements`(`ChemicalProfileID`, `TimeStamp`, `Delta1`, `Delta2`, `Delta3`, `Delta4`, `Delta5`, `Delta6`, `Delta7`, `Delta8`, `Delta9`, `Delta10`, `Delta11`, `Delta12`, `Delta13`, `Delta14`, `Delta15`, `Delta16`) 
		 VALUES (" . $profileid . ",'". $timestmp."',". $val.")";
    // echo $sql1."<br>";
        mysql_query($sql1);
		
        $i =0;
		
		if(isset($_POST['conditionname'])){
        $t = count($_POST['conditionname']);}
        
        mysql_query("delete from ProfileMedical where ChemicalProfileID="  . $profileid);
        $strval="";
        $i =0;
        $ail=substr($_POST['aidcount'],0,-1);
        $t =explode(",", $ail);
        
        for($x=1;$x<sizeof($t);$x++){
			if(isset($x)){
            $aid="ailment_".$x;}
			if(isset($_POST[$aid])){
            $strval=$_POST[$aid];}
			
            if($strval==""){
                $strval=5;
            }
            $str=str_replace("'","''",$t[$x]);
            $sql="insert into ProfileMedical (ChemicalProfileID,`Condition`,`Value`) values (" .  $profileid . ",'" . $str . "'," .$strval. ")";
            
            mysql_query($sql);
            
            $i++;         
	}
        
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
            $sqlrating="INSERT INTO `StrainRating`(`Name`, `ChemicalProfileID`, `UserID`, `isUP`) VALUES ('".$STRAIN_NAME."','".$profileid."','".$USER_ID."',".$ratings.")";
            mysql_query($sqlrating);
        }
    
    mysql_close();
        
        //exit;
        header("Location: profile.php#search/");
		exit;
    }
    //end save here
    $profileid="";
	$graphvalg="";
     if(isset($_REQUEST['sid'])){
    $strain_id=$_REQUEST['sid'];}
	if(isset($_REQUEST['uid'])){
    $profileid=$_REQUEST['uid'];}
	if(isset($_REQUEST['act'])){
	$action=$_REQUEST['act'];}
	
    if( $profileid!=""){
        $sql="select * from ChemicalProfiles where ID=" . $profileid;
        
    }else{
        $sql="select * from ChemicalProfiles where UserID=" . $userid;
        $profileid="";
    }
    
    $result=mysql_query($sql);
   if ($result !== false) {
    while($row=mysql_fetch_array($result)){
		$useridC=$row["UserID"];
		$strain_id=$row["StrainID"];
		$strainname=$row["Name"];
		$profileid=$row["ID"];
		$straintype=$row['StrainType'];
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
	if ($result !== false) {
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
	if ($query !== false) {
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
	$countm=0;
	if ($result !== false) {
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
				$straincontent.= '<input class="form-content1 input-md" id="" type="text" value="" name="FIELD_'.$row["ID"].'">';
			}
		
			$straincontent.= '</div><label for="percent" class="col-xs-1 clabel-end">'. $row["Unit"] . '</label>
			
			</div>';
		}
	}
   
    if($updateStrn=='update'){
        $sql="select * from StrainFeelings where ChemicalProfileID=".$profileid;
        
        $result=mysql_query($sql);
		if ($result !== false) {
			while($row=mysql_fetch_array($result)){
				
				$sfArraylist= Array(
					 'happy' => $row["Happy"],
					'energetic' => $row["Energetic"],
					'focused' => $row["Focused"],
					'relaxed' => $row["Relaxed"],
					'social' => $row["Social"],
					'creative' => $row["Creative"],
					'sexual' => $row["Sexual"]
						//'intelligent' => $row["Intelligent"]
						);
			}
		}
    }else{
		//if(is_array($sfArraylist)){
			$sfArraylist= Array(
				'happy' => $row["Happy"],
				'energetic' => $row["Energetic"],
				'focused' => $row["Focused"],
				'relaxed' => $row["Relaxed"],
				'social' => $row["Social"],
				'creative' => $row["Creative"],
				'sexual' => $row["Sexual"]
				//'intelligent' => $row["Intelligent"]
				);
		//}
    }
    
    
    
    $sql="select * from StrainRelief where ChemicalProfileID=".$profileid;
    $result=mysql_query($sql);
	if ($result !== false) {
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
	if ($result !== false) {
		while($row = mysql_fetch_assoc($result))
		{
			$arrayAilment[]=$row;
		}
	}
	
	function strMatchCondition($cond,$arrail){
		
		foreach ( $arrail as $key => $value ){
			if($cond===$value['Condition']){
				return $value['Value'];
			}
		}
	}
    
    $sql="select * from MedicalConditions where UserID=".$userid." AND IsON=1 order by `Condition`";
    $result=mysql_query($sql);
    
    $i=0;
    
	//$strainfeel=explode(",", $_REQUEST['relieveval']);
	$ailArr="";
	$relieve="";
	if ($result !== false) {
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
        $sqlrating="INSERT INTO `StrainRating`(`Name`, `ChemicalProfileID`, `UserID`, `isUP`) VALUES ('".$STRAIN_NAME."','".$profileid."','".$USER_ID."',".$ratings.")";
        mysql_query($sqlrating);
    }
	
	// if add new dont show this and the bottom of the graph
	if($action!="new"){
	include("linechart-sql.php");
	
	$sqlm="SELECT * FROM `Measurements` WHERE `ChemicalProfileID`=".$profileid;	
	$result=mysql_query($sqlm);
	if ($result !== false) {
		$row=mysql_fetch_array($result);
		
		$graphval=$row["Delta1"]. ",".$row["Delta2"]. ",".$row["Delta3"]. ",".
		$row["Delta4"]. ",".$row["Delta5"]. ",".$row["Delta6"]. ",".$row["Delta7"]. ",".
		$row["Delta8"]. ",".$row["Delta9"]. ",".$row["Delta10"]. ",".$row["Delta11"]. ",".
		$row["Delta12"]. ",".$row["Delta13"]. ",".$row["Delta14"]. ",".$row["Delta15"]. ",".$row["Delta16"];	
	}
	$graphvalg= GetVisualDeltaRs($graphval);
	
	}
    mysql_close();
    
    
?>