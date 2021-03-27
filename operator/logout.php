<?php
	include_once("../function/db.php");
    session_start();
	$aktiv='Keluar dari Sistem';
	$ptkid=$_SESSION['userid'];
	date_default_timezone_set('Asia/Jakarta');
	$waktu=date('Y-m-d H:i:s');
	$sql2 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
	mysqli_query($koneksi, $sql2) or die("database error:". mysqli_error($koneksi));
    session_destroy();
    header("location:../login/");
