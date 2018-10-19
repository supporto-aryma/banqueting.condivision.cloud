<!DOCTYPE html>
<html lang="it">

<head>
<meta charset="utf-8" /><title><?php if(isset($module_title)) { echo strip_tags($module_title).' - '; } echo sitename; ?></title>

<!-- Smarthphone -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> 
<meta name="apple-mobile-web-app-capable" content="yes"> 
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> 
 
<link rel="icon" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/lay/a.ico" type="image/x-icon" /> 
<link rel="shortcut icon" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/lay/a.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>img/a.png" />

<link rel="apple-touch-startup-image" href="<?php echo ROOT.$cp_admin.$cp_set; ?>lay/spl.png" media="(max-device-width : 480px) and (-webkit-min-device-pixel-ratio : 2)">
<!-- For iPhone -->
<link rel="apple-touch-icon-precomposed" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>img/Logo-iPhone.jpg">
<!-- For iPhone 4 Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>img/Logo-iPhoneRet.jpg">
<!-- For iPad -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>img/Logo-iPad.jpg">
<!-- For iPad Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>img/Logo-iPadRet.jpg">


<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Arimo:400,700,400italic">
<link href="//fonts.googleapis.com/css?family=Montserrat|Open+Sans" rel="stylesheet"> 
<link rel="stylesheet" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/condivision4-jquery.css" media="screen, projection, tv" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/condivision4.css" media="screen, projection, tv" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.$cp_set; ?>css/fl_print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.'fl_config/'.HTTP_HOST.'/'; ?>css/custom.css" media="screen, projection, tv" />

<style type="text/css" media="all">
<?php if(isset($_GET['b'])) { ?>
.sub-<?php echo check($_GET['b']); ?> { background: #528354; color: white; }
.jqueryslidemenu ul li a.sub-<?php echo check($_GET['b']); ?>  {  color: white; !important; }
<?php } ?>
@media screen and (max-width: 600) {
#corpo { margin-left: 0px; }
}
<?php if(isset($_GET['closed']) || (isset($_COOKIE['menu']) && @$_COOKIE['menu'] == 0)) { ?>
#corpo { margin-left: 0px; }
#side_menu { display: none; }
<?php } ?>
<?php if(isset($_COOKIE['#menu_modulo']) && @$_COOKIE['#menu_modulo'] == 1) { ?>
#menu_modulo { display: block; }
#corpo { margin-left: 0px; }
<?php } ?>
<?php if(isset($_COOKIE['#filtri']) && @$_COOKIE['#filtri'] == 1) { ?>
/*.filtri { display: block; }*/
<?php } ?>

</style>
   
<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/fl_ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/function.js"></script>
<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/jquery-1.8.3.js" type="text/javascript"></script>
<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/jquery-ui.js" type="text/javascript"></script>

<script>
  if(("standalone" in window.navigator) && window.navigator.standalone){

    var noddy, remotes = false;

    document.addEventListener('click', function(event) {

    noddy = event.target;

    while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
    noddy = noddy.parentNode;
    }

    if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
    {
    event.preventDefault();
    document.location.href = noddy.href;
    }

    },false);
    }
</script>

<script type="text/javascript" src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/jqueryslidemenu.js"></script>

<?php if(isset($dateTimePicker)) { ?>
<script src="../../fl_set/jsc/datetimepicker/build/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" type="text/css" href="../../fl_set/jsc/datetimepicker/jquery.datetimepicker.css"/>
<?php } ?>

<?php if(isset($formValidator)) { ?>
<link rel="stylesheet" href="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/validator/validationEngine.css" type="text/css">
<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/validator/validation_ita.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/validator/validationEngine.js" type="text/javascript" charset="utf-8"></script>
<?php } ?>

<?php if(isset($fancybox))  { ?>
<script type="text/javascript" src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/fancybox/source/jquery.fancybox.js?v=2.0.6"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/fancybox/source/jquery.fancybox.css?v=2.0.6" media="screen" />
<?php } ?>

<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/2select/select2.min.js"></script>
<link href="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/2select/select2.min.css" rel="stylesheet" />


<script type="text/javascript">


