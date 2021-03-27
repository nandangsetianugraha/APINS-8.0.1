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
$sikap=array('Sikap Spiritual','Sikap Sosial');
for ($x = 1; $x <= 2; $x++) {
	if($x===1){
		$jns='k1';
	}else{
		$jns='k2';
	};
	//Smt 1
	$sqlp13 = "SELECT * FROM deskripsi_k13 WHERE id_pd='$ids' and smt='1' and tapel='$tapel' and jns='$jns'";
	$pn13 = $connect->query($sqlp13)->fetch_assoc();
	//Smt 2
	$sqlp14 = "SELECT * FROM deskripsi_k13 WHERE id_pd='$ids' and smt='2' and tapel='$tapel' and jns='$jns'";
	$pn14 = $connect->query($sqlp14)->fetch_assoc();
	$output['data'][] = array(
		$sikap[$x-1],
		$pn13['deskripsi'],
		$pn14['deskripsi']
	);
}
// database connection close
$connect->close();

echo json_encode($output);