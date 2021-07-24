<?php 
require_once '../../function/db_connect.php';
function TanggalIndo($tanggal)
{
	$bulan = array ('Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1]-1 ] . ' ' . $split[0];
};
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
};
$output = array('data' => array());
$sql = "select * from nasabah order by nasabah_id asc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$jns=$row['jenis'];
	$idn=$row['nasabah_id'];
	$setor=$connect->query("SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE nasabah_id='".$idn."'")->fetch_assoc();
	$ambil=$connect->query("SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE nasabah_id='".$idn."'")->fetch_assoc();
	$saldo=$setor['setoran']-$ambil['penarikan'];
	$idp=$row['id'];
	if($jns==1){
		$jenis = 'Siswa';	
	}elseif($jns==2){
		$jenis = 'Guru';
	}else{
		$jenis='Lainnya';
	}
	$actionButton = '
		<button class="btn btn-effect-ripple btn-xs btn-danger" type="button" data-toggle="modal" data-target="#hapusData" onclick="outMember('.$idp.')"><i class="fa fa-trash"></i></button>
		';	
	$namasis=$row['nama'];
	$output['data'][] = array(
		$row['nasabah_id'],
		$row['nama'],
		rupiah($saldo),
		$jenis,
		$actionButton
	);
}

// database connection close
$connect->close();

echo json_encode($output);