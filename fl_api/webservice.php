 <?php


class webservice{

	var $demo = false; // Se abilitare o meno il demo 
	var $datatype = "JSON";	
	var $contenuto = array();
	var $token;
	var $user;
	var $password;
	var $uid;
	var $userId; //User that own the record
	var $accountId; //User that is connected
	var $obbligatorio = array('nome');
	var $numerici = array('telefono','cellulare');
	var $date = array('data_test_drive','periodo_cambio_vettura');
	var $table = 'fl_account';
	var $secret = 're56fdsfw285hfw5k3923k2ASYLWJ8tr3';
	var $push_type = 'post';
	var $fcmToken = 0;
	var $recordId = 1;
	var $what = '*';

function app_start(){
	session_cache_limiter( 'private_no_expire' );
	session_cache_expire(time()+5259200); 
    session_start();		
	
	if(session_id() != $this->token && $this->token != 'app') {	
	    $this->contenuto = '';
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = 'Not valid session. Please restart app';
		mysql_close(CONNECT);		
		echo json_encode($this->contenuto);
		exit;
	}

}

function cnv_makedata(){
	
	mysql_close(CONNECT);		
	
	if($this->datatype == 'JSON') {
	echo json_encode($this->contenuto);
	}
	
    if($this->datatype == 'OBJECT') {
	return $this->contenuto;
	}
	
	if($this->datatype == 'XML') {
	echo json_encode($this->contenuto);
	}
	
	exit;
}

/*ENGINE*/
function insertUpdate($recordId){

	$issue = 0;
	$sql = 'DESCRIBE '.$this->table.';';
	$updateSQL = 'UPDATE '.$this->table.' SET ';
	$createSQL = 'INSERT INTO '.$this->table.' VALUES ();';
	$fields = $this->query($sql);
	
	sleep(1);

	while($FieldProp = mysql_fetch_array($fields)){ 
		
		$FieldName = $FieldProp['Field'];
		if($FieldName == 'data_aggiornamento') $updateRecord = 1;
		if($FieldName == 'is_app') $is_app = 1;
		if($FieldName != 'id' && $FieldName != 'data_creazione'){
		if(isset($_GET['explain'])) echo "VALUE EXPECTED: ".$FieldName.' ('.$FieldProp['Type'].','.$FieldProp['Null'].','.$FieldProp['Default'].')<br>';
			
			if(isset($_REQUEST[$FieldName])){
				$Field = $this->check($_REQUEST[$FieldName]); // Security Checl of the received string
				if(isset($comma)) { $updateSQL .=  ',';  }  else { $comma = 1; }
				$updateSQL .= $this->cherookee($Field,$FieldName,$FieldProp['Type'],$FieldProp['Null'],$FieldProp['Default']); //Formal type check of field
			}
		}
	}

	if(isset($updateRecord) && $recordId == 1) $updateSQL .=  ', data_creazione = NOW() '; // only for new entries!
	if(isset($updateRecord)) $updateSQL .=  ', data_aggiornamento = NOW() '; 
	if(isset($is_app)) $updateSQL .=  ', is_app = 1 '; 

	

	if($recordId == 1 && !isset($_GET['explain'])) { $this->query($createSQL); $recordId = mysql_insert_id();  } // if 1 create a new record	
	
	$updateSQL .= ' WHERE id = '.$recordId;
	$issue = (isset($_GET['explain'])) ? '(NO QUERY SENT IN DEBUG MODE) : '.$updateSQL : $this->query($updateSQL);
	//@mail('supporto@aryma.it','Query app',$updateSQL.$_REQUEST['documento_fronte']);
	if($issue == 1) $issue = $recordId;
	
	return  $issue;//Issue of Update
	
}

function deleteRecord($recordId){

	$updateSQL = 'DELETE FROM '.$this->table;
	$updateSQL .= ' WHERE id = '.$recordId;

	$issue = (isset($_GET['explain'])) ? '(NO QUERY SENT IN DEBUG MODE) : '.$updateSQL : $this->query($updateSQL);
	if($issue == 1) $issue = $recordId;
	return  $issue;
	
}


function getRecordData(){ 

	$sql = 'SELECT '.$this->what.' FROM '.$this->table.' WHERE id = '.$this->recordId;
	$result = $this->query($sql);
	return ($result == true) ? mysql_fetch_assoc($result) : false;

}

function getRows(){
	
	$dataRows = array();

	$query = "SELECT * FROM ".$this->table."  WHERE ".$this->where;
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_array($risultato)){

		$dataRows[] = $riga;
	}


	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['results'] = $dataRows;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	return $this->contenuto;
}