/*Avvio*/
$(document).ready(function() {
	
/*PRELOAD CONTENT */
$("#preloader").fadeOut(100);
$("#container").fadeIn(400); 
$('.select2').select2();




$(".showcheckItems").click(function () { 

    $(".checkItemTd").fadeToggle();
    
});


<?php if(isset($selectLoadSrc)) { // Se nel modulo esiste questa array, deve contenere id della select, destinazione, percordo da caricare  ?>
$('<?php echo $selectLoadSrc['id']; ?>').change(function(){
 	$('<?php echo $selectLoadSrc['destinatario']; ?>').attr('src','<?php echo $selectLoadSrc['src']; ?>'+$(this).val());
});
<?php } ?>

<?php if(isset($loadSelectComuni)) { ?>

loadProvince('#regione_residenza','#provincia_residenza',0);
loadProvince('#regione_punto','#provincia_punto',0);
loadProvince('#regione_sede','#provincia_sede',0);
loadComuni('#provincia_residenza','#comune_residenza',0);
loadComuni('#provincia_punto','#comune_punto',0);
loadComuni('#provincia_sede','#comune_sede',0);




$('#regione_residenza').change(function(){
 	loadProvince('#regione_residenza','#provincia_residenza',1);
});


$('#regione_sede').change(function(){
 	loadProvince('#regione_sede','#provincia_sede',1);
});

$('#regione_punto').change(function(){
 	loadProvince('#regione_punto','#provincia_punto',1);
});

$('#provincia_residenza').change(function(){
 	loadComuni('#provincia_residenza','#comune_residenza',1);
});

$('#provincia_sede').change(function(){
 	loadComuni('#provincia_sede','#comune_sede',1);
});

$('#provincia_punto').change(function(){
 	loadComuni('#provincia_punto','#comune_punto',1);
});

$('#comune_residenza').change(function(){
 	loadCap('#comune_residenza','#cap_residenza',1);
});

$('#comune_sede').change(function(){
 	loadCap('#comune_sede','#cap_sede',1);
});

$('#comune_punto').change(function(){
 	loadCap('#comune_punto','#cap_punto',1);
});
<?php } ?>






var now = new Date();
var hrs = now.getHours();
var msg = "";

if (hrs >  0) msg = "Buona prima mattina"; // REALLY early
if (hrs >  6) msg = "Buongiorno";      // After 6am
if (hrs > 12) msg = "Buon Pomeriggio";    // After 12pm
if (hrs > 17) msg = "Buona sera";      // After 5pm
if (hrs > 22) msg = "Buona notte";        // After 10pm
<?php if(isset($_SESSION['nome'])) { ?>$('#saluto').html(msg+' <span class="hideMobile"><?php echo $_SESSION['nome']; ?></span>');<?php } ?>


/*ACCORDION*/
$("#accordion").accordion({ animate: 200 ,collapsible: true, header: "h2",heightStyle: "content", autoHeight: false,fillSpace: false, active: 'h2#<?php echo @$_SESSION['active'] ; ?>',event: "click" });
<?php $sel_b = (isset($_GET['b'])) ? check($_GET['b']) : 1; ?>
$('*[data-sel-b="<?php echo $sel_b; ?>"]').addClass('selected');

/*Form Validator*/
<?php if(isset($formValidator)) { ?>jQuery("#scheda").validationEngine();<?php } ?>

/*CALENDAR*/
jQuery(function($){
	$.datepicker.regional['it'] = {
		closeText: 'Chiudi',
		prevText: '&#x3c;Prec',
		nextText: 'Succ&#x3e;',
		currentText: 'Oggi',
		monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
		monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
		dayNames: ['Domenica','Luned&#236','Marted&#236','Mercoled&#236','Gioved&#236','Venerd&#236','Sabato'],
		dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
		dayNamesMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		gotoCurrent: true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['it']);
});
$(".calendar:input").datepicker({ changeMonth: true, changeYear: true,yearRange: '1950:2050',
    onSelect: function ()
    {      
       $(this).trigger("focusout");  //Eccezione per compatibilita con update campo ajax
    }
});

/* TABS */
var $tabsd = $( "#tabs").tabs({
selected: <?php echo (isset($_GET['t'])) ? base64_decode(check($_GET['t'])) : 0; ?> , 
show: function(event, ui) { $('.calendar:input').datepicker();  },
spinner: '<img src="<?php echo ROOT.$cp_admin; ?>fl_set/img/preloader.png" alt="Caricamento" />' ,
ajaxOptions: {	error: function( xhr, status, index, anchor ) {	$( anchor.hash ).html("Non &egrave; possibile caricare il contenuto!" );}}
});

<?php if(isset($_GET['tId'])) { ?>
var index = $('#tabs a[href="#<?php echo check($_GET['tId']); ?>"]').parent().index();
$('#tabs').tabs('select', index);
<?php } ?>

$(".next-tab").click(function() {
    var selected = $("#tabs").tabs("option", "selected");
    $("#tabs").tabs("option", "selected", selected + 1);
});
$(".prev-tab").click(function() {
    var selected = $("#tabs").tabs("option", "selected");
    $("#tabs").tabs("option", "selected", selected - 1);
});
				
// Slider
$('#slider').slider({
	range: true,
	values: [17, 67]
});

$('.sms-open').click(function () {
   if($("#sms-box").css('display').valueOf() == 'block') { $('.sms-open').html('Sms'); } else {  $('.sms-open').html(''); }	
   $("#sms-box").fadeToggle("fast", "swing");

});
$('#sms-close').click(function () {
   $("#sms-box").fadeToggle("fast", "swing");
   if($("#sms-box").css('display').valueOf() == 'block') { $('.sms-open').html('Sms'); } else {  $('.sms-open').html(''); }	
   event.preventDefault();
});

$('.filterToggle').click(function () {
   $(".filtri").fadeToggle("fast", "swing",setck('#filtri'));		
});

$('.dati').click(function () {
   $(".filtri").hide("fast", "swing",setck('#filtri'));		
});

$('.open-close').click(function () {
   if($(this).next(".dsh_panel_content").css('display').valueOf() == 'block') { $(this).html('<a><i class="fa fa-angle-down" aria-hidden="true"></i></a>'); } else {  $(this).html('<a><i class="fa fa-angle-up" aria-hidden="true"></i></a>'); }	
  $(this).next(".dsh_panel_content").fadeToggle("fast", "swing");	
	event.preventDefault();
});



/*SCROLL UP*/
$(window).scroll(function () { if ($(this).scrollTop() > 400) {	$('#scroll-up').fadeIn();		} else {		$('#scroll-up').fadeOut();	}	});
$('#scroll-up').click(function () {		
$('body,html').animate({scrollTop: 0}, 800);
return false;
}); $("#scroll-up").hide();

$(':file').change(function(){
    var file = this.files[0];
    var name = file.name;
    var size = file.size;
    var type = file.type;
   
});

$('#action_list').change(function(){
	$('.action_options').hide();
	$('#action'+$(this).val()).show();
});

/*Dynamic form processor ajax */
$( "#invio" ).click(function( event ) {
 

<?php if(isset($text_editor)) { ?> tinymce.triggerSave();  <?php  } ?>
var form = $( "#scheda" ),
url = '../mod_basic/save_data.php';
var data = new FormData(form[0]);
if($("#results").length == 0) {  form.before('<div id="results"></div>'); }

jQuery.ajax({
    url: url,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
	  fail: function(data){   $( "#results" ).empty().append( '<div class="esito red">Errore di caricamento</div>' );   }, 
    always: function(data){ $( "#results" ).empty().append( '<div class="esito orange">Creazione in corso...</div>' );  }, 
    success: function(response){
	  $("#container").show(); 
    console.log(response);
    var data = $.parseJSON(response);
	
	$('body,html').animate({scrollTop: 0}, 800);
	$( "#results" ).empty().append('<div class="esito '+data.class+'">'+data.esito+'</div>');
  <?php if(isset($_GET['external'])) echo ' parent.$.fancybox.close(); '; ?>
	if(data.action == 'goto') {	setTimeout(function(){ window.location.href = data.url; }, 100); };
  $(window).unbind('beforeunload');

    }
	
});
event.preventDefault();
});

/*Invio SMS */
$( "#invia-sms" ).click(function( event ) {
  var $form = $( "#sms-form" ),
  url = $form.attr( "action" );
  var posting = $.post( '../mod_sms/mod_opera.php', $form.serialize() );
  $( "#results" ).empty().append( '<div class="esito orange">Invio in corso...</div>' );
  posting.fail(function( data ) {
    $( "#results" ).empty().append( '<div class="esito red">Errore di caricamento</div>' );
  });
  posting.always(function( data ) {
	 $( "#results" ).empty().append( '<div class="esito orange">Elaborazione in corso...</div>' );
  });
  
 posting.done(function( response ) {
    
    var data = $.parseJSON(response);
	$( "#results" ).empty().append('<div class="esito '+data.class+'">'+data.esito+'</div>');
  });
  event.preventDefault();
});




$('#scheda input').focus(function( event ) {   
var input = $(this); 
//input.attr('class', 'bo-orange');
$(window).bind('beforeunload', function(){
  return 'Uscire senza salvare?';
});
console.log("Modifica: "+input.name);
});


/*Dynamic form processor ajax */
$( ".ajaxForm" ).on('submit',this,function( event ) {
  
  var form = $( this ),
  url = form.attr( "action" );
  var posting = $.post(url, form.serialize() ); 
  $( "#results" ).empty().append( '<div class="esito orange">Invio in corso...</div>' );
  
  posting.fail(function( data ) {   $( "#results" ).empty().append( '<div class="esito red">Errore di caricamento</div>' );  });
  posting.always(function( data ) {  $( "#results" ).empty().append( '<div class="esito orange">Elaborazione in corso...</div>' );  });
  posting.done(function( response ) {
    
  console.log('test');
  var data = $.parseJSON(response);
	$('body,html').animate({scrollTop: 0}, 800);
	$( "#results" ).empty().append('<div class="esito '+data.class+'">'+data.esito+'</div>');

	if(data.action == 'goto') {	setTimeout(function(){ window.location.href = data.url; }, 200); };
	if(data.url == '#') {	form.empty().append('<p>Invio del modulo eseguito con successo!</p>'); };
	<?php if(isset($fancybox))  { ?>if(data.action == 'popup') {	openpopup(data.url,0); };<?php } else { echo "alert('Popup Disabilitati');"; } ?>
	if(data.action == 'realoadParent') {	window.top.location.href = data.url;  };
  });

  $(window).unbind('beforeunload');
  event.preventDefault();
});

/*Dynamic form processor ajax */
$( ".ajaxFormFiles" ).on('submit',this,function( event ) {
 
event.preventDefault();
$(window).unbind('beforeunload');

var form = $( this );
url = form.attr( "action" );
var data = new FormData(form[0]);


jQuery.ajax({
    url: url,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
	fail: function(data){   $( "#results" ).empty().append( '<div class="esito red">Errore di caricamento</div>' );   }, 
    always: function(data){ $( "#results" ).empty().append( '<div class="esito orange">Creazione in corso...</div>' );  }, 
   
    success: function(response){
   
    var data = $.parseJSON(response);
	$('body,html').animate({scrollTop: 0}, 800);
	$( "#results" ).empty().append('<div class="esito '+data.class+'">'+data.esito+'</div>');
	if(data.action == 'goto') {	setTimeout(function(){ window.location.href = data.url; }, 200); };
	if(data.url == '#') {	form.empty().append('<p>Invio della richiesta è stato eseguito con successo!</p>'); };
	<?php if(isset($fancybox))  { ?>if(data.action == 'popup') {	openpopup(data.url,0); };<?php } else { echo "alert('Popup Disabilitati');"; } ?>
	if(data.action == 'realoadParent') {	window.top.location.href = data.url;  };
    }
	
});

});

/*Dynamic form processor ajax */
$( ".loadData" ).on('submit',this,function( event ) {
  
  var form = $( this ),
  url = form.attr( "action" );
  var posting = $.post(url, form.serialize() ); 
  $( "#results" ).empty().append( '<div class="esito orange">Caricamento dati...</div>' );
  
  posting.fail(function( data ) {   $( "#results" ).empty().append( '<div class="esito red">Errore di caricamento</div>' );  });
  posting.always(function( data ) {  $( "#results" ).empty().append( '<div class="esito orange">Caricamento dati...</div>' );  });
  posting.done(function( response ) {
   
    var data = $.parseJSON(response);
	
	$( "#results" ).empty().append('');
	$( "#mittente" ).val(data.mittente);
	$( "#oggetto" ).val(data.oggetto);
	$( "#messaggio" ).val(data.messaggio);
	$( "#templateId" ).val(data.id);
  tinyMCE.activeEditor.setContent('');
  tinymce.activeEditor.execCommand('mceInsertContent', false, data.messaggio);
	$('#info').html( $("#messaggio" ).value.length+' caratteri');

   });
  event.preventDefault();
});


/*Salvataggio automatico campi ajax */
$( ".updateField" ).focus(function( event ) {   
var input = $(this); 
input.attr('class', 'bo-orange');
$('.savedField').fadeOut();
$(window).bind('beforeunload', function(){
  return 'Uscire senza salvare?';
});
event.preventDefault();
});

$("#barcode" ).change(function( event ) {   
var input = $(this); 
input.attr('class', 'bo-orange');
var qty = prompt("Quanti ne stai caricando?");
$(".list" ).append( '<h2>Hai caricato '+qty+' di codice '+ $(this).val()+'</h2>' );
event.preventDefault();
input.val('');
$("#barcode" ).focus();
});


$( ".updateField" ).focusout(function( event ) {
  $(window).unbind('beforeunload');
  <?php if(isset($text_editor)) { ?> tinymce.triggerSave(); /* Salva testo di MCE */  <?php  } ?>
  var valore = $(this).val();
  var field = $(this).attr('name');
  var id = $(this).attr('data-rel');
  var obj = {gtx: '<?php echo @$tab_id; ?>'};
  if($(this).attr('data-gtx') > 1) obj['gtx'] = $(this).attr('data-gtx');
  obj[field] = valore;
  obj['id'] = id;
  var input = $(this);

  var posting = $.ajax({  url: '../mod_basic/save_data.php',  type: 'POST',  data: obj});
  posting.fail(function( data ) {  input.attr('class', 'bo-red');  });
  posting.always(function( data ) {  });
  posting.done(function( response ) {    
  var data = $.parseJSON(response);
  console.log(data);
	if(data.class == 'green') {	input.attr('class', 'bo-green updateField'); input.after( "<span class=\"savedField\"></span>" ); }
	if(data.class == 'red') {	input.attr('class', 'bo-red updateField'); }

  });
  event.preventDefault();
});

/*Registra azione */
$( ".setAction" ).click(function( event ) {
  var id = $(this).attr('data-id');
  var gtx = $(this).attr('data-gtx');
  var azione = $(this).attr('data-azione');
  var esito = $(this).attr('data-esito');
  var note = $(this).attr('data-note');
  var obj = {i: '1'};
  obj['gtx'] = gtx;
  obj['id'] = id;
  obj['azione'] = azione;
  obj['esito'] = esito;
  obj['note'] = note;
  
  var posting = $.ajax({   url: '../mod_basic/setAction.php',    type: 'POST',    data: obj});
  posting.fail(function( data ) {  });
  posting.always(function( data ) {  });
  posting.done(function( response ) {    });
});


<?php if(isset($fancybox))  { ?>
$(".fancybox").fancybox({
    autoSize : false,
    width    : "98%",
    height   : "95%",
	title : "",	
	afterClose : function() {
        location.reload();
        return;
    },	
	helpers : {
            title : {
                type: 'inside',
                position : 'top'
            }
    }
	});
$(".fancybox_small").fancybox({
    autoSize : false,
    width    : 480,
    height   : 300,
	title : "",	
	afterClose : function() {
        location.reload();
        return;
    },	
	helpers : {
            title : {
                type: 'inside',
                position : 'top'
            }
    }
	});
$(".fancybox_view").fancybox({
    autoSize : false,
    width    : "100%",
    height   : "100%",
	title : "",
	});

$(".fancybox_view_medium").fancybox({
    autoSize : true,
    width    : "800",
    height   : "600",
    title : "",
    afterClose : function() {
      location.reload();
      return;
    }     
  });

$(".fancybox_view_small").fancybox({
    autoSize : true,
    autoScale: true,
	title : "",
	});
	/*Apri un popup fancybox*/

$(".facyboxParent").click(function() {
       
        var url = this.href;

         parent.$.fancybox({             

            'autoScale': true,
            'width'    : "400",
            'height'   : "600",
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'type' : 'iframe',
            'href' : url ,
            afterClose : function() { parent.location.reload();     return;   }       

        });

        return false;
 });

$(".fancyboxParentSmall").click(function() {
       
        var url = this.href;

         parent.$.fancybox({             

            'autoScale': true,
            'width'    : "100%",
            'height'   : "100%",
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'type' : 'iframe',
            'href' : url,     
            afterClose : function() { parent.location.reload();     return;   }       

        });

        return false;
 });





<?php } ?>

<?php if(isset($dateTimePicker)) { ?>
$.datetimepicker.setLocale('it');
$('.datetimepicker').datetimepicker({
  format: 'd/m/Y H:i',
  step:15,
  onChangeDateTime:function(dp,$input){
    
    if($input[0].name == 'start_meeting') { 
      var dateset = $input.val(); 
      $('#end_meeting').val(dateset);
    }

   
  }

  });

$('#periodo_evento').change(function(){
  
   var dateNew = $('#data_evento').val();
   var dateNew = dateNew.substring(0,10);

    if($(this).val() == 102) {
    $('#data_evento').val(dateNew+' 21:00');
    $('#data_fine_evento').val(dateNew+' 23:59');
    } else {
    $('#data_evento').val(dateNew+' 13:00');
    $('#data_fine_evento').val(dateNew+' 21:00');
    }
});

<?php } ?>



 
});
<?php if(isset($_SESSION['NOTIFY'])) { echo "notify('".$_SESSION['NOTIFY']."','');"; unset($_SESSION['NOTIFY']); } 

