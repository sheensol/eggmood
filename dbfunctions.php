<?php
session_start();
include_once("config.php");
$check_for_insertion=0;
$fbconfig['http'];
function getAllMood(){
	$query="SELECT * FROM  `eggmode_mode` WHERE status=1 ";
	$rs=mysql_query($query);
	return $rs;
}
function getAllMoodType(){
	$query="SELECT * FROM  `eggmode_type` WHERE status=1 ";
	$rs=mysql_query($query);
	return $rs;
}
function getAllMoodCharacter(){
	$query="SELECT * FROM  `eggmode_character` WHERE status=1 ";
	$rs=mysql_query($query);
	return $rs;
}
function getSelectedFaces($moodtype_id){
	$query="SELECT * FROM  `eggmode_faces` WHERE status=1 and eggmode_type_id=$moodtype_id order by eggmode_character_id asc";
	$rs=mysql_query($query);
	$count=1;
	while($row=mysql_fetch_array($rs)){
		$eggmode_faceimage=$row['eggmode_faceimage'];
		$title=$row['title'];
		$eggmode_faceimage='admin/eggmode_faces/th'.$eggmode_faceimage;
	?>
     <div class="obj_item"><img  title="<?php echo $title;?>"id="obj_<?php echo $count;?>" width="56" height="33" class="ui-widget-content" src="<?php echo $eggmode_faceimage;  ?>" alt="el"/></div>
    <?php
	$count++;	
	}
}
function getSelectedFaces2($moodtype_id){
	if($moodtype_id=='6'){
	$query="SELECT * FROM  `eggmode_faces` WHERE status=1 and eggmode_type_id=6 order by eggmode_character_id asc";	
	}else{
	$query="SELECT * FROM  `eggmode_faces` WHERE status=1 and eggmode_type_id=$moodtype_id ";
	}
	$rs=mysql_query($query);
	return $rs;
	
}
function getFullfaces($moodtype_id){
	$query="SELECT * FROM  `eggmode_faces` WHERE eggmode_type_id='5' order by eggmode_character_id ASC";
	$rs=mysql_query($query);
	return $rs;
	
}
function getUserEggmodeFaces($user){
	
	$query="SELECT * FROM  `eggmode_user` WHERE fbuserid=$user and status=1 order by dated DESC";
	$rs=mysql_query($query);
	return $rs;
	
}
function getChilds($parent,$ajax=""){
	
	$query="SELECT * FROM  `eggmode_questions` WHERE parent_id=$parent";
	$rs=mysql_query($query); $cnt=0;
	if($ajax!=""){
			$row=mysql_fetch_array($rs);
			$question_statement=$row['question_statement'];
			$id=$row['id'];
			getChilds2($id);
	}
	else{
	   return $rs;
	}
	
}

function getChilds2($parent){
	
	$query="SELECT * FROM  `eggmode_questions` WHERE parent_id=$parent";
	$rs=mysql_query($query); $cnt=0;
			while($row=mysql_fetch_array($rs)){
				$question_statement=$row['question_statement'];
				$id=$row['id'];
				$qstatus=$row['qstatus'];
				if($cnt==0){
					?>
					<option>Select Options</option>
					<?php
				}
				?>
				<option  value="<?php echo $id;?>"><?php echo $question_statement;?></option>
				<?php
				$cnt++;
			}
}
function getResults($data){
	    $id=$data['id'];
	//	$qstatus=$data['qstatus'];
		$query="SELECT * FROM  `eggmode_questions` WHERE id=$id ";
		//echo $query;
		$rs=mysql_query($query); $cnt=0;
		$row=mysql_fetch_array($rs);
		$result=$row['result'];
		$result=$row['result'].'_'.$row['qstatus'];
		echo  $result;
}

function showResults($data){
	    $character_id=$data['character_id'];
	    $mood_id=$data['mood_id'];
		$query="SELECT * FROM  `eggmode_faces` WHERE eggmode_character_id=$character_id and eggmode_mode_id=$mood_id and eggmode_type_id=5 ";
		
		//echo $query;
		$rs=mysql_query($query); $cnt=0;
		$row=mysql_fetch_array($rs);
		$result='admin/eggmode_faces/'.$row['eggmode_faceimage'];
		$title='___'.$row['title'];
		echo  $result.$title;
}

