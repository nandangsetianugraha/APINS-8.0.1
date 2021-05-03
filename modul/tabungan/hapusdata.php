<?php 

require_once '../../inc/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$output = array('success' => false, 'messages' => array());

$memberId = $_POST['member_id'];
$sqlp = "SELECT * FROM tabungan WHERE id = '$memberId'";
	$queryp = $connect->query($sqlp);
	$rs = $queryp->fetch_assoc();
	$idN=$rs['nasabah_id'];
	$nnas=$connect->query("select * from nasabah where nasabah_id='$idN'")->fetch_assoc();
	$nama=$nnas['nama'];
$sql = "DELETE FROM tabungan WHERE id = {$memberId}";
$query = $connect->query($sql);
if($query === TRUE) {
	$cekmasuk=$connect->query("select sum(masuk) as setoran from tabungan where nasabah_id='$idN'")->fetch_assoc();
	$cekkeluar=$connect->query("select sum(keluar) as penarikan from tabungan where nasabah_id='$idN'")->fetch_assoc();
	$saldo=$cekmasuk['setoran']-$cekkeluar['penarikan'];
	$output['success'] = true;
	$output['messages'] = "Data Transaksi Tabungan berhasil dihapus!!";
	$output['idN']=$idN;
	$output['nama']=$nama;
	$output['saldo']=rupiah($saldo);
} else {
	$output['success'] = false;
	$output['messages'] = 'Error saat menghapus Data Transaksi';
}

// close database connection
$connect->close();

echo json_encode($output);