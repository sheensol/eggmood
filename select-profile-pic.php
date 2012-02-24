<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
        <h1>Making your Eggmood your profile picture</h1>
        <div class="pg12-col">
        <?php
		  $filename=$_REQUEST['filename'];
		
		?>
          <p>Do you want to make this Eggmood your profile picture?</p>
          <span>Eggmood Name</span> <img src="<?php echo $filename;?>" alt="" width="376" height="532" />
          <div class="optC-buttons"> <a href="<?php echo $fbconfig['redirect_url']."makeprofilepic.php?filename=$filename";?>" target="_blank" class="red optD-Red">Yes</a> <a href="<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'?>" target="_top" class="white optD-white">No</a> </div>
        </div>
      </div>
    </div>
 <?php include_once("footer.php");?>
 
   </div>
</div>
</body>
</html>
