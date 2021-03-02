<?php 
session_start();
require_once 'function/functions.php';

$data['title'] = 'Blank';
//view('template/head', $data);
include "template/kepala.php";
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "template/navbar-atas.php"; ?>
	  
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
				<div class="col-12 col-sm-6 col-md-6 col-lg-12">
				</div>
			</div>
          </div>
        </section>
		<?php include "template/setting.php"; ?>
      </div>
      <?php include "template/kaki.php"; ?>
    </div>
  </div>
  <?php include "template/script.php";?>
</body>
</html>