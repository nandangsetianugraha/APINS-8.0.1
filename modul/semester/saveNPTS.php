<?php
include_once("../../function/db.php");
$pdid=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$tapel=$_REQUEST['tapel'];
$mapel=$_REQUEST['mp'];
$kelas=$_REQUEST['kelas'];
$nilai=$_REQUEST['value'];
$kd=$_REQUEST['kd'];
$ab=substr($kelas,0,1);
$cek="select * from nuts where id_pd='$pdid' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel' and kd='$kd'";
$hasil=mysqli_query($koneksi,$cek);
$ada = mysqli_num_rows($hasil);
$utt=mysqli_fetch_array($hasil);
if(is_numeric($nilai)){
    if($nilai>100){}else{
        if ($ada>0){
        	$idn=$utt['idNH'];
        	if($nilai==0 or empty($nilai)){
        		$sql="DELETE FROM nuts WHERE idNH='$idn'";
        	}else{ 
        		$sql = "UPDATE nuts SET nilai='$nilai' WHERE idNH='$idn'";
        	};
        }else{
        	$sql = "INSERT INTO nuts(id_pd,kelas,smt,tapel,mapel,kd,nilai) VALUES('$pdid','$ab','$smt','$tapel','$mapel','$kd','$nilai')";
        };
        mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
        $vck=mysqli_num_rows(mysqli_query($koneksi,"select * from temp_pts where id_pd='$pdid' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        $vrh=mysqli_fetch_array(mysqli_query($koneksi,"select avg(nilai) as rerata from nuts where id_pd='$pdid' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        $rerata=$vrh['rerata'];
        if($vck>0){
        	$vcn=mysqli_fetch_array(mysqli_query($koneksi,"select * from temp_pts where id_pd='$pdid' AND kelas='$kelas' AND smt='$smt' AND tapel='$tapel' AND mapel='$mapel'"));
        	$idt=$vcn['idNH'];
        	$sql1 = "UPDATE temp_pts SET nilai='$rerata' WHERE idNH='$idt'";
        }else{
        	$sql1 = "INSERT INTO temp_pts(id_pd,kelas,smt,tapel,mapel,nilai) VALUES('$pdid','$kelas','$smt','$tapel','$mapel','$rerata')";
        };
        mysqli_query($koneksi, $sql1) or die("database error:". mysqli_error($koneksi));
        echo "saved";
    };
};
?>