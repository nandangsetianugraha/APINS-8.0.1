<?php

include "../../function/db.php";
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$idNasabah = $_POST['idNasabah'];
//$password = $_POST['password'];
$query			= mysqli_fetch_array(mysqli_query($koneksi, 'SELECT * FROM nasabah WHERE nasabah_id = "'.$idNasabah.'"')); // Check the table 
if($idNasabah === $query['nasabah_id']){
	if($query['jenis']==1){
		$idp=$query['user_id'];
		$nama=mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE peserta_didik_id = '$idp'"));
		$pelanggan=$nama['nama'];
	}else{
		$pelanggan=$query['nama'];
	};
	$setor=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE nasabah_id = '$idNasabah'"));
	$ambil=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idNasabah'"));
	$saldo=$setor['setoran']-$ambil['penarikan'];
    $response = array("status"=>"ada_nasabah","IDnasabah"=>$query['nasabah_id'],"namaLengkap"=>$pelanggan,"saldo"=>rupiah($saldo));
}else{
    $response = array("status"=>"no_nasabah","saldo"=>"Rp. -");
};
echo json_encode($response);