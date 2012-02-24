<div id='fb-root'></div>

<script src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
function ensure_init()
{
FB.init({
appId : "<?php echo $fbconfig['appid']; ?>", //APPLICATION ID
status : true, // check login status
cookie : true, // enable cookies to allow the server to access the session
xfbml : true // parse XFBML
});
FB.Canvas.setAutoGrow();
FB.XFBML.parse();
}


ensure_init();

</script>

<div id="fb-root"></div> 
<script type="text/javascript"> 
  window.fbAsyncInit = function() {
    FB.init({appId: '<?php echo $fbconfig['appid']; ?>', status: true, cookie: true, xfbml: true});
  window.setTimeout(function() {
    FB.Canvas.setAutoResize(true,900);
  }, 250);
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>