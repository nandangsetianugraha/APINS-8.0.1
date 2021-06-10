<?php 
session_start();
$data['title'] = 'Login';
include "template/head.php"; 
?>
<body>
<?php 
require_once 'template/Mobile_Detect.php';
$detect = new Mobile_Detect;
// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
?>
<?php include "template/preloader.php"; ?>
<div class="header-bg header-bg-1"></div>


<div class="fixed-top">
<div class="appbar-area sticky-black">
<div class="container">
<div class="appbar-container">
<div class="appbar-item appbar-actions">

</div>
<div class="appbar-item appbar-page-title mx-auto">
<h3>Login</h3>
</div>
</div>
</div>
</div>
</div>


<div class="body-content">
<div class="container">

<div class="page-header">
<div class="page-header-title page-header-item">
<h3>Login to SIKAS</h3>
</div>
</div>


<div class="authentication-form pb-15">
<form>
<div class="form-group pb-15">
<label>Nama Pengguna</label>
<div class="input-group">
<input type="text" name="name" class="form-control" required placeholder="Nama Pengguna">
<span class="input-group-text"><i class="flaticon-user-picture"></i></span>
</div>
</div>
<div class="form-group pb-15">
<label>Kata Sandi</label>
<div class="input-group">
 <input type="password" name="password" class="form-control password" required placeholder="**********">
<span class="input-group-text reveal">
<i class="flaticon-invisible pass-close"></i>
<i class="flaticon-visibility pass-view"></i>
</span>
</div>
</div>
<div class="authentication-account-access pb-15">
<div class="authentication-account-access-item">
<div class="input-checkbox">
<input type="checkbox" id="check1">
<label for="check1">Remember Me!</label>
</div>
</div>
<div class="authentication-account-access-item">
</div>
</div>
<button class="btn main-btn main-btn-lg full-width mb-10">Sign In</button>
</form>
<div class="form-desc">Kembali ke halaman <a href="./">Utama</a></div>
</div>

</div>
</div>

<div class="modal fade" id="resetPassword" tabindex="-1" aria-labelledby="resetPassword" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="container">
<div class="modal-header">
<div class="modal-header-title">
<h5 class="modal-title">Forget Password</h5>
</div>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body modal-body-center">
<h3>Type Your Email To Reset Your Password</h3>
<div class="reset-form">
<form>
<div class="input-group">
<input type="text" placeholder="Your Email Address" />
</div>
<button type="submit" class="btn main-btn main-btn-lg full-width">Reset Password</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="scroll-top" id="scrolltop">
<div class="scroll-top-inner">
<i class="icofont-long-arrow-up"></i>
</div>
</div>


<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/owl.carousel.min.js"></script>

<script src="assets/js/jquery.ajaxchimp.min.js"></script>

<script src="assets/js/form-validator.min.js"></script>

<script src="assets/js/contact-form-script.js"></script>

<script src="assets/js/script.js"></script>
<?php }else{ include "template/error.php"; } ?>
</body>
</html>