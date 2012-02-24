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
function selectImage(id,src,text,rid){
	var counter=$('#counter').val();
	for(var i=1; i < counter; i++){
		document.getElementById(i+'radio').checked=false;
		//$('#'+i+'radio').attr('checked', false);
	}
	document.getElementById(rid+'radio').checked=true;
	$('#imageid').val(id);
	$('#imagefile').val(src)
	$('#imagetextname').val(text)
}
function deleteEggMood(){
	var imageid=$('#imageid').val();
	if(imageid==""){
	alert('select Eggmood to delete');
	return;	
	}
	if(confirm('Are you sure to delete selected Eggmood?')){
	var data='user=<?php  echo $user;?>&deleteselected=1&imageid='+imageid;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
					//$(".wraper").css('opacity','0.5');
                	top.window.location='<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>';
		}});
	}
	
}
function useEggMood(){
	var imageid,imagefile,imagetextname;
	imageid=$('#imageid').val();
	imagefile=$('#imagefile').val();
	if(imageid==""){
		alert('select Eggmood');
		return;
	}else if(imagefile==""){
		alert('select Eggmood');
		return;
	}
	imagetextname='';
	top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php?imageid='?>'+imageid+'&imagefile='+imagefile+'&imagetextname='+imagetextname;
	
    	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Eggmood</title>
<style>
.arrow {
	border:thick;
	border-color:#777777 transparent white;
	border-style:solid dashed dashed;
	margin-left:5px;
	position:relative;
	top: 10px;
}

.pagination{float:right;padding:5px 0}
.pagination li{float:left;display:inline;margin-right:0}
.pagination a{text-decoration:underline}
.pagination li a,.pagination li.current{padding:0 5px; text-decoration:none;}
.pagination li.current a,.pagination li.current{color:#d61;cursor:default;font-weight:bold;text-decoration:none}
.pagination li.arrow{background:0;margin-top:2px}
.ie7 .pagination li.arrow{margin-top:8px}
.pagination .arrow a.off{cursor:default;display:none}
.pagination .prev .on{background-position:0 -25px}
.pagination .prev .on:hover{background-position:-25px -25px}
.pagination .prev .off{background-position:-75px -25px}
.pagination .next .on{background-position:0 -50px}
.pagination .next .on:hover{background-position:-25px -50px}
.pagination .next .off{background-position:-75px -50px}
.pagination .first .on{background-position:0 -75px}
.pagination .first .on:hover{background-position:-25px -75px}
.pagination .first .off{background-position:-75px -75px}
.pagination .last .on{background-position:0 -100px}
.pagination .last .on:hover{background-position:-25px -100px}
.pagination .last .off{background-position:-75px -100px}
a,a:active{color:#36b;outline:0}
a:focus,a:hover{color:#692}
a:visited{color:#4f519e}
a:visited[href^="#"]{color:#36b}
a:visited:hover,a:visited:hover[href^="#"]{color:#692}

a.cancel{line-height:24px;height:24px}
.icon,.icns span{background-repeat:no-repeat;text-decoration:none;text-indent:-999em;text-align:left;width:13px;height:13px;display:-moz-inline-stack;display:inline-block;zoom:1;*display:inline;vertical-align:text-top}
.zbt,.zbti .icon{background-image:url(images/image-base.png);background-repeat:no-repeat}
.ie7 .zbt,.ie7 .zbti .icon{background-image:url(images/btnicons_tiled.png)}
.zts,.ztsa a,.ztsi .icon{background:url(images/image.png) no-repeat;}

</style>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <?php include_once("autocanvas.php");?>

<div class="wraper">
  <div class="transparent-wrap">
<?php include_once("header.php");?>
    <div class="contents-wrap">
      <div class="optC-contents">
        <h1>Your Eggmood Library</h1>
        <div class="optC-col">
          <!--/*<div class="pg16-prevs">
            <div class="pg16-preview"> <span>Eggmood1 Name</span> <img width="171" height="243" src="images/pg-16-prev.jpg" alt="" /> </div>
            <div class="pg16-preview"> <span>Eggmood2 Name</span> <img width="171" height="243" src="images/pg-16-prev.jpg" alt="" /> </div>
            <div class="pg16-preview"> <span>Eggmood3 Name</span> <img width="171" height="243" src="images/pg-16-prev.jpg" alt="" /> </div>
            <div class="pg16-preview"> <span>Eggmood4 Name</span> <img width="171" height="243" src="images/pg-16-prev.jpg" alt="" /> </div>
          </div>*/-->
          <div class="info-bar"> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Eggmood Name</span> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Image</span> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Type</span> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Date created</span> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Share with friends</span> 
              <span class="creation-opt" style="width:147px; padding:0; height:54px;">Select</span> 
          </div>
          
          <?php
               
			   $faces_rs=getUserEggmodeFaces($user);
			   $counter=1; $divcounter=1;
			   while($face_row=mysql_fetch_array($faces_rs)){
			          
					  $eggmode_name=$face_row['name'];
					   $id=$face_row['id'];
					  $eggmode_image=$face_row['eggmode_image'];
					  $eggmode_type=$face_row['type'];
					  $d=$face_row['dated'];
					  $eggmode_date=date("d/m/y",strtotime($d));
					  $eggmode_published=$face_row['published'];
					  if($eggmode_published=='1'){
						$eggmode_published='Yes';  
					  }else{
						$eggmode_published  ='No';
					  }
					  if($counter==1){
						  echo "<div style='display:block;' id='".$divcounter."_divs'>";  
					  }
			       ?>
                  
                    <div class="info-bar" style="height:100px;"> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><?php echo $eggmode_name;?></span> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><img width="65" height="100" src="<?php echo $eggmode_image ;?>" alt="image" /></span> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><?php echo $eggmode_type;?></span> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><?php echo $eggmode_date;?></span> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><?php echo $eggmode_published;?></span> 
                      <span class="creation-opt" style="width:147px; padding:0; height:100px;"><input type="radio" id="<?php echo $counter.'radio';?>" onclick="selectImage('<?php echo $id;?>','<?php echo $eggmode_image ;?>','<?php echo $eggmode_name ;?>','<?php echo $counter;?>')"  /></span> 
                     </div>
                     
                   
                   <?php
				   if($counter%5 == 0 && $counter!=1){
					   $divcounter++;
					echo "</div><div style='display:none;' id='".$divcounter."_divs'>";   
					
				   }
			   
			     $counter++;
			   }
			   echo "</div>";
                
           ?>
             <input type="hidden" id="imageid"  />
             <input type="hidden" id="imagefile"  />
             <input type="hidden" id="imagetextname"  />
             <input type="hidden" id="counter" value="<?php echo $counter;?>"  />
             <input type="hidden" id="currentdiv" value="1"  />
             <input type="hidden" id="divcounter" value="<?php echo $divcounter;?>"  />
          <div class="pg16-buttons"> 
           <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" id="creatmood" class="blue">Create an Eggmood</a>
           <a href="#use" onclick="useEggMood();" class="white pg16-white">use selected eggmood</a>
           <a href="#use" onclick="deleteEggMood();" class="white pg16-white">delete selected eggmood</a> 
           </div>
           <div id="nav" style="font-size:13px; float:left; margin-left:200px; margin-top:10px;">
           <script>
           function nextPage(pagenumber,total_pages,start){
			   
			  for (var cnt=start; cnt <= total_pages; cnt++)
			   {
			      $("#pagecount-"+cnt).removeClass();
			      var w='<a  href="#count" onClick=nextPage("'+cnt+'","'+total_pages+'","'+start+'");>'+cnt+'</a>';
			      $("#pagecount-"+cnt).html(w);
				  $('#'+cnt+"_divs").css('display','none');
				  
		        }
				if(pagenumber=='current'){
				  pagenumber=parseInt($('#currentdiv').val());
				  pagenumber++;
				  if( pagenumber > total_pages){
					  pagenumber=1;
				  }
				}
				if(pagenumber=='previous'){
				  pagenumber=parseInt($('#currentdiv').val());
				  pagenumber--;
				  if( pagenumber < 1){
					  pagenumber=total_pages;
				  }
				}
				if(pagenumber > 1){
				  $('#previous_arr').removeClass();
				  $('#previous_arr').addClass('icon on');
				  $('#span_previous_arr').css({'border-color':'transparent','top':'2px','border-style':'hidden'});
				}else{
					 $('#previous_arr').removeClass();
				     $('#previous_arr').addClass('icon off');
					  $('#span_previous_arr').removeAttr('style');
				}
				 $('#'+pagenumber+"_divs").css('display','block');
				 $('#currentdiv').val(pagenumber);
				 $("#pagecount-"+pagenumber).addClass('current');
				 $("#pagecount-"+pagenumber).html(pagenumber);
				 
				 
				 
				    
			   
		   }
           </script>
           <ul class="pagination zbti" id="pages_next_previous">
              <li> <span id="span_previous_arr" class="arrow prev"><a  onclick="nextPage('previous','<?php echo $divcounter; ?>','1')" id="previous_arr" class="icon off">&lt;</a></span> </li>
              <li>
                <ul id="pages" class="pages">
                  <?php 
					$cnt=0;
					
				if($divcounter > 10){
					$divcounter=10;
				}
				$cycle_counter=1;
				for($cnt=1; $cnt <= $divcounter; $cnt++ ){
					if($cnt==1){
						$class='class="current"';
					echo "<li id='pagecount-1' $class>$cnt</li>";
					}else{
				?>
                 <li  id="<?php echo "pagecount-".$cnt; ?>"><a  href="#count" onClick="nextPage('<?php echo $cnt; ?>','<?php echo $divcounter; ?>','1')"><?php echo $cnt?></a></li>
                  <?php
					}
					$cycle_counter++;
				}
				?>
                </ul>
              </li>
              <li> <span class="next"><a onclick="nextPage('current','<?php echo $divcounter; ?>','1')"class="icon on">&gt;</a></span> </li>
            </ul>
            
            
            
            
           </div>
<!--            <a href="#" onclick="showMore();" class="pg16-more">More >></a>-->
  </div>
     </div>
    </div>
 <?php include_once("footer.php");?>
  </div>
</div>
<script>
$('#eggmoodlib').css('color','white');
$('#creatmood').css('color','white');

</script>
</body>
</html>
