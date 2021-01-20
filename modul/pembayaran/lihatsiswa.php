<?php 

require_once '../../function/db_connect.php';

$memberId = $_POST['member_id'];
$output = array('data' => array());
$sql = "SELECT * FROM siswa WHERE id = '$memberId'";
$query = $connect->query($sql);
$result = $query->fetch_assoc();
$output['data'][] = array(		$result['nama'],$result['nis']	);
$connect->close();

echo json_encode($output);

