<?php 

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$ids=$_GET['ids'];
	$rs = $connect->query("SELECT * FROM tabungan WHERE id = '$ids'")->fetch_assoc();
	$idN=$rs['nasabah_id'];
	$nnas=$connect->query("select * from nasabah where nasabah_id='$idN'")->fetch_assoc();
	$idp=$nnas['user_id'];
	$status=$nnas['jenis'];
	if($status==1){
		$namanasabah=$connect->query("select * from siswa where peserta_didik_id='$idp'")->fetch_assoc();
		$nama=$namanasabah['nama'];
	}else{
		$nama=$nnas['nama'];
	};
	
	if(empty($ids)){
		$validator['success'] = false;
		$validator['messages'] = "Error tuh";
	}else{
			$sql1 = "DELETE FROM tabungan WHERE id='$ids'";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {		
				$cekmasuk=$connect->query("select sum(masuk) as setoran from tabungan where nasabah_id='$idN'")->fetch_assoc();
				$cekkeluar=$connect->query("select sum(keluar) as penarikan from tabungan where nasabah_id='$idN'")->fetch_assoc();
				$saldo=$cekmasuk['setoran']-$cekkeluar['penarikan'];
				$validator['success'] = true;
				$validator['messages'] = "OK!";	
				$validator['idN']=$idN;
				$validator['nama']=$nama;
				$validator['saldo']=rupiah($saldo);				
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}