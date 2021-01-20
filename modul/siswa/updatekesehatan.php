<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_POST['idpd'];
	$idkes=$_POST['idkes'];
	$smt=$_POST['smt'];
	$tapel=$_POST['tapel'];
	$tinggi=$connect->real_escape_string($_POST['tinggi']);
	$berat=$connect->real_escape_string($_POST['berat']);
	$pendengaran=$connect->real_escape_string($_POST['pendengaran']);
	$penglihatan=$connect->real_escape_string($_POST['penglihatan']);
	$gigi=$connect->real_escape_string($_POST['gigi']);
	$lainnya=$connect->real_escape_string($_POST['lainnya']);
	if(empty($smt) || empty($id)){
		$validator['success'] = false;
		$validator['messages'] = "Keterangan tidak boleh kosong";
	}else{
			$sql1 = "UPDATE data_kesehatan set tinggi='$tinggi', berat='$berat', pendengaran='$pendengaran', penglihatan='$penglihatan', gigi='$gigi', lainnya='$lainnya' WHERE id='$idkes'";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Data Kesehatan berhasil diubah!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}