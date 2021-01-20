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
	$sqlp = "SELECT * FROM data_kesehatan WHERE peserta_didik_id='$idp' and smt='$smt' and tapel='$tapel'";
	$ada = $connect->query($sqlp)->num_rows;
	if($ada>0){
		$tombol = '
		<div class="btn-group">
		<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editKesehatan" data-kelas="'.$kelas.'" data-tapel="'.$tapel.'" data-smt="'.$smt.'" data-pdid="'.$idp.'" id="editKes"><i class="fa fa-edit"></i></a>
		</div>';
		$pn = $connect->query($sqlp)->fetch_assoc();
		$tng=$pn['tinggi'];
		$brt=$pn['berat'];
		$telinga=$pn['pendengaran'];
		$mata=$pn['penglihatan'];
		$gg=$pn['gigi'];
		$lain=$pn['lainnya'];
	}else{
		$tombol = '
		<div class="btn-group">
		<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mod-kesehatan" data-kelas="'.$kelas.'" data-tapel="'.$tapel.'" data-smt="'.$smt.'" data-pdid="'.$idp.'" id="getKes"><i class="fa fa-plus-circle"></i></a>
		</div>';
		$tng="";
		$brt="";
		$telinga="";
		$mata="";
		$gg="";
		$lain="";
	};
	
	//$namasis=$pn['nama'];
	$output['data'][] = array(
		$tombol.' '.$row['nama'],
		$tng,
		$brt,
		$telinga,
		$mata,
		$gg,
		$lain
	);
}

// database connection close
$connect->close();

echo json_encode($output);