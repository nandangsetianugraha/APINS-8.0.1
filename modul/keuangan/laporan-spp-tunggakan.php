<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$kelas=$_GET['kelas'];
$bulan=(int) $_GET['bulan'];
$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
//	$spp=$connect->query("select * from rombel where peserta_didik_id='$siswa'")->fetch_assoc();
?>
<p class="text-center">LAPORAN KEWAJIBAN INFAQ BULANAN SISWA KELAS <?=$kelas;?></p>
<div class="table-responsive">
<table class="table table-striped table-sm" id="laporan">
	<thead>
	   <tr>
			<th>Nama Siswa</th>
<?php 
$sql21="select * from bulan_spp order by id_bulan asc";
$query21 = $connect->query($sql21);
while($z=$query21->fetch_assoc()) {
?>
			<th><?=$z['bulan_pendek'];?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>	
<?php 
	$sql2="select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
	$query2 = $connect->query($sql2);
	while($n=$query2->fetch_assoc()) {
		$ids = $n['peserta_didik_id'];
		$tarifnya=$connect->query("select * from tarif_spp where peserta_didik_id='$ids'")->fetch_assoc();
?>
		<tr>
			<td><?=$n['nama'];?></td>
<?php 
$sql22="select * from bulan_spp order by id_bulan asc";
$query22 = $connect->query($sql22);
while($y=$query22->fetch_assoc()) {
	$idbln=$y['id_bulan'];
	$cekspp=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$idbln'")->num_rows;
	if($cekspp>0){
		$sppnya=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$idbln'")->fetch_assoc();
?>
			<td><?=$sppnya['tanggal'];?></td>
<?php 
	}else{
?>
			<td>X</td>
<?php 
	}
?>

<?php 
}
?>
			
		</tr>
<?php 
	} //end while penempatan
?>
	</tbody>
	<tfoot>
		<tr>
			<td>Jumlah</td>
<?php 
$sql25="select * from bulan_spp order by id_bulan asc";
$query25 = $connect->query($sql25);
while($v=$query25->fetch_assoc()) {
	$idbls=$v['id_bulan'];
	$sppnyas=$connect->query("select sum(bayar) as dibayar from penempatan left join pembayaran on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='1' and pembayaran.bulan='$idbls'")->fetch_assoc();
?>
			<td><?=rupiah($sppnyas['dibayar']);?></td>
<?php } ?>
		</tr>
	</tfoot>

</table>
</div>