function nextCQuestion($data){
	    $id=$data['parent_id'];
		$query="SELECT * FROM  `eggmode_questions` WHERE parent_id=$id";
		$rs=mysql_query($query); $cnt=0;
		$row=mysql_fetch_array($rs);
		$question_statement=$row['question_statement'];
		$id=$row['id'];
		
		$query="SELECT * FROM  `eggmode_questions` WHERE parent_id=$id";
		$rs=mysql_query($query); $cnt=0;
	?>
    
            <ul>
              <li><?php echo $question_statement;?></li>
            </ul>
            <form>
              <select   onchange="select_ans('characterchild')"  id="characterchild" name="">
              <?php
              
			  while($row=mysql_fetch_array($rs)){
				$question_statement=$row['question_statement'];
				$id=$row['id'];
				$qstatus=$row['qstatus'];
				if($cnt==0){
					?>
					<option>Select Options</option>
					<?php
				}
				?>
				<option  value="<?php echo $id;?>"><?php echo $question_statement;?></option>
				<?php
				$cnt++;
			}  
			?>
			  </select>
            </form>
    <?php
}

function getRandomFullfaces($data=""){
	$query="SELECT * FROM  `eggmode_faces` WHERE eggmode_type_id='5' order by rand() limit 1";
	$rs=mysql_query($query);
	$row=mysql_fetch_array($rs);
	$title=$row['title'];
	if($data['selectrandom']!=""){
	   $image_url=$row['eggmode_faceimage'];
	   echo $image_url.'___'.$title;
	}else{
	   $image_url=$row['eggmode_faceimage'];	
	}
	
	
    //$_SESSION['filename']='admin/eggmode_faces/'.$image_url;
	return $image_url."___".$title;
}

function userData($user){
	$query="SELECT * FROM  `user` WHERE fbuid=$user";
	$rs=mysql_query($query);
	$row=mysql_fetch_array($rs);
	return $row;
	
}


function eggmoodName($id){
	$query="SELECT * FROM  `eggmode_user` WHERE id=$id";
	//echo $query;
	$rs=mysql_query($query);
	$row=mysql_fetch_array($rs);
	//echo  $row['name'];
	return $row['name'];
	
}

function saveEggMode($data){
	$user=$data['user'];
	$filename=$data['filename'];
	$type=$data['type'];
	$title=$data['title'];
	$_SESSION['filename']=$filename;
	
	
	if($type==""){
	  $type	="Random";
	}
	 $friend_id="";
	 echo "this is session:".$_SESSION['created_for']."<BR>";
	if($_SESSION['creating_for']!=""){
	   $friend_id=$user;	
	   $user	=$_SESSION['creating_for'];
	}else{
		  $friend_id=0;	
	}
	
	$query="INSERT INTO `eggmode_user` (`fbuserid`, `eggmode_image`, `status`, `friendid`,`type`,`name`) VALUES ('$user','$filename','0','$friend_id','$type','$title')";
	
	echo $query;
	$rs=mysql_query($query);
	$fileid= mysql_insert_id();
	$_SESSION['fileid']=$fileid;
	$_SESSION['eggmoodname']='Eggmood';
	$_SESSION['gobackfile']=$data['gobackfile'];
	echo $_SESSION['fileid'];	
}
function updateEggMode($data){
	$user=$data['user'];
	$fileid=$data['fileid'];
	$name=$data['name'];
	$query="update `eggmode_user` set name='$name',status='1' where fbuserid='$user' and id=$fileid";
	$rs=mysql_query($query);
	echo $rs;
}

