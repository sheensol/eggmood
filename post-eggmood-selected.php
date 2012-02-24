<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");
$filetextname="";
if(isset($_REQUEST['imagefile'])){
$filename=$_REQUEST['imagefile'];
$fileid=$_REQUEST['imageid'];
$filetextname=$_REQUEST['imagetextname'];

}else{
$filename=$_SESSION['filename'];
$fileid=$_SESSION['fileid'];
$filetextname=$_SESSION['eggmoodname'];
}
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

function saveLib(){
	name=$('#eggname').val();
	var data='user=<?php  echo $user;?>&saveeggmode=1&fileid=<?php echo $fileid; ?>&name='+name;
	//alert(data);
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
			        $("#lib-box").html('Already Saved');
					$(".wraper").css('opacity','0.5');
					$("#content_dialog_eggmode_app").fadeIn(300);
		}});
}

function publishWall(image_url){
	var eggname=$('#eggname').val();
	if(confirm("Are you sure to publish on your wall?")){
	var message=$('#message').val();
	var data='user=<?php  echo $user;?>&publishwall=1&message='+message+'&image_url='+image_url+'&eggmoodname='+eggname;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
					$(".wraper").css('opacity','0.5');
					$("#content_dialog_eggmode_app").fadeIn(300);
		          
		
		
		}});
	}
}
function closepop(){
	$("#content_dialog_eggmode_app").css('display', 'none');
	$(".wraper").css('opacity','1');
}

function publish_wall(image_url,msg){
	image_url=image_url;
	var eggname=$('#eggname').val();
	top.window.location='<?php echo $fbconfig['redirect_url']."post-to-wall.php?image_url="?>'+image_url+'&msg='+msg+'&eggmoodname='+eggname;
	return;
 FB.ui(
		{
			method: 'stream.publish',
			message: 'EggMood',
			// target_id:uid,
			attachment: {
				name: "EggMood",
				caption: '',
				description:'My Selected Egg Mood',
				href: "<?php echo $fbconfig['appBaseUrl']; ?>",
				media: [{ "type": "image", "src": image_url, "href": "<?php echo $fbconfig['appBaseUrl']; ?>"}]
			},
			user_prompt_message: "Share this with your friend"
		},
		function(response) {
			
		});
}
function sendMessage(){
	var eggname=$('#eggname').val();
	var image_url=$('#largeImage').attr('src');
		image_url='<?php echo $fbconfig['baseUrl']?>'+image_url
		FB.ui({
		method: 'send',
		name: eggname,
		description : 'My Selected Egg Mood',
		link: '<?php echo $fbconfig['appBaseUrl']."/friend-created.php?user=$user"; ?>',
		picture : image_url,
		to:'<?php echo $_SESSION['creating_for']?>'
	},
	function(response)
	{
	   if(response != null ){
		   
		   var data='user=<?php  echo $user;?>&tempidid=<?php echo $_SESSION['tempid']?>&cfor=<?php echo $_SESSION['creating_for']?>';
	      jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		  success: function(response){
		     top.window.location='<?php echo $fbconfig['redirect_url'].'home.php'?>';
		   }});
	   }
	
	});
}
function addToLibrary(){
	var data='user=<?php  echo $user;?>&updatelibrary=1&fileid=<?php echo $_SESSION['fileid']?>';
	//alert(data);
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
	success: function(response){
		//alert(response);
		var rsarr=response.split('script>');
			if(response.length > 1){
			response=rsarr[2];
			//alert(response);
			}
			//alert(response);
		if(response=="0"){
		  alert('Some Error occured.please restart application');	
		}else{
		  alert('Added To Library');
		}
	
	}});
}
function send_in_message(image_url){
	var eggname=$('#eggname').val();
image_url='<?php echo $fbconfig['baseUrl']?>'+image_url
FB.ui({
method: 'send',
name: eggname,
description : 'My Selected Egg Mood',
link: '<?php echo $fbconfig['appBaseUrl']; ?>',
picture : image_url,
// redirect_uri : 'https://apps.facebook.com/pizza_datting/invite.php',
},
function(response)
{
/*if(response != null ){

top.window.location = "https://apps.facebook.com/pizza_datting/"; }
*/
}

);	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Post Eggmood</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include_once("autocanvas.php");?>
<div class="wraper">
  <div class="transparent-wrap">
    <?php include_once("header.php");?>
    <div class="contents-wrap">
      <div class="optC-contents">
        <h1>What do you want to do with your Eggmood?</h1>
        <div class="optC-col">
          <div class="pg8-preview"> 
          <span>Please edit your Eggmood's name</span><br />
          <input style="margin-top:10px;float:left; margin-left:135px;" type="text" id="eggname" name="eggname" value="<?php echo $eggmoodname; ?>" />
           <img width="259" height="366" id="largeImage" src="<?php echo $filename;?>" alt="" /> </div>
          <div class="pg8-questions">
            <ul>
            <li>Post your Eggmood on your wall</li>
            </ul>
            <form>
            <input name="a" type="radio" onclick="publish_wall('<?php echo $filename;?>','yes');" value="0" />
            <span>With a message</span>
            <input name="a" type="radio" onclick="publishWall('<?php echo $filename;?>');" value="0" />
            <span>Without a message</span>
            </form>            <ul>
              <li>Send your Eggmood to a friend</li>
            </ul>
            <form>
              <input name="a" type="radio" onclick="send_in_message('<?php echo $filename;?>')"value="0" />
              <span>Type your  message after prompt</span>
            </form>
            <ul>
              <li><a href="<?php echo $fbconfig['redirect_url']."select-profile-pic.php?filename=$filename";?>" target="_top" >Make your Eggmood your profile picture >></a></li>
            </ul>
            <ul>
            <?php
			     if(isset($_SESSION['creating_for'])){
					 ?>
                     <li><a href="#" onclick="sendMessage();">Send Back to your friend>></a></li>
                     <?php
				 }else{
			?>
              <li><a href="<?php echo $fbconfig['redirect_url'].'eggmood-send-message.php'?>" target="_top">Ask a friend to comment >></a></li>
              <?php
				 }
			  ?>
            </ul>
            <ul>
              <li><a href="#save" onclick="saveLib('<?php echo $fileid;?>')">Save the Eggmood to your personal Eggmood library >></a></li>
            </ul>
          </div>
          <div class="pg16-buttons" style="margin-left: 623px;"> 
           <a href="<?php echo $fbconfig['redirect_url'].$_SESSION['gobackfile'].'.php';?>" target="_top" onclick="deleteEggMood();" class="white pg16-white">Back</a> 
           </div>
        </div>
      </div>
    </div>
    <?php include_once("footer.php");?>
  </div>
</div>

<div id="content_dialog_eggmode_app" style="display:none;padding: 20px; border:1px solid gray; position: absolute;left: 300px;top: 300px;background-color: white;width: 460px;height: 294px;" >
          <span style="color: white; margin-left: 434px;"><a style="text-decoration:none;" href="#close" onclick="closepop();">Close</a></span>
          <h1 style="color:#0000A0;">Where do you want to go next?</h1>
          <div class="pg15-buttons">
           <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top" class="white pg15-white">Go to my Eggmood library</a> 
           <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg15-white">Create another Eggmood</a> 
           <a href="#invite" onclick="invite();" class="white pg15-white">Tell my friends about Eggmoods</a>
           <a href="#invite" id="lib-box" onclick="addToLibrary();" class="white pg15-white">Add Eggmood to library</a>
          
           </div>
</div></body>
</html>
