<?php
include("../../function/db.php");
$idr=$_POST['rowid'];
$cek="SELECT * FROM ptk WHERE ptk_id='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$bio=mysqli_fetch_array($hasil);
//$ids=$bio['ptk_id'];
?>