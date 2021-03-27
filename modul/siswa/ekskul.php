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
$sql = "select * from ekskul ORDER BY id_ekskul ASC";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idek=$row['id_ekskul'];
	//Smt 1
	$sqlp13 = "SELECT * FROM data_ekskul WHERE peserta_didik_id='$ids' and smt='1' and tapel='$tapel' and id_ekskul='$idek'";
	$pn13 = $connect->query($sqlp13)->fetch_assoc();
	//Smt 2
	$sqlp14 = "SELECT * FROM data_ekskul WHERE peserta_didik_id='$ids' and smt='2' and tapel='$tapel' and id_ekskul='$idek'";
	$pn14 = $connect->query($sqlp14)->fetch_assoc();
	$output['data'][] = array(
		$row['id_ekskul'],
		$row['nama_ekskul'],
		$pn13['keterangan'],
		$pn14['keterangan']
	);
}
// database connection close
$connect->close();

echo json_encode($output);