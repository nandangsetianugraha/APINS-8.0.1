<?php 

require_once '../../function/db_connect.php';

$output = array('success' => false, 'messages' => array());

$memberId = $_POST['member_id'];
$sqlp = "SELECT * FROM penempatan WHERE id_rombel = '$memberId'";
	$queryp = $connect->query($sqlp);
	$rs = $queryp->fetch_assoc();
	$nama=$rs['nama'];
	$kelas=$rs['rombel'];
$sql = "DELETE FROM penempatan WHERE id_rombel = {$memberId}";
$query = $connect->query($sql);
if($query === TRUE) {
	$output['success'] = true;
	$output['messages'] = $nama." Berhasil dikeluarkan dari Kelas ".$kelas;
} else {
	$output['success'] = false;
	$output['messages'] = 'Error saat mencoba mengeluarkan data siswa';
}

// close database connection
$connect->close();

echo json_encode($output);