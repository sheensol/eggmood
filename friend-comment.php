<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");


$friend_id=$_REQUEST['user'];
$img=$_REQUEST['img'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 

<script>
function sendMessage(){
	
	var image_url=$('#largeImage').attr('src');
	$('#feedform_user_message').text('hi buddy ');
		FB.ui({
		method: 'send',
		name: 'EggMood',
		description : 'Check my comments',
		link: '<?php echo $fbconfig['appBaseUrl']."/friend-created.php?user=$user"; ?>',
		picture : image_url,
		to:'<?php echo $friend_id?>'
	},
	function(response)
	{
	   if(response != null ){
		   
		
		    // top.window.location='<?php echo $fbconfig['redirect_url'].'home.php'?>';
	   }
	
	});
}


</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Eggmood</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include_once("autocanvas.php");?>
<div class="wraper">
  <div class="transparent-wrap">
<?php include_once("header.php");?>
    <div class="contents-wrap">
      <div class="optC-contents">
        <h1>Your Friend has asked you to comment or edit his/her Eggmood</h1>
        <div class="optC-col">
          <div class="pg8-preview"> <span>Eggmood Name</span> <img id="largeImage" width="259" height="366" src="<?php echo $img?>" alt="" /> </div>
          <div class="pg9-questions">
            <ul>
              <li>Do you want add a Comment?</li>
            </ul>
            <form>
            </form>
            <div class="pg14-buttons"> <a href="#post" onclick="sendMessage();" class="blue pg14-Blue">Post Comment</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" class="blue pg14-Blue">No Thanks</a> </div>
          </div>
        </div>
      </div>
    </div>
<?php include_once("footer.php");?>
  </div>
</div>
</body>
</html>
