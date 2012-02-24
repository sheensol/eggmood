<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");
$userdata=userData($user);
$name=$userdata['first_name'];
$eggmoodname=eggmoodName($_SESSION['fileid']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 

<script>

function invite(){
FB.ui({
method : 'apprequests',
message: '<?php echo $name;?>  has invited you to join Eggmoods'});	
}


function sendMessage(){
	
	  //
	    var eggname=$('#spanname').html();
        var friendSelector = $("#jfmfs-container").data('jfmfs');             
        var image_url=$('#largeImage').attr('src');
		image_url='<?php echo $fbconfig['baseUrl']?>'+image_url
		FB.ui({
		method: 'send',
		name: eggname,
		description : 'Please Comment on my EggMood',
		link: '<?php echo $fbconfig['appBaseUrl']."/friend-comment.php?user=$user&img="?>'+image_url,
		picture : image_url,
		to:friendSelector.getSelectedIds().join(', ')
	},
	function(response)
	{
	  
		  					$(".wraper").css('opacity','0.5');
					         $("#content_dialog_eggmode_app").fadeIn(300);
	
	});	
}
function closepop(){
	$("#content_dialog_eggmode_app").css('display', 'none');
	$(".wraper").css('opacity','1');
}
			             
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Eggmood</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <?php include_once("autocanvas.php");?>
<div class="wraper" style="background: #22538b;">
  <div class="transparent-wrap">
   <?php  include_once("header.php"); ?>
    <div class="contents-wrap">
      <div class="optC-contents">
        <h1>Sending someone a message with your Eggmood</h1>
        <div class="optC-col">
          <div class="pg8-preview"> <span id="spanname" style="float:left; margin-left:135px;"><?php echo $eggmoodname;?></span> <img id="largeImage" width="259" height="366" src="<?php echo $_SESSION['filename'];?>" alt="" /> </div>
          <div class="pg11-questions">
            <ul>
              <li>Who did you want to send an Eggmood message to?</li>
            </ul>
            <!--<form>
              <input name="" type="checkbox" value="" />
              <span>Friend A</span>
              <input name="" type="checkbox" value="" />
              <span>Friend B</span>
              <input name="" type="checkbox" value="" />
              <span>Friend C</span>
            </form>-->
            <div id="selected-friends" style="height:30px"></div> 
           <div id="jfmfs-container"></div> 

            <div class="pg11-questions">
<!--              /*<ul>
                <li>Type in your message</li>
              </ul>
              <form>
                <textarea name="" cols="" rows=""></textarea>
              </form>*/--> 
            <div class="optC-buttons"> 
             <a href="#send" onclick="sendMessage()" class="red pg9-Red">Send Message</a>
             <!--<a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg9-white">Creation Options</a> 
-->           
  <a href="<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'?>" style="float: right;margin-right: -20px;" target="_top" class="white pg9-white">Back to Options of what to do</a> 
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <?php  include_once("header.php"); ?>
  </div>
</div>
<div id="content_dialog_eggmode_app" style="display:none;padding: 20px;  border:1px solid gray;    position: absolute;left: 300px;top: 300px;background-color: white;width: 460px;height: 238px;" >
    <span style="color: white; margin-left: 434px;"><a style="text-decoration:none;" href="#close" onclick="closepop();">Close</a></span>
    <h1 style="color:#0000A0;">Where do you want to go next?</h1>
    <div class="pg15-buttons"> <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top" class="white pg15-white">Go to my Eggmood library</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg15-white">Create another Eggmood</a> <a href="#invite" onclick="invite();" class="white pg15-white">Tell my friends about Eggmoods</a> </div>
</div>
<script src="https://connect.facebook.net/en_US/all.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
<script type="text/javascript" src="css/jquery.facebook.multifriend.select.js"></script> 
<link rel="stylesheet" href="css/jquery.facebook.multifriend.select.css" /> 
<script>
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
<script>
var ids;
function init() {
                  FB.api('/me', function(response) {
                     // $("#username").html("<img src='https://graph.facebook.com/" + response.id + "/picture'/><div>" + response.name + "</div>");
                      $("#jfmfs-container").jfmfs({ 
					      max_selected: 15, 
						  max_selected_message: "{0} of {1} selected",
						  friend_fields: "id,name,last_name",
						  pre_selected_friends: [1014025367],
						  exclude_friends: [1211122344, 610526078],
						  sorter: function(a, b) {
			                var x = a.last_name.toLowerCase();
			                var y = b.last_name.toLowerCase();
			                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
						  }
			          });
                      $("#jfmfs-container").bind("jfmfs.friendload.finished", function() { 
                          window.console && console.log("finished loading!"); 
                      });
                      $("#jfmfs-container").bind("jfmfs.selection.changed", function(e, data) { 
                          window.console && console.log("changed", data);
						 
						 // alert(data.object.id);
						  
                      });                     
                      
                    //  $("#logged-out-status").hide();
                     // $("#show-friends").show();
  
                  });
                } 
</script>
<script>
setTimeout(init,1000);
init();
</script>
</body>
</html>
