<?php 

require_once '../../function/db_connect.php';
$output = array('data' => array());
$sql = "SELECT * FROM printer";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$status=$row['status'];
	$ids = $row['id_printer'];
	if($status=='0'){
		$actionButton='
		<button class="btn btn-icon btn-sm btn-primary" data-ids="'.$ids.'" id="getAktif"><i class="fas fa-lock"></i></button>
		<a href="pengaturan-printer?edit='.$ids.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
		';
	}else{
		$actionButton='
		<button class="btn btn-icon btn-sm btn-success"><i class="fas fa-check"></i></button>
		<a href="pengaturan-printer?edit='.$ids.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
		';
	};
	$output['data'][] = array(
		$row['nama'],
		$row['spp'],
		$row['tabungan'],
		$row['kwitansi'],
		$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);