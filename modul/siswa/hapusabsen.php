<?php 

require_once '../../function/db_connect.php';

$output = array('success' => false, 'messages' => array());

$memberId = $_POST['member_id'];
$sql = "DELETE from absensi where id_absen= {$memberId}";
$query = $connect->query($sql);
if($query === TRUE) {
	$output['success'] = true;
	$output['messages'] = 'Absensi Berhasil dihapus';
} else {
	$output['success'] = false;
	$output['messages'] = 'Error Bro';
}

// close database connection
$connect->close();

echo json_encode($output);