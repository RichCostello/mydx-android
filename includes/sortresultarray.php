<?php
//-------------------------------------------------------------------------------------------------
//    @name:      Sort output array
//    @purpose:   Ksort and asort combine
//    @category:  PHP Function
//    @author:    Greg E. Salivio 02/07/2015 started
//    @version:   1.0
//    @copyright: cdxlife.com
//    @Note:      
//-------------------------------------------------------------------------------------------------
/*  Array Sorting */

function sortvalarray($airarray1){
	asort($airarray1);
	foreach ($airarray1 as $key => $val) {
	$ars=explode(",",$val);
    $sortval[$key]= $ars[2].",".$val;
	$sortvala[$key]= $val;
	}
	
	$temparr=arrangearr($sortval);
	//echo '<pre>'; print_r($temparr); echo '</pre>';
	
	
	rsort($temparr);
	foreach ($temparr as $key => $val) {
    $sortval1[$key]= $val;
	$rval1=explode(",",$val);
	
	//7=thc 8=cbd
	$sorval3[$key]=$rval1[1].",".$rval1[2].",".$rval1[3].",".$rval1[4].",".$rval1[5]. "," . $rval1[6] . "," . $rval1[7] . "," . $rval1[8] . ",";// . "~";
	for($xx=0;$xx<16;$xx++){
		if($xx>0)
			$sorval3[$key].=",";
		$sorval3[$key].=$rval1[$xx+9];
	}
	$sorval3[$key].="~";
	}
	//echo '<pre>'; print_r($sorval3); echo '</pre>';
	
	return $sorval3;
	
}

function sortvalues($string){
	$outval=explode("^",$string);
	$dat2="";
	for($i=0; $i<count($outval);$i++){
		$airarray1=explode("~",$outval[$i]);
		//echo '<pre>'; print_r($airarray1); echo '</pre>';
		$dat1=sortvalarray($airarray1);
		for($x=0;$x<sizeof($dat1);$x++)
			$dat2.=$dat1[$x];
		//$dat2.=implode(",",$dat1)."^";
		//echo '<pre>'; print_r($dat2); echo '</pre>';
	}
	
	return substr($dat2,0,-1);
}

?>