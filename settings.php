<?php
	include("includes/sessions.php");
	$userid=$_SESSION['user_id'];
	
	$role=$_SESSION['user_rl']; 
	$userg=$_SESSION['user_ug'];
	//echo "Time: ".$_SESSION['start'];
	//echo "<br>Expire: ".$_SESSION['expire'];
	if($userid==""){
		$userid=-1;
	}
	//$userid=7;
	//echo "<br>User ID:".$userid;
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	
	//include("configdb.php");
	 $issaved="";
	
    //$TABLE_NAME="SettingsAilments";
	$TABLE_NAME="MedicalConditions";
	if(isset($_SERVER["HTTP_REFERER"])){
	$_SESSION["origURL"] = $_SERVER["HTTP_REFERER"];}

if(isset($_REQUEST['act'])=="Save"){
        //echo "Save Here<br>";
       	$addailment="";
	    $issaved="yes";
		if(isset($_GET['ailmentval'])){
        	$addailment=$_GET['ailmentval'];
        	$arrail=explode(",",$addailment);
        }
        if($addailment<>""){
            for($x=0;$x<sizeof($arrail);$x++){
                $sql_stmt = "SELECT * FROM  $TABLE_NAME WHERE  `Condition`='".$arrail[$x]."' AND `UserID` = $userid";
                $result = @mysql_query ($sql_stmt);
                
                if(mysql_num_rows($result)==0){
                    $strailment=str_replace("\'","''", $arrail[$x]);
                    $sql_insert = "INSERT INTO `$TABLE_NAME`(`Condition`, `UserID`, `IsON`) VALUES ('$strailment',$userid,1)";
                    $result1 = @mysql_query ($sql_insert);
                }
            }
        }
        
        $sql_stmt = "SELECT * FROM  $TABLE_NAME WHERE  `UserID` = $userid";
        $result = @mysql_query ($sql_stmt);
        if ($result !== false) {
			while($row = mysql_fetch_array($result))
			{
				if(isset($row['ID'])){
				$tname="ailment_".$row['ID'];}
				$val=$_POST[$tname];
				$sql_update = "UPDATE `$TABLE_NAME` SET `IsON`=$val  WHERE `ID`=".$row['ID'];
				$result1 = @mysql_query ($sql_update);
				
			}
		}
		
        
        $sql_stmt1 = "SELECT * FROM  SettingsUsage WHERE  `UserID` = $userid";
        $result = @mysql_query ($sql_stmt1);
        $num_rows = mysql_num_rows($result);
        if($num_rows>0)
        {
            if($_POST['owner']=="Yes"){
                $owner=1;
            }else{$owner=0;}
            $sql_update = "UPDATE `SettingsUsage` SET `type`='".$_POST['users']."',`sampletest`='".$_POST['type']."',`OwnDevice`=".$owner."  WHERE `UserID`=$userid";
            $result1 = @mysql_query ($sql_update);
        }else{
            if($_POST['owner']=="Yes"){
                $owner=1;
            }else{$owner=0;}
            $sql_insert = "INSERT INTO `SettingsUsage`(`type`, `sampletest`, `UserID`, `OwnDevice`) VALUES ('".$_POST['users']."','".$_POST['type']."',$userid,".$owner.")";
            $result1 = @mysql_query ($sql_insert);
        }
        
        
    }
    
    
    function setUserType($thetype){
        $arrtype = array('manufacturer','distributor','consumer','regulator');
        $key = array_search($thetype, $arrtype);
        $key=$key+1;
        
        return $key;
        
    }
    
    if($issaved<>"yes"){
        if(isset($_SERVER["HTTP_REFERER"])){
        $_SESSION["origURL"] = $_SERVER["HTTP_REFERER"];}
        
	
    }else{
		
        $lastpage=explode("/",$_SESSION["origURL"]);
        
		if(array_search("register.php",$lastpage)||array_search("settings.php",$lastpage))
        {
        	$_SESSION["origURL"] ='profile.php';
        }
       
        echo'<script> window.location="'.$_SESSION["origURL"].'";</script>';
		exit;
        
    }
    
    function setUserSamples($thesample){
        $arrtest = array('organa','aqua','aero','canna');
        $key = array_search($thesample, $arrtest);
        $key=$key+1;
        
        return $key;
        
        
    }
	
    if (!$con)
    {
        $msgalert= "No DB Connection";
    }else{
        $i=0;
        $sql_stmt = "SELECT * FROM $TABLE_NAME  WHERE UserID=$userid ORDER BY  `ID` ASC";
        $result = @mysql_query ($sql_stmt);
        $num_rows = mysql_num_rows($result);
        if($num_rows==0){
            $sql_stmt1 = "SELECT * FROM $TABLE_NAME  WHERE UserID=-1 ORDER BY  `ID` ASC";
            $result = @mysql_query ($sql_stmt1);
            $addme=TRUE;
        }
        //echo $sql_stmt;
        //exit;
		$ailment="";
		while($row = mysql_fetch_array($result)) {
			if($row['UserID']<0){
				$i++;
				$strailment=str_replace("'","''", $row['Condition']);
				$sql_insert="INSERT INTO `$TABLE_NAME`(`Condition`, `UserID`, `IsON`) VALUES ('".$strailment."',$userid,".$row['IsON'].")";
				$result1 = @mysql_query ($sql_insert);
				//if($i>29){
				//	exit;
				//}
			}
			if($row['IsON']<>1){
				
				$active='checked';
				$active1='';
			}else{
				
				$active='';
				$active1='checked';
            }
			$ailment.='<tr>
            <td>
            <span class="name">'.$row['Condition'].'</span>
            </td>
            <td>
            <div class="switch-toggle switch-candy">
            <input type="radio" id="ailment_'.$row['ID'].'OFF" name="ailment_'.$row['ID'].'" value="0" '.$active.'>
            <label for="ailment_'.$row['ID'].'OFF" onclick="">OFF</label>
                <input type="radio" id="ailment_'.$row['ID'].'ON" name="ailment_'.$row['ID'].'" value="1" '.$active1.'>
                <label for="ailment_'.$row['ID'].'ON" onclick="">ON</label>
                    <a></a>
                    </div>
                    </td>
                    </tr>';
                    }
		$ailment='<table class="table text-left table-ail" id="ailmentTab"><tbody>'.$ailment.'</tbody></table>';
      
		$type1="";$type2="";$type3="checked";$type4="";$owndv1="checked";$owndv2="";	
		$sample1="";$sample2=""; $sample3=""; $sample4="checked";	
		
        $sql_stmt = "SELECT * FROM SettingsUsage WHERE UserID=$userid";
        $result = @mysql_query ($sql_stmt);	
        $data=mysql_fetch_array($result);					
        $num_rows = mysql_num_rows($result);
        
        if($num_rows>0){
                    
            $ty=setUserType($data['type']);
            
            switch ($ty) {
                case 1:
                    $type1="checked";
                    break;
                case 2:
                    $type2="checked";
                    break;
                case 3:
                    $type3="checked";
                    break;
                case 4:
                    $type4="checked";
                    break;
                default:
                    $type4="checked";
            } 
            
            $dvx=$data['OwnDevice'];
            switch ($dvx) {
                case 1:
                    $owndv1="checked";
                    break;
                case 0:
                    $owndv2="checked";
                    break;
                    
                default:
                    $owndv1="checked";
            } 
            
            $test=setUserSamples($data['sampletest']);
            switch ($test) {
                case 1:
                    $sample1="checked";
                    break;
                case 2:
                    $sample2="checked";
                    break;
                case 3:
                    $sample3="checked";
                    break;
                case 4:
                    $sample4="checked";
                    break;
                default:
                    $type4="checked";
            } 
        }
    }

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

    <title>MyDx Settings</title>

    <!-- Bootstrap core CSS -->
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">
        <link href="css/toggle-switch.css" rel="stylesheet">
    
          <?php
   include("includes/scaling.php");
   ?>
    <!-- Custom styles for this template -->
 <!--    <link href="justified-nav.css" rel="stylesheet"> -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>
 
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
   <!-- end nav section -->
 <!-- start sub header section -->
    <div class="container top-white">
      <div class="row">
         <div class="col-xs-3 helpimg">
       <a data-toggle="modal" href="help_settings.php" data-target="#helpModal"><img src="assets/images/need_help.png"></a>
        </div>
        <div class="col-xs-6 text-center ailmentbuffer"><h2>Settings</h2></div>
        <div class="col-xs-3 text-right"></div>
      </div>
      </div>
       
     <form  name='mainForm' action='settings.php?act=Save' method="post" id="mainForm">
  <!-- end sub header section -->    
        <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <div class="center-block">
            <div>
                  <ul class="nav nav-pills pillsbg">
                    <li class="text-center active set-pill"><a href="#ailment" data-toggle="tab">Ailments</a></li>
                    <li class="text-center set-pill"><a href="#usageset" data-toggle="tab">Usage Settings</a></li>
                   
                  </ul>
                  <div class="tab-content tabstyle">
                    <!-- Ailments Tab Section -->
                    <div class="tab-pane active" id="ailment">
                    <p class="text-center top-ail-buffer">Ailment(s) You Wish To Track:</p>
                        <div class="table-responsive tab-setting-ail">
