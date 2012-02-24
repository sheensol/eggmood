<?php
session_start();
include("config.php");
include("dbfunctions.php");
$userdata=userData($user);
$name=$userdata['first_name'];

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

function eggmoodRequests() {
  FB.ui({method: 'apprequests',
    message: 'Please Create My EggMood For Me',
  }, requestCallback);
}
function requestCallback(response){
	if(!response){
	return;	
	}
		console.log(response.to[0]);
	var data='invited='+response.to[0]+'&tempid='+response.request+'&user=<?php echo $user?>';
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
		      //$('#moodchilds').html(response);
		}});
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Eggmood Home</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <?php include_once("autocanvas.php");?>
<div class="wraper" style="background: #22538b;">
  <div class="transparent-wrap">
<?php  include_once("header.php"); ?>


    <div class="contents-wrap">
      <div class="contents">
        <h1>Create you Eggmood</h1>
<!--        <a href="#invite" onclick="invite();" class="invite">Invite Friends</a> 
-->        <a href="<?php echo $fbconfig['redirect_url'].'eggmood-pre-designed.php'?>" target="_top" class="option"> <img src="images/option-a-icon.png" alt="" width="41" height="60" class="option-icon-a" /> <span>Pick one</span> </a> 
        <a href="<?php echo $fbconfig['redirect_url'].'eggmood-graphics.php'?>" target="_top" class="option"> <img src="images/option-b-icon.png" alt="" width="60" height="44" class="option-icon-b" /> <span class="option-b-txt">Pick each part (eyes, noses)</span> </a> 
        <a href="<?php echo $fbconfig['redirect_url'].'eggmood-questions.php'?>" target="_top" class="option"> <img src="images/option-c-icon.png" alt="" width="42" height="60" class="option-icon-a" /> <span class="option-b-txt">Answer a few questions to pick one</span> </a>
        <a href="#invite" onclick="eggmoodRequests();" class="option"> <img src="images/option-d-icon.png" alt="" width="60" height="45" class="option-icon-d" /> <span>Ask a friend</span> </a> 
        <a href="<?php echo $fbconfig['redirect_url'].'eggmood-random.php'?>" target="_top" class="option"> <img src="images/option-e-icon.png" alt="" width="64" height="43" class="option-icon-e" /> <span>Random (trust fate)</span> </a>
      </div>
    </div>
    <?php include_once("footer.php"); ?>
  </div>
</div>
</body>
</html>
