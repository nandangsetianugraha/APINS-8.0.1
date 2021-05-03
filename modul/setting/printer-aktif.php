<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());	$idprinter=$_GET['ids'];	$sql = "UPDATE printer SET status='0'";	$query = $connect->query($sql);	$query1 = $connect->query("UPDATE printer SET status='1' where id_printer='$idprinter'");
	if($query1 === TRUE) {						$validator['success'] = true;			$validator['messages'] = "Printer berhasil diaktifkan!";				} else {					$validator['success'] = false;			$validator['messages'] = "Error while adding the member information";		};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}