<?php 
require_once '../../function/db_connect.php';
function TanggalIndo($tanggal)
{
	$bulan = array ('Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1]-1 ] . ' ' . $split[0];
};

$output = array('data' => array());
$sql = "select * from id_pegawai order by pegawai_id asc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idn=$row['ptk_id'];
	$idp=$row['id'];
	$pegid=$connect->query("select * from ptk where ptk_id='$idn'")->fetch_assoc();
	$actionButton = '
		<button class="btn btn-effect-ripple btn-xs btn-danger" type="button" data-toggle="modal" data-target="#hapusData" onclick="outMember('.$idp.')"><i class="fa fa-trash"></i></button>
		';	
	$output['data'][] = array(
		$row['pegawai_id'],
		$pegid['nama'],
		$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);