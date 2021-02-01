<?php 
session_start();
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../function/functions.php';
$data['title'] = 'Beranda';
//view('template/head', $data);
include "../template/heads.php";
//include "../function/db.php";
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "../template/top-navbars.php"; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php 
		include "../template/sidebars.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
		  <div class="row">
			<div class="col-12 col-md-12 col-lg-12">
			</div>
		  </div>
        </section>
		
        <?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  
</body>
</html>