<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$ids=$_GET['ids'];
	if(empty($ids)){
		$validator['success'] = false;
		$validator['messages'] = "Error tuh";
	}else{
			$sql1 = "DELETE FROM pembayaran_temp WHERE id_bayar='$ids'";
			$query1 = $connect->query($sql1);
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