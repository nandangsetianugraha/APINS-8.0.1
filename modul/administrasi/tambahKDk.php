<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$kelas=$_POST['kelask'];
	$mpid=$_POST['mapelk'];
	$kd=$_POST['kdk'];
	$peta=$_POST['aspekk'];
	$deskripsi=strip_tags($connect->real_escape_string($_POST['deskripsik']));
	if(empty($kelas) || empty($kd) || empty($deskripsi)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
		$sql = "select * from kd where kelas='$kelas' and aspek='$peta' and mapel='$mpid' and kd='$kd'";
		$query = $connect->query($sql);
		$cks = $query->fetch_assoc();
		$ada=$query->num_rows;
		if($ada>0){
			$validator['success'] = false;
			$validator['messages'] = "Kompetensi Dasar sudah ada, silahkan hapus terlebih dahulu!";
		}else{
			$sql1 = "insert into kd(kelas, aspek, mapel, kd, nama_kd) values('$kelas','$peta','$mpid','$kd','$deskripsi')";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Penambahan Kompetensi Dasar berhasil dilakukan";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Error while adding the member information";
			};
		};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}