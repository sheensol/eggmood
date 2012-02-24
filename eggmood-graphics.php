<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 
<script type="text/javascript" src="json2.js"></script>

<script>
var data = {"images": [{"id" : "obj_0", "type" : "none" ,"src" : "background.png"	,"width" : "259", "height" : "366"}]};
Array.prototype.remove = function(from, to) {
				  var rest = this.slice((to || from) + 1 || this.length);
				  this.length = from < 0 ? this.length + from : from;
				  return this.push.apply(this, rest);
				};
function previewLargeImage(id){
	var maxvalue=$('#maxvalue').val();
	for(var i=0; i < maxvalue; i++){
		$('#'+i).removeClass() ;
		$('#'+i).addClass('optA-obj_item');
		$('#large_'+i).removeAttr('style');
		$('#large_'+i).attr('width','61');
		$('#large_'+i).attr('height','87');
	}
	$('#'+id).addClass('optA-obj_item-slectd');//large_
	var largesrc=$('#large_'+id).attr('src');
	$('#large_'+id).css({'left':'212px','top':'24px','position':'relative'});
	$('#large_'+id).removeAttr('width');
	$('#large_'+id).removeAttr('height');
	
	
}

function previewLargeImage2(id,type){
	
	
	if(document.getElementById("gobackone")){
	if(document.getElementById("gobackone").value=='1'){
		if(confirm("do you want to create new eggmood? your previous created eggmood will be lost.")){
		  	$('#largeImage').attr('src','images/background.png');
			document.getElementById("gobackone").value='3';
		}else{
			return;
		}
	}
	}
	
	
	
	var maxvalue=$('#maxvalue').val();
	for(var i=0; i < maxvalue; i++){
		$('#'+i).removeClass() ;
		$('#'+i).addClass('optA-obj_item');
		
	}
	$('#'+id).addClass('optA-obj_item-slectd');

	var chtml=$('#'+id).html();
	$('#creat_image').append(chtml);//
	$('.optA-objects #large_'+id).remove();
	$('#creat_image #large_'+id).removeAttr('width');
	$('#creat_image #large_'+id).removeAttr('height');

	$('#creat_image #large_'+id).css({'position':'absolute','z-index':'1'});
	
	var objid='large_'+id;
	var objsrc=$('#creat_image #large_'+id).attr('src');  //objwidth,objheight,objtop,objleft,'rotation'  : '0'
	var objwidth=$('#creat_image #large_'+id).attr('260');
	var objheight=$('#creat_image #large_'+id).attr('height');
	var objtop=$('#creat_image #large_'+id).attr('top');
	var objleft=$('#creat_image #large_'+id).css('left');
	type=jQuery.trim(type);
	remove_object(type);
	
	
	var newObject = {'id': objid,'src': objsrc,'width': objwidth,'height': objheight,'top': objtop,'left': objleft,'rotation'  : '0','type'  : type};
	data.images.push(newObject);
	
}
function remove_object(selected_type){
	selected_type=jQuery.trim(selected_type);
	
	for(var i = 0;i<data.images.length;++i){
		if(data.images[i].type === selected_type){
			
			var id=data.images[i].id
			var getid=data.images[i].id;
			var larr=getid.split('_');
			var add_tohref_id=larr[1];
			
			var chtml_src=$('#'+id).attr('src');
			
			var chtml='<img id="'+getid+'" width="61" height="87" src="'+chtml_src+'">';
	        $('#'+add_tohref_id).append(chtml);
			$('#creat_image #'+getid).remove();
			data.images.remove(i);
		}
	}
	
}
function saveEggMode(){
/* *************************************************/

         var dataString  = JSON.stringify(data);
		var saveimagedata='jsondata='+dataString+'&gobackfile=eggmood-graphics&type=Graphics&user=<?php echo $user;?>';
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
      <div class="optA-contents">
        <h1>Pick each part (eyes, noses)</h1>
<!--        <a href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">Eggmood Library</a>
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
            <h2>Pick your parts</h2>
            <ul>
             <?php
			$moodtype_rs=getAllMoodType();
			while($moodtype_row=mysql_fetch_array($moodtype_rs)){
				$moodtype_name=$moodtype_row['name'];
				$moodtype_image=$moodtype_row['image'];
				$moodtype_id=$moodtype_row['id'];
				?>
                 <li> <a style="text-decoration:none;" href="#<?php echo $moodtype_id.'link'; ?>" onclick="nextTab('<?php echo $moodtype_name; ?>')"> <img src="images/<?php echo $moodtype_image;?>" alt="" width="20" height="10" /> <span><?php echo $moodtype_name;?></span> </a> </li>
                <?php
				
			}
				?>
              </ul>
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
			 $count=1; 
			 $sec_count=1;  
			 $eye_counter_start=1;
			 $cls='optA-obj_item';
			 $moodfaces_rs=getSelectedFaces2('1'); 
			 $sad=array();$happy=array();$chilled=array();$angry=array(); $scared=array(); $surprised=array();
			 $sadcounter=1;$happycounter=1;$chilledcounter=1; $angrycounter=1; $scaredcounter=1;$surprisedcounter=1;
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
					$eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
					$face_title=$moodfaces_row['title'];
					$face_eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
					$face_eggmode_mode_id=$moodfaces_row['eggmode_mode_id'];
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
					
				}
			 $loop_counter=1;
			 
	/******************EYES LOOP AND ARRAYS WITH COUNTER**********************************************/
			 $globalcounter=1;
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
                <a href="#<?php echo 'link'.$loop_counter;?>" onclick="previewLargeImage2('<?php echo $loop_counter;?>','eye')" id="<?php echo $loop_counter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $loop_counter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++;
			}
			 $eye_counter_end=$sec_count-1;
			 
			$happycounter=$loop_counter; $loop_counter=1;
			while($loop_counter <= count($happy)){
				$face_eggmode_faceimage=$happy[$loop_counter]['image'];
				$face_title=$happy[$loop_counter]['title'];
				?>
                  <a href="#<?php echo 'link'.$happycounter;?>" onclick="previewLargeImage2('<?php echo $happycounter;?>','eye')" id="<?php echo $happycounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $happycounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
                <?php
			$loop_counter++; $happycounter++;
			}
			
			$angrycounter=11; $loop_counter=1; 
			//echo $loop_counter."----------angrycouynter starting is ".$angrycounter;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$angry[$loop_counter]['image'];
				$face_title=$angry[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$angrycounter;?>" onclick="previewLargeImage2('<?php echo $angrycounter;?>','eye')" id="<?php echo $angrycounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $angrycounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $angrycounter++;
			}
			 $scaredcounter=16; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$scared[$loop_counter]['image'];
				$face_title=$scared[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$scaredcounter;?>" onclick="previewLargeImage2('<?php echo $scaredcounter;?>','eye')" id="<?php echo $scaredcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $scaredcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $scaredcounter++;
			}
			
			 $surprisedcounter=21; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$surprised[$loop_counter]['image'];
				$face_title=$surprised[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$surprisedcounter;?>" onclick="previewLargeImage2('<?php echo $surprisedcounter;?>','eye')" id="<?php echo $surprisedcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $surprisedcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $surprisedcounter++;
			}
			
			 $chilledcounter=26; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$chilled[$loop_counter]['image'];
				$face_title=$chilled[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$chilledcounter;?>" onclick="previewLargeImage2('<?php echo $chilledcounter;?>','eye')" id="<?php echo $chilledcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $chilledcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $chilledcounter++;
			}
			
			 $globalcounter=$chilledcounter;
			 $eye_counter_start=1;
			 $eye_counter_end=30;
	
	
	
	/***********************************NOSE LOOPS AND ARRAYS WITH COUNTERS***************************************************/
	         $nose_counter_start=31;
			// $nose_counter_end=1;
	         $moodfaces_rs=getSelectedFaces2('2'); 
			 $sad=array();$happy=array();$chilled=array();$angry=array(); $scared=array(); $surprised=array();
			 $sadcounter=1;$happycounter=1;$chilledcounter=1; $angrycounter=1; $scaredcounter=1;$surprisedcounter=1;
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
					$eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
					$face_title=$moodfaces_row['title'];
					$face_eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
					$face_eggmode_mode_id=$moodfaces_row['eggmode_mode_id'];
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
                <a href="#<?php echo 'link'.$globalcounter;?>" style="display:none;" onclick="previewLargeImage2('<?php echo  $globalcounter;?>','nose')" id="<?php echo  $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo  $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++;  $globalcounter++;
			}
			// $eye_counter_end=$sec_count-1;
			 
			$happycounter=$loop_counter; $loop_counter=1;
			while($loop_counter <= count($happy)){
				$face_eggmode_faceimage=$happy[$loop_counter]['image'];
				$face_title=$happy[$loop_counter]['title'];
				?>
                <a href="#<?php echo 'link'. $globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo  $globalcounter;?>','nose')" id="<?php echo  $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo  $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $happycounter++;  $globalcounter++;
			}
			
			$angrycounter=11; $loop_counter=1; 
			//echo $loop_counter."----------angrycouynter starting is ".$angrycounter;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$angry[$loop_counter]['image'];
				$face_title=$angry[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','nose')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $angrycounter++; $globalcounter++;
			}
			 $scaredcounter=16; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$scared[$loop_counter]['image'];
				$face_title=$scared[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;"   onclick="previewLargeImage2('<?php echo $globalcounter;?>','nose')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $scaredcounter++; $globalcounter++;
			}
			
			 $surprisedcounter=21; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$surprised[$loop_counter]['image'];
				$face_title=$surprised[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"    style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','nose')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $surprisedcounter++; $globalcounter++;
			}
			
			 $chilledcounter=26; $loop_counter=1; 
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$chilled[$loop_counter]['image'];
				$face_title=$chilled[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','nose')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $chilledcounter++; $globalcounter++;
			}
		
			 $nose_counter_end=$globalcounter-1;
			
			
	/****************************************************************************************/		
			
	/***********************************Mouth LOOPS AND ARRAYS WITH COUNTERS***************************************************/
	         $mouth_counter_start=61;
			// $nose_counter_end=1;
	         $moodfaces_rs=getSelectedFaces2('3'); 
			 $sad=array();$happy=array();$chilled=array();$angry=array(); $scared=array(); $surprised=array();
			 $sadcounter=1;$happycounter=1;$chilledcounter=1; $angrycounter=1; $scaredcounter=1;$surprisedcounter=1;
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
					$eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
					$face_title=$moodfaces_row['title'];
					$face_eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
					$face_eggmode_mode_id=$moodfaces_row['eggmode_mode_id'];
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
                <a href="#<?php echo 'link'.$globalcounter;?>" style="display:none;" onclick="previewLargeImage2('<?php echo  $globalcounter;?>','mouth')" id="<?php echo  $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo  $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++;  $globalcounter++;
			}
			// $eye_counter_end=$sec_count-1;
			 
			$happycounter=$loop_counter; $loop_counter=1;
			while($loop_counter <= count($happy)){
				$face_eggmode_faceimage=$happy[$loop_counter]['image'];
				$face_title=$happy[$loop_counter]['title'];
				?>
                <a href="#<?php echo 'link'. $globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo  $globalcounter;?>','mouth')" id="<?php echo  $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo  $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $happycounter++;  $globalcounter++;
			}
			
			$angrycounter=11; $loop_counter=1; 
			//echo $loop_counter."----------angrycouynter starting is ".$angrycounter;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$angry[$loop_counter]['image'];
				$face_title=$angry[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','mouth')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $angrycounter++; $globalcounter++;
			}
			 $scaredcounter=16; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$scared[$loop_counter]['image'];
				$face_title=$scared[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;"   onclick="previewLargeImage2('<?php echo $globalcounter;?>','mouth')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $scaredcounter++; $globalcounter++;
			}
			
			 $surprisedcounter=21; $loop_counter=1;
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$surprised[$loop_counter]['image'];
				$face_title=$surprised[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"    style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','mouth')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $surprisedcounter++; $globalcounter++;
			}
			
			 $chilledcounter=26; $loop_counter=1; 
			while($loop_counter <= 5){
				$face_eggmode_faceimage=$chilled[$loop_counter]['image'];
				$face_title=$chilled[$loop_counter]['title'];
			?>
                <a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','mouth')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
            <?php
			$loop_counter++; $chilledcounter++; $globalcounter++;
			}
		
			 $mouth_counter_end=$globalcounter-1;
			
			
	/****************************************************************************************/		
		
			
	/***********************************Hairs LOOPS AND ARRAYS WITH COUNTERS***************************************************/
	         $hairs_counter_start=91;
			// $nose_counter_end=1;
	         $moodfaces_rs=getSelectedFaces2('6'); 
			 $sad=array();$happy=array();$chilled=array();$angry=array(); $scared=array(); $surprised=array();
			 $sadcounter=1;$happycounter=1;$chilledcounter=1; $angrycounter=1; $scaredcounter=1;$surprisedcounter=1;
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
					$eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
					$face_title=$moodfaces_row['title'];
					$face_eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
					$face_eggmode_mode_id=$moodfaces_row['eggmode_mode_id'];
				    //$face_eggmode_faceimage=$chilled[$loop_counter]['image'];
				    //$face_title=$chilled[$loop_counter]['title'];
					?>
						<a href="#<?php echo 'link'.$globalcounter;?>"   style="display:none;" onclick="previewLargeImage2('<?php echo $globalcounter;?>','hair')" id="<?php echo $globalcounter;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $globalcounter;?>" width="61" height="87" src="<?php echo $face_eggmode_faceimage;?>" alt="<?php echo $face_title;?>" title="<?php echo $face_title;?>"/></a>
					<?php
					$loop_counter++;  $globalcounter++;
				}
			 $loop_counter=1;
			
		
			 $hairs_counter_end=$globalcounter-1;
			
			
	/****************************************************************************************/		
		
    ?>
           
          </div>
        <input type="hidden" id="maxvalue" value="<?php echo $globalcounter;?>" />
         </div>
        <div class="optA-preview"> 
        <span>Your Eggmood</span> 
        <div id="creat_image" style="position: relative; left:-130px;">
        <?php
		
		if($file==$_SESSION['gobackfile'].'.php'){
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

		
		
		
		?>
        <img  style="position: absolute;z-index: 1;" width="259" id="largeImage" height="366" src="<?php echo $background;?>" alt="" />
        </div>
        
        
          <div class="buttons" style="position:relative; top:400px; "> <a href="#save image" onclick="saveEggMode()" class="blue">Accept</a> <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white optB-white">Creation Options</a> </div>
        </div>
      
    </div>
 <?php include_once("footer.php");?>
  </div>
</div>
</div>
<script>
function nextTab(id){
	if(id=='Eyes'){
	for(var i='<?php echo $eye_counter_start;?>'; i <='<?php echo $eye_counter_end;?>'; i++){
    	$('#'+i).css('display','block');	
	   }
		for(var i='<?php echo $nose_counter_start;?>'; i <= '<?php echo $nose_counter_end;?>'; i++){
			$('#'+i).css('display','none');	
		}
		for(var i='<?php echo $mouth_counter_start;?>'; i <= '<?php echo $mouth_counter_end;?>'; i++){
			$('#'+i).css('display','none');	
		}
		 for(var i='<?php echo $hairs_counter_start;?>'; i <= '<?php echo $hairs_counter_end;?>'; i++){
				$('#'+i).css('display','none');	
			}
		
	}
	if(id=='Nose'){
		
		for(var i='<?php echo $nose_counter_start;?>'; i <= '<?php echo $nose_counter_end;?>'; i++){
			$('#'+i).css('display','block');	
		}
	   for(var i='<?php echo $eye_counter_start;?>'; i <='<?php echo $eye_counter_end;?>'; i++){
    	$('#'+i).css('display','none');	
	   }
		for(var i='<?php echo $mouth_counter_start;?>'; i <= '<?php echo $mouth_counter_end;?>'; i++){
    	$('#'+i).css('display','none');	
	    }
		 for(var i='<?php echo $hairs_counter_start;?>'; i <= '<?php echo $hairs_counter_end;?>'; i++){
				$('#'+i).css('display','none');	
			}
	
	}
	if(id=='Mouth'){
		for(var i='<?php echo $mouth_counter_start;?>'; i <= '<?php echo $mouth_counter_end;?>'; i++){
			$('#'+i).css('display','block');	
		}
	
		for(var i='<?php echo $nose_counter_start;?>'; i <= '<?php echo $nose_counter_end;?>'; i++){
			$('#'+i).css('display','none');	
		}
		
		for(var i='<?php echo $eye_counter_start;?>'; i <='<?php echo $eye_counter_end;?>'; i++){
			$('#'+i).css('display','none');	
		   }
		   for(var i='<?php echo $hairs_counter_start;?>'; i <= '<?php echo $hairs_counter_end;?>'; i++){
				$('#'+i).css('display','none');	
			}
	}
	if(id=='Hairs'){
		for(var i='<?php echo $hairs_counter_start;?>'; i <= '<?php echo $hairs_counter_end;?>'; i++){
				$('#'+i).css('display','block');	
			}
	   for(var i='<?php echo $nose_counter_start;?>'; i <= '<?php echo $nose_counter_end;?>'; i++){
			$('#'+i).css('display','none');	
		}
	   for(var i='<?php echo $eye_counter_start;?>'; i <='<?php echo $eye_counter_end;?>'; i++){
    	$('#'+i).css('display','none');	
	   }
		for(var i='<?php echo $mouth_counter_start;?>'; i <= '<?php echo $mouth_counter_end;?>'; i++){
    	$('#'+i).css('display','none');	
	    }
	}
	
	
}
</script>
</body>
</html>
