<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {		$validator = array('success' => false, 'messages' => array());	$idr=$_POST['idkd'];	$jenis=$_POST['jenis'];	$tarif=strip_tags($connect->real_escape_string($_POST['tarif']));	if($jenis==1){		$sql = "SELECT * FROM tarif_spp WHERE id='$idr'";		$usis = $connect->query($sql)->fetch_assoc();	}else{		$sql = "SELECT * FROM tunggakan_lain WHERE id='$idr'";		$usis = $connect->query($sql)->fetch_assoc();	}	if(empty($tarif) || empty($jenis)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{		if($jenis==1){			$sql = "update tarif_spp set tarif='$tarif' where id='$idr'";			$query = $connect->query($sql);		}else{
			$sql = "update tunggakan_lain set tarif='$tarif' where id='$idr'";			$query = $connect->query($sql);		}
			$validator['success'] = true;
			$validator['messages'] = "Tarif berhasil diperbaharui!";		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}