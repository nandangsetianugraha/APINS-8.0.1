<?php 

require_once '../../function/db_connect.php';
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$level=$_GET['level'];
$tapel=$_GET['tapel'];
$output = array('data' => array());
if($level==96){ //guru pai
	$idmp=1;	$sqlkdp = "select * from kd where kelas='$ab' and aspek=3 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	$sqlkdp = "select * from kd where kelas='$ab' and aspek=4 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	if($lulus>0){		$boleh=true;	}else{		$boleh=false;	};
	$sql1 = "select * from kkm where kelas='$kelas' and tapel='$tapel' and mapel='$idmp'";
	$query1 = $connect->query($sql1);
	$m=$query1->fetch_assoc();
	if($boleh){
		$nkkm=$m['nilai'];
	}else{
		$nkkm="<small class='label label-danger'><i class='fa fa-clock-o'></i> Belum Lengkap</small>";
	};
	
	$output['data'][] = array(
		'Pendidikan Agama Islam',
		$nkkm
	);
}elseif($level==95){ //guru penjas
	$idmp=8;
	$sqlkdp = "select * from kd where kelas='$ab' and aspek=3 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	$sqlkdp = "select * from kd where kelas='$ab' and aspek=4 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	if($lulus>0){		$boleh=true;	}else{		$boleh=false;	};
	$sql1 = "select * from kkm where kelas='$kelas' and tapel='$tapel' and mapel='$idmp'";
	$query1 = $connect->query($sql1);
	$m=$query1->fetch_assoc();
	if($boleh){
		$nkkm=$m['nilai'];
	}else{
		$nkkm="<small class='label label-danger'><i class='fa fa-clock-o'></i> Belum Lengkap</small>";
	};
	
	$output['data'][] = array(
		'Pendidikan Jasmani Olahraga dan Kesehatan',
		$nkkm
	);
}elseif($level==94){ //guru bahasa inggris
	$idmp=10;
	$sqlkdp = "select * from kd where kelas='$ab' and aspek=3 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	$sqlkdp = "select * from kd where kelas='$ab' and aspek=4 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	if($lulus>0){		$boleh=true;	}else{		$boleh=false;	};
	$sql1 = "select * from kkm where kelas='$kelas' and tapel='$tapel' and mapel='$idmp'";
	$query1 = $connect->query($sql1);
	$m=$query1->fetch_assoc();
	if($boleh){
		$nkkm=$m['nilai'];
	}else{
		$nkkm="<small class='label label-danger'><i class='fa fa-clock-o'></i> Belum Lengkap</small>";
	};
	$output['data'][] = array(
		'Bahasa Inggris',
		$nkkm
	);
}else{
$sql = "select * from mapel order by id_mapel asc";
$query = $connect->query($sql);

while($s=$query->fetch_assoc()) {
	$idmp=$s['id_mapel'];
	$sqlkdp = "select * from kd where kelas='$ab' and aspek=3 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	$sqlkdp = "select * from kd where kelas='$ab' and aspek=4 and mapel='$idmp' group by kd";	$querykdp = $connect->query($sqlkdp);	while($mkdp=$querykdp->fetch_assoc()){		$kdp=$mkdp['kd'];		$cek1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='1'")->num_rows;		$cek2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='2'")->num_rows;		$cek3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$idmp' and kd='$kdp' and jenis='3'")->num_rows;		if($cek1>0 and $cek2>0 and $cek3>0){			$lulus=1;		}else{			$lulus=0;		};	};	if($lulus>0){		$boleh=true;	}else{		$boleh=false;	};
	$sql1 = "select * from kkm where kelas='$kelas' and tapel='$tapel' and mapel='$idmp'";
	$query1 = $connect->query($sql1);	$ada=$query1->num_rows;	if($ada>0){
	$m=$query1->fetch_assoc();
	if($boleh){
		$nkkm=$m['nilai'];
	}else{
		$nkkm="<small class='label label-danger'><i class='fa fa-clock-o'></i> Belum Lengkap</small>";
	};	};
	$output['data'][] = array(
		$s['nama_mapel'],
		$nkkm
	);
	
};
};
	

// database connection close
$connect->close();

echo json_encode($output);