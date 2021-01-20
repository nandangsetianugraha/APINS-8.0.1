<?php
include("db.php");
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$smt=$_GET['smt'];
$peta=$_GET['peta'];
$mpid = $_GET['mpid'];
$tema=$_GET['tema'];if($tema=="0"){}else{
$sql2 = "select * from pemetaan where kelas='$ab' and smt='$smt' and kd_aspek='$peta' and mapel='$mpid' and tema='$tema' order by nama_peta asc";
$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));
echo "<option value='0'>Pilih KD</option>";
	
while($s=mysqli_fetch_array($qu3)) {
	echo "<option value='".$s['nama_peta']."'>".$s['nama_peta']."</option>";
};};
?>