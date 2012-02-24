<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
function invite(){
FB.ui({
method : 'apprequests',
message: 'Select EggMood for yourself.'});	
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
        <h1>Where do you want to go next?</h1>
        <div class="optC-col">
          <div class="pg15-buttons"> <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top" class="white pg15-white">Go to my Eggmood library</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg15-white">Create another Eggmood</a> <a href="#invite" onclick="invite();" class="white pg15-white">Tell my friends about Eggmoods</a> </div>
        </div>
      </div>
    </div>
   <?php  include_once("footer.php"); ?>
  </div>
</div>
</body>
</html>
