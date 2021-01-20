<?php
include("db.php");
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$level=$_GET['level'];$kd=$_GET['kd'];if($kd=="0"){}else{echo "<option value='0'>==Pilih Penilaian==</option>";echo "<option value='tls'>Ulangan</option>";echo "<option value='tgs1'>Tugas 1</option>";echo "<option value='lsn'>Tugas 2</option>";};
?>