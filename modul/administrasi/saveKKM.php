<?php
require_once '../../function/db.php';
$kelas=substr($_REQUEST['kelas'],0,1);
$tapel=$_REQUEST['tapel'];
$mapel=$_REQUEST['mp'];
$jns=$_REQUEST['column'];
$kd=$_REQUEST['kda'];
$nilai=$_REQUEST['value'];
$jenis=$_REQUEST['jenis'];
$cek="select * from kkmku where kelas='$kelas' AND tapel='$tapel' AND mapel='$mapel' and kd='$kd' and jenis='$jenis'";
$hasil=mysqli_query($koneksi,$cek);
$ada = mysqli_num_rows($hasil);
$cks=mysqli_fetch_array($hasil);
if ($ada>0){
	$idn=$cks['id_kkm'];
	if($nilai==0 or empty($nilai)){
		$sql="DELETE FROM kkmku WHERE id_kkm='$idn'";
	}else{ 
		$sql = "UPDATE kkmku SET nilai='$nilai' WHERE id_kkm='$idn'";
	};
}else{
	$sql = "INSERT INTO kkmku(kelas,tapel,mapel,kd,jenis,nilai) VALUES('$kelas','$tapel','$mapel','$kd',$jenis,'$nilai')";
};
mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
	$sql2 = "select AVG(nilai) as ratarata from kkmku where kelas='$kelas' AND tapel='$tapel' AND mapel='$mapel'";
	$query2 = mysqli_query($koneksi,$sql2);
	$cks2 = mysqli_fetch_array($query2);
	$kkmbeneran=$cks2['ratarata'];
		
	$sql12 = "select * from kkm where kelas='$kelas' AND tapel='$tapel' AND mapel='$mapel'";
	$query12 = mysqli_query($koneksi,$sql12);
	$cks1 = mysqli_fetch_array($query12);
	$ada1 = mysqli_num_rows($query12);
	if($ada1>0){
		$idk=$cks1['id_kkm'];
		$sqln = "UPDATE kkm SET nilai='$kkmbeneran' WHERE id_kkm='$idk'";
		mysqli_query($koneksi, $sqln) or die("database error:". mysqli_error($koneksi));
	}else{
		$sql11 = "INSERT INTO kkm(kelas, tapel, mapel, nilai) VALUES('$kelas','$tapel','$mapel','$kkmbeneran')";
		mysqli_query($koneksi, $sql11) or die("database error:". mysqli_error($koneksi));
	}
echo "saved";
?>