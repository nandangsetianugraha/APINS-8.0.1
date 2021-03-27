<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array(), 'pdid'=>array(), 'tapel'=>array());
	$pdid=$_GET['pdid'];
	$tapel=$_GET['tapel'];
	if(empty($pdid)){
		$validator['success'] = false;
		$validator['messages'] = "Pilih Siswa";
	}else{
		$sql = "SELECT * FROM siswa WHERE peserta_didik_id = '$pdid'";
		$query = $connect->query($sql);
		$result = $query->fetch_assoc();
		$nis=$result['nis'].'.png';
		if(file_exists("../qrcode/temp/".$nis)){
			$validator['success'] = true;
			$validator['messages'] = "Sukses";
			$validator['pdid'] = $pdid;
			$validator['tapel'] = $tapel;
		}else{
			$validator['success'] = false;
			$validator['messages'] = "Generate terlebih dahulu QRCode!!!";
		}
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}