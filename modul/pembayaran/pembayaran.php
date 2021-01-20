<?php
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$idp=$_GET['idp'];
$sqls = "select * from siswa where peserta_didik_id='$idp'";
$querys = $connect->query($sqls);
$siswa=$querys->fetch_assoc();
$rombs=$connect->query("select * from penempatan where peserta_didik_id='$idp' and tapel='$tapel'")->fetch_assoc();
?>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
				   <tr>
						<th>Nomor Kwitansi</th>
						<th>Tanggal</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$ada = $connect->query("select * from invoice where peserta_didik_id='$idp' and tapel='$tapel' order by tanggal desc")->num_rows;
				if($ada>0){
				$invo = $connect->query("select * from invoice where peserta_didik_id='$idp' and tapel='$tapel' order by tanggal asc");
				while ($invoi=$invo->fetch_assoc()){
				?>
					<tr>
						<td><?=$invoi['nomor'];?></td>
						<td><?=$invoi['tanggal'];?></td>
						<td><?=$invoi['jumlah'];?></td>
					</tr>
				<?php 
				};}else{
				?>
					<tr>
						<td colspan="3">Belum Ada Data</td>
					</tr>
				<?php }; ?>
				</tbody>
			</table>
		</div>