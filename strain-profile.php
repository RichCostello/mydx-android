<?php
	include("includes/sessions.php");
	$userid = $_SESSION['user_id'];
	$role = $_SESSION['user_rl'];
	$userg = $_SESSION['user_ug'];
	
	include($_SERVER['DOCUMENT_ROOT'] . '/db/mysql.lib.php');
	//include("configdb.php");
	
	$action="";
	include("includes/strain-profile.inc.php");
	
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
        <title>Strain Profile</title>
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
        <script>
            function submitFrm() {
                var cl1val = document.getElementById('cl1').className;
                var cl1va2 = document.getElementById('cl2').className;
                if (cl1val == 'ico ico1 active icotoggle' || cl1va2 == 'ico ico2 active icotoggle2') {
                    document.getElementById('rating').value = -1;
                }
                if (document.getElementById('strainname').value != "") {
                    document.strainPForm.submit();
                } else {
                    var inermsg = document.getElementById('errcont');
                    inermsg.innerHTML = 'Strain Profile Name is required.';
                    //alert('Strain Profile Name is required.');
                    document.getElementById('strainname').focus();
                    $('#errorModal').modal();

                }

            }
            function setRatings(id) {
                var ratng = document.getElementById('rating');

                if (id == 'cl1') {
                    ratng.value = 1;
                }
                if (id == 'cl2') {
                    ratng.value = 0;
                }

            }
        </script> 
<?php include("includes/scaling.php");?>
    </head>
    <body>
        <svg display="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <defs>
    <symbol id="icon-add" viewBox="0 0 1024 1024">
        <title>add</title>
        <path class="path1" d="M810.667 554.667h-256v256h-85.333v-256h-256v-85.333h256v-256h85.333v256h256v85.333z" />
    </symbol>
    <symbol id="icon-remove" viewBox="0 0 1024 1024">
        <title>remove</title>
        <path class="path1" d="M810.667 554.667h-597.333v-85.333h597.333v85.333z" />
    </symbol>
    </defs>
    </svg>
    <div class="container index-cont gradient">
        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
            <div class="navbar-header">
                <h4 class="backnav"><a href="#" onclick="window.history.back();
        return false;" ><span class="arrow"></span> BACK </a></h4>
                <div id="menu-toggle">
                    <img src="img/navbut.jpg" alt="Menu"></img>
                </div>
<?php include("includes/side_menu.php");?>
                <a class="navbar-brand" href="index.php"><img class="logotop" src="assets/images/mdx.png" align="center" alt=""></a>
            </div>
        </div>
        <form class="form" action="strain-profile.php?action=Save" method="post" id="strainPForm" name="strainPForm">
            <input type="hidden" value="<?= $strain_id ?>" name="sid">
            <input type="hidden" value="<?= $profileid ?>" name="uid">
            <input type="hidden" value="<?= $strainname ?>" name="strainname">
            <input type="hidden" name="deltar"  value="<?= $graphval ?>">
            <input type="hidden" name="rating" id="rating" value="-1">
            <!-- end navbar and slide out menu -->
            <!-- start sub header section -->
            <div class="container top-white">
                <div class="row">
                    <div class="col-xs-3  helpimg">
                        <a data-toggle="modal" href="apphelp.php" data-target="#helpModal"><img src="assets/images/need_help.png"></a>
                    </div>
                    <div class=" col-xs-4 text-left sprofbuffer">
<?php if ($updateStrn != "update") {
    $strainname = "";
}?>
                        <input class="form-sprofile" name="strainname" id="strainname" placeholder="Strain Profile Name" type="text" autofocus value="<?= $strainname ?>">
                    </div>
                    <div class="col-xs-5 ratebuffer">
                        <p class="ratelabel">Rate</p>
                        <ul  id="ratings">
                            <li id="cl1" class="ico ico1" onClick="setRatings(this.id);"><input type="hidden" value="0"><a href="#"></a></li>
                            <li id="cl2" class="ico ico2" onClick="setRatings(this.id);"><a href="#"><input type="hidden" value="1"></a></li>
                        </ul>
                    </div>
                </div>
            </div>            <!-- end sub header section -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills pillsbg">
                            <li class="text-center active prof-pill"><a class="White " href="#one" data-toggle="tab">Feeling</a></li>
                            <li class="text-center prof-pill pillbord"><a class="White" href="#two" data-toggle="tab">Content</a></li>
                            <li class="text-center prof-pill-end"><a class="White" href="#twee" data-toggle="tab">Intake Info</a></li>
                        </ul>
                        <div class="tab-content tabstyle" >
                            <!-- start tab pane -->
                            <div class="tab-pane active" id="one">
                                <div class="container setcol-feel">
                                    <div class="row">
                                        <div class="center-block strain-col text-center" >
                                            <!-- start buttons -->
                                            <h4 class="text-center"><span class="ccbold">Helps You Relieve</span> (rate each symptom)<a href="settings.php"><img class="setting-profile" src="assets/images/setting-small.png"></a></span></h4>
                                            <!--group top row -->

