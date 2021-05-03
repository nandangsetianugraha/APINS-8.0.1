<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$siswa=$_GET['siswa'];
$tapel=$_GET['tapel'];
$output = array('data' => array());
$sql = "select * from invoice where peserta_didik_id='$siswa' and tapel='$tapel' order by nomor desc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$idin=$s['id'];
	$nomor=$s['nomor'];
	$status = '
	<button class="btn btn-sm btn-icon btn-danger" data-idinv="'.$idin.'" id="hapusinv"><i class="fas fa-trash"></i></button>
	<button class="btn btn-sm btn-icon btn-primary" data-idinv="'.$idin.'" id="printinv"><i class="fas fa-print"></i></button>
	<a href="#lihatinvoice" class="btn btn-sm btn-primary btn-icon" data-toggle="modal" data-idinv="'.$nomor.'"><i class="fas fa-address-card"></i></a>
	';
	$output['data'][] = array(
		$s['nomor'],$s['tanggal'],rupiah($s['jumlah']),$status
	);
};

// database connection close
$connect->close();

echo json_encode($output);