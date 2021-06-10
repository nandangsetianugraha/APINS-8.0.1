<?php 
include "template/db_connect.php"; 
$idku=$_SESSION['peserta_didik_id'];
$siswa = $connect->query("select * from siswa where peserta_didik_id='$idku'")->fetch_assoc();
$nasabah = $connect->query("select * from nasabah where user_id='$idku'")->fetch_assoc();
$idnasabah = $nasabah['nasabah_id'];
$kelas = $connect->query("select * from penempatan where peserta_didik_id='$idku' and tapel='$tapel_aktif'")->fetch_assoc();
$setor = $connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE nasabah_id = '$idnasabah'")->fetch_assoc();
$ambil = $connect->query("SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id = '$idnasabah'")->fetch_assoc();
$saldo=$setor['setoran']-$ambil['penarikan'];
if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/siswa/".$siswa['avatar'])){
	$avatar=$siswa['avatar'];
}else{
	$avatar="user-default.png";
};
?>
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="description" content="Oban">
<meta name="keywords" content="HTML,CSS,JavaScript">
<meta name="author" content="HiBootstrap">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title><?=$data['title'];?> | SD Islam Al-Jannah</title>
<link rel="icon" href="assets/images/favicon.png" type="image/png" sizes="16x16">

<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="assets/css/animate.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="assets/css/owl.carousel.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="assets/css/owl.theme.default.min.css" type="text/css" media="all" />

<link rel='stylesheet' href='assets/css/icofont.min.css' type="text/css" media="all" />

<link rel='stylesheet' href='assets/css/flaticon.css' type="text/css" media="all" />

<link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all" />

<link rel="stylesheet" href="assets/css/responsive.css" type="text/css" media="all" />
<!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>