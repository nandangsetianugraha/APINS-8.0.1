<?php
session_start();
$ptkid=$_SESSION['userid'];
date_default_timezone_set('Asia/Jakarta');
$waktu=date('Y-m-d H:i:s');
include_once("../../function/db.php");
$idp=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$tapel=$_REQUEST['tapel'];
$mpid=$_REQUEST['mp'];
$ab=$_REQUEST['kelas'];
$nilai=$_REQUEST['value'];
$tema=$_REQUEST['tema'];
$kd=$_REQUEST['kd'];
$jns=$_REQUEST['jns'];
if(is_numeric($nilai)){
    if($nilai>100){}else{
        $cek="select * from nh where id_pd='$idp' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mpid' and tema='$tema' and kd='$kd' and jns='$jns'";
        $hasil=mysqli_query($koneksi,$cek);
        $ada = mysqli_num_rows($hasil);
        if ($ada>0){
			$utt=mysqli_fetch_array($hasil);
        	$idn=$utt['idNH'];
        	if($nilai==0 or empty($nilai)){
        		$sql="DELETE FROM nh WHERE idNH='$idn'";
				$sql1 = "INSERT INTO log(ptkid, waktu, log, pdid) VALUES('$ptkid','$waktu','Hapus Nilai Pengetahuan','$idp')";
        	}else{ 
        		$sql = "UPDATE nh SET nilai='$nilai' WHERE idNH='$idn'";
				$sql1 = "INSERT INTO log(ptkid, waktu, log, pdid) VALUES('$ptkid','$waktu','Update Nilai Pengetahuan','$idp')";
        	};
        }else{
        	$sql = "INSERT INTO nh(id_pd, kelas, smt, tapel, mapel, tema, kd, jns, nilai) VALUES('$idp','$ab','$smt','$tapel','$mpid','$tema','$kd','$jns','$nilai')";
			$sql1 = "INSERT INTO log(ptkid, waktu, log, pdid) VALUES('$ptkid','$waktu','Input Nilai Pengetahuan','$idp')";
        };
        mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
		mysqli_query($koneksi, $sql1) or die("database error:". mysqli_error($koneksi));
        echo "saved";
    };
};
?>