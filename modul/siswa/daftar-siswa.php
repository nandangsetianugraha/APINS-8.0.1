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
$smt=$_GET['smt'];
$tapel=$_GET['tapel'];

	$sql = "select * from siswa where status='1' order by nama asc";
	$query = $connect->query($sql);
	while ($row = $query->fetch_assoc()) {
		$idp=$row['peserta_didik_id'];
		$nis=$row['nis'];
		$kelas = $connect->query("select * from penempatan where peserta_didik_id='$idp' and tapel='$tapel'")->fetch_assoc();
		if(file_exists("https://apins.sdi-aljannah.web.id/images/siswa/".$row['avatar'])){
			$avatarm=$row['avatar'];
		}else{
			$avatarm="user-default.png";
		};
		$actionButton = '
			<button class="btn btn-sm btn-danger" data-pdid="'.$idp.'" data-nis="'.$nis.'" id="getQR"><i class="fas fa-barcode"></i></button>
			<button class="btn btn-sm btn-danger" data-pdid="'.$idp.'" data-tapel="'.$tapel.'" id="getBlanko"><i class="fas fa-print"></i></button>
			';
		$tgl=ucfirst(strtolower($row['tempat'])).", ".TanggalIndo($row['tanggal']);
		$namasis=$row['nama'];
		$output['data'][] = array(
			"<img alt='image' src='https://apins.sdi-aljannah.web.id/images/siswa/".$avatarm."' class='rounded-circle' width='35' data-toggle='tooltip' title='".$row['nama']."'> ".$row['nama'],
			$row['nis'],
			$row['nisn'],
			$tgl,
			$kelas['rombel'],
			$actionButton
		);
	}
// database connection close
$connect->close();

echo json_encode($output);