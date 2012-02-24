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

function getRand($type_id){
$q="select * from  eggmode_faces where eggmode_type_id =$type_id order by rand() limit 1";
$rs=mysql_query($q);
$row=mysql_fetch_array($rs);
$eyes=$row['eggmode_faceimage'];
return $eyes;
}
$eyes=getRand('1');
$nose=getRand('2');
$mouth=getRand('3');
$hairs=getRand('6');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 
<script type="text/javascript" src="json2.js"></script>

<script>
var data = {"images": [{"id" : "obj_0", "type" : "none" ,"src" : "background.png"	,"width" : "259", "height" : "366"}]};

$(document).ready(function() {
	
	function placeParts(img,type){
		 var ua = $.browser;
		 var left,top;
		 if(type=='eye')top='-370px;';
		 if(type=='nose')top='-735px;';
         if(type=='mouth')top='-1100px;';
		 if(type=='hair')top='-1474px;';
		 left="0px;";
		//alert(ua.mozilla+"----"+screen.width)
  /*if (ua.mozilla && screen.width==1280) {
    alert(screen.width+"----"+screen.height);
	
	 left='320px;';
  }else{
	left='0px;';  
  }*/
		var src='admin/eggmode_faces/'+img;
		var chtml='<img style="position:relative;z-index:1; left:'+left+'top:'+top+'" src="'+src+'"/>';
		var newObject = {'id': 'test','src': src,'width': '0','height':'0','top': '0','left': '0','rotation'  : '0','type'  :type};
		data.images.push(newObject);
		$('#creat_image').append(chtml);
	}
	
	placeParts('<?php echo $eyes;?>','eye')
	placeParts('<?php echo $nose;?>','nose')
	placeParts('<?php echo $mouth;?>','mouth')
	placeParts('<?php echo $hairs;?>','hair')
	
 });
function saveEggMode(){
	var filename=$('#largeImage').attr('src');
	var title=$('#largeImage').attr('title');
	var data='user=<?php  echo $user;?>&createpredesign=1&gobackfile=eggmood-random&type=Random&filename='+filename+'&title='+title;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
		top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'; ?>';
		}});
}
function saveEggMode(){
/* *************************************************/

         var dataString  = JSON.stringify(data);
		var saveimagedata='jsondata='+dataString+'&gobackfile=eggmood-random&randomtype=1&type=Graphics&user=<?php echo $user;?>';
jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo  $fbconfig['baseUrl'].'merge.php' ?>",	data: saveimagedata,
		success: function(response){
		   top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'; ?>';
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
-->        <div class="pg6-col" style="text-align:center; height:475px;"> 


<div id="creat_image" style=" position:relative; width:260px; margin:0 0 0 0;   margin-left:300px;display:table;">
        <?php
		
		/*if($file==$_SESSION['gobackfile'].'.php'){
			if(isset($_SESSION['filename'])){
		        $background=$_SESSION['filename'];
				echo "<input type='hidden' value='1' id='gobackone' />";	
			}else{
				$background='images/background.png';
			}
		}
		else{
				$background='images/background.png';
			}

		*/
		$background='images/background.png';
		
		?>
        <img  style="z-index: 1;" width="259" id="largeImage" height="366" src="<?php echo $background;?>" alt="" />
        </div>






          <div class="optC-buttons" style="position:absolute; left:150px; top:450px; width:600px;"> <a href="#accept"  onclick="saveEggMode()" class="blue">Accept Eggmood</a> <a  target="_top"   href="<?php echo $fbconfig['redirect_url'].'eggmood-random.php'?>"  class="blue optC-Blue">Go Random Again</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg7-white">Creation Options</a> </div>
        </div>
      </div>
    </div>
<?php include_once("footer.php");?>


  </div>
</div>
</body>
</html>
