<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_POST['idsiswa'];
	$jenis=$_POST['jenis'];
	$bayar=$_POST['tarif'];
	$tapel=$_POST['tapel'];
	if(empty($bayar)){
		$validator['success'] = false;
		$validator['messages'] = "Gak Bayar dong!";
	}else{
			$sql = "SELECT * FROM siswa WHERE peserta_didik_id = '$id'";
			$query = $connect->query($sql);
			$result = $query->fetch_assoc();
			$ada = $connect->query("select * from pembayaran_temp where peserta_didik_id='$id' and jenis='$jenis'")->num_rows;
			if($ada>0){
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			}else{
				$namajenis = $connect->query("select * from jenis_tunggakan where id_tunggakan='$jenis'")->fetch_assoc();
				$penjelasan='Pembayaran '.$namajenis['nama_tunggakan'].' Tahun '.$tapel;
				$sql1 = "INSERT INTO pembayaran_temp(peserta_didik_id,jenis,deskripsi,bayar) VALUES('$id','$jenis','$penjelasan','$bayar')";
				$query1 = $connect->query($sql1);
				if($query1 === TRUE) {			
					$validator['success'] = true;
					$validator['messages'] = "OK!";		
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