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
$tapel=$_GET['tapel'];
$ids=$_GET['ids'];
$sql = "select * from mapel ORDER BY id_mapel ASC";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idm=$row['id_mapel'];
	//KI3 Smt 1
	$sqlp13 = "SELECT * FROM raport_k13 WHERE id_pd='$ids' and smt='1' and tapel='$tapel' and mapel='$idm' and jns='k3'";
	$pn13 = $connect->query($sqlp13)->fetch_assoc();
	//KI3 Smt 2
	$sqlp23 = "SELECT * FROM raport_k13 WHERE id_pd='$ids' and smt='2' and tapel='$tapel' and mapel='$idm' and jns='k3'";
	$pn23 = $connect->query($sqlp23)->fetch_assoc();
	//KI4 Smt 1
	$sqlp14 = "SELECT * FROM raport_k13 WHERE id_pd='$ids' and smt='1' and tapel='$tapel' and mapel='$idm' and jns='k4'";
	$pn14 = $connect->query($sqlp14)->fetch_assoc();
	//KI4 Smt 2
	$sqlp24 = "SELECT * FROM raport_k13 WHERE id_pd='$ids' and smt='2' and tapel='$tapel' and mapel='$idm' and jns='k4'";
	$pn24 = $connect->query($sqlp24)->fetch_assoc();
	$output['data'][] = array(
		$row['id_mapel'],
		$row['nama_mapel'],
		$pn13['nilai'],
		$pn13['predikat'],
		$pn14['nilai'],
		$pn14['predikat'],
		$pn23['nilai'],
		$pn23['predikat'],
		$pn24['nilai'],
		$pn24['predikat']
	);
}

// database connection close
$connect->close();

echo json_encode($output);