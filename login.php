<?php 

session_start(); 
session_unset();
session_destroy();

session_start();
$cookieLifetime = 365 * 24 * 60 * 60; // A year in seconds
setcookie(session_name(),session_id(),time()+$cookieLifetime);
$jquery = 1;

if(isset($_SESSION['number'])){ header("Location: index.php"); exit; }

require('fl_core/core.php'); 
include('fl_core/dataset/array_statiche.php');


include("fl_inc/headers.php");
?>


<style>
#container { min-width: 0;}
.salva,.button,input, select, textarea {
    width: 98%;
	padding: 10px;
}
.salva,.button {    width: 99%; }
img { max-width: 100%;}
</style>


<div id="up_menu">
<span class="appname">
<a href="<?php echo ROOT.$cp_admin; ?>"><img src="<?php echo LOGO; ?>" alt="<?php echo client; ?>"/></a></span>
</div>




<div style="color: #4C4C4C; max-width: 350px; height: auto; text-align: center; margin: 5% auto; padding: 20px 20px;">
<h1>Login<span class="subcolor"></span></h1>

<form id="fm_accesso" action="fl_core/login.php" method="post">


<div class="span_row">
<br />
<input accesskey="u" type="text" id="user" name="user" value=""  placeholder="User" class="cerca" />
<br />

</div>

<div class="span_row">
<br />
<input accesskey="u" type="password" id="pwd" name="pwd" value="" placeholder="Password" class="cerca" />
<input type="hidden" id="idh" name="idh" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"  />
<br />

</div>

<div class="span_row">
<br />
<?php
if($_SERVER['HTTP_HOST'] == '127.0.0.1:8080' || $_SERVER['SERVER_NAME'] == 'localhost') {
echo '<select name="HTTP_HOST">';
foreach (glob("fl_config/*") as $filename) {
    if(is_dir( $filename)) echo '<option value="'.str_replace('fl_config/', '',$filename).'">'.str_replace('fl_config/', '',$filename).'</option>';
}
echo '</select>';
} 


?>
</div>

<div class="span_row">
  <p>
  <input value="Accedi" type="submit"  class="button" style="height: 40px; border-radius: 0; " />

  </p>
</div>




<?php if(defined('googleLogin')) { ?>

<div style="text-align: center">
<a href="fl_core/googleLogin.php" style="color: gray;">
  <!-- Google Login Button -->
	<div class="g-signin2" data-onsuccess="onSuccess" data-gapiscan="true" data-onload="true" style="text-align: center; text-align: -webkit-center;">
      <div style="height:36px;" class="abcRioButton abcRioButtonLightBlue">
        <div class="abcRioButtonContentWrapper" style="background: white;">
          <div class="abcRioButtonIcon" style="padding:8px;display: -webkit-inline-box;"><div style="width:18px;height:18px;" class="abcRioButtonSvgImageWithFallback abcRioButtonIconImage abcRioButtonIconImage18"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg> </div></div>
          <span style="font-size:13px;line-height:34px;" class="abcRioButtonContents"><span id="not_signed_ingzuq86gpyu0c">Accedi con Google</span>
          </div>
        </div>  
  </div>
  <!-- End Google Login Button -->
</a>	
</div>

<?php  } ?>



<br>
  <?php if(isset($_GET['esito'])) { echo '<h2 class="red" style="padding: 2px;  margin: 0 auto;">'.check($_GET['esito']).'</h2>'; } ?>

<p>Il tuo ip: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>




</form>
</div>
 
<p style="text-align: center; "><?php echo date('Y'); ?> Condivision 2.0 - <a href="http://www.aryma.it/">made in aryma</a></p>
