<?php 
require_once '../../inc/db_connect.php';
function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
};
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

$sql="select * from tabungan group by tanggal order by tanggal desc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$nowtgl=$s['tanggal'];
	$sql1 = "SELECT sum(IF(kode='1',masuk,0)) as setoran, sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan where tanggal='$nowtgl'";
	$nh = $connect->query($sql1);
	$m=$nh->fetch_assoc();
	$output['data'][] = array(
		TanggalIndo($s['tanggal']),
		rupiah($m['setoran']),
		rupiah($m['penarikan'])
	);
	
};

	

// database connection close
$connect->close();

echo json_encode($output);