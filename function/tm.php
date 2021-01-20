<?php
include("db.php");
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$smt=$_GET['smt'];
$peta=$_GET['peta'];
$mpid = $_GET['mpid'];
if($mpid==0){}else{
if($mpid==1 or ($ab>3 and $mpid==8) or ($ab>3 and $mpid==4) or ($ab>3 and $mpid==9) or ($ab>3 and $mpid==10) or ($ab>3 and $mpid==11)){
	$sql2 = "select * from pemetaan where kelas='$ab' and smt='$smt' and kd_aspek='$peta' and mapel='$mpid' group by tema order by tema asc";
	$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));
	echo "<option value='0'>Pilih Pembelajaran</option>";
	while($s=mysqli_fetch_array($qu3)) {
		echo "<option value='".$s['tema']."'>Pembelajaran ".$s['tema']."</option>";
	};
}else{
	$sql_tema=mysqli_query($koneksi, "select * from tema where kelas='$ab' and smt='$smt'");
	echo "<option value='0'>Pilih Tema</option>";
	while($tmaku=mysqli_fetch_array($sql_tema)){
		echo "<option value='".$tmaku['tema']."'>Tema ".$tmaku['tema']."</option>";
	};
}};
?>