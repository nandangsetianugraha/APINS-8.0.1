<?php 
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$siswa=$_GET['siswa'];
$bulan=(int) $_GET['bulan'];
$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
$namasiswa=$connect->query("select * from siswa where peserta_didik_id='$siswa'")->fetch_assoc();
$namakelas=$connect->query("select * from penempatan where peserta_didik_id='$siswa' and tapel='$tapel'")->fetch_assoc();
$jumlah=0;
$sisa=0;
$nomor=0;
$bayarnya=0;
?>
<p class="text-center">LAPORAN KEWAJIBAN ADMINISTRASI SISWA<br/>SAMPAI DENGAN <?=$bln[$bulan-1];?> <?=$thn;?></p>
<p>Nama Siswa : <?=$namasiswa['nama'];?><br/>Kelas : <?=$namakelas['rombel'];?></p>
<div class="table-responsive">
<table class="table table-sm" id="laporan">
	<thead>
	   <tr>
			<th>Nama Pembayaran</th>
			<th>Bulan</th>
			<th>Tarif/Biaya</th>
			<th>Pembayaran</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody>	
<?php
if($jenis==0){
	$spp=$connect->query("select * from tarif_spp where peserta_didik_id='$siswa'")->fetch_assoc();
	for($i = 1; $i < $bulan+1; $i++){
		$sppbln=$connect->query("select * from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='1' and bulan='$i'")->num_rows;
		if($sppbln>0){
		}else{
			$blnspp=$connect->query("select * from bulan_spp where id_bulan='$i'")->fetch_assoc();
			$jumlah=$jumlah+$spp['tarif'];
			$sisa=$sisa+$spp['tarif'];
			$nomor=$nomor+1;
?>
	<tr>
		<td>SPP Tahun <?=$tapel;?></td>
		<td><?=$blnspp['bulan'];?></td>
		<td style="text-align:right"><?=rupiah($spp['tarif']);?></td>
		<td style="text-align:right">-</td>
		<td style="text-align:right"><?=rupiah($spp['tarif']);?></td>
	</tr>
<?php
			
		};
	};
	$sql11="select * from jenis_tunggakan where id_tunggakan > 1";
	$query11 = $connect->query($sql11);
	while($h=$query11->fetch_assoc()) {
		$idt=$h['id_tunggakan'];
		$cek=$connect->query("select * from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='$idt'")->num_rows;
		$tarifnya=$connect->query("select * from tunggakan_lain where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
		if($tarifnya['tarif']==0){}else{
		if($cek>0){
			$bayar=$connect->query("select sum(bayar) as sudahbayar from pembayaran where peserta_didik_id='$siswa' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
			$sudah=$bayar['sudahbayar'];
			if($sudah==$tarifnya['tarif']){
			}else{
				$sisanya=$tarifnya['tarif']-$sudah;
				$jumlah=$jumlah+$tarifnya['tarif'];
				$sisa=$sisa+$sisanya;
				$bayarnya=$bayarnya+$sudah;
				$nomor=$nomor+1;
?>
	<tr>
		<td><?=$h['nama_tunggakan'];?> Tahun <?=$tapel;?></td>
		<td></td>
		<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
		<td style="text-align:right"><?=rupiah($sudah);?></td>
		<td style="text-align:right"><?=rupiah($sisanya);?></td>
	</tr>
<?php
				
			}
		}else{
			$jumlah=$jumlah+$tarifnya['tarif'];
			$sisa=$sisa+$tarifnya['tarif'];
			$nomor=$nomor+1;
?>
	<tr>
		<td><?=$h['nama_tunggakan'];?> Tahun <?=$tapel;?></td>
		<td></td>
		<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
		<td style="text-align:right">-</td>
		<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
	</tr>
<?php 
	
		}
		};
	};
	if($sisa==0){
?>
	<tr>
		<td colspan="5" style="text-align:center">Tidak ada Tunggakan</td>
	</tr>
<?php 
	};
}
?>
</tbody>
<tfoot>
	<tr>
		<td colspan="2">Jumlah</td>
		<td style="text-align:right"><?=rupiah($jumlah);?></td>
		<td style="text-align:right"><?=rupiah($bayarnya);?></td>
		<td style="text-align:right"><?=rupiah($sisa);?></td>
	</tr>
</tfoot>
</table>
</div>

