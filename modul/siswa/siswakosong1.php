<?php 

require_once '../../function/db_connect.php';
function TanggalIndo($tanggal){
    if(!empty($tanggal)){
		$bulan = array (1 =>   'Januari',
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
		return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	};
};
$tapel=$_GET['tapel'];$tpl1=substr($tapel,0,4);$ntpl1=$tpl1-1;$tpl2=substr($tapel,5,4);$ntpl2=$tpl2-1;$ntapel=$ntpl1."/".$ntpl2;
$output = array('data' => array());

$sql = "SELECT * FROM siswa WHERE status=1 order by nama asc";
$query = $connect->query($sql);
while ($row = $query->fetch_assoc()) {
	$idp=$row['peserta_didik_id'];
	$sqlp = "SELECT * FROM penempatan WHERE peserta_didik_id='$idp' and tapel='$tapel'";
	$queryp = $connect->query($sqlp);
	$pn = $queryp->num_rows;
	$nisn=$row['nisn'];
	$jk=$row['jk'];	$adakelas = $connect->query("SELECT * FROM penempatan WHERE peserta_didik_id='$idp' and tapel='$ntapel'")->num_rows;	if($adakelas>0){	$nkelas = $connect->query("SELECT * FROM penempatan WHERE peserta_didik_id='$idp' and tapel='$ntapel'")->fetch_assoc();	$kelasnya=$nkelas['rombel'];	}else{		$kelasnya="";	};
	if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/cp/siswa/".$nisn.".jpg")){
		$gbr="../siswa/$nisn.jpg";
	}else{
		if($jk=="P"){
			$gbr="../siswa/p.png";
		}else{
			$gbr="../siswa/l.png";
		};
	};
	if($pn>0){
	}else{
			$actionButton = '
		  <button class="btn btn-effect-ripple btn-xs btn-danger" data-toggle="modal" data-target="#penempatanMemberModal" onclick="penempatanMember('.$row['id'].')"> Ambil</button>
		';
		$tgl=$row['tempat'].", ".TanggalIndo($row['tanggal']);
		$output['data'][] = array(
			$row['nama'],			$kelasnya,
			$actionButton
		);
	}
}
$connect->close();

echo json_encode($output);