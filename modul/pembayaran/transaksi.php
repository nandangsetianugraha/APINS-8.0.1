<?php
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}
require_once '../../function/db_connect.php';
$jenis=$_GET['jenis'];
$idp=$_GET['id'];
$bayar=$_GET['bayar'];
$sqls = "select * from siswa where id='$idp'";
$querys = $connect->query($sqls);
$siswa=$querys->fetch_assoc();
$idsis=$siswa['peserta_didik_id'];
$s2 = "select * from pembayaran_temp where peserta_didik_id='$idsis'";
$q2 = $connect->query($s2);
?>

<table class="table table-striped" id="tabelbayar">
	<thead>
		<tr>
			<th>Pembayaran</th>
			<th>Bayar</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	while($zk=$q2->->fetch_assoc()){
	?>
		<tr>
			<td><?=$zk['deskripsi'];?></td>
			<td><?=$zk['bayar'];?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>