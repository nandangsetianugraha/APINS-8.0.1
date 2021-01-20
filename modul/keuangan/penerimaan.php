<?php 

require_once '../../function/db_connect.php';
$output = array('data' => array());

$sql = "select * from jenis_tunggakan";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$ids=$s['id_tunggakan'];
	$actionButton = '
	<a href="#editTema" class="btn btn-effect-ripple btn-xs btn-danger" type="button" id="'.$ids.'" data-toggle="modal" data-id="'.$ids.'"><i class="fa fa-edit"></i> Edit</a>
	<button class="btn btn-effect-ripple btn-xs btn-danger" data-toggle="modal" data-target="#removeTemaModal" onclick="removeTema('.$ids.')"> <i class="fa fa-trash"></i> Hapus</button>
	';
	$output['data'][] = array(
		$ids,
		$s['nama_tunggakan'],
		$actionButton
	);
	
};

	

// database connection close
$connect->close();

echo json_encode($output);