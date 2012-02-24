<?php

  
    $fbconfig['appid'] = "294411267282400";
    $fbconfig['api_key'] = "294411267282400";
    $fbconfig['secret'] = "4e5438d7a8b9f1a2f8ffc5ac5fb537c3";
    //echo getenv('HTTP_REFERER').":enviremoent";
 
	$check_secure_url=$_SERVER['HTTP_REFERER'];
	if($check_secure_url==""){
	if(isset($_SERVER['HTTPS'])){
	$check_secure_url="https";	
	}}else{
	$check_secure_url_arr=explode(":",$check_secure_url);
	$check_secure_url=$check_secure_url_arr[0];
	}
	if($check_secure_url=="https"){
	$fbconfig['http']='https';
	$fbconfig['siteUrl']    =   "https://www.sheensol.com";	
	$fbconfig['appBaseUrl'] =   "https://apps.facebook.com/eggmood";
	
	}else{
	$fbconfig['http']='http';
	$fbconfig['siteUrl']    =   "http://www.sheensol.com";
	$fbconfig['appBaseUrl'] =   "http://apps.facebook.com/eggmood";
	
	}
	if(!isset($_REQUEST['signed_request'])):
	$fbconfig['redirect_url']=$fbconfig['siteUrl']."/userftp/bilalrabbi/eggmoodapp/";
	else:
	$fbconfig['redirect_url']=$fbconfig['appBaseUrl']."/";
	endif;
	
    $fbconfig['baseUrl']    =   $fbconfig['siteUrl']."/userftp/bilalrabbi/eggmoodapp/";// "http://thinkdiff.net/demo/newfbconnect1/iframe/sdk3";
    $fbconfig['titleUrl']   =    "Check out my Fan Page.";
	$fbconfig['descUrl']    =    "You can see my new Fan Page at http://www.facebook.com/pages/%/";
    $dbfunctions=$fbconfig['baseUrl']."dbfunctions.php";
    $fbconfig['host'] = "localhost";
    $fbconfig['db_name'] = "sheensol_eggmood";
    $fbconfig['sandbox']="false";
 	$fbconfig['shareimage']="https://www.sheensol.com/projects/bookandflycopy/images/lp_globe.png";
	$fbconfig['adminimages']="https://www.sheensol.com/projects/betacontestadmin/files/";
	$fbconfig['db_user'] = "sheensol_bilal";
    $fbconfig['db_password'] = "sheensol";
	$fbconfig['ajaxCalls']=$fbconfig['baseUrl']."dbfunctions.php"; 
	$fbconfig['ajaxtestCalls']=$fbconfig['baseUrl']."dbfunctions2.php"; 
	//if(isset($_REQUEST['signed_request'])){
		include_once("facebook.php");
	$facebook = new Facebook(array('appId'  =>  $fbconfig['appid'],'secret' => $fbconfig['secret'],  'cookie' => true));
	//}
   $user = $facebook->getUser();
  if(isset($_REQUEST['signed_request'])){ 	
   $user = $facebook->getUser();
  }
	$dblink = mysql_connect($fbconfig['host'], $fbconfig['db_user'], $fbconfig['db_password']);
	mysql_select_db($fbconfig['db_name'],$dblink);
	mysql_set_charset('utf8',$dblink);
	
	$file_arr=explode("/",$_SERVER['SCRIPT_NAME']);
    $file=end($file_arr);
	$query="SELECT * FROM  `user` WHERE fbuid=$user";
	$rs=mysql_query($query);
	$row=mysql_fetch_array($rs);
	$name=$row['first_name'];
	
	
?>
