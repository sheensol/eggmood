<?php
session_start();
include_once("config.php");
$access_token = $facebook->getAccessToken();
$json=file_get_contents("https://graph.facebook.com/$user/albums?access_token=$access_token");
$data=json_decode($json,true);
$data=$data['data'];
foreach($data as $album){
	$type=$album['type'];
	if($type=='profile'){
		$profile_album_id=$album['id'];
	}
	$count++;
}
$facebook->setFileUploadSupport(true);
$file=$_REQUEST['filename'];//'
//echo $file;
$args['image'] = '@' . realpath($file);
$data = $facebook->api('/'. $profile_album_id . '/photos?access_token='. $access_token, 'post', $args);
//echo $url;

$fbid=$data['id'];
$url = "http://www.facebook.com/photo.php?fbid=$fbid&type=1&makeprofile=1";

?>
<script>
top.window.location='<?php echo $url;?>';
</script>