//if($notifiche > 0 && (!isset($_SESSION['last_check']) || (time()-@$_SESSION['last_check']) > 30)) echo "notify('Hai ".$notifiche." notifiche da leggere!','');"; ;



?>

function openpopup(url,close=1){
$.fancybox({
            'autoScale': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'type' : 'iframe',
            'href' : url,     
            'centerOnScroll': true ,
            afterClose : function() { if(close == 1) { location.reload(); } } 
}).click();
}


function inIframe () {
    try {
      return window.self !== window.top;
    } catch (e) {
      return true;
    }
}

</script> 
 

<?php
if((!isset($_GET['advanced']) || @check($_GET['advanced']) == 0) && isset($text_editor)) { ?>


<script type="text/javascript" src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/tinymce/tinymce.min.js"></script>
<script type="text/javascript">


  const imageList = [];
  
  <?php if(isset($imageList)) { ?>
  $.ajax({
    type: "GET",
    url: "../mod_basic/fetchImages.php?folder=<?php echo $imageList; ?>",
    success: (result) => {
      const data = JSON.parse(result);
      // console.log("result",result);
      if (data.length > 1) { 
        data.forEach(image => {
          imageList.push(image);
        });
      } else if (data.length = 1) {
        imageList.push(data);
      }

      // console.log("data", data);
      // console.log("imageList", imageList);
    }
  });
  <?php } ?>


  tinymce.init({
    selector: 'textarea',
    height: 300,
    menubar: false,
    language: "it",
    plugins: [
      'advlist autolink lists link image charmap print preview anchor textcolor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code help wordcount'
    ],
    image_list: imageList,
    toolbar1: 'insert | undo redo | fontselect | fontsizeselect | formatselect',
    toolbar2: 'bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | code', 
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css']
  });

</script>

<?php }  ?>



<?php /*if(defined('HOTJAR_KEY') && @$_SESSION['user'] != 'sistema'){  ?>
<script type="text/javascript">
if(!inIframe()) { // Disabilita se in iframe
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:<?php echo HOTJAR_KEY; ?>,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
}
</script>
<?php }*/  ?>



<?php if(defined('CHAT_KEY') && !isset($_GET['id']) && !isset($_GET['nochat']) && !isset($nochat) && !isset($_GET['PiD'])) { ?>

<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
if(!inIframe()) { // Disabilita se in iframe

var _smartsupp = _smartsupp || {};
_smartsupp.key = '<?php echo CHAT_KEY; ?>';

window.smartsupp||(function(d) {
	var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	c.type='text/javascript';c.charset='utf-8';c.async=true;
	c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);

<?php if(isset($_SESSION['user'])){  ?>
smartsupp('email', '<?php echo $_SESSION['mail']; ?>');
smartsupp('name', '<?php echo $_SESSION['nome']; ?>');
<?php }  ?>
}
</script>
<?php  } ?>


<style type="text/css"> 

/*#container { display: block; }*/
.mce-branding { display: none; }
</style>

</head>
<body>