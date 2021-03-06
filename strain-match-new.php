<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=320, maximum-scale=2">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Search Results</title>

    <!-- Bootstrap core CSS -->
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
          <h4 class="matchtitle">MyDx Best Match</h4>
          <div class="mtypecontainer">
          <h3 class="mstraintitle">Trainwreck</h3><p class="mtype">Hybrid</p>
          
        </div>

          <div class="head-chart-holder">
                                               <div id="matchartHolder"></div>
                                                <p class="M1tcptext">Total Chemical Profile</p>
                                                 <p class="M1rank">MyDx Rank: 50.0%</p>
                                              </div>

        </div>

      </div>
       
     </div>
    
     
    
  <!-- end sub header section -->    
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
          <div class="center-block">
            <div>
                 
                  <div class="tab-content tabstyle" >
                    <div class="tab-pane active" id="one">
                      <div class="container match-cont">
                       <!-- Search Results -->
                        <div class="row">
         <!--grid area -->
                         <div class="center-block">
                        <div class="table-responsive" id="match-results"> 
                          <h4 class="possiblematch">Possible Matches</h4>
                          <table class="table">
                              <tbody>
                                <tr>
                                      <td>
                                    <a data-toggle="modal" href="#resultModal" class="search-r">
                                         <div class="match-r">
                                        <h3 class="text-left">Church OG</h3>
                                       
                                         
                                           <div class="col-xs-4 grapharea">
                                              <div class="chart-holder">
                                               <div id="testHolder"></div>
                                                <p class="Mtcptext">Total Chemical Profile</p>
                                                 <p class="Mrank">MyDx Rank: 50.0%</p>
                                              </div>
                                            </div>
                                         </div>
                                   
                                       
                                      </a>
                                      </td>  
                                  </tr>
                                   <tr>
                                      <td>
                                    <a data-toggle="modal" href="#resultModal" class="search-r">
                                         <div class="match-r">
                                        <h3 class="text-left">Church OG</h3>
                                     
                                         
                                           <div class="col-xs-4 grapharea">
                                              <div class="chart-holder">
                                               <div id="chartHolder"></div>
                                                <p class="Mtcptext">Total Chemical Profile</p>
                                              </div>
                                          </div>
                                     
                                       </div>
                                     
                                       
                                      </a>
                                      </td>  
                                  </tr>
                                 
                                 
                                  
                                  
                              </tbody>
                          </table>
                          <br>
                      </div>
                    </div>
                    <!-- end grid area -->
                  </div> 
                </div>
               </div>
                    <div class="tab-pane" id="two">
                      <div class="container s-match-cont">
                         <div class="row">
         <!--grid area --> <div class="center-block">
                             <div class="table-responsive" id="search-results"> 
                              <table class="table">
                               <tbody>
                                   <tr>
                                    <td>
                                     <a href="strain-details.html" class="search-r">
                                         <div class="search-r">
                                        <h3>White Fire OG</h3>
                                        <h5>17.34 % <sub class="rgrey">THC</sub></h5>
                                        <h5>0.24 % <sub class="rgrey">cbd</sub></h5>
                                        <h5>0.01 % <sub class="rgrey">cbd/THC</sub></h5>
                                      </div>
                                      </a>
                                      </td>  
                                  </tr>
                                  <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>
                                    <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>
                                   <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>


                               </tbody>
                          </table>
                      </div>
                    </div>
                    <!-- end grid area -->
                  </div>  


                      </div>
                    </div>

                    <div class="tab-pane" id="twee">
                  
                       <div class="container s-match-cont">
                      <div class="table-responsive" id="localresults">
                       
                         
                          <table class="table table-search no-margin">
                            <tbody>
                              <tr>
                                <td>
                                
                                </td>
                              </tr>
                                <tr>
                                <td>
                               
                                </td>
                              </tr>
                                <tr>
                                <td>
                              
                                </td>
                              </tr>
                                <tr>
                                <td>
                               
                                </td>
                              </tr>
                                <tr>
                                <td>
                             
                                </td>
                              </tr>
                               <tr>
                                <td>
                                 
                                </td>
                              </tr>
                                 <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>
                                   <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>
                                   <tr>
                                    <td>
                                       
                                      </td>  
                                  </tr>

                                
                                
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                   </div>
                 <ul class="nav nav-pills pillsbg-results">
                    <li class="text-center active prof-pill"><a class="White newresult" href="#one" data-toggle="tab">Community</a></li>
                    <li class="text-center prof-pill pillbord"><a class="White newresult" href="#two" data-toggle="tab">My Data</a></li>
                    <li class="text-center prof-pill-end"><a class="lresults newresult" href="#twee" data-toggle="tab">Local</a></li>
                  </ul>
                 <div class="result-sub"><p class="bot-result-text">(Click On Either Best or Possible Match)</p> </div>
                </div>
              </div>
             </div>
             </div>
            </div> 

    


   <!-- /container -->
           <!-- modal message -->
            <!-- modal message -->
 <div class="modal" id="resultModal">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">View</h4>
        </div>
        <div class="modal-body r-modal">
          <a href="locations.html">Locations</a>
          <br><br>
          <a href="strain-details.html">Strain Details</a>
        </div>
      </div>
    </div>
</div>
  <!-- modal message -->
                <!-- Modal -->
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <div class="help-modal"></div>
              </div>
              <div class="modal-footer">
            <button class="btn-modal" data-dismiss="modal">Close</button>
          </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->      
        <!-- end modal message -->
         <div class="footer-match">
         <div class="wrapperfoot">
    <div class="footlink"><a href="index.php" style="border: 0;">Add New Profile+</a></div>
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
    <script src="js/raphael.js"></script>
    <script src="js/g.raphael-min.js"></script>
    <script src="js/g.bar-min.js"></script>
     <script>
            window.onload = function () {
                var r = Raphael("matchartHolder"),
                    txtattr = { font: "12px sans-serif" };
                r.barchart(0, 0, 245, 90, [[55, 20, 13, 32, 5, 1, 2, 10, 28, 45, 25, 6, 4, 3, 4, 9]], 0, {type: "sharp"}).attr({fill: "#f36f21"});

                var r = Raphael("testHolder"),
                    txtattr = { font: "12px sans-serif" };
                r.barchart(0, 0, 245, 90, [[55, 20, 13, 32, 5, 1, 2, 10, 28, 45, 25, 6, 4, 3, 4, 9]], 0, {type: "sharp"}).attr({fill: "#f36f21"});
            };
        </script>
  </body>
</html>
