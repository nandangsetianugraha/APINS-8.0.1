<?php
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$kelas=$_GET['kelas'];
$ab=substr($kelas, 0, 1);
$smt=$_GET['smt'];
$idp=$_GET['idp'];
$sqls = "select * from siswa where peserta_didik_id='$idp'";
$querys = $connect->query($sqls);
$siswa=$querys->fetch_assoc();
$rombs=$connect->query("select * from penempatan where peserta_didik_id='$idp' and tapel='$tapel'")->fetch_assoc();
?>
<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nama Surah Juzamma</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from tahfidz where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc")->num_rows;
				if($ada>0){
				$juz = $connect->query("select * from tahfidz where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc");
				while ($juz1=$juz->fetch_assoc()){
					$idz=$juz1['surah'];
					$juz2=$connect->query("select * from juzamma where id='$idz'")->fetch_assoc();
				?>
					<tr>
						<td><?=$juz2['nama'];?></td>
						<td><?=$juz1['nilai'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="2">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nama Hadist Arbain</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from hadits_arbain where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc")->num_rows;
				if($ada>0){
				$juz = $connect->query("select * from hadits_arbain where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc");
				while ($juz1=$juz->fetch_assoc()){
					$idz=$juz1['surah'];
					$juz2=$connect->query("select * from arbain where id='$idz'")->fetch_assoc();
				?>
					<tr>
						<td><?=$juz2['nama'];?></td>
						<td><?=$juz1['nilai'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="2">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nama Surah Pilihan</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from surah_pilihan where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc")->num_rows;
				if($ada>0){
				$juz = $connect->query("select * from surah_pilihan where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc");
				while ($juz1=$juz->fetch_assoc()){
					$idz=$juz1['surah'];
					$juz2=$connect->query("select * from surah where id='$idz'")->fetch_assoc();
				?>
					<tr>
						<td><?=$juz2['nama'];?></td>
						<td><?=$juz1['nilai'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="2">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nama Doa Harian</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from doa_harian where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc")->num_rows;
				if($ada>0){
				$juz = $connect->query("select * from doa_harian where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc");
				while ($juz1=$juz->fetch_assoc()){
					$idz=$juz1['surah'];
					$juz2=$connect->query("select * from doa where id='$idz'")->fetch_assoc();
				?>
					<tr>
						<td><?=$juz2['nama'];?></td>
						<td><?=$juz1['nilai'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="2">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>
		
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nama Hadist Pilihan</th>
						<th>Nilai</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from hadits_pilihan where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc")->num_rows;
				if($ada>0){
				$juz = $connect->query("select * from hadits_pilihan where id_pd='$idp' and kelas='$ab' and smt='$smt' and tapel='$tapel' order by surah asc");
				while ($juz1=$juz->fetch_assoc()){
					$idz=$juz1['surah'];
					$juz2=$connect->query("select * from hadits where id='$idz'")->fetch_assoc();
				?>
					<tr>
						<td><?=$juz2['nama'];?></td>
						<td><?=$juz1['nilai'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="2">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>
	</div>
<div class="row">