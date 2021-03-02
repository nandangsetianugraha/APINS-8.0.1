<?php 



require_once '../../function/db_connect.php';

//if form is submitted

if($_POST) {	
	$validator = array('success' => false, 'messages' => array(), 'ids' => array(), 'jenis' => array(), 'tapel' => array(), 'bln' => array());
	$idr=$_POST['idsiswa'];
	$jenis=$_POST['jenis'];
	$tapel=$_POST['tapel'];
	$bulan=$_POST['bulan'];
	if(empty($bulan) || empty($jenis)){

		$validator['success'] = false;

		$validator['messages'] = "Tidak Boleh Kosong Datanya!";

	}else{
		$keys 	= array_keys($bulan);
$namabln='';
foreach ($keys as $bln) {
  $namabln=$namabln.$bln.'-';
}
			$validator['success'] = true;
			$validator['ids'] = $idr;
			$validator['jenis'] = $jenis;
			$validator['tapel'] = $tapel;
			$validator['bln'] = substr($namabln, 0, -1);
			$validator['messages'] = 'sukses';
				

	};

	

	// close the database connection

	$connect->close();



	echo json_encode($validator);



}