<?php
echo $relieve;
?>

<!-- end group top row -->                                          
<h4 class="text-center tenbuffer"><span class="ccbold">Helps You Feel</span> (rate each feeling)</h4>
                                            <!--group bottom row -->
<?php
//	echo sizeof($sfArraylist);
if ($updateStrn != "update") {
	if(is_array($sfArraylist)){
    foreach ($sfArraylist as $key => $value) {
        echo'
            <div class="row">
            <div class="pagination btn-group" data-toggle="buttons">
            <label class="btn btn-st-left-bot">
            <svg class="stico-remove gll"><use xlink:href="#icon-remove"></use></svg>
            <input name="' . $key . '" value="10" type="radio">Less ' . ucfirst($key) . '
            </label>
            <label class="btn btn-middle-bot active">
            <input name="' . $key . '" value="5" type="radio">
            </label>
            <label class="btn btn-medium-bot">
            <svg class="stico-remove glr"><use xlink:href="#icon-add"></use></svg>
            <input name="' . $key . '" value="0" type="radio">More ' . ucfirst($key) . '
            </label>
            </div>
            </div> ';
    }}
} else {
	if(is_array($sfArraylist)){
    foreach ($sfArraylist as $key => $value) {
        $chkM = "";
        $chkL = "";
        $chkN = "";
        $actvM = "";
        $actvN = "";
        $actvL = "";
        if ($value < 5) {
            $chkM = "checked";
            $actvM = "active";
        }
        if ($value == 5) {
            $chkN = "checked";
            $actvN = "active";
        }
        if ($value > 5) {
            $chkL = "checked";
            $actvL = "active";
        }
        echo'<div class="row">
            <div class="pagination btn-group" data-toggle="buttons">
            <label class="btn btn-st-left-bot ' . $actvL . '">
            <svg class="stico-remove gll"><use xlink:href="#icon-remove"></use></svg>
            <input name="' . $key . '" value="10" type="radio" ' . $chkL . '>Less ' . ucfirst($key) . '
            </label>
            <label class="btn btn-middle-bot ' . $actvN . '">
            <input name="' . $key . '" value="5" type="radio" ' . $chkN . '>
            </label>
            <label class="btn btn-medium-bot ' . $actvM . '" >
            <svg class="stico-remove glr"><use xlink:href="#icon-add"></use></svg>
            <input name="' . $key . '" value="0" type="radio" ' . $chkM . '>More ' . ucfirst($key) . '
            </label>
            </div>
            </div>';
    }}
}

?>                                            
<!-- end group bottom row -->
<!-- end buttons -->
</div>
</div>
</div>
<br><br>
</div>
<!-- end tab pane -->
<!-- start tab pane -->
<div class="tab-pane" id="two"><div class="top-buffer"></div>
<div class="container setcol-content">
<div class="col-xs-12 text-center">
<?php
$topval=0;
$botval=0;
if ($action != "new") {
    if ($graphvalg != "") {
        $lht = sortarray($graphvalg);
        $tlht = explode(",", $lht);
    } 
 
 $topval=number_format((float)$tlht[1], 5);
 $botval=number_format((float)$tlht[0], 5);
?>
<div class="sidenumtop"><?= $topval?></div>
<div class="sidenumbot"><?= $botval?></div>
<h3 class="tcpdata">Total Chemical Profile</h3>
<div class="mydatachart">
    <div id="savedataHolder"></div>
</div>
<?php } ?>
<div class="savetodata"><p class="bot-result-text">Help Us Improve Our Database</p> </div>
</div>
<div class="row">
<div class="form-content">
<div class="col-xs-offset-1 col-xs-8 ">
    <h5> Strain Type</h5>