function query($sql){ 
  $results = mysql_query($sql,CONNECT);
  if(mysql_affected_rows() < 0) $this->ErrorLog('Errore query su host '.ROOT,$sql.' '.mysql_error());
  //@mail('supporto@aryma.it','Query app on'.ROOT,$sql.mysql_error());
	
  return  (mysql_affected_rows() >= 0) ? $results : mysql_affected_rows();
}

function cherookee($Field,$FieldName,$Type,$Null=NULL,$Default=''){ 
  if($Type == 'date')  $Field = $this->determina_data($Field); 
  if(isset($_GET['explain'])) echo 'SENT: '.$FieldName.' = '.$Field.' '.$Type.'<br>'; 
  return  '`'.$FieldName.'` =  \''.$Field.'\''; //Per ora non fa nulla
}

public static function determina_data($data){
			$str_array = preg_split('/[\/\-]/', $data);
			return (strlen($str_array[0]) == 4) ? $data : convert_data($data,1);
}

















private function ErrorLog($sbj,$message) { 
		//smail(mail_admin,$sbj,$message);
		return null;
}






/*UPLOAD FILES METHODS*/
public function uploadFile($file,$folder,$file_name,$workflow_id=0,$record_id=0,$descrizione='',$tags='',$lang='en',$fileAction='prefix'){



$esiti = array();
$esiti[0] = "Inserire il file da caricare!";
$esiti[1] = "Caricamento avvenuto correttamente";
$esiti[2] = "Impossibile Caricare il file";
$esiti[3] = "Not valid file extension";
$esiti[4] = "Formato file non valido.";
$esiti[5] = "File esistente";
$esiti[6] = "Il file contiente errori.";
$esiti[7] = "Impossibile creare cartella di destinazione.";
$esiti[8] = "Impossibile creare cartella per le anteprime.";
$esiti[9] = "Cartella di destinazione non scrivibile.";
$notAllowed = array('exe','src','scr','piff','php','php3','mdb','mdbx','sql');

/* Check File Type */
$info = pathinfo($file['name']); 
foreach($info as $key => $valore){ 
	if($key == "extension")
	$ext = $info["extension"]; 
}

if(!isset($ext) || in_array(strtolower($ext),$notAllowed)){ 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = 0;
	$this->contenuto['info_txt'] = $esiti[3];
	$this->cnv_makedata();
} 


$file_name = ($file_name != '') ? $file_name.'.'.strtolower($ext) : $file['name']; // If we set a file name it take new name else it use the original file name. 4marco: Should be receive an injection by file name?

/* Check Folder and duplicate file name */
if(!@is_dir($folder)) {  
	if(!@mkdir($folder,0777)) {
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = 0;
	$this->contenuto['info_txt'] = $esiti[7];
	$this->ErrorLog('Errore DMS API '.ROOT,$esiti[7].' :: '.$folder);
	$this->cnv_makedata();
	} 
}
if(!is_writable($folder)) {  
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = 0;
	$this->contenuto['info_txt'] = $esiti[9].' :: '.$folder;
	$this->ErrorLog('Errore DMS API '.ROOT,$esiti[9].' :: '.$folder);
	$this->cnv_makedata();
	}

if(file_exists($folder.$file_name)) {  
	if($fileAction=='unique'){
		$this->contenuto['class'] = 'red';
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = $esiti[5];
		$this->ErrorLog('Errore DMS API '.ROOT,$esiti[5].' :: '.$folder);
		$this->cnv_makedata();
	} else if($fileAction=='overwrite') {
		//Nothing it will overwrite existent
	} else {
		$file_name = time().$file_name;
	}
	}

$saveFile = $folder.$file_name;

if(is_uploaded_file($file['tmp_name'])){
	
	if(move_uploaded_file($file['tmp_name'],$saveFile)){
	
	$query = "INSERT INTO `fl_dms` (`id`, `resource_type`, `account_id`, `workflow_id`, `record_id`, `parent_id`, `label`, `descrizione`, `tags`, `file`, `lang`, `proprietario`, `operatore`, `data_creazione`, `data_aggiornamento`) 
	VALUES (NULL, '1', '".$this->userId."', '$workflow_id', '$record_id', '$folder', '$file_name', '$descrizione', '$tags', '$file_name', '$lang', '".$this->accountId."', '".$this->accountId."', NOW(),NOW() );	";
	if($record_id > 0) $this->query($query); //If goes wrong wuery method send us an email with error so we can fix any problem (never happend in 10 years!)
	//if($record_id > 0) $this->toDMS($folder,$file_name,$workflow_id,$record_id,$descrizione,$tags,$lang);
	} else {

	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = 0;
	$this->contenuto['info_txt'] = $esiti[9];
	$this->cnv_makedata();

	}
	
} else {
	
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = 0;
	$this->contenuto['info_txt'] = $esiti[2];
	$this->cnv_makedata();
}

//ADD Antivirus check here (4marco)
return true;
}


