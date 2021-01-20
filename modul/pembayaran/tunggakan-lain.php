<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$siswa=$_GET['siswa'];
$tapel=$_GET['tapel'];
$output = array('data' => array());
$idsis=$connect->query("select * from siswa where peserta_didik_id='$siswa'")->fetch_assoc();
$idn=$idsis['id'];
$sql = "select * from tunggakan_lain where peserta_didik_id='$siswa' and tapel='$tapel' order by jenis asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$ids=$s['jenis'];
	$idt=$s['id'];
	$namajenis=$connect->query("select * from jenis_tunggakan where id_tunggakan='$ids'")->fetch_assoc();
	$ceklunas=$connect->query("select sum(bayar) as sudah_bayar from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='$ids'")->fetch_assoc();
	if($ceklunas['sudah_bayar']==$s['tarif']){
		$status='<span class="badge badge-success">Lunas</span>';
	}else{
		$status = '
		<div class="btn-group mb-3" role="group" aria-label="Basic example">
            <a href="#edittarif" class="btn btn-info btn-sm btn-icon" id="'.$idt.'" data-toggle="modal" data-id="'.$idt.'"><i class="far fa-edit"></i></a>
			<button class="btn btn-danger btn-sm btn-icon" data-id="'.$idt.'" id="hapustarif"><i class="fas fa-trash"></i></button>
			<a href="#bayarlain" class="btn btn-primary btn-sm btn-icon" data-toggle="modal" data-tapel="'.$tapel.'" data-pdid="'.$siswa.'" data-jenis="'.$ids.'" data-bayar="'.$s['tarif'].'">Bayar</a>
        </div>';
	}
	$output['data'][] = array(
		$namajenis['nama_tunggakan'],rupiah($s['tarif']),rupiah($ceklunas['sudah_bayar']),$status
	);
};

	

// database connection close
$connect->close();

echo json_encode($output);