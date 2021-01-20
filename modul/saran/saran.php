<?php 
require_once '../../function/db_connect.php';
$output = array('data' => array());
$kelas=$_GET['kelas'];
$smt=$_GET['smt'];
$tapel=$_GET['tapel'];
$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['peserta_didik_id'];
	$sql1 = "SELECT * FROM saran WHERE peserta_didik_id='$idp' and smt='$smt' and tapel='$tapel'";
	$query1 = $connect->query($sql1);
	$cek = $query1->num_rows;
	if($cek>0){
		$pn = $query1->fetch_assoc();
		$saranmu=$pn['saran'];
	}else{
		$saranmu="";
	};
	if($cek>0){
	$tombol='';
	$actionButton = '
		<button class="btn btn-icon btn-link btn-xs" type="button" data-toggle="modal" data-target="#removeSaranModal" onclick="removeSaran(\''.$pn['id'].'\')"><i class="fa fa-trash"></i></button>
		';
	}else{
		$actionButton='';
		$tombol = '
		<div class="btn-group">
		<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mod-saran" data-kelas="'.$kelas.'" data-tapel="'.$tapel.'" data-smt="'.$smt.'" data-pdid="'.$idp.'" id="getEkskul"><i class="fa fa-plus-circle"></i></a>
		</div>';
	};
	
	
	//$namasis=$pn['nama'];
	$output['data'][] = array(
		$tombol.' '.$row['nama'],
		$saranmu.$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);