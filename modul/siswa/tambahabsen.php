<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$kelas=$_POST['kelas'];
	$tanggal=$_POST['tanggals'];
	$pdid=$_POST['pdid'];
	$absensi=$_POST['jnabsen'];
	if(empty($kelas) || empty($tanggal) || empty($pdid) || empty($absensi)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
		$sql = "select * from absensi where tanggal='$tanggal' and peserta_didik_id='$pdid'";
		$query = $connect->query($sql);
		$cks = $query->fetch_assoc();
		$ada=$query->num_rows;
		if($ada>0){
			$validator['success'] = false;
			$validator['messages'] = "Tanggal $tanggal : Siswa Sudah diabsen!";
		}else{
			$sql1 = "insert into absensi values('','$tanggal','$pdid','$absensi')";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Absensi Berhasil";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Error Bro";
			};
		};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}