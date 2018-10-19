<?php 

require_once('fl_core/autentication.php');
$_SESSION['POST_BACK_PAGE'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];

$autorefresh = 0;
$vistaMarchio = ($_SESSION['marchio'] > 0) ? ' AND marchio = '.$_SESSION['marchio'] : '';

if($_SESSION['usertype'] > 0 && defined('MAIN_PAGE'))  header('Location: '.MAIN_PAGE);



$jquery = 1;
$fancybox = 1;
require('fl_core/dataset/array_statiche.php'); // Liste di valori statiche
require('fl_core/class/ARY_dataInterface.class.php'); //Classe di gestione dei dati 
$data_set = new ARY_dataInterface();
include('fl_core/dataset/proprietario.php');
include("fl_inc/headers.php");
?>

<?php include('fl_inc/testata.php'); ?>
<?php include('fl_inc/menu.php'); ?>
<script type="text/javascript">
 $("#container").show(); 

var user = {
    "user" : "<?php echo $_SESSION['user']; ?>",
};
localStorage.setItem("user", JSON.stringify(user));
 
</script>

<div id="corpo">


<div class="content">
<?php 

if (isset($_GET['d'])) {  $page =  './fl_inc/'.base64_decode(check($_GET['d'])).'.php'; } 
else if($_SESSION['usertype'] == 0) { $page = ROOTPATH.'dashboards/admin_dashboard.php';  } 
else {  
$numpage = (file_exists(ROOTPATH.'dashboards/usertype'.$_SESSION['usertype'].'_dashboard.php')) ? $_SESSION['usertype'] : 'default';
$page = ROOTPATH.'dashboards/usertype'.$numpage.'_dashboard.php'; } 


if(file_exists('update.php') && $_SESSION['number'] == 1 && $_SERVER['SERVER_NAME'] != '127.0.0.1' && $_SERVER['SERVER_NAME'] != 'localhost'){
include('update.php');
if(isset($sql)){
foreach($sql as $kew => $vals){
if(mysql_query($vals,CONNECT)) { $ok = 1; echo "<p>Aggiornamento <strong>$kew</strong> Eseguito!</p>"; 
} else { $ok = 0; echo "<span style=\"color:red; text-decoration: blink;\">Errore aggiornamento! ".$kew." ".mysql_error()."</span> <br> ";  }

}}
unlink('update.php');
} 



@include($page); 
include("fl_inc/footer.php"); ?>
