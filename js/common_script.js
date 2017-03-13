$(function() {
    $('.containerfoot').on('click', function() {
        $('.wrapperfoot .contentfoot').slideToggle('slow');

    });
    //rate button toggle
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
    // Add an ailment section 
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
    // End add an ailment section
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
    $('#myTab a').click(function(e) {
        e.preventDefault()
        $(this).tab('show')
    });
    // End tabbed content
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
        $('#resultModal').modal({
            show: true
        })
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

function updateFontSize() {
    scaleTexts.each(function() {
        var $scaleText = $$(this);
        fontMetrics.innerHTML = this.innerHTML;
        fontMetrics.style.fontFamily = $scaleText.css('font-family');
        fontMetrics.style.fontWeight = $scaleText.css('font-weight');
        fontMetrics.style.fontStyle = $scaleText.css('font-style');
        fontMetrics.style.textTransform = $scaleText.css('text-transform');
        var fontSize = 36; // max font-size to test
        fontMetrics.style.fontSize = fontSize + 'px';
        while ($$(fontMetrics).width() > $scaleText.width() && fontSize >= 0) {
            fontSize -= 1;
            fontMetrics.style.fontSize = fontSize + 'px';
        }
        this.style.fontSize = fontSize + 'px';
    });
}

function $$(object) {
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
    }
    // Change hash for page-reload
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

window.addEventListener('load', function() {
    setTimeout(function() {
        // hide the address bar in iPhone Safari
        window.scrollTo(0, 1);
    });
    // fast click library is used to remove 300ms delay
    // on click events for mobile touch based browsers
    if ('ontouchstart' in document.documentElement && window.FastClick) {
        window.FastClick.attach(document.body);
    }
}, false);