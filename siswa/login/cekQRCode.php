<?php
session_start();
require_once '../template/db_connect.php';
if(isset($_POST['pdid'])){
	$idpd = $_POST['pdid'];
	$cek=$connect->query("select * from siswa where peserta_didik_id='$idpd'")->num_rows;
	if($cek>0){
		$siswa=$connect->query("select * from siswa where peserta_didik_id='$idpd'")->fetch_assoc();
		$_SESSION['peserta_didik_id']=$idpd;
		$_SESSION['namasiswa'] = $siswa['nama'];
		header("location:../");
	}else{
		header("location:./error.php");
	}
}else{
	header("location:./qrcode.php");
}