function base64_to_jpeg($base64_string,$folder='./',$output_file) {
   
    $ifp = fopen($folder.$output_file, "wb");

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[0]));

    fclose($ifp);

    return $folder.$output_file;

}

public function toDMS($label,$file_name,$workflow_id=0,$record_id=0,$parent_id=0,$descrizione='',$tags='',$lang='en'){

	$query = "INSERT INTO `fl_dms` (`id`, `resource_type`, `account_id`, `workflow_id`, `record_id`, `parent_id`, `label`, `descrizione`, `tags`, `file`, `lang`, `proprietario`, `operatore`, `data_creazione`, `data_aggiornamento`) 
	VALUES (NULL, '1', '".$this->userId."', '$workflow_id', '$record_id', '$parent_id', '$label', '$descrizione', '$tags', '$file_name', '$lang', '".$this->accountId."', '".$this->accountId."', NOW(),NOW() );";
	
	$insertId = $this->query($query); //If goes wrong wuery method send us an email with error so we can fix any problem (never happend in 10 years!)
	//mail('supporto@aryma.it', "Query toDMS",$query);

	return $insertId;
}






































function insert_lead(){


$this->contenuto['esito'] = 0;

if(!isset($_POST['privacy']) || $_POST['privacy'] == 0){
$this->contenuto['class'] = 'red';
$this->contenuto['esito'] = "Per continuare è necessario autorizzare al trattamento dei propri dati!";
$this->cnv_makedata();
}

$mail_message = '';
// Campi Obbligatori
foreach($_POST as $chiave => $valore){
	
		if(in_array($chiave,$this->obbligatorio)) {
		if($valore == ""){
		$chiave = ucfirst(check($chiave));
		$this->contenuto['class'] = 'red';
		$this->contenuto['esito'] = "Compila il campo $chiave";
		$this->cnv_makedata();

		}}
		
		if(in_array($chiave,$this->numerici)) {
		if(!is_numeric(trim($valore))){
		$chiave = ucfirst(check($chiave));
		$this->contenuto['class'] = 'red';
		$this->contenuto['esito'] = "Inserisci solo numeri in $chiave";
		$this->cnv_makedata();
		}}
		

		$$chiave = $this->check($valore);
		if(in_array($chiave,$this->date)) $$chiave = $this->convert_data($this->check($valore),1);
		$mail_message .= '<p>'.$chiave.' = '.$$chiave.'</p>';
}


if(!is_numeric(trim($telefono)) || strlen(@$telefono) < 9 ){
$this->contenuto['class'] = 'red';
$this->contenuto['esito'] = "Inserisci un numero di telefono corretto, almeno 9 cifre!";
$this->cnv_makedata();
}



$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
if (isset($email) && !preg_match($regex, $email)){
$this->contenuto['class'] = 'red';
$this->contenuto['esito'] = "Inserisci email valido";
$this->cnv_makedata();
}


$campi = array('nome', 'cognome','email', 'messaggio','telefono','citta','ragione_sociale', 'partita_iva','campagna','attivita','oggetto','messaggio','note');
foreach($campi as $chiave => $valore){
	if(!isset($$valore)) $$valore = '';
}
$campagna = 8;
$attivita = 2;


$sql = "INSERT INTO `fl_leads` (`id`, `data_aggiornamento`,`priorita_contatto`, `data_aggiornamento`,`priorita_contatto`, `nome`, `cognome`, `email`, `telefono`, `citta`,`ragione_sociale`, `partita_iva`, `messaggio`,  `note`, `operatore`, `proprietario`, `venditore`, `data_creazione`, `data_assegnazione`, `data_scadenza`, `data_scadenza_venditore`) 
VALUES (NULL,  NOW(), '$priorita',  '$nome', '$cognome', '$email','$telefono',  '$citta', '$ragione_sociale', '$partita_iva', '$oggetto $messaggio', '$note', '1', '1', '', NOW(), '', '', '');";



if(mysql_query($sql, CONNECT)){

$lead_id = mysql_insert_id();
$mail_subject = "Nuovo Lead Inserito";


$this->contenuto['class'] = 'green';
$this->contenuto['url'] = '#';
$this->contenuto['esito'] = "Grazie l'interesse!";

$mail_body2 = str_replace("[*CORPO*]",$mail_message,mail_template); 
//mail('supporto@aryma.it', $mail_subject, $mail_message);


} else {


$this->contenuto['class'] = 'red';
$this->contenuto['esito'] = "Error 1101: Problema inserimento lead.".mysql_error();
$mail_message = "ERRORE DATABASE: ".mysql_error().'<br>'.$mail_message;
$mail_body3 = str_replace("[*CORPO*]",$mail_message,mail_template); 
//smail( mail_admin, "Problema inserimento nuovo lead su: ".ROOT,$mail_body3);
}				 

$this->cnv_makedata();

} // Lead in



