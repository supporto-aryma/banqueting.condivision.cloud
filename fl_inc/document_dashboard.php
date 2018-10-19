<br><?php 	

ini_set('display_errors',1);
error_reporting(E_ALL);




include('./fl_core/dataset/proprietario.php');
if($_SESSION['usertype'] > 1) { echo "Non puoi accedere a questo modulo"; exit; }


$proprietario_id = (isset($_GET['proprietario'])) ? check($_GET['proprietario']) : 0;
$_SESSION['POST_BACK_PAGE'] = $_SERVER['REQUEST_URI'];

?>
<h2>Seleziona un account</h2>

<div class="col_sx_content">
<form method="get" action="" id="dms_account_sel">

<?php 			$selected = ($proprietario_id == 0) ? ' checked="checked"' : '';
?>
<input id="0" onClick="form.submit();" type="radio" name="proprietario" value="0" <?php echo $selected; ?> />
		
 <?php
			
			 foreach($proprietario as $valores => $label){ // Recursione Indici di Categoria
			$selected = ($proprietario_id == $valores) ? ' checked="checked"' : '';
			if($valores != 0){ echo '
			<input id="'.$valores.'" onClick="form.submit();" type="radio" name="proprietario" value="'.$valores.'" '.$selected.' />
			<label for="'.$valores.'"><i class="fa fa-user"></i><br>'.$label.'</label>'; }
			}
		 ?>
      
     <input type="hidden" name="a" value="dashboard">
     <input type="hidden" name="d" value="ZG9jdW1lbnRfZGFzaGJvYXJk">
   
</form>
</div>

<div class="col_dx_content">
<?php if(!isset($_GET['proprietario'])) { ?><img src="./fl_set/lay/intro1.png" alt="Intro"/><?php } else { ?>

<script src="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/dropzone.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo ROOT.$cp_admin.$cp_set; ?>jsc/dropzone.css">
<div class="dashboard_content">
 
    <?php
	
   	$data_set = new ARY_dataInterface();
    $main_folder = $data_set->data_retriever('fl_dms','label','WHERE id != 1 AND resource_type = 0 AND parent_id = 4 AND (account_id = 0 OR account_id =  '.$proprietario_id.' )','label ASC');
    $main_prop = $data_set->data_retriever('fl_dms','account_id','WHERE id != 1 AND resource_type = 0 AND parent_id = 4 AND (account_id = 0 OR account_id =  '.$proprietario_id.' )','label ASC');
	
	unset($main_folder[0]);
	foreach($main_folder as $chiave => $valore){
		$Aid_new = ($main_prop[$chiave] > 1) ? base64_encode($main_prop[$chiave]) : base64_encode(0);
		echo '<div class="box_dash_auto">';
		echo '<h3><i class="fa fa-file-text-o"></i> <span class="subcolor"><a href="./fl_modules/mod_dms/?proprietario='.$proprietario_id.'&c='.base64_encode($chiave).'">'.$valore.' '.$proprietario[$main_prop[$chiave]].'</a></span> <a onClick="$(\'.fl'.$chiave.'\').toggle();" href="#" style="font-size: smaller;">[Mostra/Nascondi]</a><span class="newfolder"><a href="./fl_modules/mod_dms/mod_inserisci.php?n&PiD='.base64_encode($chiave).'&AiD='.$Aid_new.'"><i class="fa fa-plus-circle"></i> Crea cartella</a></h3><div style="display: none;" class="fl'.$chiave.'">';
	    $sub_folders  = $data_set->data_retriever('fl_dms','label','WHERE id != 1 AND resource_type = 0 AND parent_id = '.$chiave.'','label ASC');
		unset($sub_folders[0]);
		foreach($sub_folders as $chiave2 => $valore2){
			    $sub = '';
			    $sub_folders2  = $data_set->data_retriever('fl_dms','label','WHERE id != 1 AND (account_id = 0 OR account_id = '.$proprietario_id.' ) AND resource_type = 0 AND parent_id = '.$chiave2.'','label ASC');
				unset($sub_folders2[0]);
				$sub .= '<option value="'.base64_encode($chiave2).'"> '.$valore.' </option>';
				foreach($sub_folders2 as $chiave3 => $valore3){
				$sub .= '<option value="'.base64_encode($chiave3).'"> '.strtoupper($valore3).' </option>';
				}
		$sub = (count($sub_folders2) > 0) ? '<select name="PiD" class="folder_select">'.$sub.'</select>' : '<input type="hidden" name="PiD" value="'.base64_encode($chiave2).'">';
		echo '<div class="dashboard_div"> <h3>    
      <a href="./fl_modules/mod_dms/?proprietario='.$proprietario_id.'&c='.base64_encode($chiave2).'"> '.strtoupper($valore2).' </a></h3>
	  <form action="./fl_modules/mod_dms/mod_opera.php" class="dropzone"  id="my-awesome-dropzone" enctype="multipart/form-data">
	  '.$sub.'
	  <input type="hidden" name="AiD" value="'.base64_encode($proprietario_id).'">

	  </form></div>';
			   
		}
		echo '</div><br class="clear" />
		 
		
		</div>';
	}
	?>
</div>
<?php } ?>

</div>