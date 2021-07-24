<?php 

require_once '../../function/db_connect.php';

$output = array('success' => false, 'messages' => array());
$memberId = $_POST['member_id'];
$sqlp = "SELECT * FROM nasabah WHERE id = '$memberId'";
$queryp = $connect->query($sqlp);
$rs = $queryp->fetch_assoc();
$nama=$rs['nama'];
$idN=$rs['nasabah_id'];
$jenis=$rs['jenis'];
//hapus Nasabah
$sql = "DELETE FROM nasabah WHERE id = {$memberId}";
$query = $connect->query($sql);
//Hapus data tabungan
$sql1 = "DELETE FROM tabungan WHERE nasabah_id = {$idN}";
$query1 = $connect->query($sql1);
if($query === TRUE) {
	$output['success'] = true;
	$output['messages'] = $nama." Berhasil dihapus ";
} else {
	$output['success'] = false;
	$output['messages'] = 'Error saat mencoba mengeluarkan data nasabah';
}

// close database connection
$connect->close();

echo json_encode($output);