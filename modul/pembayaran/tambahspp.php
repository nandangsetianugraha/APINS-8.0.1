<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$kelas=$_POST['rombel'];
	$tapel=$_POST['tapel'];
	$tarif=$_POST['tarifspp'];
	$jenis=$_POST['jenis'];
	if(empty($kelas) || empty($tarif) || empty($jenis)){
		$validator['success'] = false;
		$validator['messages'] = "Tidak Boleh Kosong Datanya!";
	}else{
		$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
		$query = $connect->query($sql);
		while($s=$query->fetch_assoc()) {
			$idp=$s['peserta_didik_id'];
			if($jenis==1){
				$cekspp=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->num_rows;
				if($cekspp>0){
					$sppid=$connect->query("select * from tarif_spp where peserta_didik_id='$idp'")->fetch_assoc();
					$idspp=$sppid['id'];
					$query11 = $connect->query("UPDATE tarif_spp SET tarif='$tarif' WHERE id='$idspp'");
				}else{
					$sql2 = "INSERT INTO tarif_spp (peserta_didik_id, tarif) VALUES ('$idp', '$tarif')";
					$query11 = $connect->query($sql2);
				};
			}else{
				$cekspp=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idp' and tapel='$tapel' and jenis='$jenis'")->num_rows;
				if($cekspp>0){
					$sppid=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idp' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
					$idspp=$sppid['id'];
					$query11 = $connect->query("UPDATE tunggakan_lain SET tarif='$tarif' WHERE id='$idspp'");
				}else{
					$sql2 = "INSERT INTO tunggakan_lain (peserta_didik_id, tapel, jenis, tarif) VALUES ('$idp', '$tapel', '$jenis', '$tarif')";
					$query11 = $connect->query($sql2);
				};
			};
		};
		$validator['success'] = true;
		$validator['messages'] = "Selesai!";		
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}