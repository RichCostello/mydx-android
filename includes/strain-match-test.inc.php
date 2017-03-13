<?php

$appmatchdat="";

$appmatchdat=RunAlgorithm();

$appmatchdat=explode("^",$appmatchdat);
$local=$appmatchdat[2];
$commntydat="";
$commntydat=explode("~",$local);
//print_r($commntydat);
$rsltlenghtc=count($commntydat);
$tempcarr=array();
$tempcom="";
$tempval="";
$prcnt=0;
$tempstr="";

for($ic=0;$ic<$rsltlenghtc;$ic++){

$tempcarr=explode(",",$commntydat[$ic]);
	//echo $tempcarr[0];
	// $tempvalc=explode(",",$tempcarr[0]);
	//echo $tempvalc[2];
if(array_key_exists('8', $tempcarr)){
	$tempval=$tempcarr[8].','.$tempcarr[9].','.$tempcarr[10].','.$tempcarr[11].','.$tempcarr[13].','.$tempcarr[14].','.$tempcarr[15].','.$tempcarr[16].','.$tempcarr[17].','.$tempcarr[18].','.$tempcarr[19].','.$tempcarr[20].','.$tempcarr[21].','.$tempcarr[22].','.$tempcarr[23];
}
	$tempvalg=GetVisualDeltaRs($tempval);
	if(isset($tempcarr[2])){
		$prcnt=round($tempcarr[2]*100,1);}
        //$tempval=0.0000123;
		
	$tempcom.='<tr><td>';
	if(isset($tempcarr[5])){
		$tempcom.='<a href="strain-details.php?uid='.$tempcarr[0].'&val='.$tempval.'&sid='.$tempcarr[5].'&sn='.$tempcarr[1].'" class="search-r">';
	}
	$tempcom.='
		<div class="match-r">';
		if(isset($tempcarr[1])){
			$tempstr=$tempcarr[1];
		}
		$tempcom.='<h3 class="text-left">'.$tempstr.'</h3>
		<div class="col-xs-4 grapharea">
		<div class="chart-holder">
		<div id="testHolder'.$ic.'"></div>
		<p class="Mtcptext">Total Chemical Profile</p>
		 <p class="Mrank">MyDx Rank: '.$prcnt.' %</p>
		</div>
		</div>
		</div>
		
		</a>
		<script>
		
		var r = Raphael("testHolder'.$ic.'"),
		txtattr = { font: "12px sans-serif" };
		r.barchart(0, 0, 245, 90, [['.$tempvalg.']], 0, {type: "sharp"}).attr({fill: "#f36f21"});
		
		</script>
		</td></tr>';
}


$str=$appmatchdat[3];
//str  for results
//$resulttab=$sdataarr[3];
$resulttabdat="";
$resulttabdat=explode("~~",$str);
$rsltlenght=count($resulttabdat);
$temprsarr=array();
$temphdr="";
$strtemp="";
$temphdr1="";
$temprcnt="";
$temphdr1a="";
for($ir=0;$ir<$rsltlenght;$ir++){

        $temprsarr=explode("--",$resulttabdat[$ir]);
        //if($temprsarr[0]==46){
       if($temprsarr[0]==46 || $temprsarr[0]==2 || $temprsarr[0]==11){
        $strtemp.='<div class="col-xs-12 text-center details-gray"> '.$temprsarr[2].' </div>
        ';
       }
        $strtemp.='<div class="form-content">

		<div class="col-xs-offset-1 col-xs-8 ">';
		if(isset($temprsarr[1])){
			$temphdr1=$temprsarr[1];
		}
		if(isset($temprsarr[4])){
			$temphdr1a=$temprsarr[4];
		}
		if(isset($temprsarr[3])){
			$temprcnt=$temprsarr[3];
		}
		$strtemp.='
		<h5>'.$temphdr1.'</h5> </div>
		<div class="col-xs-2 form-content">
		
		<input class="form-content1 input-md" id="" type="text" value="'.$temphdr1a.'" name="FIELD_'.$temprsarr[0].'">
		
		</div><label for="percent" class="col-xs-1 clabel-end">'.$temprcnt.'</label>
		
		</div>';
                        //}

}
$straincontent=$strtemp;


//echo $strtemp;
$mydat="";
//user here for mydat
//$mydata=$sdataarr[1];
$user=$appmatchdat[1];
$mydat=explode("~",$user);
//print_r($mydat);
$rsltlenghtm=count($mydat);
$tempmarr=array();
$tempusr="";
$prcnt=0;
$tempsid=0;
$temphd="";
$tempvalmg="";
function creatbarval(){
        for($y=0;$y<16;$y++){

        }
}

for($im=0;$im<$rsltlenghtm;$im++){

$tempmarr=explode(",",$mydat[$im]);
	//echo $tempcarr[0];
	/////$tempvalm=explode(",",$tempmarr[0]);
	//echo $tempvalc[2];
	if(array_key_exists('8', $tempmarr)){
        $tempvalm=$tempmarr[8].','.$tempmarr[9].','.$tempmarr[10].','.$tempmarr[11].','.$tempmarr[13].','.$tempmarr[14].','.$tempmarr[15].','.$tempmarr[16].','.$tempmarr[17].','.$tempmarr[18].','.$tempmarr[19].','.$tempmarr[20].','.$tempmarr[21].','.$tempmarr[22].','.$tempmarr[23];
        $tempvalmg=GetVisualDeltaRs($tempvalm);
    }
        if(isset($temprsarr[2])){
		$prcnt=round($tempmarr[2]*100,1);}
		if(isset($tempmarr[5])){
			$tempsid=$tempmarr[5];
		}
		if(isset($tempmarr[1])){
			$temphd=$tempmarr[1];
		}
        $tempusr.='<tr><td>
                <a href="update-strain.php?uid='.$tempmarr[0].'&sid='.$tempsid.'" class="search-r">

                <div class="match-r">
                <h3 class="text-left">'.$temphd.'</h3>
                <div class="col-xs-4 grapharea">
                <div class="chart-holder">
                <div id="testHolderm'.$im.'"></div>
                <p class="Mtcptext">Total Chemical Profile</p>
                 <p class="Mrank">MyDx Rank: '.$prcnt.' %</p>
                </div>
                </div>
                </div>

                </a>
                <script>

        var r = Raphael("testHolderm'.$im.'"),
        txtattr = { font: "12px sans-serif" };
        r.barchart(0, 0, 245, 90, [['.$tempvalmg.']], 0, {type: "sharp"}).attr({fill: "#f36f21"});

                </script>
                </td></tr>';
}


?>