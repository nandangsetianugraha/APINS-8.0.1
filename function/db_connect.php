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
