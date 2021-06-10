<?php 
session_start();
if (!isset($_SESSION['peserta_didik_id'])) {
  header('Location: ./login/');
  exit();
};
$data['title'] = 'Transaksi';
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

		<div class="notification-section pb-15">
			<?php 
			$sql = "select * from invoice where peserta_didik_id='$idku' and tapel='$tapel_aktif' order by nomor desc";
			$query = $connect->query($sql);
			$cek = $query->num_rows;
			if($cek>0){
			while($s=$query->fetch_assoc()) {
				$nokwi=$s['nomor'];
			?>
			<div class="notification-item">
				<div class="notification-card">
					<a href="#" data-bs-toggle="modal" data-idinv="<?=$s['nomor'];?>" data-bs-target="#invoice">
						<div class="notification-card-thumb">
							<i class="flaticon-bell"></i>
						</div>
						<div class="notification-card-details">
							<h3><?=$s['nomor'];?></h3>
							<p><?=TanggalIndo($s['tanggal']);?></p>
						</div>
					</a>
				</div>
			</div>
			<?php 
			} 
			}else{
			?>
			<div class="alert alert-primary" role="alert">
				Belum ada Riwayat Transaksi
			</div>
			<?php } ?>
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