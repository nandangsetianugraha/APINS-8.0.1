<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_POST['idpd'];
	$smt=$_POST['smt'];
	$tapel=$_POST['tapel'];
	$ket=$connect->real_escape_string($_POST['keterangan']);
	if(empty($ket) || empty($id)){
		$validator['success'] = false;
		$validator['messages'] = "Keterangan tidak boleh kosong";
	}else{
		$cek=$connect->query("SELECT * FROM saran WHERE peserta_didik_id='$id' and smt='$smt' and tapel='$tapel'")->num_rows;
		if($cek>0){
			$validator['success'] = false;
			$validator['messages'] = "Saran sudah ada, silahkan hapus dulu baru tambahkan lagi";
		}else{
			$sql1 = "INSERT INTO saran(peserta_didik_id,smt,tapel,saran) VALUES('$id','$smt','$tapel','$ket')";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Saran berhasil ditambahkan!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		}
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}