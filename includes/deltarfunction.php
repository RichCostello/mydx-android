<?php

function GetVisualDeltaRs($drs){
	
	
	$arr=explode(",",$drs);
	$strrs=$drs;
	//echo($drs);
	if($drs!=",,,,,,,,,,,,,,,"){
	
		$arr[0]=0;
		$arr[15]=0;
		//$arr[3]=0;
		$strrs="";
		for($x=0;$x<16;$x++){
			if($arr[$x]<0)
				$arr[$x]=0;
				
			//echo($arr[$x]);
			if($arr[$x]>.3)
				$arr[$x]=0;	
			if($x>0)
				$strrs.=",";
			$strrs.=$arr[$x];
		}
	}
	return $strrs;
	
	
}	
	

?>
