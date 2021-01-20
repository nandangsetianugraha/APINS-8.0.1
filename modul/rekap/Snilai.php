<?php 

require_once '../../function/db_connect.php';
$kelas=$_GET['kelas'];
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$ab=substr($kelas, 0, 1);
$output = array('data' => array());

$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$idpd=$s['peserta_didik_id'];
	$sql2 = "select * from siswa where peserta_didik_id='$idpd'";
	$query2 = $connect->query($sql2);
	$j=$query2->fetch_assoc();
	$actionButton = '
		<div class="btn-group">
		<a href="../cetak/cetakRekap.php?idp='.$idpd.'&kelas='.$kelas.'&tapel='.$tapel.'&smt='.$smt.'&mp=2" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-print"></i> Cetak</a>
		</div>';
	$output['data'][] = array(
		$j['nama'],
		$actionButton
		);
		
	
};

	

// database connection close
$connect->close();

echo json_encode($output);