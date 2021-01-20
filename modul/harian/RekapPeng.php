<?php 
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$peta=$_GET['peta'];
$mpid=$_GET['mp'];
$tema=$_GET['tema'];

$mpm=$connect->query("select * from mapel where id_mapel='$mpid'")->fetch_assoc();
		?>

		<div class="table-responsive">
		<table class="table table-bordered table-hover">
									<thead>
										<tr>
										<th rowspan="2">Nama Siswa</th>
											<?php
											$sq1="select * from pemetaan where kelas='$ab' and smt='$smt' and kd_aspek='$peta' and mapel='$mpid' and tema='$tema'";
											$qu1 = $connect->query($sq1);
											$banyak=$qu1->num_rows;
											while($e=$qu1->fetch_assoc()){
											?>
											<th colspan="3">KD <?=$e['nama_peta'];?></th>
											<?php }; ?>
										</tr>
										<tr>
											<?php 
											for ($x = 1; $x <= $banyak; $x++) {
											?>
											<th>U</th>
											<th>T1</th>
											<th>T2</th>
											<?php }; ?>
										</tr>
									</thead>
									<tbody>	
										<?php 
										$sql="select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
										$query = $connect->query($sql);
										while($s=$query->fetch_assoc()) {
											$idp=$s['peserta_didik_id'];
										?>
										<tr>
											<td><?=$s['nama'];?></td>
											<?php
											$sq2="select * from pemetaan where kelas='$ab' and smt='$smt' and kd_aspek='$peta' and mapel='$mpid' and tema='$tema'";
											$qu2 = $connect->query($sq2);
											while($f=$qu2->fetch_assoc()){
												$kd=$f['nama_peta'];
												$nh1 = $connect->query("select * from nh where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='tls'")->fetch_assoc();
												$nh2 = $connect->query("select * from nh where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='tgs1'")->fetch_assoc();
												$nh3 = $connect->query("select * from nh where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='lsn'")->fetch_assoc();
											?>
											<td><?=$nh1['nilai'];?></td>
											<td><?=$nh2['nilai'];?></td>
											<td><?=$nh3['nilai'];?></td>
											<?php } ?>
										</tr>
										<?php } ?>
																	
									</tbody>
								</table>
								</div>
