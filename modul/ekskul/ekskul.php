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
	$sql1 = "SELECT * FROM data_ekskul WHERE peserta_didik_id='$idp' and smt='$smt' and tapel='$tapel' order by id_ekskul asc";
	$query1 = $connect->query($sql1);
	$namapeta="<div class='buttons'>";
	while($pn = $query1->fetch_assoc()){
		$nm=$pn['id_ekskul'];
		$nme = $connect->query("SELECT * FROM ekskul WHERE id_ekskul='$nm'")->fetch_assoc();
		$halo=$nme['nama_ekskul'];
		$namapeta.='
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#removeEkskulModal" onclick="removeEkskul(\''.$pn['id'].'\')">
            '.$halo.' <span class="badge badge-transparent">'.$pn['keterangan'].'</span>
        </button>
		';
	};
	$namapeta.='</div>';
	$tombol = '
		<div class="btn-group">
		<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mod-ekskul" data-kelas="'.$kelas.'" data-tapel="'.$tapel.'" data-smt="'.$smt.'" data-pdid="'.$idp.'" id="getEkskul"><i class="fa fa-plus-circle"></i></a>
		</div>';
	
	//$namasis=$pn['nama'];
	$output['data'][] = array(
		$tombol.' '.$row['nama'],
		$namapeta
	);
}

// database connection close
$connect->close();

echo json_encode($output);