<?php

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
//if($_SESSION['user'] == 'sistema') echo '<span class="hideMobile">REPORT: Elaborato in '. sprintf('%.2f',$callTime) , " secondi", " - Picco memoria: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB (Messaggio visibile solo per testing unit Condivision)</span>" ; ?>
<br class="clear" />
<!-- Chiudo Content -->
</div>

<div id="scroll-up" class="hideMobile" ><i class="fa fa-chevron-circle-up"></i></div>

<script>

$(window).scroll(function () {

var scrollPosition = $(document).scrollTop();
var minHead =  80;

if(scrollPosition > minHead){ 
//$("#testata").attr("class", "chiuso");
//$("#menu").attr("class", "chiuso");
} else { 
//$("#testata").attr("class", "aperto");
//$("#menu").attr("class", "aperto");
}
});
</script>

<!-- Chiudo Corpo -->
</div>

<br class="clear" />
<!-- Chiudo Container -->
</div>


<?php if(account_sid != '' && !isset($client) && $_SESSION['usertype'] == 0) { ?>
<!--<div id="send-sms"><div id="sms-box">
<div id="sms-close"><a href="#" title="Chiudi">x</a></div>
<form id="sms-form" action="../mod_basic/mod_opera.php" method="post" enctype="multipart/form-data">

<div id="results"></div>

<div style="text-align: right; width: 190px ;">
<h1>Invia SMS</h1>

<p class="input_text">
<label for="from">Da</label>
<input  disabled type="text" name="from" id="from"  value="" style="width: 100%;"  /></p>

<p class="input_text"><label for="to">Destinatario  </label>
<input   class="" type="text" name="to" id="to"  value="" placeholder="+39" style="width: 100%;"  /> </p>

<p class="input_text"><label for="body">Messaggio  </label>
<input  class="" type="text" name="body" id="body"  value="" placeholder="Scrivi messaggio..."  style="height: 50px; width: 100%;" /> </p>



<input type="submit"  value="Invia" class="button salva" id="invia-sms" />

</form>
</div>
<?php
	echo "<script type=\"text/javascript\">	
	$('#from').val('".from."');	
	</script>";
	
	
if(isset($_GET['to'])) {
	echo "<script type=\"text/javascript\">	
	$('#to').val('".phone_format(check($_GET['to']),'39')."');	
	</script>";
}
?>

<?php

if(isset($_GET['sms'])) {

	echo "<script type=\"text/javascript\">	
	$('#body').val('".check($_GET['sms'])."');	
	</script>";
}
?>


</div><a href="#" class="sms-open">Sms</a></div>-->
<?php } ?> 


<?php if(isset($_SESSION['last_managed'])) echo '<div id="highlight" class="no-print noprint" style="position: fixed;
bottom: 0;
right: 84px;
background: #3DA042;
padding: 8px;
border-radius: 8px 0 0 0;
color: white; z-index: 9999;"><a href="'.$_SESSION['last_managed']['link'].'" title="Torna all\'evento" style="color: white">Evento '.$_SESSION['last_managed']['name'].'</a></div>'; ?>
</body>

</html>
<?php @mysql_close(CONNECT); ?>