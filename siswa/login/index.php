<?php 
session_start();
if (isset($_SESSION['peserta_didik_id'])) {
    header("location:../");
}
$data['title'] = 'Login';
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
<meta charset="utf-8">
<meta name="description" content="Oban">
<meta name="keywords" content="HTML,CSS,JavaScript">
<meta name="author" content="HiBootstrap">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title><?=$data['title'];?> | SD Islam Al-Jannah</title>
<link rel="icon" href="../assets/images/favicon.png" type="image/png" sizes="16x16">

<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/animate.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/owl.carousel.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css" type="text/css" media="all" />

<link rel='stylesheet' href='../assets/css/icofont.min.css' type="text/css" media="all" />

<link rel='stylesheet' href='../assets/css/flaticon.css' type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/responsive.css" type="text/css" media="all" />
<!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>
<body>
<?php 
require_once '../template/Mobile_Detect.php';
$detect = new Mobile_Detect;
// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
?>
<div class="preloader">
	<div class="preloader-wrapper">
		<div class="preloader-content">
			<img src="../assets/images/preloader-logo.png" alt="logo">
			<h3>A P I N S</h3>
		</div>
	</div>
</div>
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
				<h3>Login to APINS</h3>
			</div>
		</div>


		<div class="authentication-form pb-15">
			<div id="message"></div>
			<div id="login-form">
				<form method="POST" name="form1" action="checklogin.php">
					<div class="form-group pb-15">
						<label>NIS</label>
						<div class="input-group">
							<input id="username" type="text" class="form-control" name="username" autocomplete=off required placeholder="NIS">
							<span class="input-group-text"><i class="flaticon-user-picture"></i></span>
						</div>
					</div>
					<div class="form-group pb-15">
						<label>Tanggal Lahir (YYYYmmdd)</label>
						<div class="input-group">
							<input id="password" type="password" name="password" autocomplete=off class="form-control password" required placeholder="**********">
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
						<div class="authentication-account-access-item"></div>
					</div>
					<button name="Submit" id="submit" class="btn main-btn main-btn-lg full-width mb-10">Sign In</button>
					<a href="qrcode.php" class="btn main-btn main-btn-lg main-btn-red full-width mb-10"><i class="icofont-qr-code"></i> Login QRCode</a>
				</form>
			</div>
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


<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/owl.carousel.min.js"></script>

<script src="../assets/js/jquery.ajaxchimp.min.js"></script>

<script src="../assets/js/form-validator.min.js"></script>

<script src="../assets/js/contact-form-script.js"></script>

<script src="../assets/js/script.js"></script>
<script src="login.js"></script>
<?php }else{ ?>
	<div class="body-content">
		<div class="container">
			<section class="error-page-section pb-15">
			<div class="container">
			<div class="error-page-content">
			 <img src="../assets/images/404.png" alt="404">
			<h2>Error</h2>
			<p>Hanya Bisa diakses via Mobile</p>
			</div>
			</div>
			</section>
		</div>
	</div>
<?php } ?>
</body>
</html>