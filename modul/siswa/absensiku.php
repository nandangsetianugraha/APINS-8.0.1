<?php require_once '../../function/db_connect.php';$dayList = array(		'Sun' => 'Minggu',		'Mon' => 'Senin',		'Tue' => 'Selasa',		'Wed' => 'Rabu',		'Thu' => 'Kamis',		'Fri' => 'Jumat',		'Sat' => 'Sabtu'	);$kelas=$_GET['kelas'];$tanggal=$_GET['tgl'];$tapel=$_GET['tapel'];$day = date('D', strtotime($tanggal));$output = array('data' => array());//$sql = "select penempatan.*, absensi.* from penempatan join absensi using(peserta_didik_id) where absensi.tanggal='$tgls' and penempatan.rombel='$kelas' and penempatan.tapel='$tapel'";$sql = "select * from penempatan where rombel='$kelas' and tapel='$tapel'";$query = $connect->query($sql);while($s=$query->fetch_assoc()) {	$idp=$s['peserta_didik_id'];	$sql1 = "select * from siswa where peserta_didik_id='$idp'";	$query1 = $connect->query($sql1);	$m=$query1->fetch_assoc();	$cekabsen=$connect->query("select * from absensi where tanggal='$tanggal' and peserta_didik_id='$idp'")->num_rows;	if($cekabsen>0){	}else{		$tombol = '		<div class="btn-group">		<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#tambahAbsen" data-kelas="'.$kelas.'" data-tgls="'.$tanggal.'" data-tapel="'.$tapel.'" data-pdid="'.$idp.'" id="getEkskul"><i class="fa fa-user"></i> Absensi</a>		</div>';		$output['data'][] = array(			$tombol.' '.$m['nama']		);	};};$connect->close();echo json_encode($output);