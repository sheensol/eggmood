<?php
session_start();
include_once("config.php");
include_once("dbfunctions.php");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script> 

<script>
function nextQuestion(){
	var parent_id=$('#mood').val();
	var data='ajax=1&parent_id='+parent_id;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
			
		      $('#moodchilds').html(response);
		}});
}
function nextCQuestion(){
		var parent_id=$('#character').val();
		var data='cquestion=1&parent_id='+parent_id;
		jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
			success: function(response){
				
				  $('#questiontext').html(response);
			}});
	
}
function select_ans(cid){
	var id=$('#'+cid).val();
	var data='id='+id+'&findresult=1';
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
			if(cid=='moodchilds'){
		       $('#result1').val(response);
			}else{
				
				$('#result2').val(response);
				showresult();
			}
			
		}});

}
function saveEggMode(){
	var filename=$('#largeImage').attr('src');
	var title=$('#largeImage').attr('title');
	var data='user=<?php  echo $user;?>&createpredesign=1&gobackfile=eggmood-questions&type=Questions&filename='+filename+'&title='+title;
	jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
		top.window.location='<?php echo $fbconfig['redirect_url'].'post-eggmood-selected.php'; ?>';
		}});
}

function showresult(){
	//alert("ca"+$('#result1').val());
	if($('#result1').val()==''){
				alert("Please Select All Options");	
				return;
	  }
	  var character_id=$('#result1').val();
	  var character_id_arr=character_id.split('_');
	  character_id=character_id_arr[0];
	  
	  var mood_id=$('#result2').val();
	  var mood_id_arr=mood_id.split('_');
	  mood_id=mood_id_arr[0];
	  var data='character_id='+character_id+'&showresult=1'+'&mood_id='+mood_id;
jQuery.ajax({type: "GET",  dataType: 'text',url: "<?php echo $dbfunctions ?>",	data: data,
		success: function(response){
				//		var rsarr=response.split('script>');
			//response=rsarr[2];
           // alert(response);
			var temp=response.split('___');
		    var title=temp[1];
			var src=temp[0];
		    //src='admin/eggmode_faces/'+src;
		    $('#largeImage').attr('src',src);
		    $('#largeImage').attr('title',title);
			$('#acceptmood').css('display','block');
			$('#optc_preview').css('display','block');
			//$('#largeImage').attr('src',response);
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
        <h1>Answer a few questions to pick one</h1>
<!--         <a style="padding: 5px 20px;" href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">Eggmood Library</a>
-->        <div class="optC-col">
          <div class="optC-questions">
            <div class="optC-head">Eggmood character questions</div>
            <ul>
              <li>What gender do you want your Eggmood to be?</li>
            </ul>
            <form>
            <select onchange="nextQuestion()" id="mood" name="">
            <?php
			    $rs=getChilds('6');
				$cnt=0;
				while($row=mysql_fetch_array($rs)){
					$question_statement=$row['question_statement'];
					$id=$row['id'];
					if($cnt==0){
						?>
                        <option>Select Options</option>
                        <?php
					}
					?>
                    <option value="<?php echo $id;?>"><?php echo $question_statement;?></option>
                    <?php
					$cnt++;
				}
			?>
              </select>
            </form>
            <ul>
              <li>Would you rather make a million dollars or be on a planet where money does not exist?</li>
            </ul>
            <form>
              <select onchange="select_ans('moodchilds')" id="moodchilds" name="">
                
              </select>
            </form>
          </div>
          <div class="optC-questions">
            <div class="optC-head">Mood questions</div>
            <ul>
              <li>If your doorbell rang right now, what would you expect?</li>
            </ul>
            <form>
            <select onchange="nextCQuestion()" id="character">
             <?php
			    $rs=getChilds('17');
				$cnt=0;
				while($row=mysql_fetch_array($rs)){
					$question_statement=$row['question_statement'];
					$id=$row['id'];
					if($cnt==0){
						?>
                        <option>Select Options</option>
                        <?php
					}
					?>
                    <option value="<?php echo $id;?>"><?php echo $question_statement;?></option>
                    <?php
					$cnt++;
				}
			?>
              </select>
            </form>
            <div id="questiontext">
            <ul>
              <li></li>
            </ul>
            <form>
              <select name="">
              </select>
            </form>
            </div>
          </div>
          
          <input type="hidden" id="result1" />
          <input type="hidden" id="result2" />
          <?php
		  if($file==$_SESSION['gobackfile'].'.php'){
		  if(isset($_SESSION['filename'])){
			 $style='style="display:block;"';
		     $background=$_SESSION['filename'];	
			 $spantext="Previous Eggmood";
		   }
		   else{
			   $style='style="display:none;"';
			   $background='images/background.png';
			   $spantext="Resulting Eggmood";
		   }
		  }else{
			   $style='style="display:none;"';
			   $background='images/background.png';
			   $spantext="Resulting Eggmood";
		   }
		  ?>
          
          <div class="optC-preview" id="optc_preview" <?php echo $style;?> > <span><?php echo $spantext;?></span> <img id="largeImage" width="259" height="366" src="<?php echo $background;?>" alt="" /> </div>
          <div class="optC-buttons">
           <a href="<?php echo $fbconfig['redirect_url'].'home.php'?>" target="_top" class="white optC-white">Creation Options</a> 
           <a href="<?php echo $fbconfig['redirect_url'].'eggmood-questions.php'?>" target="_top" class="blue optC-Blue" style="margin-right:25px;">Answer questions again</a>
           <a href="#accept" style="display:none;" id="acceptmood" onclick="saveEggMode()" class="blue">Accept Eggmood suggested</a> </div>
        </div>
      </div>
    </div>
    <?php include_once("footer.php"); ?>
  </div>
</div>
</body>
</html>
