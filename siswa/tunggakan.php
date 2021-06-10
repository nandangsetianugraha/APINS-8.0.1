<?php 
session_start();
if (!isset($_SESSION['peserta_didik_id'])) {
  header('Location: ./login/');
  exit();
};
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
$data['title'] = 'Tunggakan';
include "template/head.php"; 
?>
<body>

<?php 
include "template/preloader.php"; 
require_once 'template/Mobile_Detect.php';
$detect = new Mobile_Detect;
// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
?>
<div class="header-bg header-bg-1"></div>


<?php include "template/fixtop.php"; ?>
<div class="body-content">
	<div class="container">

		<div class="tab-selector">

			<ul class="tab-selector-list">
				<li class="active" data-tab-list="1">
					<button>Infaq Bulanan</button>
				</li>
				<li data-tab-list="2">
					<button>Tunggakan Lainnya</button>
				</li>
			</ul>


			<div class="tab-selector-details">
				<div class="tab-selector-details-item active" data-tab-details="1">
					<div class="row gx-3">
						<?php 
						$query = $connect->query("select * from bulan_spp order by id_bulan asc");
						while($s=$query->fetch_assoc()) {
							$ids=$s['id_bulan'];
							$namabulan=$connect->query("select * from bulan_spp where id_bulan='$ids'")->fetch_assoc();
							$cekspp=$connect->query("select * from tarif_spp where peserta_didik_id='$idku'")->num_rows;
							$tarifspp=$connect->query("select * from tarif_spp where peserta_didik_id='$idku'")->fetch_assoc();
							$tarifnya=$tarifspp['tarif'];
							$spp=$connect->query("select * from pembayaran where peserta_didik_id='$idku' and tapel='$tapel_aktif' and jenis='1' and bulan='$ids'")->num_rows;
						?>
						<div class="col-6 pb-15">
							<div class="monthly-bill-card monthly-bill-card-green">
								<div class="monthly-bill-thumb">
									<img src="assets/images/cm-logo-1.png" alt="logo">
								</div>
								<div class="monthly-bill-body">
									<h3><a href="#">Infaq Bulanan</a></h3>
									<p>Bulan <?=$namabulan['bulan'];?> </p>
								</div>
								<div class="monthly-bill-footer monthly-bill-action">
									<?php if($spp>0){ ?>
									<a href="#" class="btn main-btn main-btn-success">Lunas</a>
									<?php }else{ ?>
									<a href="#" class="btn main-btn main-btn-danger">Pay Now</a>
									<?php } ?>
									<p class="monthly-bill-price"><?=rupiah($tarifnya);?></p>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="tab-selector-details-item" data-tab-details="2">
					<div class="row gx-3">
						<?php 
						$sql = "select * from tunggakan_lain where peserta_didik_id='$idku' and tapel='$tapel_aktif' order by jenis asc";
						$query = $connect->query($sql);
						$cek = $query->num_rows;
						if($cek>0){
						while($s=$query->fetch_assoc()) {
							$ids=$s['jenis'];
							$idt=$s['id'];
							$namajenis=$connect->query("select * from jenis_tunggakan where id_tunggakan='$ids'")->fetch_assoc();
							$ceklunas=$connect->query("select sum(bayar) as sudah_bayar from pembayaran where peserta_didik_id='$idku' and tapel='$tapel_aktif' and jenis='$ids'")->fetch_assoc();
						?>
						<div class="col-6 pb-15">
							<div class="monthly-bill-card monthly-bill-card-green">
								<div class="monthly-bill-thumb">
									<img src="assets/images/cm-logo-3.png" alt="logo">
								</div>
								<div class="monthly-bill-body">
									<h3><?=$namajenis['nama_tunggakan'];?></h3>
								</div>
								<div class="monthly-bill-footer monthly-bill-action">
									<?php if($ceklunas['sudah_bayar']==$s['tarif']){ ?>
									<a href="#" class="btn main-btn main-btn-success">Lunas</a>
									<?php }else{ ?>
									<a href="#" class="btn main-btn main-btn-danger"><?=rupiah($ceklunas['sudah_bayar']);?></a>
									<?php } ?>
									<p class="monthly-bill-price"><?=rupiah($s['tarif']);?></p>
								</div>
							</div>
						</div>
						<?php 
						} 
						}else{ 
						?>
						<div class="alert alert-primary" role="alert">
							Belum ada Tunggakan Lain
						</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>


<?php include "template/app-navbar.php"; ?>
<?php include "template/sidebardrawer.php"; ?>

<div class="modal fade" id="invoice" tabindex="-1" aria-labelledby="notificationModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered notification-modal-dialog">
		<div class="modal-content">
			<div class="container">
				<div class="modal-header">
					<div class="modal-header-title">
						<h5 class="modal-title">Invoice Details</h5>
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="notification-modal fetched-data1">
						
					</div>
				</div>
			</div>
			<div class="notification-delete">
				<a href="#" data-bs-dismiss="modal" aria-label="Close">
				<i class="flaticon-trash"></i>
				</a>
			</div>
		</div>
	</div>
</div>


<div class="scroll-top" id="scrolltop">
<div class="scroll-top-inner">
<i class="icofont-long-arrow-up"></i>
</div>
</div>

<?php 
}else{
	include "template/error.php";
}
?>
<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/jquery.ajaxchimp.min.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.js"></script>
<script src="assets/js/script.js"></script>
<script>
	$('#invoice').on('show.bs.modal', function (e) {
        var idinv = $(e.relatedTarget).data('idinv');
			
		//menggunakan fungsi ajax untuk pengambilan data
		$.ajax({
			type : 'post',
			url : 'modul/invoice.php',
			data :  'idinv='+idinv,
			beforeSend: function()
				{	
					$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
				},
			success : function(data){
				$('.fetched-data1').html(data);//menampilkan data ke dalam modal
			}
		});
			
    });
</script>
</body>
</html>