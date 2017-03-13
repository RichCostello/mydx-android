<?php	
	
	include("includes/sessions.php");
	$userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl'];
		
	// Added for back button issues Date: 03/09/2015 3:58PM By Empower Team
	header("Cache-Control: max-age=200000");
	
	$local="";
	$str="";
	$user="";
	$data="";
	$thedeltas="";
	if(isset($_REQUEST['mraw'])){
		$data=$_REQUEST['mraw'];}
	if(isset($_REQUEST['os'])){
	$offset=$_REQUEST["os"];}
	if(isset($_REQUEST['drs'])){
	$thedeltas=$_REQUEST["drs"];}
	if(isset($_REQUEST['sm'])){
	$startmeasure=$_REQUEST["sm"];}
	if(isset($_REQUEST['mp'])){
	$midpoint=$_REQUEST["mp"];}
	if(isset($_REQUEST['em'])){
	$endmeasure=$_REQUEST["em"];}
	if(isset($_REQUEST['ui'])){
	$userid=$_REQUEST["ui"];}
	$delatars=$thedeltas;
	
	$android="";

$commntydat="";

$tempcarr=array();
$tempcom="";
$tempval="";
$prcnt=0;
$tempstr="";

function createcomhtml($commntydat,$ic){
//    echo '<pre>';
//    print_r('$commntydat');
//    print_r($commntydat);
//    echo '</pre>';
	$tempcom1="";
	$tempcarr=explode(",",$commntydat);
//        echo '<pre>';
//        print_r('$tempcarr');
//        print_r($tempcarr);
//        echo '</pre>';
	//echo $tempcarr[0];
	// $tempvalc=explode(",",$tempcarr[0]);
	//echo $tempvalc[2];
if(array_key_exists('8', $tempcarr)){
	$tempval=$tempcarr[8].','.$tempcarr[9].','.$tempcarr[10].','.$tempcarr[11].','.$tempcarr[13].','.$tempcarr[14].','.$tempcarr[15].','.$tempcarr[16].','.$tempcarr[17].','.$tempcarr[18].','.$tempcarr[19].','.$tempcarr[20].','.$tempcarr[21].','.$tempcarr[22].','.$tempcarr[23];
}
	$tempvalg=GetVisualDeltaRs($tempval);
        
//        echo '<pre>';
//        print_r('$tempvalg');
//        print_r($tempvalg);
//        echo '</pre>';
        
	if(isset($tempcarr[2])){
		$prcnt=round($tempcarr[2]*100,1);}
        //$tempval=0.0000123;
		
	$tempcom1.='<tr><td>';
	if(isset($tempcarr[5])){
		$tempcom1.='<a href="strain-details.php?uid='.$tempcarr[0].'&val='.$tempval.'&sid='.$tempcarr[5].'&sn='.$tempcarr[1].'" class="search-r">';
	}
        
	$tempcom1.='
		<div class="match-r">';
		if(isset($tempcarr[1])){
			$tempstr=$tempcarr[1];
		}
		$tempcom1.='<h3 class="text-left">'.$tempstr.'</h3>
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
                
//                echo '<pre>';
//                print_r('$tempcom1');
//                print_r($tempcom1);
//                echo '</pre>';
                
  return $tempcom1;
}

