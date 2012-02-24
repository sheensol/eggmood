<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 
<script>
function previewLargeImage(id){
	var maxvalue=$('#maxvalue').val();
	for(var i=0; i < maxvalue; i++){
		$('#'+i).removeClass() ;
		$('#'+i).addClass('optA-obj_item');
	}
	$('#'+id).addClass('optA-obj_item-slectd');//large_
	/*$('#'+id).css('width','177px');*/
	var largesrc=$('#large_'+id).attr('src');
	$('#largeImage').attr('src',largesrc);
	var title=$('#large_'+id).attr('title');
	$('#largeImage').attr('title',title);
	
}
function saveEggMode(){
	var filename=$('#largeImage').attr('src');
	var title=$('#largeImage').attr('title');
	var data='user=<?php  echo $user;?>&type=Pre-Designed&gobackfile=eggmood-pre-designed&createpredesign=1&filename='+filename+'&title='+title;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
		top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'; ?>';
		}});
}
/*function upload(filename){
	
jQuery.ajax({type: "GET",  dataType: 'json',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
			alert(response);
		}});	
}*/
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
      <div class="optA-contents">
        <h1>Pick one from  our pre-designed Eggmoods</h1>
<!--              <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">Eggmood Library</a>  
-->        <div class="optA-left-col">
          <div class="optA-left-col-moods"> <span class="optA-pick-txt">Pick a mood</span>
            <?php
			$mood_rs=getAllMood();
			while($mood_row=mysql_fetch_array($mood_rs)){
				$mood_name=$mood_row['name'];
				$mood_image=$mood_row['image'];
				$mood_id=$mood_row['id'];
				?>
            
           
            <div class="optA-left-col-mood"> <img src="<?php echo 'images/'.$mood_image;?>" alt="" width="38" height="53" />
              <p><?php echo $mood_name;?></p>
            </div>
            
            <?php
			}
			?>
            
            
          </div>
          <div class="optA-left-col-top">
            <h2>Pick one</h2>
          </div>
          <div class="optA-names"> 
          
          <?php
			$moodcharacter_rs=getAllMoodCharacter();
			$moodtype_id_first='0';
			while($moodcharacter_row=mysql_fetch_array($moodcharacter_rs)){
				$moodcharacter_name=$moodcharacter_row['name'];
				//$moodcharacter_image=$moodcharacter_row['image'];
				$moodcharacter_id=$moodcharacter_row['id'];
				if($i!=0){$style='style="width:103px;"'; $moodtype_id_first=$moodcharacter_id;}
				else{$style='';}
				?>
               <span <?php echo $style;?> ><?php echo $moodcharacter_name;?></span> 
          <?php
			}
		  ?>
          
          </div>
          <div class="optA-objects"> 
          
          <?php
		    $faces_rs=  getFullfaces('5');
			$faces_counter='1';
			$first_id='';
			$loop_counter=0;
			$sad=array();$happy=array();$chilled=array();$angry=array(); $scared=array(); $surprised=array();
			$sadcounter=1;$happycounter=1;$chilledcounter=1; $angrycounter=1; $scaredcounter=1;$surprisedcounter=1;
			while($faces_row=mysql_fetch_array($faces_rs)){
				$face_id=$faces_row['id'];
				$face_eggmode_faceimage=$faces_row['eggmode_faceimage'];
				$face_eggmode_mode_id=$faces_row['eggmode_mode_id'];
				$face_eggmode_type_id=$faces_row['eggmode_type_id'];
				$face_eggmode_character_id=$faces_row['eggmode_character_id'];
				$face_title=$faces_row['title'];
				if($face_eggmode_mode_id=='1' || $face_eggmode_mode_id=='Sad'){
					$sad[$sadcounter]['image']=$face_eggmode_faceimage;
					$sad[$sadcounter]['title']=$face_title;
					$sadcounter++;
				}
				if($face_eggmode_mode_id=='2' || $face_eggmode_mode_id=='Happy'){
					$happy[$happycounter]['image']=$face_eggmode_faceimage;
					$happy[$happycounter]['title']=$face_title;
					$happycounter++;
				}
				if($face_eggmode_mode_id=='3' || $face_eggmode_mode_id=='Angry'){
					$angry[$angrycounter]['image']=$face_eggmode_faceimage;
					$angry[$angrycounter]['title']=$face_title;
					$angrycounter++;
				}
				if($face_eggmode_mode_id=='4' || $face_eggmode_mode_id=='Scared'){
					$scared[$scaredcounter]['image']=$face_eggmode_faceimage;
					$scared[$scaredcounter]['title']=$face_title;
					$scaredcounter++;
				}
				if($face_eggmode_mode_id=='5' || $face_eggmode_mode_id=='Surprised'){
					$surprised[$surprisedcounter]['image']=$face_eggmode_faceimage;
					$surprised[$surprisedcounter]['title']=$face_title;
					$surprisedcounter++;
				}
				if($face_eggmode_mode_id=='7' || $face_eggmode_mode_id=='Chilled'){
					$chilled[$chilledcounter]['image']=$face_eggmode_faceimage;
					$chilled[$chilledcounter]['title']=$face_title;
					$chilledcounter++;
				}
				
				
				$face_couter++;
			}
			$loop_counter=1;
			while($loop_counter <= count($sad)){
				$face_eggmode_faceimage=$sad[$loop_counter]['image'];
				$face_title=$sad[$loop_counter]['title'];
				//$sad[$sadcounter]['title']=$face_title;
				if($loop_counter==1){
				   $cls='optA-obj_item-slectd';
				   
				}else {
					  $cls='optA-obj_item';	
				}
				if($face_counter % 5==0){
					  $cls='optA-obj_item-5';	
				}
				
				?>
                <a href="#<?php echo 'link'.$loop_counter;?>" onclick="previewLargeImage('<?php echo $loop_counter;?>')" id="<?php echo $loop_counter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $loop_counter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++;
			}
			 $happycounter=$loop_counter; $loop_counter=1;
			while($loop_counter <= count($happy)){
				$face_eggmode_faceimage=$happy[$loop_counter]['image'];
				$face_title=$happy[$loop_counter]['title'];
				?>
                <a href="#<?php echo 'link'.$happycounter;?>" onclick="previewLargeImage('<?php echo $happycounter;?>')" id="<?php echo $happycounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $happycounter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $happycounter++;
			}
			
			$angrycounter=11; $loop_counter=1; 
			//echo $loop_counter."----------angrycouynter starting is ".$angrycounter;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$angry[$loop_counter]['image'];
				$face_title=$angry[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$angrycounter;?>" onclick="previewLargeImage('<?php echo $angrycounter;?>')" id="<?php echo $angrycounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $angrycounter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $angrycounter++;
			}
			 $scaredcounter=16; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$scared[$loop_counter]['image'];
				$face_title=$scared[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$scaredcounter;?>" onclick="previewLargeImage('<?php echo $scaredcounter;?>')" id="<?php echo $scaredcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $scaredcounter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $scaredcounter++;
			}
			
			 $surprisedcounter=21; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$surprised[$loop_counter]['image'];
				$face_title=$surprised[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$surprisedcounter;?>" onclick="previewLargeImage('<?php echo $surprisedcounter;?>')" id="<?php echo $surprisedcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $surprisedcounter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $surprisedcounter++;
			}
			
			 $chilledcounter=26; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$chilled[$loop_counter]['image'];
				$face_title=$chilled[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$chilledcounter;?>" onclick="previewLargeImage('<?php echo $chilledcounter;?>')" id="<?php echo $chilledcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $chilledcounter;?>" width="61" height="87" src="admin/eggmode_faces/<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $chilledcounter++;
			}
			
			
		  ?>
          </div>
        <input type="hidden" id="maxvalue" value="<?php echo $chilledcounter;?>" />
         </div>
        <div class="optA-preview"> <span>Large Preview</span> <img width="259" id="largeImage" height="366" src="" alt="" />
          <div class="buttons"> <a href="#save image" onclick="saveEggMode()" class="blue">Accept</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white optB-white">Creation Options</a> </div>
        </div>
      
    </div>
 <?php include_once("footer.php");?>
  </div>
</div>
</div>
<?php
if($file!=$_SESSION['gobackfile'].'.php'){
?>
<script>
previewLargeImage('1');
</script>
<?php
}else if($file==$_SESSION['gobackfile'].'.php'){
?>
<script>
$('#largeImage').attr('src','<?php echo $_SESSION['filename']; ?>');
</script>
<?php	
}
?>
</body>
</html>
