<?php
//-------------------------------------------------------------------------------------------------
//    @name:      update-strain.inc.php
//    @purpose:   backend of update-strain.php page
//    @category:  Include
//    @author:    Greg E. Salivio 03/24/2015 started
//    @version:   1.0
//    @copyright: cdxlife.com
//
//-------------------------------------------------------------------------------------------------	
	
		if(isset($_SERVER['HTTP_REFERER'])){
	$strefr=explode("?",$_SERVER['HTTP_REFERER']);}
	if(isset($strefr[1])!='act=Save'){
		if(isset($_SERVER['HTTP_REFERER'])){
		$_SESSION['strainproLP']=$_SERVER['HTTP_REFERER'];}
		if(isset($_REQUEST['id'])){
		$_SESSION['search_id']=$_REQUEST['id'];}
	}
   
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
	if(isset($_REQUEST['act'])=="Save"){
        
		$ratings=$_REQUEST['rating'];
		$strain_id=$_REQUEST['sid'];
		$profileid=$_REQUEST['uid'];
		//echo "StrainIDt=".$strain_id;
		$USER_ID=$userid;
        
		$roleid="";
		$error="";
        $migranes="";
     		
		if($strain_id!=""){
			$sql="SELECT * from StrainChemicals where StrainID='" . $strain_id . "' ";
            
			$result = mysql_query($sql,$con) ;
            
			if(mysql_num_rows($result)>0)
				$isfound=true;
		}else{
			$strain_id=time();
			$isfound=false;
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
		
		$straintype=$_POST["straintype"];
		
		
		$HOWMUCH=$_POST['howmuch'];
		$HOWLONG=$_POST['howlong'];
		if($HOWMUCH=="")
			$HOWMUCH=0;
		if($HOWLONG=="")
			$HOWLONG=0;
		$FEELINGSBEFORE=$_POST['feelingsbefore'];
		$INTAKEMETHOD=$_POST['intake'];
        
        
        
		$profileid=$_REQUEST['uid'];
		
		$ispublic=$_REQUEST['savetodb'];
		
		if($ispublic==""){
			$ispublic=0;}
		
			
		$STRAIN_NAME=str_replace("'","''",$STRAIN_NAME);
        
 		$sql="UPDATE ChemicalProfiles set IsPublic=" . $ispublic . ", Comments='" . $comments . "', Name='" . $STRAIN_NAME . "',MethodIntake='" . $INTAKEMETHOD . "',FeelBefore='" . $FEELINGSBEFORE . "',QtyIntake='" . $HOWMUCH . "',EffectsLasted='" . $HOWLONG . "',StrainType='" . $straintype . "' where ID=" . $profileid;
        
        
        //echo "<br>ChemicalProfiles= ".$sql;
        
		mysql_query($sql);
		if($profileid=="")
			$PROFILE_ID=mysql_insert_id();
		else
			$PROFILE_ID=$profileid;
        
        $sql="UPDATE StrainFeelings set Energetic='" . $feelEnergetic . "',Social='" . $feelSocial . "',Focused='" . $feelFocused . "',Relaxed='" . $feelRelaxed . "',Happy='" . $feelHappy . "',Creative='" . $feelCreative . "',Sexual='" . $feelSexual . "' where ChemicalProfileID=" .$profileid;
        
        
        
		mysql_query($sql);
        
		$thc="";
		$cbd="";
		$cbn="";
		$cbg="";
		$thcv="";
		
		//if(!$isfound ||$roleid==0){
 			$sql="delete from StrainChemicals where StrainID='" . $strain_id . "'";
            
			mysql_query("delete from StrainChemicals where StrainID='" . $strain_id . "'");
            
			$sql="SELECT * FROM Chemicals ORDER BY `Type` ASC";
          
			$result = mysql_query($sql,$con) ;
            
            
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
					//echo $sql."<br>";
					mysql_query($sql);
				}
                
			}
			
		//}
		
		$sql="update ChemicalProfiles set THC='" . $thc . "',CBD='" . $cbd . "',CBN='" . $cbn . "',CBG='" . $cbg . "',THCV='" . $thcv . "' where ID=" . $PROFILE_ID;
		mysql_query($sql);
        //echo $sql;
		//exit;
		$aid="";
 		$i =0;
		if(isset($_POST['conditionname'])){
		$t = count($_POST['conditionname']);}
        
		mysql_query("delete from ProfileMedical where ChemicalProfileID="  . $PROFILE_ID);
        
        $i =0;
        $ail=$_POST['aidcount'];
        
        $arrt = explode(",", $ail);
        
		for($x=1;$x<sizeof($arrt);$x++){
			if(isset($x)){
			$aid="ailment_".$x;}
			if(isset($_POST[$aid])){
			$strval=$_POST[$aid];}
			
			if($strval==""){
				$strval=5;
			}
			$str= str_replace("'","''",$arrt[$x]);
			$sql="insert into ProfileMedical (ChemicalProfileID,`Condition`,`Value`) values (" .  $PROFILE_ID . ",'" . $str . "'," .$strval. ")";
            //echo "<br>ProfileMedical= ".$sql;
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
        
		$sqlvalues=$USER_ID. ',' . $PROFILE_ID . "," . $migranes . "," . $siezure. "," .$pain;
         
        $sqlrelieves="update StrainRelief set Migraines=". $migranes . ",Siezures=" . $siezure . ",Pain=" . $pain . " where ChemicalProfileID=" . $profileid;
        
		mysql_query($sqlrelieves);
        
        if($ratings!=-1){
$sqlrate="SELECT `isUP` FROM `StrainRating` WHERE `ChemicalProfileID`=".$PROFILE_ID." AND `UserID`=".$USER_ID;
            $result=mysql_query($sqlrate,$con);
            
            if(mysql_num_rows($result)==0){
                $sqlrateIn="INSERT INTO `StrainRating`(`Name`, `ChemicalProfileID`, `UserID`, `isUP`) VALUES ('".$STRAIN_NAME."','".$PROFILE_ID."','".$USER_ID."',".$ratings.")";
                mysql_query($sqlrateIn);
            }else{
                $sqlrating="UPDATE `StrainRating` set `Name`='".$STRAIN_NAME."', `isUP`=".$ratings." WHERE `ChemicalProfileID`=".$PROFILE_ID;
                mysql_query($sqlrating);}
		}
       // exit;
		mysql_close($con);
	if(isset($_SESSION['search_id'])!=""){
     $gobackurl=$_SESSION['searchLP1'];
      header("Location: $gobackurl");
	}else{
		 header("Location: profile.php#search/");	
	}
	
}
    //end save here
	
