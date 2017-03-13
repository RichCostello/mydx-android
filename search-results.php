<?php
	
	include("includes/sessions.php");
    $userids=$_SESSION['user_id'];
	$role=$_SESSION['user_rl'];
	$userg=$_SESSION['user_ug'];
	$usergroupid=$userg;
	
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	//include("configdb.php");
	if(isset($_SERVER['HTTP_REFERER'])){
		$strefr=explode("?",$_SERVER['HTTP_REFERER']);
		$_SESSION['searchLP']=$_SERVER['HTTP_REFERER'];
	}
	$_SESSION['searchLP1']='search-results.php?'.$_SERVER['QUERY_STRING']."#two";
	
	if(isset($strefr[1])){
		if(($strefr[1]!='act=Save')||(strrchr($strefr[1],'ss=')=="")){
			if(strrchr($strefr[1],'ss=')<>""){
				$_SESSION['searchLP']=$strefr[0];
			}
		}
	}
	
    include_once('includes/paginationfunc.php');
	include("../deltarfunctions.php");
	$searchstring="";
	$userid="";
	$strbackpro="";
	$feeling="";
	$condition="";
	$num_rows=0;
	$ispublic="";
	if(isset($_GET['id'])){
    	$userid=$_GET['id'];
	}
	if(isset($_GET['feeling'])){
	$feeling=substr($_GET['feeling'],0,-1);}
	if(isset($_GET['condition'])){
	$condition=substr($_GET['condition'],0,-1);}
	if(isset($_GET['ispublic'])){
	$ispublic=$_GET['ispublic'];}
	if(isset($_GET['ss'])){
		$searchstring=$_GET['ss'];
	}
	if(isset($_GET['s'])){
		$strain_id=$_GET['s'];
	}
	
	if(isset($_REQUEST['vid'])){
    $strbackpro=$_REQUEST['vid'];}
    $_SESSION['profile_settings']=$strbackpro;
    
    $history="profile.php";
    if(($feeling!="") && ($condition=="")){
        $history="profile.php#feeling/";}
    
    if ($searchstring!=""){
		$sql="select cp.*, cs.Value as THC, cs1.Value as CBD,cs2.Value as CBN,cs3.Value as CBG,cs4.Value as THCV  from ChemicalProfiles cp 
			INNER JOIN Users us on cp.UserID=us.ID 
			LEFT OUTER JOIN AppStrains a on cp.StrainID=a.SampleID 
			LEFT OUTER JOIN StrainChemicals cs ON cp.StrainID = cs.StrainID
			AND cs.ChemicalID =2
			LEFT OUTER JOIN StrainChemicals cs1 ON cp.StrainID = cs1.StrainID
			AND cs1.ChemicalID =3 
			LEFT OUTER JOIN StrainChemicals cs2 ON cp.StrainID = cs2.StrainID AND cs2.ChemicalID =4 
			LEFT OUTER JOIN StrainChemicals cs3 ON cp.StrainID = cs3.StrainID AND cs3.ChemicalID =5  
			LEFT OUTER JOIN StrainChemicals cs4 ON cp.StrainID = cs4.StrainID AND cs4.ChemicalID =6  
			where cp.Name like '%" . $searchstring . "%'";

		$sql="select cp.*,m.Delta1,m.Delta2,m.Delta3,m.Delta4,m.Delta5,m.Delta6,
		m.Delta7,m.Delta8,m.Delta9,m.Delta10,m.Delta11,m.Delta12,m.Delta13,
		m.Delta14,m.Delta15,m.Delta16 from ChemicalProfiles cp 
			INNER JOIN Users us on cp.UserID=us.ID 
			LEFT OUTER JOIN Measurements m on m.ChemicalProfileID=cp.ID 
			where cp.Name like '%" . $searchstring . "%'";
        $history="profile.php#search/";
		
	} else {
       // $scond=0;
		//if($condition!=""){
            $arrcond=explode(",",$condition);
            $scond=count($arrcond);        //}
		//$sfeel=0;
       // if($feeling!=""){
            $arrrec=explode(",",$feeling);
            $sfeel=count($arrrec);       // }
        
		$whereclause="";
		$joinclause="";
		//echo "cond=".$condition==="";
        //echo " feeel=".sizeof($arrrec);
        
        for($x=0;$x<$scond;$x++){
			if($arrcond[$x]!=""){
                if($whereclause!=""){
                    
                    $whereclause.= " AND ";
                }
                $joinclause.=" left outer join ProfileMedical pm" . $x . " on cp.ID=pm" . $x . ".ChemicalProfileID  ";
                $whereclause.=" (pm" . $x . ".Condition='" . str_replace("'","''", $arrcond[$x]) . "' AND pm" . $x . ".Value<4) ";
            }
			
		}
		
        for($x=0;$x<$sfeel;$x++){
			if($arrrec[$x]!=""){
				if($whereclause!=""){
                    
					$whereclause.= " AND ";
				}
				$whereclause.=" (sf." . str_replace("'","''", $arrrec[$x]) . "<4) ";
			}
			
		}
		
		$sql="select cp.*, cs.Value as THC, cs1.Value as CBD,cs2.Value as CBN,cs3.Value as CBG,cs4.Value as THCV from ChemicalProfiles cp 
		INNER JOIN StrainFeelings sf on cp.ID=sf.ChemicalProfileID 
		INNER JOIN Users us on cp.UserID=us.ID 
		LEFT OUTER JOIN AppStrains a on cp.StrainID=a.SampleID 
		LEFT OUTER JOIN StrainChemicals cs ON cp.StrainID = cs.StrainID
		AND cs.ChemicalID =2
		LEFT OUTER JOIN StrainChemicals cs1 ON cp.StrainID = cs1.StrainID
		AND cs1.ChemicalID =3 
			LEFT OUTER JOIN StrainChemicals cs2 ON cp.StrainID = cs2.StrainID AND cs2.ChemicalID =4  
			LEFT OUTER JOIN StrainChemicals cs3 ON cp.StrainID = cs3.StrainID AND cs3.ChemicalID =5  
			LEFT OUTER JOIN StrainChemicals cs4 ON cp.StrainID = cs4.StrainID AND cs4.ChemicalID =6 " . $joinclause . " WHERE " . $whereclause;
		
		$sql="select cp.*, m.Delta1,m.Delta2,m.Delta3,m.Delta4,m.Delta5,m.Delta6,m.Delta7,m.Delta8,m.Delta9,m.Delta10,m.Delta11,m.Delta12,m.Delta13,m.Delta14,m.Delta15,m.Delta16  from ChemicalProfiles cp 
		INNER JOIN StrainFeelings sf on cp.ID=sf.ChemicalProfileID  
			LEFT OUTER JOIN Measurements m on m.ChemicalProfileID=cp.ID 
		INNER JOIN Users us on cp.UserID=us.ID " . $joinclause . " WHERE " . $whereclause;
		
		
	}
	
		
    $mainsql=$sql;
	
	
	if($ispublic=="0")
    $sql.=" and cp.UserID=" . $userid;
	else
    $sql.=" and cp.IsLive=1 and cp.IsPublic=1 and cp.Name not like '%(demo)%'";
	
	$sql=$sql . " ORDER BY cp.Name asc";
	
	$sql=$mainsql. " and cp.UserID=" . $userid . " ORDER BY cp.Name asc";
	
	$query = mysql_query("SELECT UserGroup FROM Users WHERE ID = $userid");
	
	if (mysql_fetch_array($query) !== false) {
	$row = mysql_fetch_array($query);
	$usergroupid=$row["UserGroup"];}
    
	//echo $sql;
   
	$result = mysql_query($sql) ;
	$ii=0;
	$i=0;
	$searchmydata="";
	if ($result !== false) {
	while($row = mysql_fetch_array($result))
	{
		$i++;
		$strval1a=$row["Delta1"] ."," . $row["Delta2"] . ",". 
		$row["Delta3"] . ",". $row["Delta4"] . ",". $row["Delta5"] . ",". 
		$row["Delta6"] . "," . $row["Delta7"] . "," . $row["Delta8"] . "," . 
		$row["Delta9"] . "," . $row["Delta10"] . ",". $row["Delta11"] . ",". 
		$row["Delta12"] . ",". $row["Delta13"] . ",". $row["Delta14"] . ",". $row["Delta15"] . ",". $row["Delta16"];
			
		$strval1ag=GetVisualDeltaRs($strval1a);
			
		$strainval='uid='.$row['ID'].'&val='.$strval1a.'&sid='.$row['StrainID'].'&sn='.$row['Name'];
		$nomodal='<a href="strain-details.php?'.$strainval.' " class="search-r">';
        $withmodal='<a data-toggle="modal" href="#resultModal" onClick="ShowMe('.$i.',0);" class="search-r">';
		
		$thumbs="";
		if(isset($row["isUP"])<>""){
			if($row["isUP"]==1){
				$thumbs='<div class="icoresults ico1 active"></div>';
			}else{
				$thumbs='<div class="icoresults ico2 active"></div>';
			}
		}
            
            $searchmydata.='<tr><td>
            '.$withmodal.'
            <div class="search-r">
            <h3 class="text-left">'.$row['Name'].'</h3>
            <p class="r-type">'.$row['StrainType'].'</p>
              <div class="col-xs-8 grapharea-sr">
            <div id="chartHolder_'.$i.'"></div>
            <p class="tcptext-sr">Total Chemical Profile</p>
            </div>
            
             <div class="col-xs-4 results-r">
            <h5>'.$row["THC"].' %<sub class="rgrey-sr">THC</sub></h5>
            <h5>'.$row["CBD"].' %<sub class="rgrey-sr">cbd</sub></h5>
            <h5>'.$row["CBN"].' %<sub class="rgrey-sr">cbn</sub></h5>
            <h5>'.$row["CBG"].' %<sub class="rgrey-sr">cbg</sub></h5>
            <h5><span class="na">NA % </span><sub class="rgrey-sr">thcv</sub></h5>
            </div>
            </div>
            
           
            </a>
            <input type="hidden" value="'.$strainval.'" name="result_'.$i.'" id="result_'.$i.'"/>
            <script>
            var r = Raphael("chartHolder_'.$i.'");
            txtattr = { font: "12px sans-serif" };
            r.barchart(0, 0, 230, 90, [['.$strval1ag.' ]], 0, {type: "sharp"}).attr({fill: "#f36f21"});</script></td></tr>';
            $ii++;
        //}
    }
	}
    $datactr=$ii;
    
    $searchmydata='<table class="table"><tbody>'.$searchmydata.' </tbody></table>';
	
    
	$sql1=$mainsql . " and cp.UserID=999 and cp.Name not like '%(demo)%' and m.UserID='alla4' Group By cp.ID ORDER BY cp.Name asc";
	$sql1=$mainsql . " and cp.UserID=999 and cp.Name not like '%(demo)%'  Group By cp.ID ORDER BY cp.Name asc";
	
	
	$result1 = mysql_query($sql1,$con) ;
	  if ($result1 !== false) {
	$num_rows=mysql_num_rows($result1);}
	//$total_groups = ceil($num_rows/$items_per_group);
	
	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	//echo $page;
	if ($page <= 0) $page = 1;
	$per_page=10;
	$startpoint = ($page * $per_page) - $per_page;
	
	
	$sql=$mainsql . " and cp.UserID=999 and cp.Name not like '%(demo)%' and m.UserID='alla4' Group By cp.ID ORDER BY cp.Name asc";
	$sql=$mainsql . " and cp.UserID=999 and cp.Name not like '%(demo)%'  Group By cp.ID ORDER BY cp.Name asc LIMIT ".$startpoint.", ".$per_page;;
	
	
	$result = mysql_query($sql,$con) ;
	//echo "<br><br>".$sql;
	$i1=0;
	$searcRslt="";
	  if ($result !== false) {
	while($row = mysql_fetch_array($result))
    {
		
			$i++;
            
            $strval1b=$row["Delta1"] ."," . $row["Delta2"] . ",". $row["Delta3"] . ",". 
			$row["Delta4"] . ",". $row["Delta5"] . ",". $row["Delta6"] . "," . 
			$row["Delta7"] . "," . $row["Delta8"] . "," . $row["Delta9"] . "," . 
			$row["Delta10"] . ",". $row["Delta11"] . ",". $row["Delta12"] . ",". 
			$row["Delta13"] . ",". $row["Delta14"] . ",". $row["Delta15"] . ",". $row["Delta16"];
			
			$strval1bg=GetVisualDeltaRs($strval1b);
			
			
            $strainval='uid='.$row['ID'].'&val='.$strval1b.'&sid='.$row['StrainID'].'&sn='.$row['Name'];
            $nomodal='<a href="strain-details.php?'.$strainval.' " class="search-r">';
           	$withmodal='<a data-toggle="modal" href="#resultModal" onClick="ShowMe('.$i.',1);" class="search-r">';
		    
			$searcRslt.='<tr><td>'.$withmodal.'
            
            <div class="search-r">
            <h3 class="text-left">'.$row['Name'].'</h3>
            <p class="r-type">'.$row['StrainType'].'</p>
            <div class="col-xs-8 grapharea-sr">
            <div id="chartHolder_'.$i.'"></div>
            <p class="tcptext-sr">Total Chemical Profile</p>
            </div>
            
            <div class="col-xs-4 results-r">
            <h5>'.$row["THC"].' %<sub class="rgrey-sr">THC</sub></h5>
            <h5>'.$row["CBD"].' %<sub class="rgrey-sr">cbd</sub></h5>
            <h5>'.$row["CBN"].' %<sub class="rgrey-sr">cbn</sub></h5>
            <h5>'.$row["CBG"].' %<sub class="rgrey-sr">cbg</sub></h5>
            <h5><span class="na">NA %</span><sub class="rgrey-sr">thcv</sub></h5>
            </div>
            </div>
            
          
            
            </a>
             <input type="hidden" value="'.$strainval.'" name="result_'.$i.'" id="result_'.$i.'"/>
            <script>
            var r = Raphael("chartHolder_'.$i.'");
            txtattr = { font: "12px sans-serif" };
            r.barchart(0, 0, 230, 90, [['.$strval1bg.' ]], 0, {type: "sharp"}).attr({fill: "#f36f21"});</script>              </td></tr>';
            $i1++;
        //}
		
		}
	}
	$searchctr=$i1;
	$searcRslt= '<table class="table"><tbody>'.$searcRslt.' </tbody></table>';
	//echo $mainsql;
	if($usergroupid!="")
		$sql=$mainsql . " and cp.IsLive=1 and cp.IsPublic=1 and cp.Name not like '%(demo)%' and us.UserGroup='" . $usergroupid . "'  Group By cp.ID  ORDER BY cp.Name asc";
	else
		$sql=$mainsql . " and cp.IsLive=1 and cp.IsPublic=1 and cp.UserID!=45 and cp.UserID!=730  and cp.Name not like '%(demo)%'  Group By cp.ID  ORDER BY cp.Name asc";
	
	$result = mysql_query($sql,$con) ;
	
	$searchLocal="";
	$i2=0;
	if ($result !== false) {
	while($row = mysql_fetch_array($result))
	{
		
			$i++;
            
           	$strval1c=$row["Delta1"] ."," . $row["Delta2"] . ",". 
			$row["Delta3"] . ",". $row["Delta4"] . ",". $row["Delta5"] . ",". 
			$row["Delta6"] . "," . $row["Delta7"] . "," . $row["Delta8"] . "," . 
			$row["Delta9"] . "," . $row["Delta10"] . ",". $row["Delta11"] . ",". 
			$row["Delta12"] . ",". $row["Delta13"] . ",". $row["Delta14"] . ",". $row["Delta15"] . ",". $row["Delta16"];
			
			$strval1cg= GetVisualDeltaRs($strval1c);
		   
		    $strainval='uid='.$row['ID'].'&val='.$strval1c.'&sid='.$row['StrainID'].'&sn='.$row['Name'];
            $strainval='uid='.$row['ID'].'&val='.$strval1b.'&sid='.$row['StrainID'].'&sn='.$row['Name'];
            $nomodal='<a href="strain-details.php?'.$strainval.' " class="search-r">';
           	$withmodal='<a data-toggle="modal" href="#resultModal" onClick="ShowMe('.$i.',0);" class="search-r">';
			
            $searchLocal.='<tr><td>
            '.$withmodal.'
            <div class="search-r">
            <h3 class="text-left">'.$row['Name'].'</h3>
            <p class="r-type">'.$row['StrainType'].'</p>
            <div class="col-xs-8 grapharea-sr">
            <div id="chartHolder_'.$i.'"></div>
            <p class="tcptext-sr">Total Chemical Profile</p>
            </div>
            
            <div class="col-xs-4 results-r">
            <h5>'.$row["THC"].' %<sub class="rgrey-sr">THC</sub></h5>
            <h5>'.$row["CBD"].' %<sub class="rgrey-sr">cbd</sub></h5>
            <h5>'.$row["CBN"].' %<sub class="rgrey-sr">cbn</sub></h5>
            <h5>'.$row["CBG"].' %<sub class="rgrey-sr">cbg</sub></h5>
            <h5><span class="na">NA % </span><sub class="rgrey-sr">thcv</sub></h5>
            </div>
          
            </div>
            
          
            </a>
             <input type="hidden" value="'.$strainval.'" name="result_'.$i.'" id="result_'.$i.'"/>
             <div class="loading"></div>
            <script>
            var r = Raphael("chartHolder_'.$i.'");
            txtattr = { font: "12px sans-serif" };
            r.barchart(0, 0, 230, 90, [['.$strval1cg.' ]], 0, {type: "sharp"}).attr({fill: "#f36f21"});</script>            </td></tr>';
            $i2++;
		//}
		
	}
	}
	$localctr=$i2;
    $searchLocal= '<table class="table"><tbody>'.$searchLocal.' </tbody>
    </table>';
    
    mysql_close($con);
    $cid="";
    /*
	if(($datactr==0)&&($searchctr==0)){
        echo'<script> window.location.href="'.$_SESSION['searchLP'].'?errmsg=No Results Found<br>Please adjust your criteria";</script>';
		exit;
    }
    */
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

    <title>Search Results</title>

    <!-- Bootstrap core CSS -->
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">
<script src="js/raphael.js"></script>
<script src="js/g.raphael-min.js"></script>
<script src="js/g.bar-min.js"></script>    <!-- Custom styles for this template -->
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
		function ShowMe(theid,pge){
			var link = document.getElementById("mystrain");
			var cid='='+theid
			var myid='result_'+theid;
			
			var urlval=document.getElementById(myid).value;
			if(pge==1){
				var url='strain-details.php?'+urlval;}
			else{
				var url='update-strain.php?'+urlval;}
			link.setAttribute("href", url);
		}
	</script>
 <style>
