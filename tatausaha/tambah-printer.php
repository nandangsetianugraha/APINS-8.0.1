<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Tambah Printer';
//view('template/head', $data);
include "../template/head.php";
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
		include "../template/sidebar.php";
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
					  <h4>Tambah Printer</h4>
					  <div class="card-header-form">
					  </div>
					</div>
					<div class="card-body">
						<form method="post" class="needs-validation" action="../modul/setting/tambahprinter.php" id="tambahForm">
									<div class="row">
									  <div class="form-group col-md-12 col-12">
										<label>Nama Printer</label>
										<input type="text" name="namaprinter" class="form-control" required="">
									  </div>
									</div>
									<div class="row">
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Kartu SPP</label>
										<input type="text" name="kertasspp" class="form-control">
									  </div>
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Tabungan</label>
										<input type="text" name="kertastabungan" class="form-control">
									  </div>
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Kwitansi dan Laporan</label>
										<input type="text" name="kertaskwitansi" class="form-control">
									  </div>
									</div>
									<div class="card-footer text-right">
										<button class="btn btn-primary">Tambah</button>
									</div>
						</form>
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
  <script>
  $(document).ready(function(){
	$("#tambahForm").unbind('submit').bind('submit', function() {
		var form = $(this);
			//submi the form to server
		$.ajax({
			url : form.attr('action'),
			type : form.attr('method'),
			data : form.serialize(),
			dataType : 'json',
			success:function(response) {
				if(response.success == true) {
					swal(response.messages, {buttons: false,timer: 1000,});
					setTimeout(function () {window.open("pengaturan-printer","_self");},500)
				} else {
					swal(response.messages, {buttons: false,timer: 1000,});
				}  // /else
			} // success  
		}); // ajax subit 				
		return false;
	}); // /submit form for create member
  }); 
  </script>
</body>
</html>