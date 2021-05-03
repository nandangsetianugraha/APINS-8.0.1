<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$siswa=$_GET['siswa'];
$tanggal=$_GET['tanggal'];
$output = array('data' => array());
$idsis=$connect->query("select * from siswa where peserta_didik_id='$siswa'")->fetch_assoc();
$idn=$idsis['id'];
$sql = "select * from pembayaran_temp where peserta_didik_id='$siswa'";
$query = $connect->query($sql);
$bayarnya=0;
while($s=$query->fetch_assoc()) {
	$ids=$s['id_bayar'];
	$tombol='<button class="btn btn-sm btn-icon btn-danger" data-ids="'.$ids.'" id="gethapus"><i class="fas fa-trash"></i></button>';
	$bayarnya=$bayarnya+$s['bayar'];
	$output['data'][] = array(
		$s['deskripsi'],rupiah($s['bayar']),$tombol
	);
};
$output['data'][] = array(
		'Jumlah',rupiah($bayarnya),''
	);

	

// database connection close
$connect->close();

echo json_encode($output);