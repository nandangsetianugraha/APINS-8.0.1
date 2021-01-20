<?php 

require_once '../../function/db_connect.php';

$memberId = $_POST['member_id'];

$sql = "SELECT * FROM siswa WHERE id = '$memberId'";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

$connect->close();

echo json_encode($result);

