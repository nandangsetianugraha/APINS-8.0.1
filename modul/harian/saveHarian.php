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
$nama=mysqli_fetch_array(mysqli_query($koneksi,"select * from siswa where peserta_didik_id='$idp'"));
$pelajaran=mysqli_fetch_array(mysqli_query($koneksi,"select * from mapel where id_mapel='$mpid'"));
if(is_numeric($nilai)){
    if($nilai>100){}else{
        $cek="select * from nh where id_pd='$idp' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mpid' and tema='$tema' and kd='$kd' and jns='$jns'";
        $hasil=mysqli_query($koneksi,$cek);
        $ada = mysqli_num_rows($hasil);
        if ($ada>0){
			$utt=mysqli_fetch_array($hasil);
        	$idn=$utt['idNH'];
        	if($nilai==0 or empty($nilai)){
				$aktiv='Hapus Nilai Pengetahuan '.$pelajaran['kd_mapel'].' [Tema '.$tema.' KD '.$kd.'] atas nama '.$nama['nama'];
        		$sql="DELETE FROM nh WHERE idNH='$idn'";
				$sql1 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
        	}else{ 
				$aktiv='Update Nilai Pengetahuan '.$pelajaran['kd_mapel'].' [Tema '.$tema.' KD '.$kd.'] atas nama '.$nama['nama'];
        		$sql = "UPDATE nh SET nilai='$nilai' WHERE idNH='$idn'";
				$sql1 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
        	};
        }else{
        	$sql = "INSERT INTO nh(id_pd, kelas, smt, tapel, mapel, tema, kd, jns, nilai) VALUES('$idp','$ab','$smt','$tapel','$mpid','$tema','$kd','$jns','$nilai')";
			$aktiv='Input Nilai Pengetahuan '.$pelajaran['kd_mapel'].' [Tema '.$tema.' KD '.$kd.'] atas nama '.$nama['nama'];
			$sql1 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
        };
        mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
		mysqli_query($koneksi, $sql1) or die("database error:". mysqli_error($koneksi));
        echo "saved";
    };
};
?>