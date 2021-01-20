<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_GET['pdid'];
	$jenis=$_GET['jenis'];
	$bulan=$_GET['bulan'];
	$bayar=$_GET['bayar'];
	$tapel=$_GET['tapel'];
	if(empty($bayar)){
		$validator['success'] = false;
		$validator['messages'] = "Gak Bayar dong!";
	}else{
			$sql = "SELECT * FROM siswa WHERE peserta_didik_id = '$id'";
			$query = $connect->query($sql);
			$result = $query->fetch_assoc();
			$ada = $connect->query("select * from pembayaran_temp where peserta_didik_id='$id' and jenis='$jenis' and bulan='$bulan'")->num_rows;
			if($ada>0){
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			}else{
				$namabulan = $connect->query("select * from bulan_spp where id_bulan='$bulan'")->fetch_assoc();
				$penjelasan='SPP Tahun '.$tapel.' ('.$namabulan['bulan'].')';
				$sql1 = "INSERT INTO pembayaran_temp(peserta_didik_id,jenis,bulan,deskripsi,bayar) VALUES('$id','$jenis','$bulan','$penjelasan','$bayar')";
				$query1 = $connect->query($sql1);
				if($query1 === TRUE) {			
					$validator['success'] = true;
					$validator['messages'] = "OK!";		
				} else {		
					$validator['success'] = false;
					$validator['messages'] = "Kok Error ya???";
				};
			};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}