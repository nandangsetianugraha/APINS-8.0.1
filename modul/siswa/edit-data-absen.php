<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_POST['id'];
	$sakit=$connect->real_escape_string($_POST['sakit']);
	$ijin=$connect->real_escape_string($_POST['ijin']);
	$alfa=$connect->real_escape_string($_POST['alfa']);
	if(empty($id)){
		$validator['success'] = false;
		$validator['messages'] = "Keterangan tidak boleh kosong";
	}else{
		
			$sql1 = "UPDATE data_absensi SET sakit='$sakit', ijin='$ijin', alfa='$alfa' WHERE id='$id'";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Data Absen berhasil diubah!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}