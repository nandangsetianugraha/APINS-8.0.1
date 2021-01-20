<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$ids=$_POST['ids'];
	$username=strip_tags($connect->real_escape_string($_POST['username']));
	$password=strip_tags($connect->real_escape_string($_POST['password']));
	$newpw = password_hash($password, PASSWORD_DEFAULT);
	if(empty($username) || empty($password)){
		$validator['success'] = false;
		$validator['messages'] = "Username atau Password tidak boleh kosong";
	}else{
			$sql1 = "UPDATE pengguna SET username='$username', password='$newpw' WHERE ptk_id='$ids'";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Username atau Password berhasil diubah!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}