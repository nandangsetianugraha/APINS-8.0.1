<?php 

require_once '../../function/db_connect.php';

$output = array('success' => false, 'messages' => array());

$memberId = $_POST['member_id'];
$sql = "DELETE from data_ekskul where id= {$memberId}";
$query = $connect->query($sql);
if($query === TRUE) {
	$output['success'] = true;
	$output['messages'] = 'Kegiatan Ekstrakurikuler Berhasil dihapus';
} else {
	$output['success'] = false;
	$output['messages'] = 'Error saat mencoba menghapus Ekskul';
}

// close database connection
$connect->close();

echo json_encode($output);