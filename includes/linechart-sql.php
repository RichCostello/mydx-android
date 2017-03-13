<?php

function sortarray($varstrc){
	$temparray=explode(",",$varstrc);
	sort($temparray);
	$templenght=count($temparray);
	for($x=0;$x<$templenght;$x++)
   {
   		$temparray[$x];
   }
   return $temparray[0].",".$temparray[$templenght-1];
}

$divgraph="";
$xvalue=16;
$countm=0; $valtemp1="";
if($profileid!=""){
		$valtemp1="";$valtemp2="";$valtemp3="";$valtemp4="";$valtemp5="";$valtemp6="";$valtemp7="";$valtemp8="";$valtemp9="";$valtemp10="";
		$valtemp11="";$valtemp12="";$valtemp13="";$valtemp14="";$valtemp15="";$valtemp16="";
		$countm=0;	
		$xvar=0;
		
		$sql="SELECT  * FROM  `MeasurementsRaw` WHERE  `ChemicalProfileID` =".$profileid." and Sensor1>0 and Sensor2>0";
		$result = mysql_query($sql,$con);
		while($row = mysql_fetch_array($result))
		{
			
			$valtemp1.="$row[Sensor1],";
			$valtemp2.="$row[Sensor2],";
			$valtemp3.="$row[Sensor3],";
			$valtemp4.="$row[Sensor4],";
			$valtemp5.="$row[Sensor5],";
			$valtemp6.="$row[Sensor6],";
			$valtemp7.="$row[Sensor7],";
			$valtemp8.="$row[Sensor8],";
			$valtemp9.="$row[Sensor9],";
			$valtemp10.="$row[Sensor10],";
			$valtemp11.="$row[Sensor11],";
			$valtemp12.="$row[Sensor12],";
			$valtemp13.="$row[Sensor13],";
			$valtemp14.="$row[Sensor14],";
			$valtemp15.="$row[Sensor15],";
			$valtemp16.="$row[Sensor16],";
			$countm++;
			$xvar.=$countm.",";
		}
		$lowh=array();
		$values1=substr_replace($valtemp1,"",-1);
		$lh=sortarray($values1);
		$tlh1=explode(",",$lh);
		$lowh[0]=array(1=>$tlh1[0],2=>$tlh1[1]);
		$values2=substr_replace($valtemp2,"",-1);
		$lh=sortarray($values2);
		$tlh2=explode(",",$lh);
		$lowh[1]=array(1=>$tlh2[0],2=>$tlh2[1]);
		$values3=substr_replace($valtemp3,"",-1);
		$lh=sortarray($values3);
		$tlh3=explode(",",$lh);
		$lowh[2]=array(1=>$tlh3[0],2=>$tlh3[1]);
		$values4=substr_replace($valtemp4,"",-1);
		$lh=sortarray($values4);
		$tlh4=explode(",",$lh);
		$lowh[3]=array(1=>$tlh4[0],2=>$tlh4[1]);
		$values5=substr_replace($valtemp5,"",-1);
		$lh=sortarray($values5);
		$tlh5=explode(",",$lh);
		$lowh[4]=array(1=>$tlh5[0],2=>$tlh5[1]);
		$values6=substr_replace($valtemp6,"",-1);
		$lh=sortarray($values6);
		$tlh6=explode(",",$lh);
		$lowh[5]=array(1=>$tlh6[0],2=>$tlh6[1]);
		$values7=substr_replace($valtemp7,"",-1);
		$lh=sortarray($values7);
		$tlh7=explode(",",$lh);
		$lowh[6]=array(1=>$tlh7[0],2=>$tlh7[1]);
		$values8=substr_replace($valtemp8,"",-1);
		$lh=sortarray($values8);
		$tlh8=explode(",",$lh);
		$lowh[7]=array(1=>$tlh8[0],2=>$tlh8[1]);
		$values9=substr_replace($valtemp9,"",-1);
		$lh=sortarray($values9);
		$tlh9=explode(",",$lh);
		$lowh[8]=array(1=>$tlh9[0],2=>$tlh9[1]);
		$values10=substr_replace($valtemp10,"",-1);
		$lh=sortarray($values10);
		$tlh10=explode(",",$lh);
		$lowh[9]=array(1=>$tlh10[0],2=>$tlh10[1]);
		$values11=substr_replace($valtemp11,"",-1);
		$lh=sortarray($values11);
		$tlh11=explode(",",$lh);
		$lowh[10]=array(1=>$tlh11[0],2=>$tlh11[1]);
		$values12=substr_replace($valtemp12,"",-1);
		$lh=sortarray($values12);
		$tlh12=explode(",",$lh);
		$lowh[11]=array(1=>$tlh12[0],2=>$tlh12[1]);
		$values13=substr_replace($valtemp13,"",-1);
		$lh=sortarray($values13);
		$tlh13=explode(",",$lh);
		$lowh[12]=array(1=>$tlh13[0],2=>$tlh13[1]);
		$values14=substr_replace($valtemp14,"",-1);
		$lh=sortarray($values14);
		$tlh14=explode(",",$lh);
		$lowh[13]=array(1=>$tlh14[0],2=>$tlh14[1]);
		$values15=substr_replace($valtemp15,"",-1);
		$lh=sortarray($values15);
		$tlh15=explode(",",$lh);
		$lowh[14]=array(1=>$tlh15[0],2=>$tlh15[1]);
		$values16=substr_replace($valtemp16,"",-1);
		$lh=sortarray($values16);
		$tlh16=explode(",",$lh);
		$lowh[15]=array(1=>$tlh16[0],2=>$tlh16[1]);
		
		$xvalue=substr_replace($xvar,"",-1);
		
}
	else{
		
		$sensorarr=explode("\n",$measurements);
		
			$values1=$sensorarr[0];
			$values2=$sensorarr[1];
			$values3=$sensorarr[2];
			$values4=$sensorarr[3];
			$values5=$sensorarr[4];
			$values6=$sensorarr[5];
			$values7=$sensorarr[6];
			$values8=$sensorarr[7];
			$values9=$sensorarr[8];
			$values10=$sensorarr[9];
			$values11=$sensorarr[10];
			$values12=$sensorarr[11];
			$values13=$sensorarr[12];
			$values14=$sensorarr[13];
			$values15=$sensorarr[14];
			$values16=$sensorarr[15];
	
	
		$lowh=array();
		
		$lh=sortarray($values1);
		$tlh1=explode(",",$lh);
		$lowh[0]=array(1=>$tlh1[0],2=>$tlh1[1]);
		
		$lh=sortarray($values2);
		$tlh2=explode(",",$lh);
		$lowh[1]=array(1=>$tlh2[0],2=>$tlh2[1]);
		
		$lh=sortarray($values3);
		$tlh3=explode(",",$lh);
		$lowh[2]=array(1=>$tlh3[0],2=>$tlh3[1]);
		
		$lh=sortarray($values4);
		$tlh4=explode(",",$lh);
		$lowh[3]=array(1=>$tlh4[0],2=>$tlh4[1]);
		
		$lh=sortarray($values5);
		$tlh5=explode(",",$lh);
		$lowh[4]=array(1=>$tlh5[0],2=>$tlh5[1]);
		
		$lh=sortarray($values6);
		$tlh6=explode(",",$lh);
		$lowh[5]=array(1=>$tlh6[0],2=>$tlh6[1]);
		
		$lh=sortarray($values7);
		$tlh7=explode(",",$lh);
		$lowh[6]=array(1=>$tlh7[0],2=>$tlh7[1]);
		
		$lh=sortarray($values8);
		$tlh8=explode(",",$lh);
		$lowh[7]=array(1=>$tlh8[0],2=>$tlh8[1]);
		
		$lh=sortarray($values9);
		$tlh9=explode(",",$lh);
		$lowh[8]=array(1=>$tlh9[0],2=>$tlh9[1]);
		
		$lh=sortarray($values10);
		$tlh10=explode(",",$lh);
		$lowh[9]=array(1=>$tlh10[0],2=>$tlh10[1]);
		
		$lh=sortarray($values11);
		$tlh11=explode(",",$lh);
		$lowh[10]=array(1=>$tlh11[0],2=>$tlh11[1]);
		
		$lh=sortarray($values12);
		$tlh12=explode(",",$lh);
		$lowh[11]=array(1=>$tlh12[0],2=>$tlh12[1]);
		
		$lh=sortarray($values13);
		$tlh13=explode(",",$lh);
		$lowh[12]=array(1=>$tlh13[0],2=>$tlh13[1]);
		
		$lh=sortarray($values14);
		$tlh14=explode(",",$lh);
		$lowh[13]=array(1=>$tlh14[0],2=>$tlh14[1]);
		
		$lh=sortarray($values15);
		$tlh15=explode(",",$lh);
		$lowh[14]=array(1=>$tlh15[0],2=>$tlh15[1]);
		
		$lh=sortarray($values16);
		$tlh16=explode(",",$lh);
		$lowh[15]=array(1=>$tlh16[0],2=>$tlh16[1]);
		
		//echo $values1;
		//$chartid="curve_chart1";
}

if($countm>0 || $valtemp1!=""){
		$y=0;
		for($i=0;$i<16;$i++){
			$y++;
			$divgraph.='		
					<div class="sensorchartarea">
					<div class="sensornumtop">'.$lowh[$i][2].'</div>
        			<div class="sensornumbot">'.$lowh[$i][1].'</div>
               		<div class="chart-line">        

                     <div id="curve_chart'.$y.'"> </div>
                   	</div>
                    <h3 class="sensortitle">Sensor '.$y.' Changes</h3>
      				</div> ';
		}

}

?>