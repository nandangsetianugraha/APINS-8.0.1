<?php 

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$tgl=$_GET['tglbro'];
	$jns=$_GET['jenis'];
	$nasabah=$_GET['idNasabah'];
	$setor=$_GET['pagu'];
	$setab=explode(".",$setor);
	$okjon=implode($setab);
	//
	//$tanggal=substr($_GET['tglbro'], 6, 4)."-".substr($_GET['tglbro'], 0, 2)."-".substr($_GET['tglbro'], 3, 2);
	if(empty($tgl) || empty($jns) || empty($nasabah) || empty($setor)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
		
		if($jns==1){
			$sql1 = "insert into tabungan(tanggal,kode,nasabah_id,masuk,keluar) values('$tgl','$jns','$nasabah','$okjon','')";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$cekmasuk=$connect->query("select sum(masuk) as setoran from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
				$cekkeluar=$connect->query("select sum(keluar) as penarikan from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
				$cekid=$connect->query("select * from tabungan where nasabah_id='$nasabah' order by id desc limit 1")->fetch_assoc();
				$saldo=$cekmasuk['setoran']-$cekkeluar['penarikan'];
				$validator['success'] = true;
				$validator['messages'] = "Tambah Setoran Berhasil";	
				$validator['idN'] = $nasabah;	
				$validator['idtrans'] = $cekid['id'];
				$validator['saldo'] = rupiah($saldo);				
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Error Bro";
			};
		}else{
			$cekmasuk=$connect->query("select sum(masuk) as setoran from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
			$cekkeluar=$connect->query("select sum(keluar) as penarikan from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
			$saldo=$cekmasuk['setoran']-$cekkeluar['penarikan'];
			if($okjon>$saldo){
				$validator['success'] = false;
				$validator['messages'] = "Saldonya Kurang dari Penarikan!!";
			}else{
				$sql1 = "insert into tabungan(tanggal,kode,nasabah_id,masuk,keluar) values('$tgl','$jns','$nasabah','','$okjon')";
				$query1 = $connect->query($sql1);
				if($query1 === TRUE) {	
					$cekmasuk=$connect->query("select sum(masuk) as setoran from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
					$cekkeluar=$connect->query("select sum(keluar) as penarikan from tabungan where nasabah_id='$nasabah'")->fetch_assoc();
					$cekid=$connect->query("select * from tabungan where nasabah_id='$nasabah' order by id desc limit 1")->fetch_assoc();
					$saldo=$cekmasuk['setoran']-$cekkeluar['penarikan'];
					$validator['success'] = true;
					$validator['messages'] = "Tambah Pengambilan Berhasil";	
					$validator['idN'] = $nasabah;
					$validator['idtrans'] = $cekid['id'];
					$validator['saldo'] = rupiah($saldo);
				} else {		
					$validator['success'] = false;
					$validator['messages'] = "Error Bro";
				};
			}
			
		};
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}