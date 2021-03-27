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
$status=$_GET['status'];
$output = array('data' => array());
$sql = "select * from ptk where status_keaktifan_id='$status'";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['ptk_id'];
	//$sqlp = "SELECT * FROM ptk WHERE ptk_id='$idp'";
	//$pn = $connect->query($sqlp)->fetch_assoc();
	$nama=$row['nama'];
	if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$row['gambar'])){
		$avatarm=$row['gambar'];
	}else{
		$avatarm="user-default.png";
	};
	$actionButton = '
		<a href="ptk?idptk='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
		<button data-target="#myModal" class="btn btn-info btn-icon btn-sm btn-sm" type="button" data-toggle="modal" data-id="'.$idp.'"><i class="fas fa-user-times"></i></button>
		';
	$output['data'][] = array(
		"<img alt='image' src='../images/ptk/".$avatarm."' class='rounded-circle' width='35' data-toggle='tooltip' title='".$row['nama']."'> ".$row['nama'],
		$row['tempat_lahir'].', '.TanggalIndo($row['tanggal_lahir']),
		$row['nik'],
		$row['niy_nigk'],
		$row['nuptk'],
		$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);