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
$sikap=array('Tinggi Badan','Berat Badan','Pendengaran','Penglihatan','Gigi','Lainnya');
$aspek=array('tinggi','berat','pendengaran','penglihatan','gigi','lainnya');
for ($x = 1; $x <= 6; $x++) {
	//Smt 1
	$sqlp13 = "SELECT * FROM data_kesehatan WHERE peserta_didik_id='$ids' and smt='1' and tapel='$tapel'";
	$pn13 = $connect->query($sqlp13)->fetch_assoc();
	//Smt 2
	$sqlp14 = "SELECT * FROM data_kesehatan WHERE peserta_didik_id='$ids' and smt='2' and tapel='$tapel'";
	$pn14 = $connect->query($sqlp14)->fetch_assoc();
	$output['data'][] = array(
		$x,
		$sikap[$x-1],
		$pn13[$aspek[$x-1]],
		$pn14[$aspek[$x-1]]
	);
};
// database connection close
$connect->close();

echo json_encode($output);