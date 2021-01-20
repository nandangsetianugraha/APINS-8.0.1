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
$kelas=$_GET['kelas'];
$smt=$_GET['smt'];
$tapel=$_GET['tapel'];
$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['peserta_didik_id'];
	$sqlp = "SELECT * FROM siswa WHERE peserta_didik_id='$idp'";
	$pn = $connect->query($sqlp)->fetch_assoc();
	$nisn=$pn['nisn'];
	$jk=$pn['jk'];
	$ids=$pn['id'];
	$rmb=$row['rombel'];
	$tgl=$pn['tempat'].", ".TanggalIndo($pn['tanggal']);
	$namasis=$pn['nama'];
	$output['data'][] = array(
		$pn['nama'],
		$pn['nis'],
		$pn['nisn']
	);
}

// database connection close
$connect->close();

echo json_encode($output);