</div>
<div class="col-xs-3 selectstrain">
    <select name="straintype">
        <option value="Hybrid">Hybrid</option>
        <option value="Indica">Indica</option>
        <option value="Sativa">Sativa</option>
    </select>
</div>
</div>
<?= $straincontent ?>
</div>
                                    <!-- Code for Sensor Chart Goes Here  -->

<?php if ($countm > 0) {
    echo '<div class="sensorchartarea">';
    echo $divgraph;
    echo '</div>';
}?>
<!-- End Sensor Chart Code -->
</div>
<br><br>
</div>
<!-- end tab pane -->
<!-- start tab pane -->
<div class="tab-pane" id="twee">
<div class="container setcol-intake">
<div class="row">
<div class="center-block profile-box">
<h5>Comments</h5>
<div class="form-horizontal">
<div class="form-group">
<div class="col-xs-12">
<?php
if ($updateStrn != 'update') {
    $comments = "";
}?>
<textarea name="comments" class="intake" rows="4" required><?= $comments ?></textarea>
</div>
</div>
</div>
<h5>Intake Method</h5>
<div class="form-horizontal">
<div class="form-group">
<div class="col-xs-12 styled-select">
<select id='inmethod' name="intake">
    <option>Vaporizer [Flower]</option>
    <option>Vaporizer [Oil]</option>
    <option>Glass Device</option>
    <option>Cigarette</option>
    <option>Sublingal</option>
    <option>Edible</option>
    <option>Beverage</option>
</select>
</div>
</div>
</div>
<h5>How You Felt Before</h5>
<div class="form-horizontal">
<div class="form-group">
<div class="col-xs-12 styled-select">
<select id='fbefore' name="feelingsbefore">
    <option>Positive</option>
    <option selected>Neutral</option>
    <option>Negative</option>
</select>
</div>
</div>
</div>
<h5>Save To (Data Is Anonymous)</h5>
<div class="form-horizontal">
<div class="form-group">

<?php
$s1 = '';
if ($ispublicval == 1) {
    $s1 = 'selected';
}
?>
<div class="col-xs-12 styled-select">
    <select name="savetodb">
        <option value="0">Community Database</option>
        <option value="1" <?= $s1 ?>>Internal Database</option>
    </select>
</div>
</div>
</div>
<h5>How Much Did I Intake(mg):</h5>
<div class="form-horizontal">
<div class="form-group">
<div class="col-xs-12 styled-select">
    <select id='intakeval' name="howmuch">
        <option value="0">Not Sure</option>
        <option value="5">Beginners: 2.5-5 mg THC</option>
        <option value="20">Experienced: 10-20 mg THC</option>
        <option value="25">Heavy: 25mg +</option>
    </select>
</div>
</div>
</div>
<h5>Length Of Effect</h5>
<div class="form-horizontal">
<div class="form-group">
<div class="col-xs-12 styled-select">
    <select id='leneffect' name="howlong">
        <option value="0">0-30</option>
        <option value="30" >30 min - 1 hr</option>
        <option value="60">1 hr - 2 hrs</option>
        <option value="120">>2 hrs</option>
    </select>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- end tab pane -->
