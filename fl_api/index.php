<?php 

header("Access-Control-Allow-Origin: *");

ini_set('display_errors',0);
error_reporting(E_ALL);
//define('TESTING',1);



include('../fl_core/core.php'); // Variabili Modulo
 
include "webservice.php";
$webservice = new webservice;


$dataset = $_POST; 
if(isset($_GET['explain'])) $dataset = $_GET; 

$message = $_SERVER['REQUEST_URI']."\r\n\r\n<br>";



foreach($dataset as $chiave=>$valore){ $message .= $chiave." = ".$valore."\r\n<br>"; }
//mail('michelefazio@aryma.it','APP',$message);

function mandatory_fileds ($array){
$dataset = $_POST;
if(isset($_GET['explain'])) $dataset = $_GET; 
foreach($array as $chiave=>$valore){
if(!isset($dataset[$valore])) { echo json_encode(array('esito'=>0,'info_txt'=>"Manca $valore"));  exit; } 
}
}


if(isset($dataset['usr_sign_up'])){
sleep(3);
$webservice->token = check($dataset['token']);
$webservice->signup();

}




if(isset($dataset['app_login'])){
mandatory_fileds(array('time','request_id'));

session_cache_limiter( 'private_no_expire' );
session_cache_expire(time()+5259200); 
session_start();		

$time = check($dataset['time']);
$request_id = check($dataset['request_id']);

$correct = sha1($time.$webservice->secret);
if($request_id != $correct && !isset($_GET['demo']) && $webservice->demo == true) {
echo json_encode(array('esito'=>0,'info_txt'=>"Request Id Errato"));
exit;
}


$deviceuid = check($dataset['request_id']);
$_SESSION['deviceuid'] = $deviceuid;
echo json_encode(array('token'=>session_id(),'esito'=>1,'info_txt'=>'OK'));
exit;

}


if(isset($dataset['usr_login'])){
mandatory_fileds(array('token','user','password'));
$webservice->user = check($dataset['user']);
$webservice->password = check($dataset['password']);
$webservice->token = check($dataset['token']);
$webservice->uid = (isset($dataset['uid'])) ? check($dataset['uid']) : 0;
$webservice->fcmToken = (isset($dataset['fcmToken'])) ? check($dataset['fcmToken']) : 0;
$webservice->do_login();
foreach($webservice->contenuto as $chiave => $valore) { $_SESSION[$chiave] = $valore; } ;
exit;
}

if(isset($dataset['lead_info'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->lead_info(check($dataset['user_id']));
}

if(isset($dataset['get_items'])){
mandatory_fileds(array('token','item_rel'));
$webservice->token = check($dataset['token']);
$webservice->get_items(check($dataset['item_rel']));
}


if(isset($dataset['insert_lead'])){
mandatory_fileds(array('token'));
$webservice->token = check($dataset['token']);
$webservice->insert_lead();
}






if(isset($dataset['usrLogout'])){

mandatory_fileds(array('token','userId'));
if(isset($dataset['token'])) $webservice->token =  $webservice->check($dataset['token']);
$webservice->userId = check($dataset['userId']);
$webservice->fcmToken = (isset($dataset['fcmToken'])) ? $webservice->check($dataset['fcmToken']) : 0;
$webservice->session_id = (isset($dataset['session_id'])) ?  $webservice->check($dataset['session_id']) : session_id();

//$webservice->do_logout();


}

if(isset($dataset['listArticles'])){

mandatory_fileds(array('token','categoria_id'));
$webservice->token = check($dataset['token']);
$webservice->categoria_id = check($dataset['categoria_id']);
$webservice->listArticles();

}


if(isset($dataset['getArticle'])){

mandatory_fileds(array('token','articleId'));
$webservice->token = check($dataset['token']);
$webservice->articleId = check($dataset['articleId']);
$webservice->getArticle();

}

if(isset($dataset['lost_password'])){
mandatory_fileds(array('token','email'));
if(isset($dataset['token'])) $webservice->token = check($dataset['token']);
if(isset($dataset['email'])) $webservice->email = check($dataset['email']);
$webservice->send_login();
exit;
}




/*METODI DEI TENANTS*/
if(file_exists(ROOTPATH."api/index.php")) require_once(ROOTPATH."api/index.php");




echo json_encode(array('esito'=>0,'info_txt'=>"Specifica un metodo o autentica client"));
exit;

?>