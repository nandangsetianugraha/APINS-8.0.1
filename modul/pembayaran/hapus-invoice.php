<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$idinv=$_GET['idinv'];
	if(empty($idinv)){
		$validator['success'] = false;
		$validator['messages'] = "Error tuh";
	}else{
		$noinv = $connect->query("SELECT * FROM invoice WHERE id = '$idinv'")->fetch_assoc();
		$nomor=$noinv['nomor'];
		$sql1 = "DELETE FROM invoice WHERE id='$idinv'";
		$query1 = $connect->query($sql1);
		$sql2 = "DELETE FROM pembayaran WHERE id_invoice='$nomor'";
		$query2 = $connect->query($sql2);
		if($query1 === TRUE) {			
			$validator['success'] = true;
			$validator['messages'] = "OK!";		
		} else {		
			$validator['success'] = false;
			$validator['messages'] = "Kok Error ya???";
		};
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}