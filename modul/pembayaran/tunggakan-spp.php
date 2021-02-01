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
$sql = "select * from bulan_spp order by id_bulan asc";
$query = $connect->query($sql);
$hapus = "DELETE FROM pembayaran_temp WHERE peserta_didik_id='$siswa'";
$hapus1 = $connect->query($hapus);
$status=array();
while($s=$query->fetch_assoc()) {
	$ids=$s['id_bulan'];
	$namabulan=$connect->query("select * from bulan_spp where id_bulan='$ids'")->fetch_assoc();
	$cekspp=$connect->query("select * from tarif_spp where peserta_didik_id='$siswa'")->num_rows;
	$tarifspp=$connect->query("select * from tarif_spp where peserta_didik_id='$siswa'")->fetch_assoc();
	$tarifnya=$tarifspp['tarif'];
	$spp=$connect->query("select * from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='1' and bulan='$ids'")->num_rows;
	if($spp>0){
		$tglspp=$connect->query("select * from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='1' and bulan='$ids'")->fetch_assoc();
		$status[$ids]='<button class="btn btn-sm btn-icon icon-left btn-success" data-idspp="'.$tglspp['id_bayar'].'" id="getKartu"><span class="badge badge-success">'.$namabulan['bulan'].'<br/>'.$tglspp['tanggal'].'</span><i class="fas fa-print"></i></button>';
	}else{
		if($cekspp>0){
			$ceklagi=$connect->query("select * from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='6'")->fetch_assoc();
			$biayapsb=$ceklagi['bayar'];
			if($biayapsb>300000 and $ids==1){
				$status[$ids] ='<span class="badge badge-info">NULL</span>';
			}else{
				$status[$ids] = '
			<button class="btn btn-danger" data-tapel="'.$tapel.'" data-pdid="'.$siswa.'" data-jenis="1" data-bulan="'.$ids.'" data-bayar="'.$tarifnya.'" id="getBayar">'.$namabulan['bulan'].'<br/>'.rupiah($tarifnya).'</button>';
			};
		}else{
			$status[$ids] = '<span class="badge badge-info">NULL</span>';
		};
	}
	
};
$output['data'][] = array(
		$status[1],$status[2],$status[3],$status[4]
	);
$output['data'][] = array(
		$status[5],$status[6],$status[7],$status[8]
	);
$output['data'][] = array(
		$status[9],$status[10],$status[11],$status[12]
	);


// database connection close
$connect->close();
echo json_encode($output);