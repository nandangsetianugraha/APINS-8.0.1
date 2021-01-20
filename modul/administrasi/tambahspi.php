<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$kelas=$_POST['kelas'];
	$smt=$_POST['smt'];
	$tapel=$_POST['tapel'];
	$idp=$_POST['idsis'];
	$pengamatan=strip_tags($connect->real_escape_string($_POST['pengamatan']));
	$aspek=$_POST['aspek'];
	$nilai=$_POST['nilai'];
	if(empty($kelas) || empty($smt) || empty($tapel) || empty($idp) || empty($nilai) || empty($aspek)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
			$sql1 = "insert into nsp(id_pd, kelas, smt, tapel, perilaku, jns, nilai) values('$idp','$kelas','$smt','$tapel','$pengamatan','$aspek','$nilai')";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Nilai Spiritual berhasil dimasukkan";				
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Error while adding the member information";
			};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}