function deleteTempids($data){
	$user=$data['user'];
	$fileid=$data['tempid'];
	$cfor=$data['cfor'];
	$query="delete  from `temp_invitation`  where user='$cfor' and invited=$user";
	$rs=mysql_query($query);
    unset($_SESSION['tempid']);
	unset($_SESSION['creating_for']);
	echo $query;
}
function createdForFriend($data){
	$query="select *  from `eggmode_user`  where user='$cfor' and invited=$user";
	$rs=mysql_query($query);
    unset($_SESSION['tempid']);
	unset($_SESSION['creating_for']);
	echo $query;
}
function deleteEggMode($data){
	$id=$data['imageid'];
	$query="delete   from `eggmode_user`  where id='$id'";
	$rs=mysql_query($query);
	echo $query;
}

function updateLibEggMode($data){
	$id=$data['fileid'];
	$query="update  `eggmode_user`   set status=1  where id='$id'";
	$rs=mysql_query($query);
	if($rs==1){
	echo $query;	
	}else{
	echo '0';
	}
}


function publish_to_wall($data,$fbconfig,$facebook){
	            $message=$data['message'];
				$eggmoodname=$data['eggmoodname'];
				if($message=='' || $message=='undefined'){
					$message='An eggmood to express how I feel';
				}
				$user=$data['user'];
				$image_url= $fbconfig['baseUrl'].'/'.$data['image_url'];
				$attachment =  array('message' => "$message");
				$attachment['name'] ="$eggmoodname";
				$attachment['caption'] ="My EggMood";
			    $attachment['link'] = $fbconfig['appBaseUrl'];
			    $attachment['description'] ='';
			    $attachment['picture'] = "$image_url";
			try{
				
			     $ret_code = $facebook->api('/'.$user.'/feed', 'POST', $attachment);
			   }
			catch(Exception $ex)
			 {
				 //print_r($ex);
			 }
			 	$query="update `eggmode_user` set published='1' where fbuserid='$user' and id=".$_SESSION['fileid'];
				echo $query;
	            $rs=mysql_query($query);

}
function saveTempId($data){
$user=$data['user'];	
$tempid=$data['tempid'];	
$invited=$data['invited'];	
$user=$data['user'];	
$q="insert into temp_invitation (tempid,user,invited) values ('$tempid','$user','$invited')";	
$rs=mysql_query($q);	echo $q; echo $rs;
}
if(isset($_REQUEST['ajax'])){
	$parent_id=$_REQUEST['parent_id'];
	getChilds($parent_id,'1');
}

if(isset($_REQUEST['updatelibrary'])){
	$data=$_REQUEST;
	updateLibEggMode($data);
}
if(isset($_REQUEST['deleteselected'])){
	$data=$_REQUEST;
    deleteEggMode($data);
}
if(isset($_REQUEST['invited'])){
	$data=$_REQUEST;
	saveTempId($data);
}
if(isset($_REQUEST['tempidid'])){
	$data=$_REQUEST;
	deleteTempids($data);
}


if(isset($_REQUEST['showresult'])){
	$data=$_REQUEST;
	showResults($data);
}

if(isset($_REQUEST['findresult'])){
	$data=$_REQUEST;
	getResults($data);
}
if(isset($_REQUEST['cquestion'])){
	$data=$_REQUEST;
	nextCQuestion($data);
}

if(isset($_REQUEST['moodtype_id'])){
	$moodtype_id=$_REQUEST['moodtype_id'];
	getSelectedFaces($moodtype_id);
}
if(isset($_REQUEST['jsondatavalue'])){
	$_SESSION['jsondatavalue']=$_REQUEST['jsondatavalue'];
	echo $_SESSION['jsondatavalue'];
}
if(isset($_REQUEST['selectrandom'])){
	$data=$_REQUEST['selectrandom'];
	getRandomFullfaces($data);
}

if(isset($_REQUEST['createpredesign'])){
	$data=$_REQUEST;
	saveEggMode($data);
}
if(isset($_REQUEST['saveeggmode'])){
	$data=$_REQUEST;
	updateEggMode($data);
}

if(isset($_REQUEST['publishwall'])){
	$data=$_REQUEST;
	publish_to_wall($data,$fbconfig,$facebook);
}


?>