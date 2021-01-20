<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$kelas=$_GET['kelas'];
$tapel=$_GET['tapel'];
$output = array('data' => array());
$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$idp=$s['peserta_didik_id'];
	$namasis=$connect->query("select * from siswa where peserta_didik_id='$idp'")->fetch_assoc();
	$tarifspp=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->fetch_assoc();
	$tarifnya=$tarifspp['tarif'];
	$spp=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->num_rows;
	if($spp>0){
		$status='
		<div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button class="btn btn-info btn-sm btn-icon" data-tapel="'.$tapel.'" data-pdid="'.$idp.'" data-jenis="1" data-bayar="'.$tarifnya.'" id="edittarif"><i class="far fa-edit"></i></button>
			<button class="btn btn-danger btn-sm btn-icon" data-idspp="'.$tarifspp['id'].'" id="hapustarif"><i class="fas fa-trash"></i></button>
        </div>';
	}else{
		$status= '
		<div class="btn-group mb-3" role="group" aria-label="Basic example">
            <button class="btn btn-info btn-sm btn-icon" data-tapel="'.$tapel.'" data-pdid="'.$idp.'" data-jenis="1" id="tambahtarif"><i class="fas fa-donate"></i></button>
        </div>';
	}
	$output['data'][] = array(
		$s['nama'],rupiah($tarifnya),$status
	);
};

	

// database connection close
$connect->close();

echo json_encode($output);