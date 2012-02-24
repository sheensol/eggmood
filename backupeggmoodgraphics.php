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
	/*if(type=='hair'){
	var top='-375px';	
	}else if(type=='eye'){
	var top='-400px';	
	}else if(type=='mouth'){
	var top='-1101px';	
	}else if(type=='nose'){
	var top='-755px';	
	}*/

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
		var saveimagedata='jsondata='+dataString+'&user=<?php echo $user;?>';
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
        <h1>Build it by graphically picking each piece</h1>
          

        <div class="optA-left-col">
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
            <h2>Pick a part for your Eggmood, move tabs for other parts</h2>
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
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
					$eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
					$title=$moodfaces_row['title'];
					$eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
             ?>
                <a href="#<?php echo 'link'.$sec_count;?>"  onclick="previewLargeImage2('<?php echo $sec_count;?>','eye')" id="<?php echo $sec_count;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $sec_count;?>" width="61" height="87" src="<?php echo $eggmode_faceimage;?>" alt="<?php echo $title;?>" title="<?php echo $title;?>"/></a>
			  <?php
                   $sec_count++;
                }
				$eye_counter_end=$sec_count-1;
                $nose_counter_start=$sec_count; 
			    $moodfaces_rs=getSelectedFaces2('2');   
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
                $eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
                $title=$moodfaces_row['title'];
				//$count=1;
                $eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
            ?>
                <a style="display:none" href="#<?php echo 'link'.$sec_count;?>"   onclick="previewLargeImage2('<?php echo $sec_count;?>','nose')"    id="<?php echo $sec_count;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $sec_count;?>" width="61" height="87" src="<?php echo $eggmode_faceimage;?>" alt="<?php echo $title;?>" title="<?php echo $title;?>"/></a>
				<?php
                 $sec_count++;
                }
				$nose_counter_end=$sec_count-1;
                  $mouth_counter_start=$sec_count; 
			      $moodfaces_rs=getSelectedFaces2('3');   
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
                $eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
                $title=$moodfaces_row['title'];
				//$count=1;
                $eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
            ?>
                <a  style="display:none" href="#<?php echo 'link'.$sec_count;?>"    onclick="previewLargeImage2('<?php echo $sec_count;?>','mouth')"    id="<?php echo $sec_count;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $sec_count;?>" width="61" height="87" src="<?php echo $eggmode_faceimage;?>" alt="<?php echo $title;?>" title="<?php echo $title;?>"/></a>
			<?php
                $sec_count++;
                }
				$mouth_counter_end=$sec_count-1;
				$hairs_counter_start=$sec_count; 
                 $moodfaces_rs=getSelectedFaces2('6');   
                while($moodfaces_row=mysql_fetch_array($moodfaces_rs)){
					$count=$moodfaces_row['id'];
                $eggmode_faceimage=$moodfaces_row['eggmode_faceimage'];
                $title=$moodfaces_row['title'];
				//$count=1;
                $eggmode_faceimage='admin/eggmode_faces/'.$eggmode_faceimage;
            ?>
                <a style="display:none" href="#<?php echo 'link'.$sec_count;?>"   onclick="previewLargeImage2('<?php echo $sec_count;?>','hair')" id="<?php echo $sec_count;?>" class="<?php echo $cls;?>"><img id="large_<?php echo $sec_count;?>" width="61" height="87" src="<?php echo $eggmode_faceimage;?>" alt="<?php echo $title;?>" title="<?php echo $title;?>"/></a>
			<?php
                $sec_count++;
                }
				$hairs_counter_end=$sec_count-1; 
                ?>
                 
                 
           
          </div>
        <input type="hidden" id="maxvalue" value="<?php echo $sec_count;?>" />
         </div>
        <div class="optA-preview"> 
        <span>Build it by graphically picking each piece</span> 
        <div id="creat_image" style="position: relative; left:-130px;">
        <img  style="position: absolute;z-index: 1;" width="259" id="largeImage" height="366" src="images/background.png" alt="" />
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