$tempmarr=array();
$tempusr="";
/*
$prcnt=0;
$tempsid=0;
$temphd="";
$tempvalmg="";
*/
function createmdathtml($mydat,$im){
	
$tempusr1="";
$tempvalmg="";
$prcnt=0;
$temphd="";
$tempsid=0;
$tempmarr=explode(",",$mydat);
	//echo $tempcarr[0];
	/////$tempvalm=explode(",",$tempmarr[0]);
	//echo $tempvalc[2];
	if(array_key_exists('8', $tempmarr)){
        $tempvalm=$tempmarr[8].','.$tempmarr[9].','.$tempmarr[10].','.$tempmarr[11].','.$tempmarr[13].','.$tempmarr[14].','.$tempmarr[15].','.$tempmarr[16].','.$tempmarr[17].','.$tempmarr[18].','.$tempmarr[19].','.$tempmarr[20].','.$tempmarr[21].','.$tempmarr[22].','.$tempmarr[23];
        $tempvalmg=GetVisualDeltaRs($tempvalm);
    }
    
//    echo '<pre>';
//    print_r('$tempmarr===');
//    print_r($tempmarr);
//    print_r($tempsid);
//    echo '</pre>';
        if(isset($temprsarr[2])){
		$prcnt=round($tempmarr[2]*100,1);}
		if(isset($tempmarr[5])){
			$tempsid=$tempmarr[5];
		}
		if(isset($tempmarr[1])){
			$temphd=$tempmarr[1];
		}
        $tempusr1.='<tr><td>
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
       
	return $tempusr1;
}
		
	include("../appmatch_2_1A.php");
	include("includes/strain-match.inc.php");
	$values1=GetVisualDeltaRs($delatars);
        



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

    <title>Match Results</title>

    <!-- Bootstrap core CSS -->
      <script>
   
            window.onload = function () {
                var r = Raphael("matchartHolder"),
                    txtattr = { font: "12px sans-serif" };
                r.barchart(0, 0, 245, 90, [[<?=$values1?>]], 0, {type: "sharp"}).attr({fill: "#f36f21"});

            };
    
    

        </script>

        <?php
   include("includes/scaling.php");
   ?>
     <link href="css/bootstrap.css" rel="stylesheet">
      <link href="css/styles-iframe.css" rel="stylesheet">

    <!-- Custom styles for this template -->
 <!--    <link href="justified-nav.css" rel="stylesheet"> -->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   

    <script src="js/raphael.js"></script>
    <script src="js/g.raphael-min.js"></script>
    <script src="js/g.bar-min.js"></script>
  
  </head>

  <body>
    <div class="container index-cont gradient"> 
    <div class="navbar navbar-inverse navbar-static-top" role="navigation"> 
      
       <div class="navbar-header"> 
         <div class="molliematch"></div>
          <h4 class="backnav"><span class="arrow"></span><a href="index.php"> BACK </a></h4>
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
  <div class="container match-top">
      <div class="row">
        <div class="col-xs-2">
        </div>
        <div class="col-xs-8 text-left scale-text results-buffer">
        
        <div class="mtypecontainer">
        <h4 class="matchtitle">Total Chemical Profile</h4>
        
        </div>
        
        <div class="head-chart-holder">
        <div id="matchartHolder"></div>
        
        </div>
        
        </div>

      </div>
       
     </div>
    
     <div class="result-sub"><p class="bot-result-text">(Click On Nearest Match or Add New +)</p> </div>
    
  <!-- end sub header section -->    
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <div class="center-block">
            <div>
                 
                  <div class="tab-content tabstyle" >
                    <div class="tab-pane" id="one">
                        <h4 class="possiblematch">Nearest MyDx Samples</h4>

                      <div class="container match-cont">
                       <!-- Search Results -->
                        <div class="row">
                                   <!--grid area -->
                         <div class="center-block">

                        <div class="table-responsive" id="match-results"> 
                           <table class="table">
                              <tbody>
						  
						  <?php
						  	//show results match here
							echo $tempcom;
						  ?>
                          </tbody>
                          </table>
                         
                          <br>
                      </div>
                    </div>
                    <!-- end grid area -->
                  </div> 
                </div>
               </div>
                    <div class="tab-pane active" id="two">
                    <?php
					   if(isset($appmatchdat[5])){
						   $newdeltar=$appmatchdat[5];
					   }else{
						    $newdeltar=$thedeltas;
					   }
					?>
                     <form name="frmstrcontent" action="strain-profile-mydata.php?drs=<?=$newdeltar?>" method="post">
                     <input type="hidden" value="<?=$data?>" name="measurementsraw">
                       <h4 class="possiblematch">Total Chemical Profile</h4>

                      <div class="container s-match-cont fcontent">
                         <div class="row">
                        
                         <?=$straincontent?>
                         
                        </div>  
                      </div>
                      </form>
                    </div>

                    <div class="tab-pane" id="twee">
                     <h4 class="possiblematch">Nearest MyDx Samples</h4>
                     <div class="container match-cont">
                       <!-- Search Results -->
                        <div class="row">
         <!--grid area -->
                         <div class="center-block">
                        <div class="table-responsive" id="match-results"> 
                         
                           <table class="table">
                              <tbody>
						  
						  <?php
						  	//show results match here
							echo $tempusr;
						  ?>
                          </tbody>
                          </table>
                          <br>
                      </div>
                    </div>
                    <!-- end grid area -->
                  </div> 
                </div>


                    </div>
                   </div>
                 <ul class="nav nav-pills pillsbg-results">
                    <li class="text-center prof-pill"><a class="White newresult" href="#one" data-toggle="pill">Community</a></li>
                    <li class="text-center prof-pill pillbord active"><a class="White newresult" href="#two" data-toggle="pill">Results</a></li>
                    <li class="text-center prof-pill-end"><a class="lresults newresult" href="#twee" data-toggle="pill">My Data</a></li>
                  </ul>
                 
                </div>
              </div>
             </div>
             </div>
            </div> 

       <?php
   include("includes/match-footer.php");
   ?>


   <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
       <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
    <script src="js/customjs.js"></script>
    <script src="js/hide.js"></script>

   
  </body>
</html>
