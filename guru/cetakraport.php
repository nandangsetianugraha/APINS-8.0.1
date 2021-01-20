<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Cetak Raport';
//view('template/head', $data);
include "../template/head.php";
$peta=3;
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "../template/top-navbar.php"; ?>
	  <div class="main-sidebar sidebar-style-2">
		<?php 
		include "sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
						  <h4>Cetak Raport Kelas <?=$kelas;?> Tahun Pelajaran <?=$tapel;?> Semester <?=$smt;?></h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							<div class="alert alert-warning alert-has-icon">
							  <div class="alert-icon"><i class="fas fa-question-circle"></i></div>
							  <div class="alert-body">
								<div class="alert-title">Perhatian</div>
								Rapor tidak bisa dicetak selama masih ada mata pelajaran yang belum generate nilai rapornya.
							  </div>
							</div>
							 <div class="table-responsive">
										<table id="Raportku" class="table table-bordered">
								<thead>
								    <tr>
										<th width="45%">Nama</th>
										<th>KI-1</th>
										<th>KI-2</th>
										<th>KI-3</th>
										<th>KI-4</th>
										<th></th>
									</tr>
								</thead>
								<tbody>	
																
								</tbody>
							</table>
									</div>
						</div>
					</div>
				</div>
			</div>
          </div>
        </section>
		
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
<script type="text/javascript" language="javascript" class="init">
	var Raportku;
	$(document).ready(function() {
		Raportku = $("#Raportku").DataTable({
			"searching": false,
			"paging":false,
			"ajax": "../modul/rekap/Scetak.php?kelas=<?=$kelas;?>&tapel=<?=$tapel;?>&smt=<?=$smt;?>",
			"order": []
		});
	});
</script>
</body>
</html>