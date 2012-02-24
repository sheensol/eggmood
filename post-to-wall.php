<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");
$image_url=$_REQUEST['image_url'];
$userdata=userData($user);
$name=$userdata['first_name'];
$eggmoodname=eggmoodName($_SESSION['fileid']);
$eggmoodname=$_REQUEST['eggmoodname'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 
<script type="text/javascript" src="json2.js"></script>
<script>
function publishWall(image_url){

if(confirm("Are you sure to publish on your wall?")){
	var message=$('#message').val();
	var eggname=$('#eggmoodname').val();
	var data='user=<?php  echo $user;?>&publishwall=1&message='+message+'&image_url='+image_url+'&eggmoodname='+eggname;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
					$(".wraper").css('opacity','0.5');
					$("#content_dialog_eggmode_app").fadeIn(300);

					
		}});
}
}

function addToLibrary(){
	var data='user=<?php  echo $user;?>&updatelibrary=1&fileid=<?php echo $_SESSION['fileid']?>';
	//alert(data);
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
	success: function(response){
		alert('Added To Library');
	
	}});
}

function closepop(){
	$(".wraper").css('opacity','1');
	$("#content_dialog_eggmode_app").css('display', 'none');
}
function invite(){
FB.ui({
method : 'apprequests',
message: '<?php echo $name;?>  has invited you to join Eggmoods'});	
}

</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Eggmood</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include_once("autocanvas.php");?>

<div class="wraper">
<input type="hidden" id="eggmoodname" value="<?php echo $eggmoodname;?>" />
  <div class="transparent-wrap">
    <?php include_once("header.php");?>
        <div class="contents-wrap">
      <div class="optC-contents">
        <h1>The Eggmood will be posted on your wall</h1>
        <div class="optC-col">
          <div class="pg8-preview" style="width:366px;"> <span><?php echo $eggmoodname;?></span> <img width="259" height="366" src="<?php echo $image_url; ?>" alt="" /> </div>
          <div class="pg9-questions">
            
            <?php
			if($_REQUEST['msg']=='no'){
				$able='disabled="disabled"';
			}else{
					$able='';
			}
			?>
            <ul>
              <li>Do you want add a message</li>
            </ul>
            <form>
              <textarea <?php echo $able;?>  name="" id="message" cols="" rows=""></textarea>
            </form>
            <div class="optC-buttons"> <a href="#publish" onclick="publishWall('<?php echo $image_url; ?>');" class="red pg9-Red">Post Eggmood</a> <a href="<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'?>" target="_top"class="white pg9-white">Back to Options of what to do</a> </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <?php include_once("footer.php");?>
    
  </div>
  
</div>
<div id="content_dialog_eggmode_app" style="display:none;padding: 20px;  border:1px solid gray;    position: absolute;left: 300px;top: 300px;background-color: white;width: 460px;height: 294px;" >
        <span style="color: white; margin-left: 434px;"><a style="text-decoration:none;" href="#close" onclick="closepop();">Close</a></span>
        <h1 style="color:#0000A0;">Where do you want to go next?</h1>
          <div class="pg15-buttons"> <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top" class="white pg15-white">Go to my Eggmood library</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white pg15-white">Create another Eggmood</a> <a href="#invite" onclick="invite();" class="white pg15-white">Tell my friends about Eggmoods</a> 
                     <a href="#invite" onclick="addToLibrary();" class="white pg15-white">Add Eggmood to library</a>
          </div>
</div>
</body>
</html>
