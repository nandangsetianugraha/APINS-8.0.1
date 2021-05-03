<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());	$namaprinter=$connect->real_escape_string($_POST['namaprinter']);	$spp=$connect->real_escape_string($_POST['kertasspp']);	$tabungan=$connect->real_escape_string($_POST['kertastabungan']);	$kwitansi=$connect->real_escape_string($_POST['kertaskwitansi']);	$sql = "INSERT INTO printer(nama,spp,tabungan,kwitansi,status) VALUES('$namaprinter','$spp','$tabungan','$kwitansi','0')";	$query = $connect->query($sql);
	if($query === TRUE) {						$validator['success'] = true;			$validator['messages'] = "Printer berhasil ditambahkan!";				} else {					$validator['success'] = false;			$validator['messages'] = "Error while adding the member information";		};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}