<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_GET) {	

	$validator = array('success' => false, 'messages' => array());
	$id=$_GET['siswa'];
	$tapel=$_GET['tapel'];
	$tanggal=$_GET['tanggal'];
	$nothn=substr($tanggal,0,4);
	$nobulan=substr($tanggal,5,2);
	$notanggal=substr($tanggal,8,2);
	$kodein=$nothn.$nobulan.$notanggal;
	$cektr = $connect->query("SELECT * FROM pembayaran_temp WHERE peserta_didik_id = '$id'")->num_rows;
	if(empty($tanggal) || $cektr==0){
		$validator['success'] = false;
		$validator['messages'] = "Isi Tanggal Bro";
	}else{
			$dibayar = $connect->query("SELECT sum(bayar) as bayarnya FROM pembayaran_temp WHERE peserta_didik_id = '$id'")->fetch_assoc();
			$telahbayar=$dibayar['bayarnya'];
			$noin = $connect->query("select * from invoice where tanggal='$tanggal'")->num_rows;
			if($noin>0){
				$nomax = $connect->query("select max(nomor) as besar from invoice where tanggal='$tanggal'")->fetch_assoc();
				$noinvmax=$nomax['besar'];
				$noinv=(int) substr($noinvmax,11,3) + 1;
			}else{
				$noinv=1;
			};
			if($noinv<10){
				$kode='SDI'.$kodein.'00'.$noinv;
			}elseif($noinv<100){
				$kode='SDI'.$kodein.'0'.$noinv;
			}else{
				$kode='SDI'.$kodein.$noinv;
			};
			$qinv = $connect->query("INSERT INTO invoice(nomor,tanggal,peserta_didik_id,tapel,jumlah) VALUES('$kode','$tanggal','$id','$tapel','$telahbayar')");
			$sql = "SELECT * FROM pembayaran_temp WHERE peserta_didik_id = '$id'";
			$query = $connect->query($sql);
			while($r = $query->fetch_assoc()){
				$idpd=$r['peserta_didik_id'];
				$jns=$r['jenis'];
				$bln=$r['bulan'];
				$desk=$r['deskripsi'];
				$byr=$r['bayar'];
				$qmove = $connect->query("INSERT INTO pembayaran(id_invoice,tanggal,peserta_didik_id,tapel,jenis,bulan,deskripsi,bayar) VALUES('$kode','$tanggal','$idpd','$tapel','$jns','$bln','$desk','$byr')");
				if($jns==1){
					$qhapusspp = $connect->query("DELETE FROM tunggakan_spp where peserta_didik_id='$idpd' and tapel='$tapel' and bulan='$bln'");
				};
			};
			$hapus1 = $connect->query("TRUNCATE TABLE pembayaran_temp");
			$info = $connect->query("select * from invoice where nomor='$kode'")->fetch_assoc();
			$idinv=$info['id'];
			$validator['success'] = true;
			$validator['messages'] = $idinv;					
			
		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}