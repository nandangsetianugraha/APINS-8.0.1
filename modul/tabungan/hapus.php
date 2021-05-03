<?php 

require_once '../../assets/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
$output = array('success' => false, 'messages' => array());

$memberId = $_POST['member_id'];
$sql = "DELETE FROM tabungan WHERE tanggal = '$memberId'";
$query = $connect->query($sql);
if($query === TRUE) {
	$output['success'] = true;
	$output['messages'] = "Data Transaksi Tabungan berhasil dihapus!!";
} else {
	$output['success'] = false;
	$output['messages'] = 'Error saat menghapus Data Transaksi';
}

// close database connection
$connect->close();

echo json_encode($output);