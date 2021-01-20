<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {		$validator = array('success' => false, 'messages' => array());	$idr=$_POST['idsiswa'];	$jenis=$_POST['jenis'];	$tapel=$_POST['tapel'];	$tarif=strip_tags($connect->real_escape_string($_POST['tarif']));	$sql = "SELECT * FROM tarif_spp WHERE peserta_didik_id='$idr'";	$usis = $connect->query($sql)->num_rows;	if(empty($tarif) || empty($jenis)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{		if($usis>0){			$sql = "UPDATE tarif_spp SET tarif='$tarif' WHERE peserta_didik_id='$idr'";			$query = $connect->query($sql);			$validator['success'] = true;			$validator['messages'] = "Tarif SPP Berhasil diubah";		}else{
			$sql = "INSERT INTO tarif_spp(peserta_didik_id,tarif) VALUES('$idr','$tarif')";
			$query = $connect->query($sql);
			$validator['success'] = true;
			$validator['messages'] = "Tarif berhasil ditambah";			}			
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}