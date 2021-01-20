<?php
include("db.php");
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$level=$_GET['level'];$kd=$_GET['kd'];if($kd=="0"){}else{echo "<option value='0'>==Pilih Penilaian==</option>";echo "<option value='prak'>Praktek</option>";echo "<option value='proy'>Proyek</option>";echo "<option value='port'>Portofolio</option>";};
?>