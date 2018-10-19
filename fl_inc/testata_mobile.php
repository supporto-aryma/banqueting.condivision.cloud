<div id="up_menu" class="noprint hidden-print" style="text-align:left;">
<span class="topsx"><a class="back" href="javascript:history.back();
	<?php //echo (isset($_SESSION['POST_BACK_PAGE']) && !isset($historyBack)) ? $_SESSION['POST_BACK_PAGE'] : 'javascript:history.back();'; ?>">  <i class="fa fa-angle-left"></i>

 </a></span>
<span class="appname">
<a href="<?php echo ROOT.$cp_admin; ?>?a=dashboard"><img src="<?php echo LOGO; ?>" alt="<?php echo client; ?>"/></a></span>
</div>
 

<?php if(isset($_GET['copy_record'])) echo '<div class="msg orange">ATTENZIONE! Stai creando una copia di questo elemento</div>' ?>