function get_leads(){
	$leads = array();
	$query = "SELECT * FROM `fl_potentials`  WHERE 1 ORDER BY data_creazione DESC";
	
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_array($risultato)){

	array_push($leads,array(
	
	'id'=>$riga['id'],
	'nome'=>$riga['nome'],
	'cognome'=>$riga['cognome'],
	'priorita'=>$riga['priorita']
	));
	
	}	
	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['leads'] = $leads;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}

function get_items($item_rel,$condition=0) {
	$query = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 AND item_rel = $item_rel ORDER BY label ASC";
	$dati = array();
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_array($risultato)){

	array_push($dati,array(
	
	'id'=>$riga['id'],
	'label'=>$riga['label'],
	'descrizione'=>$riga['descrizione']
	));
	
	}	
	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;
	
	} else { 
	$this->contenuto['class'] = 'red';
	$this->contenuto['esito'] = "Error 1102: Errore caricamento.".mysql_error();
	}
	
	$this->cnv_makedata();
}


/*Funzioni Globali e Utility */
function lead_info($lead_id) {
 	
	$this->app_start();
	$query = "SELECT * FROM `fl_leads_hrc` WHERE `id` = $lead_id LIMIT 1";
	$risultato = mysql_query($query,CONNECT);	
	$riga = @mysql_fetch_array($risultato); 
	
	if(mysql_affected_rows(CONNECT) < 1){			
	$this->contenuto =  array('id'=>$lead_id,'ragione_sociale'=>'Unknow','nome'=>'Unknow','cognome'=>'Unknow',"email"=>'Unknow',"telefono"=>'Unknow',"indirizzo"=>'Unknow',"cap"=>'Unknow',"localita"=>'Unknow',"citta"=>'Unknow');
	} else {
	$this->contenuto =  array('id'=>$riga['id'],'ragione_sociale'=>$riga['ragione_sociale'],'nome'=>$riga['nome'],'cognome'=>$riga['cognome'],"email"=>$riga['email'],"telefono"=>$riga['telefono'],"indirizzo"=>$riga['indirizzo'],"cap"=>$riga['cap'],"citta"=>$riga['citta']);
	}
	$this->cnv_makedata();

}


