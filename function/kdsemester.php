<?php
include("../function/db.php");
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$smt=$_GET['smt'];
$peta=$_GET['peta'];
$mpid = $_GET['mpid'];
if($mpid==0){}else{
	$sql_tema=mysqli_query($koneksi, "select * from pemetaan where kelas='$ab' and smt='$smt' and kd_aspek='$peta' and mapel='$mpid' group by nama_peta order by nama_peta asc");
	echo "<option value='0'>Pilih KD</option>";
	while($tmaku=mysqli_fetch_array($sql_tema)){
		echo "<option value='".$tmaku['nama_peta']."'>KD ".$tmaku['nama_peta']."</option>";
	};
};
?>