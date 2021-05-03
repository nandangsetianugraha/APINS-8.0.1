<?php 

require_once '../../inc/db_connect.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
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
$search=$_REQUEST['search'];
$output = array('data' => array());

$sql = "SELECT * FROM tabungan WHERE nasabah_id='".$search."' order by tanggal asc";
$query = $connect->query($sql);
$saldo=0;
$cek=$query->num_rows;
if($cek>0){
	$sql = "SELECT * FROM tabungan WHERE nasabah_id='".$search."' order by tanggal asc";
	$query = $connect->query($sql);
	while ($row = $query->fetch_assoc()) {
		$saldo=$saldo+$row['masuk']-$row['keluar'];
		$output['data'][] = array(
			$row['tanggal'],
			rupiah($row['masuk']),
			rupiah($row['keluar']),
			rupiah($saldo)
		);
	}
};

// database connection close
$connect->close();

echo json_encode($output);