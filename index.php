<?php 
session_start();
include_once("config.php");

if(isset($_REQUEST['state'])){
?>
<script>top.window.location='<?php echo $fbconfig['redirect_url'].'home.php';?>'</script>
<?php	
}
if(isset($_REQUEST['signed_request'])){
include_once("fbmain.php");	
}
?><script>top.window.location='<?php echo $fbconfig['redirect_url'].'home.php';?>'</script>
 