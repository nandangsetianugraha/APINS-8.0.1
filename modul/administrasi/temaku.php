<?php 

require_once '../../function/db_connect.php';
$kelas=$_GET['kelas'];
$smt=$_GET['smt'];
$output = array('data' => array());

$sql = "select * from tema where kelas='$kelas' and smt='$smt' order by tema asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$ids=$s['id_tema'];
	$actionButton = '
	<a href="#editTema" class="btn btn-effect-ripple btn-xs btn-danger" type="button" id="'.$ids.'" data-toggle="modal" data-id="'.$ids.'"><i class="fa fa-edit"></i> Edit</a>
	<button class="btn btn-effect-ripple btn-xs btn-danger" data-toggle="modal" data-target="#removeTemaModal" onclick="removeTema('.$s['id_tema'].')"> <i class="fa fa-trash"></i> Hapus</button>
	';
	$output['data'][] = array(
		"Tema ".$s['tema'],
		$s['nama_tema'],
		$actionButton
	);
	
};

	

// database connection close
$connect->close();

echo json_encode($output);