<?php
include_once("../../function/db.php");
$pdid=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$mapel=$_REQUEST['mp'];
$kelas=$_REQUEST['kelas'];
$nilai=$_REQUEST['value'];
$cek="select * from raport where id_pd='$pdid' AND kelas='$kelas' AND smt='$smt' AND mapel='$mapel'";
$hasil=mysqli_query($koneksi,$cek);
$ada = mysqli_num_rows($hasil);
$utt=mysqli_fetch_array($hasil);
if ($ada>0){
	$idn=$utt['id_raport'];
	if($nilai==0 or empty($nilai)){
		$sql="DELETE FROM raport WHERE id_raport='$idn'";
	}else{ 
		$sql = "UPDATE raport SET nilai='$nilai' WHERE id_raport='$idn'";
	};
}else{
	$sql = "INSERT INTO raport VALUES('','$pdid','$kelas','$smt','','$mapel','$nilai','')";
};
mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
echo "saved";
?>