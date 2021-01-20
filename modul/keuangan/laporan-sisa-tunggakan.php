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
if($kelas==0){
?>
<p class="text-center">LAPORAN KEWAJIBAN ADMINISTRASI SISWA<br/>SAMPAI DENGAN <?=$bln[$bulan-1];?></p>
<?php
$sql1="select * from rombel where tapel='$tapel' order by nama_rombel asc";
$query1 = $connect->query($sql1);
while($m=$query1->fetch_assoc()) {
	$idromb=$m['nama_rombel'];
?>
<br/>
Kelas <?=$m['nama_rombel'];?>
<div class="table-responsive">
<table class="table table-sm" id="laporan">
	<thead>
	   <tr>
			<th>Nama Pembayaran</th>
			<th>Total</th>
			<th>Sudah dibayar</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody>	
<?php 
	$jtot=0;
	$jbayar=0;
	$jsisa=0;
	$sql2="select * from jenis_tunggakan";
	$query2 = $connect->query($sql2);
	while($n=$query2->fetch_assoc()) {
		$idtung = $n['id_tunggakan'];
		if($jenis==0){
			if($idtung==1){
				$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from tarif_spp left join penempatan on penempatan.peserta_didik_id=tarif_spp.peserta_didik_id where penempatan.rombel='$idromb' and penempatan.tapel='$tapel'")->fetch_assoc();
				$totaltunggakan=$jumlahtunggakan['jumlahspp']*$bulan;
			}else{
				$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from tunggakan_lain left join penempatan on penempatan.peserta_didik_id=tunggakan_lain.peserta_didik_id where penempatan.rombel='$idromb' and penempatan.tapel='$tapel' and tunggakan_lain.tapel='$tapel' and tunggakan_lain.jenis='$idtung'")->fetch_assoc();
				$totaltunggakan=$jumlahtunggakan['jumlahspp'];
			};
			$sql5="select sum(bayar) as dibayar from pembayaran left join penempatan on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.rombel='$idromb' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='$idtung'";
			$query5= $connect->query($sql5);
			$jumlahbayar=$query5->fetch_assoc();
			$jtot=$jtot+$totaltunggakan;
			$jbayar=$jbayar+$jumlahbayar['dibayar'];
			//$jsisa=$jsisa+($jtot-$jbayar);
			if($totaltunggakan==0){}else{
?>
		<tr>
			<td><?=$n['nama_tunggakan'];?></td>
			<td><?=rupiah($totaltunggakan);?></td>
			<td><?=rupiah($jumlahbayar['dibayar']);?></td>
			<td><?=rupiah($totaltunggakan-$jumlahbayar['dibayar']);?></td>
		</tr>
<?php 
			}
		} //end if jenis
	} //end while jenis tunggakan
?>
</tbody>
<tfoot>
	<tr>
		<td>Jumlah</td>
		<td><?=rupiah($jtot);?></td>
		<td><?=rupiah($jbayar);?></td>
		<td><?=rupiah($jtot-$jbayar);?></td>
	</tr>
</tfoot>
</table>
</div>
<?php 
} //end while rombel 
}else{
//	$spp=$connect->query("select * from rombel where peserta_didik_id='$siswa'")->fetch_assoc();
?>
<p class="text-center">LAPORAN KEWAJIBAN ADMINISTRASI SISWA KELAS <?=$kelas;?><br/>SAMPAI DENGAN <?=$bln[$bulan-1];?></p>
<div class="table-responsive">
<table class="table table-sm" id="laporan">
	<thead>
	   <tr>
			<th>Nama Pembayaran</th>
			<th>Total</th>
			<th>Sudah dibayar</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody>	
<?php 
	$jtot=0;
	$jbayar=0;
	$jsisa=0;
	$sql2="select * from jenis_tunggakan";
	$query2 = $connect->query($sql2);
	while($n=$query2->fetch_assoc()) {
		$idtung = $n['id_tunggakan'];
		if($jenis==0){
			if($idtung==1){
				$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from tarif_spp left join penempatan on penempatan.peserta_didik_id=tarif_spp.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel'")->fetch_assoc();
				$totaltunggakan=$jumlahtunggakan['jumlahspp']*$bulan;
			}else{
				$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from tunggakan_lain left join penempatan on penempatan.peserta_didik_id=tunggakan_lain.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel' and tunggakan_lain.tapel='$tapel' and tunggakan_lain.jenis='$idtung'")->fetch_assoc();
				$totaltunggakan=$jumlahtunggakan['jumlahspp'];
			};
			$sql5="select sum(bayar) as dibayar from pembayaran left join penempatan on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='$idtung'";
			$query5= $connect->query($sql5);
			$jumlahbayar=$query5->fetch_assoc();
			$jtot=$jtot+$totaltunggakan;
			$jbayar=$jbayar+$jumlahbayar['dibayar'];
			//$jsisa=$jsisa+($jtot-$jbayar);
			if($totaltunggakan==0){}else{
?>
		<tr>
			<td><?=$n['nama_tunggakan'];?></td>
			<td><?=rupiah($totaltunggakan);?></td>
			<td><?=rupiah($jumlahbayar['dibayar']);?></td>
			<td><?=rupiah($totaltunggakan-$jumlahbayar['dibayar']);?></td>
		</tr>
<?php 
		} // end if gak ada tunggakan
		}		//end if jenis
	} //end while jenis tunggakan
?>
	</tbody>
	<tfoot>
		<tr>
			<td>Jumlah</td>
			<td><?=rupiah($jtot);?></td>
			<td><?=rupiah($jbayar);?></td>
			<td><?=rupiah($jtot-$jbayar);?></td>
		</tr>
	</tfoot>

</table>
</div>
<?php 
}
?>
