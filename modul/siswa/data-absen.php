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
	$sqlp = "SELECT * FROM data_absensi WHERE peserta_didik_id='$idp' and smt='$smt' and tapel='$tapel'";
	$ada = $connect->query($sqlp)->num_rows;
	if($ada>0){
		$pn = $connect->query($sqlp)->fetch_assoc();
		$sakit=$pn['sakit'];
		$ijin=$pn['ijin'];
		$alfa=$pn['alfa'];
		$idabsen=$pn['id'];
		$aksi='
		<a href="#editabsen" class="btn btn-effect-ripple btn-xs btn-danger" type="button" id="'.$idabsen.'" data-toggle="modal" data-id="'.$idabsen.'"><i class="fa fa-edit"></i> Edit</a>
		';
	}else{
		$sakit="";
		$ijin="";
		$alfa="";
		$aksi='
		<a href="#syncabsen" class="btn btn-effect-ripple btn-xs btn-danger" type="button" id="'.$idp.'" data-toggle="modal" data-id="'.$idp.'" data-tapel="'.$tapel.'" data-smt="'.$smt.'"><i class="fa fa-sync"></i> Ambil Data</a>
		';
	};
	//$namasis=$pn['nama'];
	$output['data'][] = array(
		$row['nama'],
		$sakit,
		$ijin,
		$alfa,
		$aksi
	);
}

// database connection close
$connect->close();

echo json_encode($output);