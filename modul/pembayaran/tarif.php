<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$kelas=$_GET['kelas'];
$tapel=$_GET['tapel'];
$jenis=$_GET['jenis'];
$output = array('data' => array());
$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$idp=$s['peserta_didik_id'];
	$namasis=$connect->query("select * from siswa where peserta_didik_id='$idp'")->fetch_assoc();
	if($jenis==1){
		$tarifspp=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->fetch_assoc();
		$tarifnya=$tarifspp['tarif'];
		$spp=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->num_rows;
	}else{
		$tarifspp=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idp' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
		$tarifnya=$tarifspp['tarif'];
		$spp=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idp' and tapel='$tapel' and jenis='$jenis'")->num_rows;
	}
	if($spp>0){
		$status='
		<div class="btn-group mb-3" role="group" aria-label="Basic example">
            <a href="#edittariflain" class="btn btn-info btn-sm btn-icon" data-toggle="modal" data-idspp="'.$tarifspp['id'].'" data-jenis="'.$jenis.'"><i class="far fa-edit"></i></a>
			<button class="btn btn-danger btn-sm btn-icon" data-idspp="'.$tarifspp['id'].'" data-jenis="'.$jenis.'" id="hapustarif"><i class="fas fa-trash"></i></button>
        </div>';
	}else{
		$status= '
		<div class="btn-group mb-3" role="group" aria-label="Basic example">
            <a href="#tambahtariflain" data-toggle="modal" class="btn btn-info btn-sm btn-icon" data-tapel="'.$tapel.'" data-idsiswa="'.$idp.'" data-jenis="'.$jenis.'"><i class="fas fa-donate"></i></a>
        </div>';
	}
	$output['data'][] = array(
		$s['nama'],rupiah($tarifnya),$status
	);
};

	

// database connection close
$connect->close();

echo json_encode($output);