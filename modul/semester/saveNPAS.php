<?php
session_start();
$ptkid=$_SESSION['userid'];
date_default_timezone_set('Asia/Jakarta');
$waktu=date('Y-m-d H:i:s');
include_once("../../function/db.php");
$pdid=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$tapel=$_REQUEST['tapel'];
$mapel=$_REQUEST['mp'];
$kelas=$_REQUEST['kelas'];
$nilai=$_REQUEST['value'];
$kd=$_REQUEST['kd'];
$ab=substr($kelas,0,1);
$cek="select * from nats where id_pd='$pdid' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel' and kd='$kd'";
$hasil=mysqli_query($koneksi,$cek);
$ada = mysqli_num_rows($hasil);
$utt=mysqli_fetch_array($hasil);
$nama=mysqli_fetch_array(mysqli_query($koneksi,"select * from siswa where peserta_didik_id='$pdid'"));
$pelajaran=mysqli_fetch_array(mysqli_query($koneksi,"select * from mapel where id_mapel='$mapel'"));
if(is_numeric($nilai)){
    if($nilai>100){}else{
        if ($ada>0){
        	$idn=$utt['idNH'];
        	if($nilai==0 or empty($nilai)){
        		$sql="DELETE FROM nats WHERE idNH='$idn'";
				$aktiv='Hapus Nilai PAS '.$pelajaran['kd_mapel'].' [KD '.$kd.'] atas nama '.$nama['nama'];
				$sql2 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
				mysqli_query($koneksi, $sql2) or die("database error:". mysqli_error($koneksi));
        	}else{ 
        		$sql = "UPDATE nats SET nilai='$nilai' WHERE idNH='$idn'";
				$aktiv='Update Nilai PAS '.$pelajaran['kd_mapel'].' [KD '.$kd.'] atas nama '.$nama['nama'];
				$sql2 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
				mysqli_query($koneksi, $sql2) or die("database error:". mysqli_error($koneksi));
        	};
        }else{
        	$sql = "INSERT INTO nats(id_pd,kelas,smt,tapel,mapel,kd,nilai) VALUES('$pdid','$ab','$smt','$tapel','$mapel','$kd','$nilai')";
			$aktiv='Input Nilai PAS '.$pelajaran['kd_mapel'].' [KD '.$kd.'] atas nama '.$nama['nama'];
			$sql2 = "INSERT INTO log(ptk_id, logDate, activity) VALUES('$ptkid','$waktu','$aktiv')";
			mysqli_query($koneksi, $sql2) or die("database error:". mysqli_error($koneksi));
        };
        mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
        $vck=mysqli_num_rows(mysqli_query($koneksi,"select * from temp_pas where id_pd='$pdid' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        $vrh=mysqli_fetch_array(mysqli_query($koneksi,"select avg(nilai) as rerata from nats where id_pd='$pdid' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        $rerata=$vrh['rerata'];
        if($vck>0){
        	$vcn=mysqli_fetch_array(mysqli_query($koneksi,"select * from temp_pas where id_pd='$pdid' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        	$idt=$vcn['idNH'];
        	$sql1 = "UPDATE temp_pas SET nilai='$rerata' WHERE idNH='$idt'";
        }else{
        	$sql1 = "INSERT INTO temp_pas(id_pd,kelas,smt,tapel,mapel,nilai) VALUES('$pdid','$kelas','$smt','$tapel','$mapel','$rerata')";
        };
        mysqli_query($koneksi, $sql1) or die("database error:". mysqli_error($koneksi));
        echo "saved";
};
};
?>