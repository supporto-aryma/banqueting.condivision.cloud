<?php // Controllo Login


	/*
    if ($_SERVER["HTTPS"] == "on" || defined('NOSSL')) 
    {
    $secure_connection = true;
    } else { 
	header("Location: https://".$_SERVER['HTTP_HOST']."/"); 
	exit; }*/

require_once('fl_core/autentication.php'); 
include("fl_inc/headers.php");
?>


<style>
#container { min-width: 0;}
.salva,.button,input, select, textarea {
    width: 92%;
	padding: 10px;
}
.salva,.button {    width: 99%; }
img { max-width: 100%;}
</style>

<div id="container">

<div id="up_menu">
<span class="appname">
<a href="<?php echo ROOT.$cp_admin; ?>"><img src="<?php echo LOGO; ?>" alt="<?php echo client; ?>"/></a></span>
</div>




<div style="color: #4C4C4C; max-width: 350px; height: auto; text-align: center; margin: 5% auto; padding: 20px 20px;">
<h1 style="font-size: 1000%; margin-bottom: 5px;">404</h1>
<span class="subcolor" style="font-size: 200%; margin-bottom: 5px;">La risorsa che cerchi non esiste</span><br>
<p><a href="./" class="button">Torna alla Dashboard</a></p>
</div>
 
 <p style="text-align: center; "> <a href="http://www.aryma.it/">2015 - made in aryma</a></p>
</div>
