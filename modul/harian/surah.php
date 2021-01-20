<?php
require_once '../../function/db.php';
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$smt=$_GET['smt'];
$mpid = $_GET['mpid'];
if($mpid==0){	}else{
	if($mpid==1){
		$sql2 = "select * from juzamma order by id asc";
		$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));
		echo "<option value='0'>Pilih Surah</option>";
		while($s=mysqli_fetch_array($qu3)) {
			echo "<option value='".$s['id']."'>Surah ".$s['nama']."</option>";
		};
	};	if($mpid==2){		$sql2 = "select * from arbain order by id asc";		$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));		echo "<option value='0'>Pilih Hadits Arbain</option>";		while($s=mysqli_fetch_array($qu3)) {			echo "<option value='".$s['id']."'>HADITS ".$s['nama']."</option>";		};	};	if($mpid==3){		$sql2 = "select * from surah order by id asc";		$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));		echo "<option value='0'>Pilih Surah Pilihan</option>";		while($s=mysqli_fetch_array($qu3)) {			echo "<option value='".$s['id']."'>Surah ".$s['nama']."</option>";		};	};	if($mpid==4){		$sql2 = "select * from doa order by id asc";		$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));		echo "<option value='0'>Pilih Doa Harian</option>";		while($s=mysqli_fetch_array($qu3)) {			echo "<option value='".$s['id']."'>Doa ".$s['nama']."</option>";		};	};	if($mpid==5){		$sql2 = "select * from hadits order by id asc";		$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));		echo "<option value='0'>Pilih Hadits Pilihan</option>";		while($s=mysqli_fetch_array($qu3)) {			echo "<option value='".$s['id']."'>".$s['nama']."</option>";		};	};};
?>