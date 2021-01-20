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
$sql = "select * from pengguna";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['ptk_id'];
	$sqlp = "SELECT * FROM ptk WHERE ptk_id='$idp'";
	$pn = $connect->query($sqlp)->fetch_assoc();
	$nama=$pn['nama'];
	$verval=$row['verified'];
	if($verval==1){
		$verval='Aktif';
	}else{
		$verval='Non Aktif';
	};
	if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$pn['gambar'])){
		$avatarm=$pn['gambar'];
	}else{
		$avatarm="user-default.png";
	};
	$actionButton = '
		<a href="pengguna?idsiswa='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
		';
	$output['data'][] = array(
		"<img alt='image' src='../images/ptk/".$avatarm."' class='rounded-circle' width='35' data-toggle='tooltip' title='".$pn['nama']."'> ".$row['username'],
		"*********",
		$nama,
		$row['level'],
		$verval,
		$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);