ul.pagination {
    text-align:center;
    color:#829994;
}
ul.pagination li {
    display:inline-block;
    padding:0px 1px;
}
ul.pagination a {
color: #6d6e70;
display: inline-block;
padding: 4px 10px;
border: 1px solid #bdc6ca;
text-decoration: none;
}
ul.pagination a:hover,
ul.pagination a.current {
    background:#f36f21;
    color:#fff;
}


</style>
  </head>

  <body>
    <div class="container index-cont gradient"> 
    <div class="navbar navbar-inverse navbar-static-top" role="navigation"> 
      
       <div class="navbar-header"> 
          <h4 class="backnav"><span class="arrow"></span><a href="#" onclick="window.history.back();return false;" > BACK </a></h4>
        <div id="menu-toggle">
    <img src="img/navbut.jpg" alt="Menu"></img>
  </div>
     <?php
   include("includes/side_menu.php");
   ?>
          <a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
        </div> 
    </div> 
 
<!-- end navbar and slide out menu -->
<!-- start sub header section -->
  <div class="container prof-head">
      <div class="row">
        <div class="col-xs-3 helpimg">
       <a data-toggle="modal" href="help_resultspage.php" data-target="#helpModal"><img class="no-resize" src="assets/images/need_help.png"></a>
        </div>
        <div class="col-xs-8 text-left scale-text results-buffer">
