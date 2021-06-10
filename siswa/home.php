<?php 
$bln=(int) date("m");
$blns = array("Januari", "Februari", "Maret", "April", "Mei", "Juni","Juli", "Agustus", "September", "Oktober", "November", "Desember");
switch ($bln) {
	case 1: 
		$blnspp=7;
		break;
	case 2: 
		$blnspp=8;
		break;
	case 3: 
		$blnspp=9;
		break;
	case 4: 
		$blnspp=10;
		break;
	case 5: 
		$blnspp=11;
		break;
	case 6: 
		$blnspp=12;
		break;
	case 7: 
		$blnspp=1;
		break;
	case 8: 
		$blnspp=2;
		break;
	case 9: 
		$blnspp=3;
		break;
	case 10: 
		$blnspp=4;
		break;
	case 11: 
		$blnspp=5;
		break;
	case 12: 
		$blnspp=6;
		break;
	default:
		$blnspp=0; 
		break;
};
$spp = $connect->query("select * from tarif_spp where peserta_didik_id='$idku'")->fetch_assoc();
$sppbln = $connect->query("select * from pembayaran where peserta_didik_id='$idku' and tapel='$tapel_aktif' and jenis='1' and bulan='$blnspp'")->num_rows;
$rincian = $connect->query("select * from pembayaran where peserta_didik_id='$idku' and tapel='$tapel_aktif' and jenis='1' and bulan='$blnspp'")->fetch_assoc();
?>
<div class="transaction-card section-to-header mb-15">
	<a href="transaction-details.html">
		<div class="transaction-card-info">
			<div class="transaction-info-thumb">
				<img src="https://apins.sdi-aljannah.web.id/images/siswa/<?=$avatar;?>" alt="user">
			</div>
			<div class="transaction-info-text">
				<h3><?=$siswa['nama'];?></h3>
				<p><?=$kelas['rombel'];?></p>
			</div>
		</div>
	</a>
</div>
<div class="add-card section-to-header mb-30">
	<div class="add-card-inner">
		<div class="add-card-item add-card-info">
			<p>Tabungan</p>
			<h3><?=rupiah($saldo);?></h3>
		</div>		
	</div>
</div>

<div class="option-section mb-15">
	<?php if($sppbln>0){ ?>
	<div class="alert alert-success" role="alert">
		<h4 class="alert-heading">Terima Kasih</h4>
		<p>Anda sudah melakukan pembayaran Infaq Bulanan Bulan <?=$blns[$bln-1];?></p>
		<hr>
		<p class="mb-0">No. Invoice : <?=$rincian['id_invoice'];?> Tanggal : <?=TanggalIndo($rincian['tanggal']);?></p>
	</div>
	<?php }else{ ?>
	<div class="alert alert-danger" role="alert">
		<h4 class="alert-heading">Warning</h4>
		<p>Infaq Bulanan Bulan <?=$blns[$bln-1];?> Belum dibayar.</p>
		<hr>
		<p class="mb-0">Segera lakukan pembayaran Infaq Bulanan paling lambat tanggal 10 setiap bulannya</p>
	</div>
	<?php } ?>
</div>

<!--
<div class="option-section mb-15">
	<div class="row gx-3">
		<div class="col pb-15">
			<div class="option-card option-card-violet">
				<a href="#" data-bs-toggle="modal" data-bs-target="#withdraw">
					<div class="option-card-icon">
						<i class="flaticon-down-arrow"></i>
					</div>
					<p>Withdraw</p>
				</a>
			</div>
		</div>
		<div class="col pb-15">
			<div class="option-card option-card-yellow">
				<a href="#" data-bs-toggle="modal" data-bs-target="#sendMoney">
					<div class="option-card-icon">
						<i class="flaticon-right-arrow"></i>
					</div>
					<p>Send</p>
				</a>
			</div>
		</div>
		<div class="col pb-15">
			<div class="option-card option-card-blue">
				<a href="my-cards.html">
					<div class="option-card-icon">
						<i class="flaticon-credit-card"></i>
					</div>
					<p>Cards</p>
				</a>
			</div>
		</div>
		<div class="col pb-15">
			<div class="option-card option-card-red">
				<a href="#" data-bs-toggle="modal" data-bs-target="#exchange">
					<div class="option-card-icon">
						<i class="flaticon-exchange-arrows"></i>
					</div>
					<p>Exchange</p>
				</a>
			</div>
		</div>
	</div>
</div>
-->

<div class="latest-news-section pb-15">
	<div class="section-header">
		<h2>Berita Terkini</h2>
	</div>
	<div class="row gx-3">
		<?php 
		$sberita="SELECT * FROM berita order by tanggal desc limit 6";
		$qberita = $connect->query($sberita);
		while($berita=$qberita->fetch_assoc()) {
		?>
		<div class="col-6 pb-15">
			<div class="blog-card">
				<div class="blog-card-thumb">
					<a href="#">
					<img src="https://sdi-aljannah.web.id/images/berita/<?=$berita['images'];?>" alt="blog">
					</a>
				</div>
				<div class="blog-card-details">
					<ul class="blog-entry">
						<li>Admin</li>
						<li><?=TanggalIndo($berita['tanggal']);?></li>
					</ul>
					<h3><a href="#"><?=limit_words($berita['judul'],5);?>...</a></h3>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