include("../deltarfunctions.php");
$profileid="";

if(isset($_REQUEST['sid'])){
$strain_id=$_REQUEST['sid'];}
if(isset($_REQUEST['uid'])){
$profileid=$_REQUEST['uid'];}
	
    if( $profileid!=""){
        $sql="select * from ChemicalProfiles where ID=" . $profileid;
        //$userid="";
    }else{
        $sql="select * from ChemicalProfiles where UserID=" . $userid;
        $profileid="";
    }
    
    $result=mysql_query($sql);
   if ($result !== false) {
    while($row=mysql_fetch_assoc($result)){
		
		$useridC=$row["UserID"];
		$strain_id=$row["StrainID"];
		$strainname=$row["Name"];
		$profileid=$row["ID"];
		$straintype=$row['StrainType'];
		$comments=$row["Comments"];
		$intmethod=$row["MethodIntake"];
		$howfeel=$row["FeelBefore"];
		$ispublicval=$row['IsPublic'];
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
		}                            
	}
   }
    
    
    $sql="SELECT * from StrainChemicals where StrainID='" . $strain_id. "' ";
    
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
	if ($result !== false) {
		while($row = mysql_fetch_array($result))
		{
		
			if($type!=$row["Type"])
			
			$straincontent.='<div class="col-xs-12 text-center details-gray">'.$row["Type"].'</div>';
			
			$type=$row["Type"];
			
			$straincontent.= '
			<div class="form-content">
			<div class="col-xs-offset-1 col-xs-8 ">
			<h5>'.$row["Name"].'</h5>
			</div>';
			
			$straincontent.= '
			<div class="col-xs-2 form-content">
			<input class="form-content1 input-md" id="" type="text" value="'. $row["Value"] . '" name="FIELD_'.$row["ID"].'">
			</div><label for="percent" class="col-xs-1 clabel-end">'. $row["Unit"] . '</label>
			</div>';
		}
	}
	
   
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
   if ($result !== false) {
		$arrayAilment=array();
		//echo $sql."<br>";
		while($row = mysql_fetch_assoc($result))
		{
			$arrayAilment[]=$row;
		}
   }
	function strMatchCondition($cond,$arrail){
		$ii=0;
		foreach ( $arrail as $key => $value ){
			if($cond==$value['Condition']){
				return $value['Value'];
			}
		}
	}
    
    $sql="select * from MedicalConditions where UserID=".$userid." AND IsON=1 order by `Condition`";
    $result=mysql_query($sql);
    
    $i=0;
	$ailArr="";
	$relieve="";
    if(isset($_REQUEST['relieveval'])){
    	$strainfeel=explode(",", $_REQUEST['relieveval']);
	}
	if ($result !== false) {
    while($row=mysql_fetch_array($result))
    {
		
        $i++;
        
        $act1="";
		$act0="";
        $chkb='';
		$chkl='';        $ailment=$row["Condition"];
		$tempval=strMatchCondition($ailment,$arrayAilment);
		
		if($tempval<5){
			$act1="active";
			$chkb='checked';
		}
		if($tempval>9){
			$act0="active";
			$chkl='checked';
		}
        
        $ailArr.= $row["Condition"].",";
		
        $relieve.=' <div class="row">
        <div class="pagination btn-group" data-toggle="buttons">
        <label class="btn btn-st-left  '.$act0.'">
        <input name="ailment_'.$i.'" value="10" type="radio" '.$chkl.'>Worse
        </label>

        <label class="btn btn-middle-top ">
        <svg class="stico-remove gly-left"><use xlink:href="#icon-remove"></use></svg>
        <input name="ailment_'.$i.'" value="5" type="radio">'.$ailment.'
        <svg class="stico-remove gly-right"><use xlink:href="#icon-add"></use></svg>
        </label>
        <label class="btn btn-medium '.$act1.'">
        <input name="ailment_'.$i.'" value="0" class="active" type="radio"  '.$chkb.'>Better
        </label>
        </div>
        </div>';
        
    }
	}
    $relieve.='<input type="hidden" name="aidcount" value="'.substr($ailArr,0,-1).'" />';
    
    
    $sqlrate="SELECT `isUP` FROM `StrainRating` WHERE `ChemicalProfileID`=".$profileid." AND `UserID`=".$userid;
	$result=mysql_query($sqlrate);
	if ($result !== false) {
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result)>0){
			$srating=$row["isUP"];}else{$srating="";}
	}
	
	include("linechart-sql.php");
	
	$sqlm="SELECT * FROM `Measurements` WHERE `ChemicalProfileID`=".$profileid;	
	$result=mysql_query($sqlm);
	if ($result !== false) {
	$row=mysql_fetch_array($result);
	$drstr=$row["Delta1"].",". $row["Delta2"].",".$row["Delta3"]. ",".
		$row["Delta4"]. ",". 
		$row["Delta5"] . ",". 
		$row["Delta6"] . ",". 
		$row["Delta7"] . "," . 
		$row["Delta8"] . "," . 
		$row["Delta9"] . "," . 
		$row["Delta10"]. "," . 
		$row["Delta11"]. ",". 
		$row["Delta12"] . ",". 
		$row["Delta13"]. ",". 
		$row["Delta14"]. ",". 
		$row["Delta15"]. ",". 
		$row["Delta16"];
		
	$graphvalg=GetVisualDeltaRs($drstr);
	}
    
mysql_close();

?>