<?php

//include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');;

// Try Sensor 10 first , 14 then 3

// 1,16 ignore maybe remove 15













include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');;


//echo "1";
function getvectorarray($sensorarr,$userid,$gid){

	$sql="select m.ID,m.ChemicalProfileID, cp.Name ";
	$from=" from Measurements m 
		inner join ChemicalProfiles cp on m.ChemicalProfileID=cp.ID  ";

	$arr=$sensorarr;
	$values=$arr;
	
	
	$sqlstrtooutput="";
	$igid=-11111;
	if($gid!=""){
		$igid=$gid;
	}
	$total=0;
	
	
	
	
	
	
	$indexes = array(0 =>1,0 => 9,1=>13,2=>2);
	
	
	for($in=0;$in<sizeof($indexes);$in++){
		//$x=$indexes[$in];
		for($x=0;$x<16;$x++)
		{
			for($y=0;$y<16;$y++){
			
			
				$fldname="m.Delta" . ($y+1);
				$fldnamenext="m.Delta" . ($x+1);
				$fldindex="m.Delta" . ($indexes[$in] + 1);
				
				
			
				
				
				$slope="ABS(" . $arr[$x] . "/" . $arr[$y] . ")";
				$dataslope="ABS(" . $fldnamenext . "/". $fldname . ")";
				
				if($in>0){
					$slope="ABS(" . $arr[$x] . "/" . $arr[$y] . "/" . $arr[$indexes[$in]] . ")";
					$dataslope="ABS(" . $fldnamenext . "/". $fldname . "/" . $fldindex .  ")";
				}
				$range=" (ABS(" . $slope . " - ABS(" . $fldnamenext . "/". $fldname . "))) ";
				$currentfld=$x+1;
				$otherfld= ", " . ($x) . " as sensora, " . ($y) . " as sensorb ";
			
				$otherfld.=", IF(" . $dataslope . ">" . $slope . "," . $slope . "/" .$dataslope . "," . $dataslope . "/" . $slope . ") as rank ";
				
				$addedwhere="";
				$stom=$_GET["sn"];
				if($_GET["sn"]!="")
					$addedwhere=" and cp.Name like '%$stom%' ";
				$segment="(m.SampleID='S2' or m.SampleID='S3' or m.SampleID is null)";
				if($_GET["se"]!="")
					$segment="(m.SampleID='" . $_GET["se"] . "')";
				$tsql=$sql . $otherfld .   $from .  " where   m.ID!=" . $igid . " and m.ChemicalProfileID>1 and " . $segment . " and  m.UserID='" . $userid . "' $addedwhere order by rank desc limit 0,1";
			
			

			
				if($arr[$x]<.1 && $arr[$y]<.1 && $x!=0  && $x!=15 && $y!=0 && $y!=15 && $x!=3&& $y!=3 &&$x!=$y){
					$total++;
					if($sqlstrtooutput!="")
						$sqlstrtooutput.=" UNION ALL <BR>";
				
					$sqlstrtooutput.="(" . $tsql . ") ";
			
			
				}
			}
	
		}
	}
	
	
	

	/*	
	
	
	
	
	
	for($x=0;$x<16;$x++)
	{
		for($y=0;$y<16;$y++){
			$fldname="m.Delta" . ($y+1);
			$fldnamenext="m.Delta" . ($x+1);
			
			
			
			$slope="ABS(" . $arr[$x] . "/" . $arr[$y] . ")";
			$dataslope="ABS(" . $fldnamenext . "/". $fldname . ")";
			
			$range=" (ABS(" . $slope . " - ABS(" . $fldnamenext . "/". $fldname . "))) ";
			$currentfld=$x+1;
			$otherfld= ", " . ($x) . " as sensora, " . ($y) . " as sensorb ";
			
			$otherfld.=", IF(" . $dataslope . ">" . $slope . "," . $slope . "/" .$dataslope . "," . $dataslope . "/" . $slope . ") as rank ";
			$tsql=$sql . $otherfld .   $from .  " where m.ID!=" . $igid . " and m.ChemicalProfileID>1 and  m.UserID='" . $userid  . "' order by rank desc limit 0,1";
			
		

			
			if($arr[$x]<.1 && $arr[$y]<.1){
				$total++;
				if($sqlstrtooutput!="")
					$sqlstrtooutput.=" UNION ALL <BR>";
				
				$sqlstrtooutput.="(" . $tsql . ") ";
			
			
			}
		}
	
	}	
	
	*/
	
	
	$sqlstrtooutput="SELECT t.ID,t.Name,t.ChemicalProfileID,COUNT(t.Name) as cnt,avg(t.rank) as rnk, (COUNT(t.Name) * t.rank) as newrank  from (" . $sqlstrtooutput . ") as t group by t.ID order by newrank desc LIMIT 0,200";
	
	
	$stom=$_GET["sn"];
	if($_GET["sn"]!="")
		$addedwhere=" and cp.Name like '%$stom%' ";
	$segment="(m.SampleID='S2' or m.SampleID='S3' or m.SampleID is null)";
	if($_GET["se"]!="")
		$segment="(m.SampleID='" . $_GET["se"] . "')";
	$tsql=$sql . $otherfld .   $from .  " where   m.ID!=" . $igid . " and m.ChemicalProfileID>1 and " . $segment . " and  m.UserID='" . $userid . "' $addedwhere order by rank desc limit 0,1";
			
	
	
	$sqlstrtooutput="SELECT m.ID,cp.Name,m.ChemicalProfileID,55 as cnt,55 as rnk, 55 as newrank  from 
	Measurements m 
	inner join ChemicalProfiles cp on m.ChemicalProfileID=cp.ID 
	where m.UserID='" . $userid . "' and m.ID!=" . $igid . " and " . $segment . " " . $addedwhere;
	
	
	
	$res=mysql_query(str_replace("<BR>","",$sqlstrtooutput));
	$numrows=mysql_num_rows($res);
	
	if($_GET['ssql']=="1")
		echo("<BR>" . $sqlstrtooutput . "<BR>");
	
	$matches="";
	
	while($row = mysql_fetch_array($res)){
		//21630,Northern Lights,0.41463414634146,68
		$num=$row["cnt"];
		$perc=$num/$total;
		
		if($matches!="")
			$matches.="~";
		
		$matches=$matches . $row["ChemicalProfileID"] . "," . $row["Name"] . "," . $perc . "," . $num . "," . $total . "," . $row["ID"];
		//echo $row["ChemicalProfileID"] . "<BR><BR>";
		//$matchcp.= $row["ChemicalProfileID"].",";
		
	}
	//echo($matches);
	return $matches;
}
	//echo "<br>2";
