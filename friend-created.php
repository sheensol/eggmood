<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");

//print_r($_REQUEST);//friend_id==this fbuserid===user

$friend_id=$_REQUEST['user'];

$q="select * from `eggmode_user` where friendid='$friend_id' and fbuserid=$user order by id desc limit 1";
$rs=mysql_query($q);
$row=mysql_fetch_array($rs);
$image_url=$row['eggmode_image'];




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
<div class="wraper">
  <div class="transparent-wrap">
<?php include_once("header.php");?>
    <div class="contents-wrap">
      <div class="optC-contents">
        <h1>Your friend has created an Eggmood for you as you had requested:</h1>
         <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">Eggmood Library</a>
        <div class="pg6-col"> <img src="<?php echo $image_url;?>" alt="" width="376" height="532" />
          <div class="optC-buttons"> <a href="#" class="blue">Accept Eggmood</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" class="white optD-white">Creation Options</a> </div>
        </div>
      </div>
    </div>
<?php include_once("footer.php");?>
  </div>
</div>
</body>
</html>
