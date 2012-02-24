<header> <a href="<?php echo $fbconfig['redirect_url'].'home.php';?>" target="_top"></a>
 <img src="images/header-eggs-new.png" alt="" height="76" />
 <a style="padding: 5px 20px; cursor:pointer; margin-top:0px; width: 135px;height: 20px;" target="_top" onclick="invite()"  class="invite">Invite Friends</a>
 <a id="eggmoodlib" style="padding: 5px 4px; margin-top:5px;width: 167px;height: 20px;" href="<?php echo $fbconfig['redirect_url'].'eggmood-library.php'?>" target="_top"  class="invite">My Eggmood Library</a>

 
 
  <span style="margin-top:10px;">
 </span> </header>
<script>
function invite(){
FB.ui({
method : 'apprequests',
message: '<?php echo $name;?>  has invited you to join Eggmoods'});	
}


</script>