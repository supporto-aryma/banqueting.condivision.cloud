<?php

class apicore{


	var $demo = true; // Se abilitare o meno il demo 
	var $datatype = "JSON";	
	var $contenuto = array();
	var $token;
	var $user;
	var $password;
	var $uid;
	var $id1;
	var $type1 = 113;
	var $obbligatorio = array('nome');
	var $numerici = array('telefono','cellulare');
	var $date = array();
	var $table = 'fl_leads';
	var $secret = 're56fdsfw285hfw5k3923k2ASYLWJ8tr3';
	var $push_type = 'post';
	var $deviceToken = 0;
	var $path = '';
	


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

private function cnv_makedata(){
	
	mysql_close(CONNECT);		
	
	if($this->datatype == 'JSON') {
	echo json_encode($this->contenuto);
	exit;
	}
	
    if($this->datatype == 'OBJECT') {
	return $this->contenuto;
	}
	
	if($this->datatype == 'XML') {
	echo json_encode($this->contenuto);
	exit;
	}
	
}

private function db_fetch_obj($table,$what='*',$where){ 
	/* 26/7/2018 Michele & Josue (on 2028 we still use this?)
	some updates..  */
	$query = "SELECT $what FROM $table WHERE $where";
	$results = mysql_query($query,CONNECT);
	$dati = array();
	if(mysql_error())  $dati = array('id'=>$query.' '.mysql_error());
	if(mysql_affected_rows() > 0) { while($riga = mysql_fetch_assoc($results)) { $dati[] = $riga; } }
	return $dati;
}

function get_quote_details($id){
	$details = $this->db_fetch_obj('fl_menu_portate','*','id = '.$id);
	$cgRes = $this->db_fetch_obj('fl_cg_res','label','id > 1');
	$details[0]['descrizione_menu'] = $cgRes[$details[0]['centro_di_ricavo']]['label'];
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $details;	
	
	$this->cnv_makedata();

}

function update_quote($id,$totale_prodotto){
	$details = $this->query('UPDATE fl_menu_portate SET totale_prodotto = '.$totale_prodotto.' WHERE id = '.$id);
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $details;	
	
	$this->cnv_makedata();

}


function get_food(){

	$category = array('Non usare','Aperitivi','Antipasti','Primi','Secondi','Frutta','Dessert','Torte',50=>'Menù Baby',200=>'Varie');
	$dati = array();
	$id1 = $this->id1;
	$type1 = $this->type1;
	$type2 = 119; //Ricettario
	

	foreach ($category as $cat_id => $cat_name) {

		if($cat_id > 0){
		$subcatsList = array();

		#NEW 
		$subcats = $this->db_fetch_obj('fl_ricettario_categorie','*',"id != 1 AND (disponibilita_portate = '' OR disponibilita_portate = $cat_id) ");
		//ricordarsi di controllare se ricetta perde categoria e poi non viene pescata in synapsy o se peggio viene eliminata deve risultare in synapsy come RICETTA NON PRESENTE!!!
		foreach ($subcats as $subcat_id => $subcat_name) {
			$addedItems = $this->db_fetch_obj('fl_synapsy AS t1 LEFT JOIN fl_ricettario AS t2 ON t1.id2 = t2.id','t1.id,t1.descrizione,t1.valore,t1.qty,t1.note,t1.priority',"t1.id != 1 AND t1.id1 = ".$id1." AND t1.type2 = $type2 AND t2.portata = $cat_id AND (t2.categoria_ricetta < 2 OR t2.categoria_ricetta = ".$subcat_name['id'].') ORDER BY priority DESC');
			$items = $this->db_fetch_obj('fl_ricettario','id,nome_tecnico AS descrizione,prezzo_vendita AS ultimo_prezzo,categoria_ricetta',"id != 1 AND portata = $cat_id AND (categoria_ricetta = ".$subcat_name['id'].' OR categoria_ricetta < 2)');
			

			$subcatsList[$subcat_id] = array(
			    'subcat_id'=>$subcat_name['id'],
			    'subcat_name'=>$subcat_name['descrizione'],
				'subcat_note'=>@$subcat_name['note'],
				'quiverCode'=>base64_encode($type1.'-'.$type2.'-'.$id1),
				'items'=>$items, // all items in this subcat
				'addedItems'=>$addedItems // all items added form client
			);

		}
		
		$dati[] = array('cat_id'=>$cat_id,'cat_name'=>$cat_name,'cat_minVal'=>1,'subcatsList'=>$subcatsList);
		}

	}
	
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;	
	
	$this->cnv_makedata();

}


function get_beverage(){

	$category = array(100=>'Vini');
	$dati = array();
	$id1 = $this->id1;
	$type1 = $this->type1;
	$type2 = 119;

	foreach ($category as $cat_id => $cat_name) {

		$subcatsList = array();

		#NEW 
		$subcats = $this->db_fetch_obj('fl_ricettario_categorie','*',"id != 1 AND disponibilita_portate = $cat_id");
		//ricordarsi di controllare se ricetta perde categoria e poi non viene pescata in synapsy o se peggio viene eliminata deve risultare in synapsy come RICETTA NON PRESENTE!!!
		foreach ($subcats as $subcat_id => $subcat_name) {
			$addedItems = $this->db_fetch_obj('fl_synapsy AS t1 LEFT JOIN fl_ricettario AS t2 ON t1.id2 = t2.id','t1.id,t1.descrizione,t1.valore,t1.qty,t1.note,t1.priority',"t1.id != 1 AND t1.id1 = ".$id1." AND t1.type2 = $type2 AND t2.portata = $cat_id AND (t2.categoria_ricetta < 2 OR t2.categoria_ricetta = ".$subcat_name['id'].') ORDER BY priority DESC');
			$items = $this->db_fetch_obj('fl_ricettario','id,nome_tecnico AS descrizione,prezzo_vendita AS ultimo_prezzo,categoria_ricetta',"id != 1 AND portata = $cat_id AND (categoria_ricetta = ".$subcat_name['id'].' OR categoria_ricetta < 2)');
			$subcatsList[$subcat_id] = array(
			    'subcat_id'=>$subcat_name['id'],
			    'subcat_name'=>$subcat_name['descrizione'],
				'subcat_note'=>@$subcat_name['note'],
				'quiverCode'=>base64_encode($type1.'-'.$type2.'-'.$id1),
				'items'=>$items, // all items in this subcat
				'addedItems'=>$addedItems // all items added form client
			);

		}
		
		$dati[] = array('cat_id'=>$cat_id,'cat_name'=>$cat_name,'cat_minVal'=>1,'subcatsList'=>$subcatsList);

	}
	
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;	
	
	$this->cnv_makedata();

}

function get_stewarding(){

	$category = array(2=>'Coperto',3=>'Evento');
	$dati = array();
	$id1 = $this->id1;
	$type1 = $this->type1;
	$type2 = 115;

	foreach ($category as $cat_id => $cat_name) {

		$subcatsList = array();

		#NEW 
		$subcats = $this->db_fetch_obj('fl_magazzino_categorie','*',"id != 1 AND tipo_materia = $cat_id");

		foreach ($subcats as $subcat_id => $subcat_name) {
			$addedItems = $this->db_fetch_obj('fl_synapsy AS t1 LEFT JOIN fl_materieprime AS t2 ON t1.id2 = t2.id','t1.id,t1.descrizione,t1.valore,t1.qty,t1.note,t1.priority',"t1.id != 1 AND t1.id1 = ".$id1." AND t1.type2 = $type2 AND t2.categoria_materia = ".$subcat_name['id']." ORDER BY priority DESC");
			$items = $this->db_fetch_obj('fl_materieprime','id,descrizione,ultimo_prezzo,categoria_materia',"id != 1 AND categoria_materia = ".$subcat_name['id']);
			$subcatsList[$subcat_id] = array(
			    'subcat_id'=>$subcat_name['id'],
			    'subcat_name'=>$subcat_name['descrizione'],
				'subcat_note'=>@$subcat_name['note'],
				'quiverCode'=>base64_encode($type1.'-'.$type2.'-'.$id1),
				'items'=>$items, // all items in this subcat
				'addedItems'=>$addedItems // all items added form client
			);

		}
		
		$dati[] = array('cat_id'=>$cat_id,'cat_name'=>$cat_name,'cat_minVal'=>1,'subcatsList'=>$subcatsList);

	}
	
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;	
	
	$this->cnv_makedata();

}

function get_staff(){

	$category = array(0=>'Staff');
	$dati = array();
	$id1 =  $this->id1;
	$type1 = $this->type1;
	$type2 = 83;

	foreach ($category as $cat_id => $cat_name) {

		$subcatsList = array();

		#NEW 
		$subcats = $this->db_fetch_obj('fl_processi','id,processo AS descrizione',"id != 1");
		
		foreach ($subcats as $subcat_id => $subcat_name) {
			$addedItems = $this->db_fetch_obj('fl_synapsy AS t1 LEFT JOIN fl_profili_funzione AS t2 ON t1.id2 = t2.id','t1.id,t1.descrizione,t1.valore,t1.moltiplicatore,t1.qty,t1.note,t1.priority',"t1.id != 1 AND t1.id1 = ".$id1." AND t1.type2 = $type2 AND t2.processo_id = ".$subcat_name['id']." ORDER BY priority DESC");
			$items = $this->db_fetch_obj('fl_profili_funzione','id,funzione AS descrizione,vendita_orario AS ultimo_prezzo,processo_id',"id != 1 AND processo_id = ".$subcat_name['id']);
			$subcatsList[$subcat_id] = array(
			    'subcat_id'=>$subcat_name['id'],
			    'subcat_name'=>$subcat_name['descrizione'],
				'subcat_note'=>@$subcat_name['note'],
				'quiverCode'=>base64_encode($type1.'-'.$type2.'-'.$id1),
				'items'=>$items, // all items in this subcat
				'addedItems'=>$addedItems // all items added form client
			);

		}
		
		$dati[] = array('cat_id'=>$cat_id,'cat_name'=>$cat_name,'cat_minVal'=>1,'subcatsList'=>$subcatsList);

	}
	
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;	
	
	$this->cnv_makedata();

}

function get_veichels(){

	$category = array(1=>'Cargo',2=>'Auto',3=>'Transfert');
	$dati = array();
	$id1 =  $this->id1;
	$type1 = $this->type1;
	$type2 = 114;
	$subcatsList = array();

	foreach ($category as $cat_id => $cat_name) {


		$addedItems = $this->db_fetch_obj('fl_synapsy AS t1 LEFT JOIN fl_veicoli_tipo AS t2 ON t1.id2 = t2.id','t1.id,t1.descrizione,t1.valore,t1.qty,t1.note,t1.priority',"t1.id != 1 AND t1.type2 = $type2 AND t1.id1 = ".$id1." AND t1.type2 = $type2 AND t2.tipo_veicolo = ".$cat_id." ORDER BY priority DESC");
		$items = $this->db_fetch_obj('fl_veicoli_tipo','id,CONCAT(descrizione) AS descrizione,prezzo_vendita AS ultimo_prezzo,tipo_veicolo',"id != 1 AND tipo_veicolo = ".$cat_id);
		$subcatsList[$cat_id] = array(
			    'subcat_id'=>$cat_id,
			    'subcat_name'=>$cat_name,
				'subcat_note'=>'',
				'quiverCode'=>base64_encode($type1.'-'.$type2.'-'.$id1),
				'items'=>$items, // all items in this subcat
				'addedItems'=>$addedItems // all items added form client
		);

	
		
		$dati[] = array('cat_id'=>$cat_id,'cat_name'=>$cat_name,'cat_minVal'=>1,'subcatsList'=>$subcatsList);

	}
	
	$this->contenuto['esito'] = "OK";
	$this->contenuto['dati'] = $dati;	
	
	$this->cnv_makedata();

}


function createSynapsy(){

	$this->table = 'fl_synapsy';
		
	$synVal = base64_decode($_REQUEST['quiverCode']);//we decode quiver data
	$synVal = explode('-',$synVal); // we make an array from string we get
	$_REQUEST['type1'] = $synVal[0]; //we set value 1 as id of table 1
	$_REQUEST['type2'] = $synVal[1]; //we set value 2 as id of table 2
	$_REQUEST['id1'] = $synVal[2]; //we set value 3 as id of row in table 1
	$_REQUEST['id2'] = $_REQUEST['arrowId']; //we set arroId as id in table 2

	$this->contenuto['dati'] = $this->insertUpdate(1);	

	$this->cnv_makedata();
}

function updateSynapsy($recordId){
	
	$this->table = 'fl_synapsy';

	$this->contenuto['dati'] = $this->insertUpdate($recordId);	

	$this->cnv_makedata();
}

function removeSynapsy($recordId){	
    $this->contenuto['esito'] = ($this->remove('fl_synapsy',$recordId) == 1) ? 'OK' : 'KO';
	$this->cnv_makedata();
}

private function insertUpdate($recordId){

	$issue = 0;
	$sql = 'DESCRIBE '.$this->table.';';
	$updateSQL = 'UPDATE '.$this->table.' SET ';
	$createSQL = 'INSERT INTO '.$this->table.' VALUES ();';
	$fields = $this->query($sql);
	
	sleep(1);

	while($FieldProp = mysql_fetch_array($fields)){ 
		
		$FieldName = $FieldProp['Field'];
		if($FieldName == 'data_aggiornamento') $updateRecord = 1;
		if($FieldName != 'id' && $FieldName != 'data_creazione'){
		if(isset($_GET['explain'])) echo "VALUE EXPECTED: ".$FieldName.' ('.$FieldProp['Type'].','.$FieldProp['Null'].','.$FieldProp['Default'].')<br>';
			
			if(isset($_REQUEST[$FieldName])){
				$Field = $this->check($_REQUEST[$FieldName]); // Security Check of the received field data
				if(isset($comma)) { $updateSQL .=  ',';  }  else { $comma = 1; }
				$updateSQL .= $this->checkField($Field,$FieldName,$FieldProp['Type'],$FieldProp['Null'],$FieldProp['Default']); //Formal type check of field
			}
		}
	}

	if(isset($updateRecord) && $recordId == 1) $updateSQL .=  ', data_creazione = NOW() '; 
	if(isset($updateRecord)) $updateSQL .=  ', data_aggiornamento = NOW() '; //Used only for new entries!


	

	if($recordId == 1 && !isset($_GET['explain'])) { $this->query($createSQL); $recordId = mysql_insert_id();  } // if 1 create a new record	
	
	$updateSQL .= ' WHERE id = '.$recordId;
	$issue = (isset($_GET['explain'])) ? '(NO QUERY SENT IN DEBUG MODE) : '.$updateSQL : $this->query($updateSQL);
	//mail('supporto@aryma.it','Query app da ',$updateSQL);
	if($issue == 1) $issue = $recordId;
	$this->contenuto['esito'] = ($issue < 1) ? 'KO' : 'OK';

	return  $issue;//Issue of Update
	
}


function query($sql){ 
  $results = mysql_query($sql,CONNECT);
  return  (mysql_affected_rows() >= 0) ? $results : $sql.mysql_error();
}

function checkField($Field,$FieldName,$Type,$Null=NULL,$Default=''){ 
  if($Type == 'date')  $Field = $this->determina_data($Field); 
  if(isset($_GET['explain'])) echo 'SENT: '.$FieldName.' = '.$Field.' '.$Type.'<br>'; 
  return  '`'.$FieldName.'` =  \''.$Field.'\''; //Per ora non fa nulla
}

private function remove($table,$recordId){ 
  $sql = "DELETE FROM $table WHERE id = $recordId LIMIT 1;";
  $this->query($sql);
  return  (mysql_affected_rows() >= 0) ? 1 : $sql.mysql_error();
}

public static function determina_data($data){
			$str_array = preg_split('/[\/\-]/', $data);
			return (strlen($str_array[0]) == 4) ? $data : $this->convert_data($data,1);
}



function get_items($item_rel,$condition=0) {
	$query = "SELECT * FROM `fl_items` WHERE id != 1 AND attiva > 0 AND item_rel = $item_rel ORDER BY label ASC";
	$dati = array();
	if($risultato = mysql_query($query,CONNECT)){
	
	while($riga = mysql_fetch_array($risultato)){
	$descrizione = (isset($riga['descrizione'])) ? $riga['descrizione'] : '';
	array_push($dati,array(
	
	'id'=>$riga['id'],
	'label'=>$riga['label'],
	'descrizione'=>$descrizione
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



function do_login(){

		$this->app_start();

		/*$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
		if ($this->user != 'sistema' && !preg_match($regex,strtolower(trim($this->token)))){
		$this->contenuto['esito'] = 1;
		$this->contenuto['info_txt'] = "Per usare le api devi essere registrato";
		$this->cnv_makedata();
		}*/

		
		if(($this->user == "" || $this->password == "") && $this->uid == 0) {	
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Inserisci user e password!";
		$this->cnv_makedata();
		}
		
	
		
		$this->password = md5($this->password); 
		
		$query = "SELECT * FROM `fl_admin` WHERE `password`  = '".$this->password."' AND `user`  = '".trim(strtolower($this->user))."' LIMIT 1";
		if($this->uid != 0) $query = "SELECT * FROM `fl_admin` WHERE  `uid`  = '".$this->uid."' LIMIT 1";
		$risultato = mysql_query($query,CONNECT);
		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = mysql_affected_rows();
	
	
		if(mysql_affected_rows(CONNECT) < 1){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Email o password errate o utente Fb non riconosciuto";
		$this->cnv_makedata();
		} 		
		
		$riga = mysql_fetch_array($risultato);
				
		
		if($riga['attivo'] == 0){		
		$this->contenuto['esito'] = 0;
		$this->contenuto['info_txt'] = "Utente non attivo.";
		$this->cnv_makedata();
		}
		
		mysql_query("UPDATE `fl_admin` SET `visite` = visite+1 WHERE '".$this->password."' AND `user`  = '".$this->user."' LIMIT 1;");
		
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
		$this->contenuto['nome'] = $_SESSION['nome'];	
		$this->contenuto['aggiornamento_password'] = $riga['aggiornamento_password'];	
		$this->contenuto['time'] = time();	
		$this->contenuto['idh'] = $_SERVER['REMOTE_ADDR'];
		$this->contenuto['marchio'] = $_SESSION['marchio'] ;
	
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