function listArticles(){
	$content = array();
	$risultato = $this->query("SELECT * FROM `fl_articoli`  WHERE categoria_id = ".$this->categoria_id." ORDER BY data_creazione DESC");
	
	while($riga = mysql_fetch_array($risultato)){

	array_push($content,array(
	'id'=>$riga['id'],
	'titolo'=>$riga['titolo'],
	'data_pubblicazione'=>$riga['data_pubblicazione'],
	'articolo'=>$riga['articolo'],
	'video'=>$riga['video'],
	'video'=>$riga['sorgente_esterna'],
	'data_aggiornamento'=>$riga['data_aggiornamento']
	));
	}

	$this->contenuto['class'] = 'green';
	$this->contenuto['esito'] = "OK";
	$this->contenuto['content'] = $content;
	
	$this->cnv_makedata();
}


function getArticle(){
		
		$risultato = $this->query("SELECT * FROM `fl_articoli` WHERE `id`  = '".$this->articleId."' AND status_contenuto > 0 LIMIT 1");
		$riga = mysql_fetch_array($risultato);
		
		$this->contenuto['esito'] = 1;
		$this->contenuto['info_txt'] = "Ok";
		$this->contenuto['id'] = $riga['id'];
		$this->contenuto['data_pubblicazione'] = $riga['data_pubblicazione'];
		$this->contenuto['titolo'] = $riga['titolo'];
		$this->contenuto['articolo'] = $this->convert($riga['articolo']);
		$this->contenuto['video'] = $riga['video'];
		$this->contenuto['sorgente_esterna'] = $riga['sorgente_esterna'];
		$this->contenuto['data_aggiornamento'] = $riga['data_aggiornamento'];
	
		$this->cnv_makedata();
}

