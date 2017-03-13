<?php
    
	include("includes/sessions.php");
    $userid=$_SESSION['user_id'];
	//echo "<br>User ID:".$userid;
	$role=$_SESSION['user_rl'];
	$userg=$_SESSION['user_ug'];
	if(isset($_SERVER["HTTP_REFERER"])){
	$_SESSION['strainlocLP']=$_SERVER["HTTP_REFERER"];}
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);
		
	require_once($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	
      function getRealIpAddr()     {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
	
	$address="";
	$zip="";
	$org="";
	$location="";
	$file="";
	
    $ip=getRealIpAddr();
    $hostname = gethostbyaddr($ip);
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
	if(isset($details->country)){
    	$address=$details->city.", ".$details->region.", ".$details->country;}
    $location=$details->loc;
    $org=$details->org;
	if(isset($details->postal)){
    	$zip=$details->postal;}
	$longlat=explode(",",$location);
	$LAT=$longlat[0];
	$LONG=$longlat[1];
	
    // This is a limit by distance and quantity.
    $sql = "SELECT weedmaps_url, name, phone, address, id, delivery_only, latitude, longitude,
    ( 3959 * acos( cos( radians(${LAT}) ) * cos( radians( latitude ) ) *
                  cos( radians( longitude ) - radians(${LONG}) ) + sin( radians(${LAT}) ) * sin(radians(latitude)) ) )
    AS distance FROM dispensary where latitude is not null HAVING distance < 50  ORDER BY distance LIMIT 0 , 100";

    $result = mysql_query($sql, $con) ;
	if($result !=false){
		while($row = mysql_fetch_array($result))
		{
			$url="<a class='maptest' data-toggle='modal' onClick='passID(".$row["id"].")' href='#helpModal'>".$row["name"]."</a>";
			$node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("name",$url);
			//$newnode->setAttribute("name",$row["name"]);
			$newnode->setAttribute("address", $row['address']);
			$newnode->setAttribute("lat", $row['latitude']);
			$newnode->setAttribute("lng", $row['longitude']);
			$newnode->setAttribute("phone", $row['phone']);
		}
	}
    //echo $dom->saveXML();
    $file="strain_locator_xml.xml";
    $fp = fopen($file,"w");
    //Write the XML nodes
    fwrite($fp,$dom->saveXML());
    //Close the data
    fclose($fp);
	
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
<title>My Profile</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/styles-iframe.css" rel="stylesheet">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
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
<script>
var customIcons = {
icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
};
function load() {
    var map = new google.maps.Map(document.getElementById("map"), {
                                  center: new google.maps.LatLng(<?=$location?>),
                                  zoom: 9,
                                  mapTypeId: 'roadmap'
                                  });
    var infoWindow = new google.maps.InfoWindow;
    // Change this depending on the name of your PHP file
    downloadUrl("strain_locator_xml.xml", function(data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                for (var i = 0; i < markers.length; i++) {
                var name = markers[i].getAttribute("name");
                //var address = markers[i].getAttribute("address");
                var phone = markers[i].getAttribute("phone");
                var type = markers[i].getAttribute("type");
                var point = new google.maps.LatLng(
                                                   parseFloat(markers[i].getAttribute("lat")),
                                                   parseFloat(markers[i].getAttribute("lng")));
                var html = "<b>" + name + "</b> <br/>" + phone;
                var icon = customIcons[type] || {};
                var marker = new google.maps.Marker({
                                                    map: map,
                                                    position: point,
                                                    icon: icon.icon
                                                    });
                bindInfoWindow(marker, map, infoWindow, html);
                }
                });
}
function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
                                  infoWindow.setContent(html);
                                  infoWindow.open(map, marker);
                                  });
}
function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };
    request.open('GET', url, true);
    request.send(null);
}
function doNothing() {}
</script>
</head>
<body onload="load()">
<div class="container index-cont gradient">
<div class="navbar navbar-inverse navbar-static-top" role="navigation">
<div class="navbar-header">
<h4 class="backnav"><a href="#" onclick="window.history.back();return false;" ><span class="arrow"></span> BACK </a></h4>
<div id="menu-toggle">
<img src="img/navbut.jpg" alt="Menu"></img>
</div>
<?php     include("includes/side_menu.php");    ?>
<a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
</div>
</div>
<!-- end navbar and slide out menu -->
<!-- start sub header section -->
<div class="container">
<div id="map" style="width: 320px; height: 500px"></div>
</div>
<!-- /container -->
<!-- modal message -->
 <!-- modal message -->
                <!-- Modal -->
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content1">
              <div class="modal-body">
                <div class="help-modal">
                <iframe id="disp2" width="100%" height="100%" frameborder="0" scrolling="yes" allowtransparency="true" src=""></iframe>
                </div>
              </div>
              <div class="modal-footer">
            <button class="btn-modal" data-dismiss="modal">Close</button>
          </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- end modal message -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/customjs.js"></script>
<script src="js/hide.js"></script>
<script>
function passID(id){
        var theurl=document.getElementById('disp2');
        theurl.src="/view_dispensary.php?id="+id;
        //alert(theurl);
}
</script>
</body>
</html>
