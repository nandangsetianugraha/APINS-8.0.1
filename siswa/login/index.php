<?php 
session_start();
include "../../function/db.php";
//require_once '../function/functions.php';
if (isset($_SESSION['peserta_didik_id'])) {
    header("location:../beranda");
}
$sql_tahun=mysqli_query($koneksi, "select * from konfigurasi");
$esmanis=mysqli_fetch_array($sql_tahun);
$tapel=$esmanis['tapel'];
$smt=$esmanis['semester'];
$maintenis=$esmanis['maintenis'];
?>
<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../assets/css/app.min.css">
  <link rel="stylesheet" href="../../assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="../../assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='../../assets/img/fav.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card">
              <div class="card-body">
				<div class="row">
					<div class="col-3">
						<img alt="image" src="../../assets/img/logo.png" class="header-logo" />
					</div>
					<div class="col-9">
						<h2>A P I N S</h2><span class="text-center">Versi <?=$esmanis['versi'];?></span>
					</div>
				</div>
				<br/>
				<div id="message"></div>
				<div id="login-form">
                <form method="POST" name="form1" action="checklogin.php" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Username</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" autocomplete=off required autofocus>
                    <div class="invalid-feedback">
                      Silahkan isi Username
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      Silahkan isi Password
                    </div>
                  </div>
				  <div class="form-group">
                    <button name="Submit" id="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
				</div>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Kembali ke Website <a href="https://sdi-aljannah.web.id">Utama</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="js/jquery-2.2.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script src="login.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="../../assets/js/custom.js"></script>
</body>
</html>