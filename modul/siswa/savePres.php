<?php
include_once("../../function/db.php");
$idp=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$tapel=$_REQUEST['tapel'];
$nilai=$_REQUEST['value'];
$kolom=$_REQUEST['column'];
$cek="select * from data_prestasi where peserta_didik_id='$idp' AND smt='$smt' AND tapel='$tapel'";
$hasil=mysqli_query($koneksi,$cek);
$ada = mysqli_num_rows($hasil);
$utt=mysqli_fetch_array($hasil);
if ($ada>0){
	$idn=$utt['id'];
	$sql = "UPDATE data_prestasi SET $kolom='$nilai' WHERE id='$idn'";
}else{
	if($kolom=='kesenian'){
		$sql = "INSERT INTO data_prestasi(peserta_didik_id,smt,tapel,kesenian) VALUES('$idp','$smt','$tapel','$nilai')";
	}elseif($kolom=='olahraga'){
		$sql = "INSERT INTO data_prestasi(peserta_didik_id,smt,tapel,olahraga) VALUES('$idp','$smt','$tapel','$nilai')";
	}else{
		$sql = "INSERT INTO data_prestasi(peserta_didik_id,smt,tapel,akademik) VALUES('$idp','$smt','$tapel','$nilai')";
	}
	
};
mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
echo "saved";
?>