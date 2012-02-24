<?php
   
include("config.php");
    
    //
    if (isset($_GET['request_ids'])){
        //user comes from invitation
        //track them if you need
		$request_ids=end(explode(",",$_GET['request_ids']));
		$query="select * from temp_invitation where tempid='$request_ids'";
		$rs=mysql_query($query);
		$row=mysql_fetch_array($rs);
		$_SESSION['creating_for']=$row['user'];
		$_SESSION['tempid']=$row['tempid'];
    }
    if (isset($_GET['code'])){
        header("Location: " . $fbconfig['appBaseUrl']);
        exit;
    }
	
    
    $user = null; //facebook user uid
    try{
        include_once "facebook.php";
    }
    catch(Exception $o){
        echo '<pre>';
        print_r($o);
        echo '</pre>';
    }
    // Create our Application instance.
    $facebook = new Facebook(array('appId'  => $fbconfig['appid'],'secret' => $fbconfig['secret'],'cookie' => true,));
        
    //Facebook Authentication part
    $user = $facebook->getUser();
	
	$params = array(
  'scope' => 'publish_stream, friends_likes,user_photos',
  'redirect_uri' => $fbconfig['redirect_url'].'index.php');

$loginUrl = $facebook->getLoginUrl($params);



   // $loginUrl   = $facebook->getLoginUrl(array('scope' => 'email,publish_stream,user_birthday,user_location'));
  //  echo $loginUrl;
	
	
	//https://www.facebook.com/dialog/permissions.request?app_id=107482072703477&display=page&next=https%3A%2F%2Fwww.fandura.com%2Fclients%2Fhotfit%2F&response_type=code&state=0ce67047684cb85cc56035e442115704&fbconnect=1&perms=email%2Cpublish_stream%2Cuser_birthday%2Cuser_location
//https://www.fandura.com/clients/hotfit/?state=0ce67047684cb85cc56035e442115704&code=AQBRY0G0zQtDBA-KmyjNT9pJxKY4OmjumOp-G-lY8Pby5ub7w2PtfC41MvyjS2lSjDYGB9x4adIeV_Y9CZmpSpzoN-Km4i9Lsxv7oqO2qclkkgpCMOyvjlK9t-vMPtyK4oZvcph3Nf9srglVJTqqjvBVqfRCBvKqH9QCoJP85ILW5RTn-aJ7M2VFwhhMtGvkHuNMaCJk8smuhda7zsNqttJ-#_=_	
	
//	
	
	
    if ($user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
		//print_r($user_profile);
      } catch (FacebookApiException $e) {
        //you should use error_log($e); instead of printing the info on browser
        d($e);  // d is a debug function defined at the end of this file
        $user = null;
      }
    }

    if (!$user) {
        echo "<script type='text/javascript'>top.window.location= '$loginUrl';</script>";
        exit;
    }
    
    //get user basic description
    $userInfo = $facebook->api("/$user");
	$fql    =   "select pic_square,current_location,pic_big,email,birthday_date,first_name,last_name,username,birthday,sex,profile_url  from user where uid=" . $user;
	$param  =   array(
		'method'    => 'fql.query',
		'query'     => $fql,
		'callback'  => ''
	);
	$fqlResult   =   $facebook->api($param);
	//echo "<PRE>"; print_r($fqlResult); echo "</pre>";
	$birthday = $fqlResult[0]['birthday_date'] ;
	$time_birthday = explode("/",$birthday);
	$date = date("m/d/Y");
	$time_date = explode("/",$date);
	$age = $time_date[2]-$time_birthday[2] ;
	
   if ($user) { 
   //echo $dblink;
	$userresult = mysql_query("SELECT * FROM `user` WHERE fbuid=".$user,$dblink);
	
	//echo "numb of rows".mysql_num_rows($userresult);
	
	
 	if(mysql_num_rows($userresult)<1){
        $query="INSERT INTO `user` (`fbuid`, `first_name`, `last_name`, `email`, `access_token`,`gender`, `username`, `profile_link`) VALUES 
                                          ('$user','".$userInfo['first_name']."','".$userInfo['last_name']."', '".$fqlResult[0]['email']."','".$facebook->getAccessToken()."','".$userInfo['gender']."','".$userInfo['username']."','".$userInfo['link']."')";
        $success = mysql_query($query,$dblink);
		//echo "<BR><BR><BR>";
	//	echo $query."<BR>";
		//echo $query;
	}
   }
?>
