<?php require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {		$validator = array('success' => false, 'messages' => array());
	$idptk=$_POST['idptk'];
	//$idp=$_POST['idp'];
	$status=$_POST['status'];
	$sql = "select * from ptk where ptk_id='$idptk'";
		$query = $connect->query($sql);
		$cks = $query->fetch_assoc();
		$ada=$query->num_rows;
		if($ada>0){
			$sql1 = "UPDATE ptk SET status_keaktifan_id='$status' WHERE ptk_id='$idptk'";
			$query1 = $connect->query($sql1);			$sql2 = "UPDATE pengguna SET verified='0' WHERE ptk_id='$idptk'";			$query2 = $connect->query($sql2);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Status ".$cks['nama']." Berhasil diubah!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Error while adding the member information";
			};
		}else{
			$validator['success'] = false;
			$validator['messages'] = "PTK tidak diketemukan";
		
		};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}