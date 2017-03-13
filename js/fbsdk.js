

/********* FB Share GES ********/    
function fbShareGs(url, title, descr, image, winWidth, winHeight) {        var winTop = (screen.height / 2) - (winHeight / 2);        var winLeft = (screen.width / 2) - (winWidth / 2);        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + encodeURIComponent(title) + '&p[summary]=' + encodeURIComponent(descr) + '&p[url]=' + encodeURIComponent(url) + '&p[images][0]=' +  encodeURIComponent(image), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);}
/********* FB Share End********/


/***************************fb login **************************/ window.fbAsyncInit = function() {
    FB.init({
            appId      : '357973111042790', // Set YOUR APP ID
            channelUrl : 'https://appconnect.cdxlife.com/webapp-demo', // Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
            });

    FB.Event.subscribe('auth.authResponseChange', function(response)
                       {
                       if (response.status === 'connected')
                       {
                       
                       console.log('Connected to Facebook');
                       
                       //SUCCESS
                       
                       }
                       else if (response.status === 'not_authorized')
                       {
                       console.log('Failed to Connect');
                       
                       //FAILED
                       } else
                       {
                       console.log('Logged Out');
                       
                       //UNKNOWN ERROR
                       }
                       });
    
};

function Login()
{
    
    FB.login(function(response) {
             if (response.authResponse)
             {
             getUserInfo();
             
             } else
             {
             console.log('User cancelled login or did not fully authorize.');
             }
             },{scope: 'email,user_photos,user_videos'});
    
}

function getUserInfo() {
    FB.api('/me', function(response) {
           var strurl="&fn="+response.first_name;
           strurl +="&ln="+response.last_name;
           strurl +="&fid="+response.id;
           strurl +="&eml="+response.email;
           
           
           document.getElementById("user-icon").value=response.email;
           document.getElementById("pass-icon").value=response.id;
           var thisone=document.getElementById('fblogin');
           var thisone=document.getElementById('qstring').value=strurl;
           document.getElementById('fblogin').action="?act=FBlogin";
           setInterval(function(){ dsubmit()},1000);
           
           });
}

function dsubmit(){
  
    $("#fblogin").submit();
}