function delarray($searchitem, $array){
	if (in_array($searchitem, $array)) 
		{
			unset($array[array_search($searchitem,$array)]);
			return $array;
		}
			return 0;
	}

function arrangearr($deltar){
		$deltasmarr=array();
		$i=0;
		foreach($deltar as $k => $item)
		{
			$deltasmarr[$i]=$item;
			unset($deltar[$k]);
			$i++;
		}
		//echo $i.",";
		if($i>0){
			return $deltasmarr;
		}else{
			return 0;
		}
		
	}


	
	
function searchmathc($matchstr){

//echo '<pre>'; print_r($matchstr); echo '</pre>';
$x=0;
for($y1=0;$y1<=sizeof($matchstr);$y1++){

   $sql1="select * from Measurements where ChemicalProfileID=".$matchstr[$y1];
   $res1=mysql_query($sql1);

   while($row = mysql_fetch_array($res1)){
	  $data[$x]=array($row["ChemicalProfileID"],1=>$row["Delta1"],2=>$row["Delta2"],3=>$row["Delta3"],4=>$row["Delta4"],5=>$row["Delta5"],6=>$row["Delta6"],7=>$row["Delta7"],8=>$row["Delta8"],9=>$row["Delta9"],10=>$row["Delta10"],11=>$row["Delta11"],12=>$row["Delta12"],13=>$row["Delta13"],14=>$row["Delta14"],15=>$row["Delta15"],16=>$row["Delta16"]);
		
	  $x++;
    }
}
    return $data;
  
}
	
$matchesout=array();
$deltasmarr=array();
$arrsize=0;

//echo "<br>3";

function searchformatch($sens,$usid,$gid){
$sens1=$sens;
 //echo '<pre>'; print_r($sens); echo '</pre>';
	$i=1;
    foreach($sens as $k => $item)
    {
      $deltasmarr[$i]=$item;
      unset($sens[$k]);
      $i++;

    }
 //echo '<pre>'; print_r($deltasmarr); echo '</pre>';
	$matchesout=getvectorarray($sens1,$usid,$gid );	
	
	
	return $matchesout;
	
	/*
	
    $matches=array();	
    $matches=explode("~",$matchesout);
    //echo '<pre>'.print_r($matchesout).'</pre>';

   $x1=0;
   $data=array();
   $matcharr=array();

   foreach($matches as $k => $item)
		{
			$temp=explode(",",$item);
			$matcharr[$x1]=$temp[0];
			$x1++;
		}
//echo '<pre>'; print_r($matcharr); echo '</pre>';
   $arrsize=sizeof($matches);

   $temparr=array();

   for($y=0; $y<=$arrsize; $y++)
     {
    
     $data=searchmathc($matcharr);
       if(sizeof($data)>0){
       $svm = new SVM();
       $model = $svm->train($data);
  
       $result = $model->predict($deltasmarr);
    
       $temparr=delarray($result, $matcharr);
	   $matcharr=arrangearr($temparr);
	   
	   if (in_array($result, $matches)) 
		{
			//echo $matches[array_search($result,$matches)]."~";
			$resultout=$matches[array_search($result,$matches)]."~";
			unset($matches[array_search($result,$matches)]);
			$temparr1=$matches;
		}
  $resultout1.=$resultout;
       //$temparr1=delarray1($result, $matches);
	   $matches=$temparr1;
       $temparr1=arrangearr($temparr1);
     }  
 }
 return substr($resultout1,0,-1);
 */
}


?>