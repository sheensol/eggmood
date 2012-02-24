<?php
session_start();
include_once("config.php");
$access_token = $facebook->getAccessToken();
/*$json=file_get_contents("https://graph.facebook.com/$user/albums?access_token=$access_token");
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
$args['image'] = '@' . realpath($file);
$data = $facebook->api('/'. $profile_album_id . '/photos?access_token='. $access_token, 'post', $args);
$url = "http://www.facebook.com/photo.php?fbid=$fbid&type=1&makeprofile=1";
$fbid=$data['id'];*/
?>
<script>
document.location='<?php echo $url;?>';
</script>

<?php
 $parameters = array(
    'app_id' => $facebook->getAppId(),
    'to' => $user,
    'link' => 'http://google.com/',
    'redirect_uri' => 'http://apps.facebook.com/eggmood/testupload'
 );
 $url = 'http://www.facebook.com/dialog/send?'.http_build_query($parameters);
 
 
 ?>
 <script>
 function callit(){
	window.open('<?php echo json_encode($url); ?>'); 
 }
 </script>
 <a href="#DAF" onclick="callit();">publish it here </a>