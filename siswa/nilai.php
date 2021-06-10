<?php 
session_start();
if (!isset($_SESSION['peserta_didik_id'])) {
  header('Location: ./login/');
  exit();
};
$data['title'] = 'Nilai';
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
		<!-- Isi konten -->
		<div class="page-header">
			<div class="page-header-title page-header-item">
			<h3>Cek Nilai</h3>
			</div>
		</div>
		<div class="option-section mb-15">
			<div class="row gx-3">
				<div class="col pb-15">
					<input type="hidden" id="kelas" value="<?=$kelas['rombel'];?>">
					<input type="hidden" id="idpd" value="<?=$idku;?>">
					<div class="option-card option-card-violet">
						<a href="#" data-bs-toggle="modal" data-idinv="Harian" data-bs-target="#withdraw">
							<div class="option-card-icon">
							<i class="flaticon-invoice"></i>
							</div>
							<p>Harian</p>
						</a>
					</div>
				</div>
				<div class="col pb-15">
					<div class="option-card option-card-violet">
						<a href="#" data-bs-toggle="modal" data-idinv="PTS" data-bs-target="#withdraw">
							<div class="option-card-icon">
							<i class="flaticon-invoice"></i>
							</div>
							<p>PTS</p>
						</a>
					</div>
				</div>
				<div class="col pb-15">
					<div class="option-card option-card-violet">
						<a href="#" data-bs-toggle="modal" data-idinv="PAT" data-bs-target="#withdraw">
							<div class="option-card-icon">
							<i class="flaticon-invoice"></i>
							</div>
							<p>PAT/UKK</p>
						</a>
					</div>
				</div>
				<div class="col pb-15">
					<div class="option-card option-card-violet">
						<a href="#" data-bs-toggle="modal" data-idinv="Raport" data-bs-target="#withdraw">
							<div class="option-card-icon">
							<i class="flaticon-invoice"></i>
							</div>
							<p>Raport</p>
						</a>
					</div>
				</div>
				<div class="col pb-15">
					<div class="option-card option-card-violet">
						<a href="raport.php">
							<div class="option-card-icon">
							<i class="flaticon-invoice"></i>
							</div>
							<p>View</p>
						</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

<?php include "template/app-navbar.php"; ?>
<?php include "template/sidebardrawer.php"; ?>
		<div class="modal fade" id="withdraw" tabindex="-1" aria-labelledby="withdraw" aria-hidden="true">
			<div class="modal-dialog side-modal-dialog">
				<div class="modal-content">
					<div class="container fetched-data1">
						
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
	$('#withdraw').on('show.bs.modal', function (e) {
        var idinv = $(e.relatedTarget).data('idinv');
		var kelas = $('#kelas').val();	
		var idku = $('#idpd').val();	
		//menggunakan fungsi ajax untuk pengambilan data
		$.ajax({
			type : 'post',
			url : 'modul/nilai.php',
			data :  'idinv='+idinv+"&kelas="+kelas+"&pdid="+idku,
			beforeSend: function()
				{	
					$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
				},
			success : function(data){
				$('.judul').html(idinv)
				$('.fetched-data1').html(data);//menampilkan data ke dalam modal
			}
		});
			
    });
</script>
</body>
</html>