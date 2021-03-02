<?php 
	//session_start();
	include "../function/db.php";
	function TanggalIndo($tanggal)
	{
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
	function limit_words($string, $word_limit){
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
};
	if (!isset($_SESSION['username'])) {
	  header('Location: login');
	  exit();
	};
	$sql_tahun=mysqli_query($koneksi, "select * from konfigurasi");
	$cfg=mysqli_fetch_array($sql_tahun);
	$sekolah=$cfg['nama_sekolah'];
	$alamat=$cfg['alamat_sekolah'];
	$img_login=$cfg['image_login'];
	$maintenis=$cfg['maintenis'];
	
	$versi=$cfg['versi'];
	$idku=$_SESSION['userid'];
	$bioku = mysqli_fetch_array(mysqli_query($koneksi, "select * from ptk where ptk_id='$idku'"));
	$status=$bioku['status_kepegawaian_id'];
	$level=$bioku['jenis_ptk_id'];
	if($maintenis==1 and $level<>11){
		header('location:./maintenance');
		exit();
	};
	$tapel = $_SESSION['tapel'];
	$smt = $_SESSION['smt'];
	$jns_ptk = mysqli_fetch_array(mysqli_query($koneksi, "select * from jenis_ptk where jenis_ptk_id='$level'"));
	$status_ptk = mysqli_fetch_array(mysqli_query($koneksi, "select * from status_kepegawaian where status_kepegawaian_id='$status'"));
	if($level==96){
		$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and pai='$idku' order by nama_rombel asc");
		$nk=mysqli_fetch_array($sql_mk);
		$kelas=$nk['nama_rombel'];
	}elseif($level==95){
		$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and penjas='$idku' order by nama_rombel asc");
		$nk=mysqli_fetch_array($sql_mk);
		$kelas=$nk['nama_rombel'];
	}elseif($level==94){
		$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and inggris='$idku' order by nama_rombel asc");
		$nk=mysqli_fetch_array($sql_mk);
		$kelas=$nk['nama_rombel'];
	}elseif($level==97){
		$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and pendamping='$idku' order by nama_rombel asc");
		$nk=mysqli_fetch_array($sql_mk);
		$kelas=$nk['nama_rombel'];
	}elseif($level==98){
		$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and wali_kelas='$idku' order by nama_rombel asc");
		$nk=mysqli_fetch_array($sql_mk);
		$kelas=$nk['nama_rombel'];
	}else{
		$kelas="1A";
	};
	if($kelas==''){
		$norombel=true;
	}else{
		$norombel=false;
	};
	$ab=substr($kelas,0,1);
	if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$bioku['gambar'])){
		$avatar=$bioku['gambar'];
	}else{
		$avatar="user-default.png";
	};

	?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>APINS - <?=$data['title'];?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/app.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/pretty-checkbox/pretty-checkbox.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='<?= base_url(); ?>assets/img/fav.ico' />
