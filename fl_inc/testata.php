<div id="preloader"><img src="<?php echo ROOT.$cp_admin; ?>fl_set/lay/preloader.png" /><a href="#" onClick="location.reload();" style="display: block; text-align: center;">Condivision sta caricando</a></div>


<div id="container">

<div id="up_menu">
<div id="menu_toggler"><a href="#" onclick="display_toggle('#side_menu','fast', 'swing');"  title="Nascondi/Mostra Menu principale"><i class="fa fa-navicon"></i></a></div>

<span class="appname">
<a href="<?php echo ROOT.$cp_admin; ?>?a=dashboard"><img src="<?php echo LOGO; ?>" alt="<?php echo client; ?>"/></a></span>
<span class="topdx">
<?php if(defined('MULTI_LOCATION') && isset($data_set)) { 

$sedi = $data_set->data_retriever('fl_sedi','sede',"WHERE id != 1",'id ASC');
unset($sedi[0]);

echo '<form method="GET" style="display: inline;"><span class="msg gray" style="margin-top: -7px;">Sede: <select name="sede_id" onchange="form.submit();">';
foreach($sedi AS $key => $val){ $selectedSede = ($_SESSION['sede_id'] == $key) ? 'selected' : ''; echo '<option value="'.$key.'" '.$selectedSede.'>'.$val.'</option>'; }
echo '</select></span></form>';

} ?>	
<a class="logout" href="<?php echo ROOT.$cp_admin; ?>fl_core/login.php?logout" title="Sei collegato al server dalle ore: <?php echo @date("H:i",$_SESSION['time'])." come ".@$tipo[$_SESSION['usertype']]; ?>"><i class="fa fa-power-off"></i> <span class="desktop">Esci</span> </a>  


</span>
</div>


<?php if(!isset($nomsg)) { ?>
<div class="info red"></div>
<div class="info orange"></div>
<div class="info orange" ></div>
<?php } ?>

