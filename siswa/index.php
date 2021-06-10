<?php 
session_start();
if (!isset($_SESSION['peserta_didik_id'])) {
  header('Location: ./login/');
  exit();
};
$data['title'] = 'Beranda';
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
<div class="body-content body-content-lg">
	<div class="container">
		<!-- Isi konten -->
		<?php 
			include "home.php";
		?>
	</div>
</div>

<?php include "template/app-navbar.php"; ?>
<?php include "template/sidebardrawer.php"; ?>

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
</body>
</html>