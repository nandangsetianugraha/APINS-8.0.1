<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$tglawal=$_GET['tglawal'];
$tglakhir=$_GET['tglakhir'];
$jenis=$_GET['jenis'];
if($jenis==0){
	$sql11="select * from pembayaran where tanggal >= '$tglawal' and tanggal <= '$tglakhir' and tapel='$tapel'";
}else{
	$sql11="select * from pembayaran where tanggal >= '$tglawal' and tanggal <= '$tglakhir' and tapel='$tapel' and jenis='$jenis'";
};
$query11 = $connect->query($sql11);
?>
	<div class="table-responsive">
	<table class="table table-bordered table-hover" id="laporan">
		<thead>
		   <tr>
				<th>Invoice</th>
				<th>Tanggal</th>
				<th>Nama Siswa</th>
				<th>Deskripsi</th>
				<th>Bayar</th>
			</tr>
		</thead>
		<tbody>	
<?php
while($h=$query11->fetch_assoc()) {
	$idpd=$h['peserta_didik_id'];
	$namasiswa=$connect->query("select * from siswa where peserta_didik_id='$idpd'")->fetch_assoc();
?>
			<tr>
				<td><?=$h['id_invoice'];?></td>
				<td><?=$h['tanggal'];?></td>
				<td><?=$namasiswa['nama'];?></td>
				<td><?=$h['deskripsi'];?></td>
				<td style="text-align:right;"><?=rupiah($h['bayar']);?></td>
			</tr>
<?php 
};
if($jenis==0){
	$tot=$connect->query("select sum(bayar) as total from pembayaran where tanggal >= '$tglawal' and tanggal <= '$tglakhir' and tapel='$tapel'")->fetch_assoc();
}else{
	$tot=$connect->query("select sum(bayar) as total from pembayaran where tanggal >= '$tglawal' and tanggal <= '$tglakhir' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
};
?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="text-align:right;">TOTAL</td>
				<td style="text-align:right;"><?=rupiah($tot['total']);?></td>
			</tr>
		</tfoot>
	</table>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#laporan').DataTable();
	});
</script>
