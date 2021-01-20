<?php
include_once("../../function/db.php");
$idp=$_REQUEST['id'];
$smt=$_REQUEST['smt'];
$tapel=$_REQUEST['tapel'];
$mpid=$_REQUEST['mp'];
$ab=$_REQUEST['kelas'];
$nilai=strtoupper($_REQUEST['value']);
if($nilai=='A' or $nilai=='B' or $nilai=='C' or $nilai=='D' or $nilai=='E'){
        $cek="select * from hadits_arbain where id_pd='$idp' AND kelas='$ab' AND smt='$smt' AND tapel='$tapel' AND surah='$mpid'";
        $hasil=mysqli_query($koneksi,$cek);
        $ada = mysqli_num_rows($hasil);
        $utt=mysqli_fetch_array($hasil);
        if ($ada>0){
        	$idn=$utt['idNH'];
        	if(empty($nilai)){
        		$sql="DELETE FROM hadits_arbain WHERE idNH='$idn'";
        	}else{ 
        		$sql = "UPDATE hadits_arbain SET nilai='$nilai' WHERE idNH='$idn'";
        	};
        }else{
        	$sql = "INSERT INTO hadits_arbain(id_pd, kelas, smt, tapel,surah, nilai) VALUES('$idp','$ab','$smt','$tapel','$mpid','$nilai')";
        };
        mysqli_query($koneksi, $sql) or die("database error:". mysqli_error($koneksi));
        echo "saved";
    
}else{
	echo "gagal";
};
?>