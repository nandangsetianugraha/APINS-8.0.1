<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$idr=$_POST['idtema'];
	
	$namatema=strip_tags($connect->real_escape_string($_POST['namatema']));
	$sql = "SELECT * FROM jenis_tunggakan WHERE id_tunggakan='$idr'";
	$usis = $connect->query($sql)->fetch_assoc();
	if(empty($namatema)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
			$sql = "update jenis_tunggakan set nama_tunggakan='$namatema' where id_tunggakan='$idr'";
			$query = $connect->query($sql);
			$validator['success'] = true;
			$validator['messages'] = "Penerimaan berhasil diperbaharui!";		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}