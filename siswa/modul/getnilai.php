<?php
require_once '../template/db_connect.php';
$jenis=$_GET['jenis'];
$mapel=$_GET['mapel'];
$kelas=substr($_GET['kelas'],0);
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$pdid=$_GET['pdid'];
if($jenis=="Harian"){ 
	$sql = "select * from nh where id_pd='$pdid' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$mapel' order by kd asc";
	$query = $connect->query($sql);
};
if($jenis=="PTS"){ 
	$sql = "select * from nuts where id_pd='$pdid' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$mapel' order by kd asc";
	$query = $connect->query($sql);
};
if($jenis=="PAT"){ 
	$sql = "select * from nats where id_pd='$pdid' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$mapel' order by kd asc";
	$query = $connect->query($sql);
};
if($jenis=="Raport"){ 
	$sql = "select * from raport_k13 where id_pd='$pdid' and kelas='$kelas' and smt='$smt' and tapel='$tapel' and mapel='$mapel' order by jns asc";
	$query = $connect->query($sql);
};
?>
		<div class="payment-list pb-15">
			<?php 
			$cek = $query->num_rows;
			if($cek>0){
			?>
			<?php if($jenis=="Raport"){ ?>
			<?php while($s=$query->fetch_assoc()) { ?>
			<div class="payment-list-details">
				<div class="payment-list-item payment-list-title">
					<?php if($s['jns']=='k3'){ echo "Pengetahuan"; }else{ echo "Ketrampilan"; } ?>
				</div>
				<div class="payment-list-item payment-list-info"><?=$s['nilai'];?> (<?=$s['predikat'];?>)</div>
			</div>
			<?php } ?>
			<?php }else{ ?>
			<?php while($s=$query->fetch_assoc()) { ?>
			<div class="payment-list-details">
				<div class="payment-list-item payment-list-title"><?=$s['kd'];?></div>
				<div class="payment-list-item payment-list-info"><?=$s['nilai'];?></div>
			</div>
			<?php } ?>
			<?php } ?>
			<?php }else{ ?>
			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">Warning</h4>
				<p>Belum Ada Nilai</p>
			</div>
			<?php } ?>
		</div>