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
if($kelas==0){
	$sql = "select * from siswa where status='1' order by nama asc";
	$query = $connect->query($sql);
	while ($row = $query->fetch_assoc()) {
		$idp=$row['peserta_didik_id'];
		if(file_exists($_SERVER{'DOCUMENT_ROOT'} . "/images/siswa/".$row['avatar'])){
			$avatarm=$row['avatar'];
		}else{
			$avatarm="user-default.png";
		};
		$actionButton = '
			<a href="siswa?idsiswa='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
			<a href="raport?idsiswa='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="far fa-address-book"></i></a>
			<button class="btn btn-info btn-border btn-round btn-sm" type="button" data-toggle="modal" data-target="#outMemberModal" onclick="outMember('.$row['id_rombel'].')"><i class="fa fa-trash"></i> Out</button>
			';
		$tgl=ucfirst(strtolower($row['tempat'])).", ".TanggalIndo($row['tanggal']);
		$namasis=$row['nama'];
		$output['data'][] = array(
			"<img alt='image' src='https://apins.sdi-aljannah.web.id/images/siswa/".$avatarm."' class='rounded-circle' width='35' data-toggle='tooltip' title='".$row['nama']."'> ".$row['nama'],
			$row['nis'],
			$row['nisn'],
			$tgl,
			$row['jk'],
			$actionButton
		);
	}
}else{
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
		if(file_exists($_SERVER{'DOCUMENT_ROOT'} . "/images/siswa/".$pn['avatar'])){
			$avatarm=$pn['avatar'];
		}else{
			$avatarm="user-default.png";
		};
		$actionButton = '
			<a href="siswa?idsiswa='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="fas fa-edit"></i></a>
			<a href="raport?idsiswa='.$idp.'" class="btn btn-icon btn-sm btn-warning"><i class="far fa-address-book"></i></a>
			';
		$tgl=ucfirst(strtolower($pn['tempat'])).", ".TanggalIndo($pn['tanggal']);
		$namasis=$pn['nama'];
		$output['data'][] = array(
			"<img alt='image' src='https://apins.sdi-aljannah.web.id/images/siswa/".$avatarm."' class='rounded-circle' width='35' data-toggle='tooltip' title='".$pn['nama']."'> ".$pn['nama'],
			$pn['nis'],
			$pn['nisn'],
			$tgl,
			$pn['jk'],
			$actionButton
		);
	}
}
// database connection close
$connect->close();

echo json_encode($output);