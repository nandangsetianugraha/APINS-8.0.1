<?php 

require_once '../../function/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0);
	return $hasil_rupiah;
 
}
function TanggalIndo($date){
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);
 
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;        
    return($result);
};
$hariini=$_REQUEST['tanggal_now'];
$output = array('data' => array());

$sql = "SELECT * FROM tabungan where tanggal='$hariini' order by id desc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['nasabah_id'];
	$nsb=$connect->query("select * from nasabah where nasabah_id='$idp'")->fetch_assoc();
	$ids=$nsb['user_id'];
	$idtab=$row['id'];
	$status=$nsb['jenis'];
	if($status==1){
		$namanasabah=$connect->query("select * from siswa where peserta_didik_id='$ids'")->fetch_assoc();
		$namanya=$namanasabah['nama'];
	}else{
		$namanya=$nsb['nama'];
	};
	$tombol='<button class="btn btn-danger" data-ids="'.$idtab.'" id="gethapus"><i class="fa fa-trash"></i></button>';
	$output['data'][] = array(
		$namanya,
		$row['kode'],
		rupiah($row['masuk']),
		rupiah($row['keluar']),
		$tombol
	);
};

// database connection close
$connect->close();

echo json_encode($output);