function do_login(){
		
		$this->app_start();

		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if (!defined('LOGINBYUSER') && $this->user != 'sistema' && !preg_match($regex,strtolower(trim($this->user)))){
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Per usare le api devi essere registrato";
		$this->cnv_makedata();
		}

		
		if($this->user == "" || $this->password == "") {	
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Inserisci user e password!";
		$this->cnv_makedata();
		}
		
	
		if($this->user != "" && $this->password != ""){
		
		$this->password = md5($this->password); 
		
		$query = "SELECT * FROM `".$this->table."` WHERE `password`  = '".$this->password."' AND `user`  = '".$this->user."' LIMIT 1";
		if($this->uid != 0) $query = "SELECT * FROM `".$this->table."` WHERE  `uid`  = '".$this->uid."' LIMIT 1";
		
		$risultato = mysql_query($query,CONNECT);
	
		if(mysql_affected_rows(CONNECT) < 1){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Email o password errate!";
		$this->cnv_makedata();
		} 		
		
		$riga = mysql_fetch_array($risultato);
				
		
		if($riga['attivo'] == 0){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Utente non attivo.";
		$this->cnv_makedata();
		}
		

		$fcmToken = ", fcmToken = '".$this->fcmToken."'";		
		$updateAccount = "UPDATE `".$this->table."` SET `visite` = visite+1 $fcmToken WHERE `id` = '".$riga['id']."' LIMIT 1;";
		if(!mysql_query($updateAccount,CONNECT)) mail('supporto@aryma.it',"Update FcmToken Fallito",$updateAccount);


		$_SESSION['user'] = $riga['user'];
		$_SESSION['operatore'] = $riga['user'];
		$_SESSION['userid'] = $riga['id'];
		$_SESSION['nome'] = $riga['nominativo'];
		$_SESSION['mail'] = $riga['email'];		
		$_SESSION['number'] = $riga['id'];			
		$_SESSION['usertype'] = $riga['tipo'];
		$_SESSION['time'] = time();	
		$_SESSION['idh'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['aggiornamento_password'] = $riga['aggiornamento_password'];
		$_SESSION['marchio'] = $riga['marchio'];
		
		// Fine Avvio Sessione			
		$agent = @$_SERVER['HTTP_USER_AGENT'];
		$referer = @$_SERVER['HTTP_REFERER'];
		$lang = @$_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $data = time();

		$this->contenuto['esito'] = $riga['attivo'];		
		$this->contenuto['info_txt'] = "Login OK";
		$this->contenuto['usertype'] = $_SESSION['usertype'];
		$this->contenuto['user'] = $_SESSION['user'];
		$this->contenuto['operatore'] = $_SESSION['user'];
		$this->contenuto['email'] = $_SESSION['mail'];
		$this->contenuto['usr_id'] = $_SESSION['number'];	
		$this->contenuto['token'] = session_id();
		$this->contenuto['fcmToken'] = $this->fcmToken;
		$this->contenuto['nome'] = $_SESSION['nome'];	
		$this->contenuto['aggiornamento_password'] = $riga['aggiornamento_password'];	
		$this->contenuto['time'] = time();	
		$this->contenuto['idh'] = $_SERVER['REMOTE_ADDR'];
		$this->contenuto['marchio'] = $_SESSION['marchio'] ;
		}
		$this->cnv_makedata();
} // Login



private function data_labels($item_rel,$condition=0) {
	$query = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 AND item_rel = $item_rel ORDER BY label ASC";
	$risultato = mysql_query($query,CONNECT);
	$rel_info = array();
	
	while ($riga = @mysql_fetch_array($risultato)) {
	$rel_info[$riga['id']] = $riga['label'];
    }
	
	if($condition == 1){	
	$this->contenuto = 	array('dati'=>$rel_info,'esito'=>1,'info_txt'=>"dati caricati");	
	echo json_encode($this->contenuto);
	mysql_close(CONNECT);
	exit;	
	} else {
	return $rel_info;
	}
}
function html_to_text($stringa,$quot=0){
	$stringa = str_replace("&gt;", ">",str_replace("&lt;", "<",str_replace("'", "&rsquo;",$stringa)));
	//sostituisc i <br/>
	$stringa=preg_replace("/<br\W*?\/>/", "\r\n",$stringa);
	//elimino tutti i tag
	$stringa = strip_tags($stringa);
	return $stringa."\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
}
function mydate($mysqldate){
	if($mysqldate != '0000-00-00') {
	$phpdate = strtotime( $mysqldate );
	return date( 'd/m/Y', $phpdate );
	} else { return '--'; }
}
function mydatetime($mysqldate){
	$phpdate = strtotime( $mysqldate );
	return date('H:i d/m/Y', $phpdate );
}
function convert($var,$quot=0){
$var =  str_replace("../../../",ROOT,str_replace("&gt;", ">",str_replace("&lt;", "<",str_replace("'", "&rsquo;",$var))));
if($quot==0) { $var =  str_replace("&quot;", '"',$var); }
str_replace('"', "&quot;",$var);
return $var;
}
	
function check($var){
$var =  trim(str_replace("<", "&lt;",str_replace(">", "&gt;",@addslashes(@stripslashes(@str_replace('"',"&quot;",str_replace("'", "&rsquo;", $var) ))))));
return $var;
} 


	
function convert_data($data,$mode=0){

if($mode == 0) {
$tempo = explode("/",$data);
$extra = "";
$data = @mktime(0,0,0,$tempo[1],$tempo[0],$tempo[2]);
} else if($mode == 1){ 
$tempo = explode("/",$data);
$extra = "";
$data = trim($tempo[2])."-".trim($tempo[1])."-".trim($tempo[0]);
 }
return $data;

}





}