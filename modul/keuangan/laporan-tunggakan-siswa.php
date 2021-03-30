<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$jenis=$_GET['jenis'];
$jtunggakan=$connect->query("select * from jenis_tunggakan where id_tunggakan='$jenis'")->fetch_assoc();
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
?>
<p class="text-center">LAPORAN KEWAJIBAN ADMINISTRASI SISWA<br/><?=$jtunggakan['nama_tunggakan'];?></p>
<div class="table-responsive">
<table class="table table-sm" id="laporan">
	<thead>
	   <tr>
			<th>Nama Siswa</th>
			<th>Kelas</th>
			<th>Tarif</th>
			<th>Sudah dibayar</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody>	
		<?php
		$sql1="select * from penempatan where tapel='$tapel' order by rombel asc";
		$query1 = $connect->query($sql1);
		$jumlahtotal=0;
		$dibayar=0;
		$jumlahsisa=0;
		while($m=$query1->fetch_assoc()) {
			$idpd=$m['peserta_didik_id'];
			$jumlahtunggakan=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idpd' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
			$jumlahbayar=$connect->query("select sum(bayar) as jumlahbayar from pembayaran where peserta_didik_id='$idpd' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
			$sisa=$jumlahtunggakan['tarif']-$jumlahbayar['jumlahbayar'];
			$jumlahtotal=$jumlahtotal+$jumlahtunggakan['tarif'];
			$dibayar=$dibayar+$jumlahbayar['jumlahbayar'];
			$jumlahsisa=$jumlahsisa+$sisa;
			if($sisa==0){
			}else{
		?>
		<tr>
			<td><?=$m['nama'];?></td>
			<td><?=$m['rombel'];?></td>
			<td><?=rupiah($jumlahtunggakan['tarif']);?></td>
			<td><?=rupiah($jumlahbayar['jumlahbayar']);?></td>
			<td><?=rupiah($sisa);?></td>
		</tr>
		<?php }} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">Jumlah</td>
			<td><?=rupiah($jumlahtotal);?></td>
			<td><?=rupiah($dibayar);?></td>
			<td><?=rupiah($jumlahsisa);?></td>
		</tr>
	</tfoot>
</table>
</div>
<script>
	$('#laporan').DataTable();
</script>