<?php

        echo $ailment;
    
        
        ?>




<div class="add-ailment">
<input class="form-search" name="addailment" id="ailmentadd" placeholder="Add New Ailment" type="text" maxlength="422" required autofocus ><p><input type="hidden" id="ailmentval" name="ailmentval" value=""></p>
<button class="btn btn-add" onClick="addAilments();" type="button">Add</button>
<section id="al1"></section>
</div>

    <br>

       </div>
           </div>
                     <!-- End Ailments Tab -->
                     <!-- Start Usage Settings Tab -->
                    <div class="tab-pane tabbed-area-u" id="usageset">
                 
                           <div class="center-block setcol-use">
                            <div class="usage-box">
                            <h5>Check which type of USER you are:</h5>
                                <div class="radio">
                                <label>
                                  <input type="radio" name="users" value="manufacturer" <?=$type1?>>
                                  Manufacturer
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="users" value="distributor" <?=$type2?>>
                                  Distributor
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="users" value="consumer" <?=$type3?>>
                                  Consumer
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="users" value="regulator" <?=$type4?>>
                                  Regulator
                                </label>
                              </div>

                           </div>
                           <div class="usage-box">
                          <h5>Do you have a MyDx Device?</h5>
                             <div class="radio">
                                <label>
                                  <input type="radio" name="owner" value="Yes" <?=$owndv1?>>
                                  Yes
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="owner" value="no" <?=$owndv2?>>
                                  No
                                </label>
                              </div>
                           </div>
                           <div class="usage-box">
                            <h5>Which Samples will you TEST most often?</h5>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="type" value="organa" <?=$sample1?>>
                                  Fruits & Vegetables<span class ="orange">(Organa Dx)</span>
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="type" value="aqua" <?=$sample2?>>
                                  Liquids <span class ="orange">(Aqua Dx)</span>
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="type" value="aero" <?=$sample3?>>
                                  Air Quality <span class ="orange">(Aero Dx)</span>
                                </label>
                              </div>
                              <div class="radio">
                                <label>
                                  <input type="radio" name="type" value="canna" <?=$sample4?>>
                                  Cannabis <span class ="orange">(Canna Dx)</span>
                                </label>
                              </div>
                           </div>
                           <br><br>
                          
                        </div>
                    </div>
                  </div>   
                    <!-- End Usage Settings Tab -->
                   </div>
                </div>
              </div>
             </div>
             </div>
      </form> 
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
 <!-- end main content -->
  <div class="footer"> 
    <div class="wrapperfoot">
      <div class="footlink-set"><a id="setclick" href="#" onClick="javascript:document.mainForm.submit();">Save Settings</a></div>
        <div id="spinner" class="spinner" style="display:none;">
         <img id="img-spinner" src="assets/images/712.gif" alt="Loading"/>
        </div>
        <div class="containerfoot">
         <div id="buttonfoot"><a></a></div>
          <div class="border-test"></div>
           <div class="contentfoot">
           <ul class="list-inline">
            <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
            <li class="rlist"><a class="text-right" href="" >MyProfile<span class="gn-bottom-icon gn-icon-bottom"></span></a></li>
          
          </ul>
        </div>  
  </div>
