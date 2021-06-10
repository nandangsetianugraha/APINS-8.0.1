<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apins8";

// create connection
$connect = new mysqli($servername, $username, $password, $dbname);

// check connection 
if($connect->connect_error) {
	die("Connection Failed : " . $connect->connect_error);
} else {
	// echo "Successfully Connected";
};
$sql = "select * from konfigurasi";
$cekconfig = $connect->query($sql);
$cfg=$cekconfig->fetch_assoc();
$tapel_aktif=$cfg['tapel'];
$smt_aktif=$cfg['semester'];

function TanggalIndo($tanggal) {
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
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
};
function limit_words($string, $word_limit){
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
};
function base_url($param = []) {

  $base_url = 'http://localhost:8080/oban/';
  $result = (!$param) ? $base_url : $base_url . $param;

  return $result;
};