</div>
</div>
</div>
</div>
</form>
        <!-- /container -->
        <!-- /container -->
        <!-- error modal -->
        <div class="modal ercustom" id="errorModal">
            <div class="modal-dialog">
                <div class="modal-canna">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"></button>
                        <h4 class="modal-title text-center errorm" >Strain Profile</h4>
                        <div class="text-center errorp">
                            <p id="errcont"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn-modal" href="<?= $_SESSION['searchLP'] ?>" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- error modal -->
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
        <div class="footer">
            <div class="wrapperfoot">
                <div class="footlink"><a href="#" onClick="submitFrm();" style="border: 0;">Add Strain Profile+</a></div>
                <div class="containerfoot">
                    <div id="buttonfoot"><a></a></div>
                    <div class="border-test"></div>
                    <div class="contentfoot">
                        <ul class="list-inline">
                            <li class="llist"><a class="text-left" href="quicktest.html" ><span class="qtest-icon"></span>Quick TEST</a></li>
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
            <script>
                
                $('#strainname').on('keyup', function(e) {
                var mEvent = e || window.event;
                var mPressed = mEvent.keyCode || mEvent.which;
                if (mPressed == 13) {
//                    alert('You pressed a "enter" key in textbox');
                    jQuery(this).blur();
                     event.stopPropagation();
                    return false;
                }
               
                return true;
            });
            $(function() {
    $('.containerfoot').on('click', function() {
        $('.wrapperfoot .contentfoot').slideToggle('slow');

    });
    $('#ratings li').click(function() {

        // remove active class for all other list items
        $(this).parents('ul').find('li.active').removeClass('active');

        // add active class on this item
        $(this).addClass('active');
        $(".ratelabel").hide()
        $("#ratings").css('top', '-3px')
    });
    var count = 0;
    $("#cl1").each(function() {
        var $thisParagraph = $(this);
        $thisParagraph.click(function() {
            count++;
            $thisParagraph.toggleClass("icotoggle", count % 3 === 0)
        });
    });
    var count = 0;
    $("#cl2").each(function() {
        var $thisParagraph = $(this);
        $thisParagraph.click(function() {
            count++;
            $thisParagraph.toggleClass("icotoggle2", count % 3 === 0);
        });
    });
// slide menu
    $('#menu-toggle').click(function() {
        if ($('#menu').hasClass('open')) {
            $('#menu').removeClass('open');
            $('#menu-toggle').removeClass('open');
        } else {
            $('#menu').addClass('open');
            $('#menu-toggle').addClass('open');
        }
    });
// end slide 
   var inp = $("#txt");
// where #txt is the id of the textbox
    $(".table-cell-text").keyup(function(event) {
        if (event.keyCode == 13) {
            $('.table-ail tr:last').after('<tr><td><span class="name">' + inp.val() + '</span></td>' +
                    '<td>' +
                    '<div class="btn-group btn-toggle">' +
                    '<button class="btn btn-sm btn-primary active">OFF</button>' +
                    ' <button class="btn btn-sm btn-default">ON</button>' +
                    '</div></td></tr>');
            $('#txt').val("");
        }
    });
    // toggle switch
    $('.btn-toggle').click(function() {
        $(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }
        if ($(this).find('.btn-danger').size() > 0) {
            $(this).find('.btn').toggleClass('btn-danger');
        }
        if ($(this).find('.btn-success').size() > 0) {
            $(this).find('.btn').toggleClass('btn-success');
        }
        if ($(this).find('.btn-info').size() > 0) {
            $(this).find('.btn').toggleClass('btn-info');
        }
        $(this).find('.btn').toggleClass('btn-default');
    });
    $("input#amount_actual.form-control.st-text").hide();
    $("#sampleStrain").click(function() {
        $("input#amount_actual.form-control.st-text").show();
    });
    $("#spinner").bind("ajaxSend", function() {
        $(this).show();
    }).bind("ajaxStop", function() {
        $(this).hide();
    }).bind("ajaxError", function() {
        $(this).hide();
    });
    $('#rpgo').click(function() {
        if ($('input[type="checkbox"]').is(':checked')) {
            $('#spinner').show();
        } else {
            $('#spinner').hide();
        }
    });
// end toggle switch
    $('#myTab a').click(function(e) {
        e.preventDefault()
        $(this).tab('show')
    });
//My data footer replace 
    $('a.White.mydata').click(function() {
        $('div.footlink-prof a').html("<span class='white'>Add Strain Profile +</span>");
    });
    var url = "https://appconnect.cdxlife.com/webapp_ges/profile.php#search/";
    $(function() {
        if (location.href == url) {
            $('div.footlink-prof a').html("<span class='white'>Add Strain Profile +</span>");
        }
    });
    $('a.White.ail, a.White.feel').click(function() {
        $('div.footlink-prof a').html("Recommend Profiles >");
    });
// End My data footer replace
//Modal
    $('#resultBtn').click(function() {
        $('#resultModal').modal({show: true})
    });
// iframe modal  
    $('.helpimg a, .subslider a, a.gn-icon.gn-icon-education, a.gn-icon.gn-icon-forums, a.gn-icon.gn-icon-faq, a.register, a.maptest, #qt1mod a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $(".help-modal").html('<iframe width="100%" height="100%" frameborder="0" scrolling="yes" allowtransparency="true" src="' + url + '"></iframe>');
    });
    $('#helpModal').on('show.bs.modal', function() {
        $(this).find('.modal-dialog').css({
            width: '60%x', //choose your width
            height: '100%',
            'padding': '0'
        });
        $(this).find('.modal-content').css({
            height: '90%',
            'border-radius': '0',
            'padding': '0'
        });
        $(this).find('.modal-body').css({
            width: 'auto',
            height: '100%',
            'padding': '0'
        });
    })
    $('.buttonpf').click(function() {
        $('.footlink-prof a').css('color', '#fff');
    });
    $(document).ready(function() {
        $(".pagination .btn").slice(1, 2).button("toggle");
    });
});
var ButtonsCtrl = function($scope) {
    $scope.singleModel = 1;
    $scope.radioModel = 'Middle';
    $scope.checkModel = {
        left: false,
        middle: true,
        right: false
    };
};
// font metrics for search results
var fontMetrics = document.getElementById('font-metrics');
var scaleTexts = $('.scale-text');
$(window).on('resize', updateFontSize);
updateFontSize();
function updateFontSize()
{
    scaleTexts.each(function()
    {
        var $scaleText = $$(this);
        fontMetrics.innerHTML = this.innerHTML;
        fontMetrics.style.fontFamily = $scaleText.css('font-family');
        fontMetrics.style.fontWeight = $scaleText.css('font-weight');
        fontMetrics.style.fontStyle = $scaleText.css('font-style');
        fontMetrics.style.textTransform = $scaleText.css('text-transform');
        var fontSize = 36; // max font-size to test
        fontMetrics.style.fontSize = fontSize + 'px';
        while ($$(fontMetrics).width() > $scaleText.width() && fontSize >= 0)
        {
            fontSize -= 1;
            fontMetrics.style.fontSize = fontSize + 'px';
        }
        this.style.fontSize = fontSize + 'px';
    });
}
function $$(object)
{
    if (!object.jquery)
        object.jquery = $(object);
    return object.jquery;
}
$("#search-results tr").click(function() {
    $(this).addClass("selected").siblings().removeClass("selected");
});
$(window).load(function() {
    var url = document.location.toString();
    if (url.match('#search')) {
        $('.nav-pills a').tab('show');
    }
    var url = document.location.toString();
    if (url.match('#feeling')) {
        $('a.White.feel').tab('show');
    }    // Change hash for page-reload
    $('.nav-tabs a').on('shown', function(e) {
        window.location.hash = e.target.hash;
    });
    var url = document.location.toString();
    if (url.match('#al1')) {
        $('.add-ailment');
    }
    //Measurement modal on start spin page
    $('#startModal').modal('show');
});
var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);
/********* FB Share GES ********/
function fbShareGs(url, title, descr, image, winWidth, winHeight) {
    var winTop = (screen.height / 2) - (winHeight / 2);
    var winLeft = (screen.width / 2) - (winWidth / 2);
    window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + encodeURIComponent(title) + '&p[summary]=' + encodeURIComponent(descr) + '&p[url]=' + encodeURIComponent(url) + '&p[images][0]=' + encodeURIComponent(image), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
}
/********* FB Share End********/
            </script>
            <script>
             window.addEventListener('load', function () {
                setTimeout(function () {
                    window.scrollTo(0, 1);
                });
                // on click events for mobile touch based browsers
                if ('ontouchstart' in document.documentElement && window.FastClick) {
                    window.FastClick.attach(document.body);
                }
            }, false);
            </script>
            <script src="js/raphael.js"></script>
            <script src="js/g.raphael-min.js"></script>
            <script src="js/g.bar-min.js"></script>
            <script src="js/g.line-min.js"></script>
            <script>
           window.onload = function() {
               // Total Chemical Profile Chart
               var r = Raphael("savedataHolder"),
                       txtattr = {font: "12px sans-serif"};
               r.barchart(0, 0, 250, 90, [[<?php echo $graphvalg ?>]], 0, {type: "sharp"}).attr({fill: "#f36f21"});
           }

<?php
//linechart js here
if ($action != "new") {
    include("includes/linechart-js.php");
}?>
            </script>
<?php if ($updateStrn == 'update') { ?>
                <script>
                    var id = 'inmethod';
                    var val = '<?php echo $intmethod ?>';
                    document.getElementById(id).value = val;
                    var id = 'fbefore';
                    var val = '<?php echo $howfeel ?>';
                    document.getElementById(id).value = val;
                    var id = 'intakeval';
                    var val = '<?php echo $qtytake ?>';
                    document.getElementById(id).selectedIndex = val;
                    var id = 'leneffect';
                    var val = '<?php echo $LOLindex ?>';
                    document.getElementById(id).selectedIndex = val;
                </script>
<?php
}
?>
            </body>
            </html>