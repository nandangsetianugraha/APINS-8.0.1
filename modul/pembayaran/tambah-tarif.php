<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {		$validator = array('success' => false, 'messages' => array());	$idr=$_POST['idsiswa'];	$jenis=$_POST['jenis'];	$tapel=$_POST['tapel'];	$tarif=strip_tags($connect->real_escape_string($_POST['tarif']));		if(empty($tarif) || empty($jenis)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{		if($jenis==1){			$sql = "INSERT INTO tarif_spp(peserta_didik_id,tarif) VALUES('$idr','$tarif')";			$query = $connect->query($sql);		}else{
			$sql = "INSERT INTO tunggakan_lain(peserta_didik_id,tapel,jenis,tarif) VALUES('$idr','$tapel','$jenis','$tarif')";			$query = $connect->query($sql);		}
			$validator['success'] = true;
			$validator['messages'] = "Tarif berhasil ditambah!";		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}