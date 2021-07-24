<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$idNasabah=$_POST['idNasabah'];
	$idsis=$_POST['idsis'];
	$qry = $connect->query("select * from ptk where ptk_id='$idsis'");
	$namasiswa=$qry->fetch_assoc();
	$namanya=$namasiswa['nama'];
	//$idnya=$namasiswa[''];
	if(empty($idNasabah) || empty($idsis)){
		$validator['success'] = false;
		$validator['messages'] = "Nasabah ID tidak boleh Kosong!";
	}else{
			$sql = "select * from nasabah where nasabah_id='$idNasabah'";
			$query = $connect->query($sql);
			$ada=$query->num_rows;
			if($ada>0){
				$validator['success'] = false;
				$validator['messages'] = "ID Nasabah sudah terdaftar!";
			}else{
				$sql1 = "select * from nasabah where nama='$namanya'";
				$query1 = $connect->query($sql1);
				$ada1=$query1->num_rows;
				if($ada1>0){
					$validator['success'] = false;
					$validator['messages'] = "Nama Guru sudah terdaftar!";
				}else{
					$query4 = $connect->query("select * from ptk where ptk_id='$idsis'");
					$nsis=$query4->fetch_assoc();
					$nama=$nsis['nama'];
					$sql2 = "INSERT INTO nasabah VALUES('','$idNasabah','$idsis','$nama','2')";				
					$query2 = $connect->query($sql2);
					$sql1 = "UPDATE ptk SET nasabah_id='$idNasabah' WHERE ptk_id='$idsis'";
					$query1 = $connect->query($sql1);
					$validator['success'] = true;
					$validator['messages'] = "Nasabah berhasil ditambahkan";
				}
			};	
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}