<?php 
    $isnotempty=false;
	if($condition<>""){
        echo $condition;
        $isnotempty=true;
    }
    if(($feeling<>"")&&($isnotempty)) {
        echo ",".$feeling;
    }else{
        echo $feeling;
    }
    if($searchstring<>""){
        echo $searchstring;
    }
    ?>
        </div>
       <div id="font-metrics"></div>
      </div>
       
     </div>
    
     
       
         <div class="center-block s-results-title">
          <h2 >Search Results:</h2>
        </div>
  <!-- end sub header section -->    
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <div class="center-block">
            <div>
                  <ul class="nav nav-pills pillsbg">
                    <li class="text-center active prof-pill"><a class="White" href="#one" data-toggle="tab">Community</a></li>
                    <li class="text-center prof-pill pillbord"><a class="White" href="#two" data-toggle="tab">My Data</a></li>
                    <li class="text-center prof-pill-end"><a class="lresults" href="#twee" data-toggle="tab">Local</a></li>
                  </ul>
                  <div class="tab-content tabstyle" >
                    <div class="tab-pane active" id="one">
                      <div class="container s-results-cont">
                       <!-- Search Results -->
                        <div class="row">
         <!--grid area -->
                         <div class="center-block">
                        <div class="table-responsive" id="search-results"> 
                         <?=$searcRslt?>

                          <br>
                           <center>
                          <div style="width:220px">
                          <?php 
                        
                          if(isset($_REQUEST['page'])==""){
                          $urls="search-results.php?".$_SERVER['QUERY_STRING']."&";
                          $_SESSION['pg_url']=$urls;
                          }else{
                             $urls= $_SESSION['pg_url'];
                          }
                          
                          echo pagination($num_rows,$per_page,$page,$urls);
                          
                          ?></div>
                          </center>
                      </div>
                      
                    </div>
                    <!-- end grid area -->
                  </div> 
                </div>
               </div>
                    <div class="tab-pane" id="two">
                      <div class="container s-results-cont">
                         <div class="row">
         <!--grid area --> <div class="center-block">
                             <div class="table-responsive" id="search-results"> 
                             <?=$searchmydata?>
                            
                      </div>
                    </div>
                    <!-- end grid area -->
                  </div>  


                      </div>
                    </div>

                    <div class="tab-pane" id="twee">
                  
                       <div class="container s-results-cont">
                      <div class="table-responsive" id="localresults">
                       
                         <?=$searchLocal?>
                        </div>
                      </div>
                    </div>
                   </div>
                </div>
              </div>
             </div>
             </div>
            </div> 

    


   <!-- /container -->
           <!-- modal message -->
         <div class="modal" id="resultModal">
  <div class="modal-dialog">
      <div class="modal-canna">
      <div class="modal-header-canna">
          
          <h4 class="modal-title text-center">View</h4>
        </div>
        <div class="modal-body">
           
          <br> 
             <p class="sharel text-center"><a id="mystrain" href="strain-details.php">Strain Profile</a></p>
          <br> 
           <p class="sharel text-center"><a id="mystrain" href="strain-locator.php">Strain Locator</a></p>
        </div>
         <div class="shares-modal-footer">
        <button type="button" class="btn btn-shares" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
</div>
            <!-- modal message -->

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
        <!-- error modal -->
   <div class="modal ercustom" id="errorModal">
     <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal"></button>
           <h4 class="modal-title text-center errorm" >Search Results</h4>
               <div class="text-center errorp">
                  <p>No Results Found<br>Please adjust your criteria</p>
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
     <div class="footer-results">
         <div class="wrapperfoot">
    <div class="footlink-results"><a href="<?=$history?>"  style="border: 0;"> < Refine Search </a></div>
    <div class="containerfoot">
        <div id="buttonfoot"><a></a></div>
        <div class="border-test"></div>
        <div class="contentfoot">
           
         <ul class="list-inline">
             <li class="llist"><a class="text-left" href="quicktest.php" ><span class="qtest-icon"></span>Quick TEST</a></li>
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
<script>
	if (window.location.hash != ""){
		
		$(function () {
	
		  $('a[href="' + window.location.hash + '"]').click();
	
		})
	
	}
</script>
<?php
    
	if(($datactr==0)&&($searchctr==0)){
		?>   
	<script>alert('No Results Found\nPlease adjust your criteria'); window.location.href='profile.php';</script>
<?php }
    ?>
  </body>
</html>
