<?php
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



?>