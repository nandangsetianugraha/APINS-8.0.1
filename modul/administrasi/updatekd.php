<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$idr=$_POST['idkd'];
	
	$kd=$_POST['kd'];
	$namakd=strip_tags($connect->real_escape_string($_POST['deskripsi']));
	$sql = "SELECT * FROM kd WHERE id_kd='$idr'";
	$usis = $connect->query($sql)->fetch_assoc();
	if(empty($kd) || empty($namakd)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
			$sql = "update kd set kd='$kd',nama_kd='$namakd' where id_kd='$idr'";
			$query = $connect->query($sql);
			$validator['success'] = true;
			$validator['messages'] = "KD berhasil diperbaharui!";		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}