</div> 
</div> 
  
     <!-- /container -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="js/bootstrap.min.js"></script>
    <script src="js/customjs.js"></script>
     <script src="js/hist.js"></script>
     <script src="js/hide.js"></script>
     <script>
	//alert(window.location.hash);
	if (window.location.hash != ""){ 	
	
	 $(function () {
	   // $('a[href="'+ window.location.hash +'"]').tab('show')
		$('a[href="' + window.location.hash + '"]').click();
	  })
	}
var arrAilVal = [];
function addAilments() {
	var x = document.getElementById("ailmentTab").rows.length;
    var table = document.getElementById("ailmentTab");
    var row = table.insertRow(x);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
	
	var c1=document.getElementById("ailmentadd").value;
	var ail=document.getElementById('ailmentval').value;
	if(c1!=""){
		arrAilVal.splice(0, 0,c1);
    	cell1.innerHTML = '<span id="name_'+x+'" class="name">'+c1+'</span>';
        cell2.innerHTML = '<div class="switch-toggle switch-candy"><input type="radio" id="ailment_'+x+'OFF" name="ailment_'+x+'" value="0" checked><label for="ailment_'+x+'OFF" onclick="">OFF</label><input type="radio" id="ailment_'+x+'ON" name="ailment_'+x+'" value="1" checked><label for="ailment_'+x+'ON" onclick="">ON</label><a></a></div>';
        //ail=ail+c1+',';
	}else{
		alert('Ailment cannot be blank!');
	}
    document.getElementById('ailmentval').innerHTML = arrAilVal;
	  document.getElementById('mainForm').action="settings.php?act=Save&ailmentval="+arrAilVal;
	
}
</script>
  </body>
</html>
