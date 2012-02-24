<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");
$image_url=getRandomFullfaces();
$temp=explode('___',$image_url);
$image_url='admin/eggmode_faces/'.$temp[0];
$title=$temp[1];
if($file==$_SESSION['gobackfile'].'.php'){
if(isset($_SESSION['filename'])){
		   $image_url=$_SESSION['filename'];	
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 

<script>
function saveEggMode(){
	var filename=$('#largeImage').attr('src');
	var title=$('#largeImage').attr('title');
	var data='user=<?php  echo $user;?>&createpredesign=1&gobackfile=eggmood-random&type=Random&filename='+filename+'&title='+title;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
		top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'; ?>';
		}});
}
function selectedRandom(){
	
	var filename=$('#largeImage').attr('src');
	var data='selectrandom=1';
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
			var rsarr=response.split('script>');
			//alert(response);
			response=rsarr[2];
			//alert(response);
            var temp=response.split('___');
		    var title=temp[1];
			var src=temp[0];
		    src='admin/eggmode_faces/'+src;
		    $('#largeImage').attr('src',src);
		    $('#largeImage').attr('title',title);
		}});
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
        <h1>We have built a random Eggmood for you:</h1>
<!--         <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">Eggmood Library</a>
-->        <div class="pg6-col"> <img src="<?php echo $image_url; ?>" title="<?php echo $title;?>" id="largeImage" alt="" width="260"  />
          <div class="optC-buttons"> <a href="#accept"  onclick="saveEggMode()" class="blue">Accept Eggmood</a> <a href="#random"   onclick="selectedRandom()"  class="blue optC-Blue">Go Random Again</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg7-white">Creation Options</a> </div>
        </div>
      </div>
    </div>
<?php include_once("footer.php");?>


  </div>
</div>
</body>
</html>
