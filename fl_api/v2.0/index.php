<?php 

header("Access-Control-Allow-Origin: *");

ini_set('display_errors',1);
error_reporting(E_ALL);
define('NOSSL',1);

include('../../fl_core/core.php'); // Variabili Modulo
 

include "apicore.php";
$apicore = new apicore;


$dataset = $_REQUEST;
$message = $_SERVER['REQUEST_URI']."\r\n\r\n<br>";
//mail('michelefazio@aryma.it','APP',$message,intestazioni);


foreach($dataset as $chiave=>$valore){ $message .= $chiave." = ".$valore."\r\n<br>"; }

function mandatory_fileds ($array){
foreach($array as $chiave=>$valore){
if(!isset($_GET[$valore])) { echo json_encode(array('esito'=>0,'info_txt'=>"Manca $valore"));  exit; } 
}
}


if(isset($dataset['usr_sign_up'])){
sleep(3);
$apicore->token = check($dataset['token']);
$apicore->signup();

}

if(isset($dataset['type1'])) $this->type1 = check($dataset['type1']); // imposta type ovvero tabella di collegamento elementi 123 menu_portate di default, 113 per collegare preventivo


if(isset($dataset['app_login'])){
mandatory_fileds(array('time','request_id'));

session_cache_limiter( 'private_no_expire' );
session_cache_expire(time()+5259200); 
session_start();		

$time = check($dataset['time']);
$request_id = check($dataset['request_id']);

$correct = sha1($time.$apicore->secret);
if($request_id != $correct && !isset($_GET['demo']) && $apicore->demo == true) {
echo json_encode(array('esito'=>0,'info_txt'=>"Request Id Errato"));
exit;
}


$deviceuid = check($dataset['request_id']);
$_SESSION['deviceuid'] = $deviceuid;
echo json_encode(array('token'=>session_id(),'esito'=>1,'info_txt'=>'OK'));
exit;

}


if(isset($dataset['usr_login'])){
mandatory_fileds(array('token','user','password','uid'));
$apicore->user = check($dataset['user']);
$apicore->password = check($dataset['password']);
$apicore->uid = check($dataset['uid']);
$apicore->token = check($dataset['token']);
$apicore->do_login();
foreach($apicore->contenuto as $chiave => $valore) { $_SESSION[$chiave] = $valore; } ;
exit;
}


if(isset($dataset['get_quote_details'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->get_quote_details(check($dataset['menuId']));
}

if(isset($dataset['update_quote'])){
mandatory_fileds(array('token','menuId','totale_prodotto'));
$apicore->token = check($dataset['token']);
$apicore->update_quote(check($dataset['menuId']),check($dataset['totale_prodotto']));
}

if(isset($dataset['get_items'])){
mandatory_fileds(array('token','item_rel'));
$apicore->token = check($dataset['token']);
$apicore->get_items(check($dataset['item_rel']));
}


if(isset($dataset['get_stewarding'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->id1 = check($dataset['menuId']);
$apicore->get_stewarding();
}

if(isset($dataset['get_veichels'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->id1 = check($dataset['menuId']);
$apicore->get_veichels();
}


if(isset($dataset['get_food'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->id1 = check($dataset['menuId']);
$apicore->get_food();
}


if(isset($dataset['get_beverage'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->id1 = check($dataset['menuId']);
$apicore->get_beverage();
}

if(isset($dataset['get_staff'])){
mandatory_fileds(array('token','menuId'));
$apicore->token = check($dataset['token']);
$apicore->id1 = check($dataset['menuId']);
$apicore->get_staff();
}


if(isset($dataset['createSynapsy'])){
mandatory_fileds(array('token','quiverCode','arrowId','valore','qty'));
$apicore->token = check($dataset['token']);
$apicore->createSynapsy();
}

if(isset($dataset['updateSynapsy'])){
mandatory_fileds(array('token','recordId','quiverCode'));
$apicore->token = check($dataset['token']);
$recordId = check($dataset['recordId']);
$apicore->updateSynapsy($recordId);
}

if(isset($dataset['removeSynapsy'])){
mandatory_fileds(array('token','recordId','quiverCode'));
$apicore->token = check($dataset['token']);
$recordId = check($dataset['recordId']);
$apicore->removeSynapsy($recordId);
}


if(isset($dataset['usr_logout'])){

mandatory_fileds(array('token','usr_id'));
if(isset($dataset['token'])) $apicore->token = check($dataset['token']);

// Logout
session_start();
session_unset();
session_destroy();
setcookie('user','');
echo json_encode(array('esito'=>1,'info_txt'=>"Logged out.")); exit;

}


if(isset($dataset['get_page'])){

mandatory_fileds(array('token','page_id'));
$apicore->token = check($dataset['token']);
$apicore->page_id = check($dataset['page_id']);
$apicore->get_page();

}

if(isset($dataset['lost_password'])){
mandatory_fileds(array('token','email'));
if(isset($dataset['token'])) $apicore->token = check($dataset['token']);
if(isset($dataset['email'])) $apicore->email = check($dataset['email']);
$apicore->send_login();
exit;
}


echo json_encode(array('esito'=>0,'info_txt'=>"Specifica un metodo o autentica client"));
exit;

?>