<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Pengaturan Printer';
//view('template/head', $data);
include "../template/head.php";
$idprinter=isset($_GET['edit']) ? $_GET['edit'] : '0';
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
			<?php if($idprinter=='0'){  ?>
            <div class="row">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Pengaturan Printer</h4>
					  <div class="card-header-form">
						<a href="tambah-printer" class="btn btn-icon btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah Printer</a>
					  </div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="TablePrinter">
								<thead>
								   <tr>
										<th>Nama Printer</th>
										<th>Kartu SPP</th>
										<th>Tabungan</th>
										<th>Kuitansi</th>
										<th>&nbsp;</th>
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
			<?php }else{ ?>
			<div class="row">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Edit Printer</h4>
					  <div class="card-header-form">
					  </div>
					</div>
					<div class="card-body">
						<?php $pprint = mysqli_fetch_array(mysqli_query($koneksi, "select * from printer where id_printer='$idprinter'")); ?>
						<form method="post" class="needs-validation" action="../modul/setting/ubahprinter.php" id="ubahForm">
									<div class="row">
									  <div class="form-group col-md-12 col-12">
										<label>Nama Printer</label>
										<input type="text" name="namaprinter" class="form-control" value="<?=$pprint['nama'];?>" required="">
										<input type="hidden" name="idprinter" class="form-control" value="<?=$pprint['id_printer'];?>">
									  </div>
									</div>
									<div class="row">
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Kartu SPP</label>
										<input type="text" name="kertasspp" class="form-control" value="<?=$pprint['spp'];?>">
									  </div>
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Tabungan</label>
										<input type="text" name="kertastabungan" class="form-control" value="<?=$pprint['tabungan'];?>">
									  </div>
									  <div class="form-group col-md-4 col-4">
										<label>Jenis Kertas Buat Kwitansi dan Laporan</label>
										<input type="text" name="kertaskwitansi" class="form-control" value="<?=$pprint['kwitansi'];?>">
									  </div>
									</div>
									<div class="card-footer text-right">
										<button class="btn btn-primary">Save Changes</button>
									</div>
						</form>
					</div>
				  </div>
				</div>
			</div>
			<?php } ?>
		  </div>
        </section>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script>
  var TablePrinter;
  $(document).ready(function(){
	TablePrinter = $('#TablePrinter').DataTable( {
		"destroy":true,
		"searching": false,
		"paging":false,
		"ajax": "../modul/setting/daftar-printer.php",
		"order": []
	} );
	$("#ubahForm").unbind('submit').bind('submit', function() {
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
	$(document).on('click', '#getAktif', function(e){
		
			e.preventDefault();
			
			var uids = $(this).data('ids');
			$.ajax({
				type : 'GET',
				url : '../modul/setting/printer-aktif.php',
				data :  'ids='+uids,
				success: function (data) {
					TablePrinter.ajax.reload(null, false);					
				}
			});
			
		});
  }); 
  </script>
</body>
</html>