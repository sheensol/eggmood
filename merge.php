<?php
session_start();
include_once("config.php");

$res = json_decode(stripslashes($_REQUEST['jsondata']), true);
$user=$_REQUEST['user'];

/////////////////////////////////////////////////////////////////////////////////////////////
/* get data */
$count_images = count($res['images']);
$background 	= $res['images'][0]['src'];
$image_1 		= imagecreatefrompng('/home2/sheensol/public_html/userftp/bilalrabbi/eggmoodapp/images/'.$background);
imagealphablending($image_1, true);
imagesavealpha($image_1, true);

for($i = 1; $i < $count_images; ++$i){
	
	$image_2 = '/home2/sheensol/public_html/userftp/bilalrabbi/eggmoodapp/'.$res['images'][$i]['src'];
	$image_2= imagecreatefrompng($image_2);
	if($res['images'][$i]['type']=='eye'){
	imagecopy($image_1, $image_2,10,90,10,90,260,360);
	}
	if($res['images'][$i]['type']=='hair'){
	imagecopy($image_1, $image_2,5,9,5,9,260,360);
	}
	if($res['images'][$i]['type']=='nose'){
	imagecopy($image_1, $image_2,5,9,5,9,260,360);
	}
	if($res['images'][$i]['type']=='mouth'){
	imagecopy($image_1, $image_2,5,9,5,9,260,360);
	}

}
$filename=$user.'_'.time();
$friend_id="";
if($_SESSION['creating_for']!=""){
	   $friend_id=$user;	
	   $user	=$_SESSION['creating_for'];
	}else{
		  $friend_id=0;	
	}
	if(isset($_REQUEST['randomtype'])){
		$query="INSERT INTO `eggmode_user` (`fbuserid`, `eggmode_image`, `status`, `friendid`,`type`) VALUES ('$user','admin/eggmode_faces/$filename.png','0','$friend_id','Random')";

	}else{
	$query="INSERT INTO `eggmode_user` (`fbuserid`, `eggmode_image`, `status`, `friendid`,`type`) VALUES ('$user','admin/eggmode_faces/$filename.png','0','$friend_id','Graphics')";
	
	}
echo $query."<Br>";
mysql_query($query);
$_SESSION['filename']='admin/eggmode_faces/'.$filename.'.png';
$fileid= mysql_insert_id();
$_SESSION['fileid']=$fileid;
$_SESSION['gobackfile']=$_REQUEST['gobackfile'];

header('Content-type: image/png');
$targetfile="/home2/sheensol/public_html/userftp/bilalrabbi/eggmoodapp/admin/eggmode_faces/$filename.png";
imagepng($image_1,$targetfile);

imagedestroy($image_1);

exit;




?>  

