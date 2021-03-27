<?php 
session_start();
include "function/db.php";
//require_once '../function/functions.php';
if (isset($_SESSION['username'])) {
    header("location:login/");
}
//$idptk=$_SESSION['userid'];
?>
<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/fav.ico' />
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card">
              <div class="card-body">
				<div class="row">
					<div class="col-3">
						<img alt="image" src="assets/img/logo.png" class="header-logo" />
					</div>
					<div class="col-9">
						<h2>A P I N S</h2><span class="text-center">Versi dddd</span>
					</div>
				</div>
				<br/>
				<p class="text-center"><img alt="image" src="assets/img/loading.gif" /></p>
				<p class="text-center"><span class="logo-name">Autentifikasi Pengguna berhasil, Anda akan diarahkan ke Halaman Admin</span></p>
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  
</body>
</html>