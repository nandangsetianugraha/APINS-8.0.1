<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Laporan Pembayaran';
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
					  <h4>Laporan Harian</h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" id="cetaklaporan"><i class="fas fa-print"></i> Cetak</button>
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<select class="form-control" name="jenis" id="jenis">
											<option value="0">All</option>
											<?php 
											$sql_mk=mysqli_query($koneksi, "select * from jenis_tunggakan");
											while($nk=mysqli_fetch_array($sql_mk)){
											?>
											<option value="<?=$nk['id_tunggakan'];?>"><?=$nk['nama_tunggakan'];?></option>
											<?php };?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
										<input type="text" class="form-control datepicker" name="tanggal1" id="tanggal1">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<input type="text" class="form-control datepicker" name="tanggal2" id="tanggal2">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<button class="btn btn-primary mr-1" type="button" id="getLaporan">Submit</button>
									</div>
								</div>
							</div> <!--Akhir Row-->
					  <div id="tabel-laporan">
						
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
  
  <script>
  var SPPku;
  $(document).ready(function() {
	  $(document).on('click', '#getLaporan', function(e){
		
			e.preventDefault();
			
			var tglawal=$('#tanggal1').val();
			var tglakhir=$('#tanggal2').val();
			var jenis=$('#jenis').val();
			var tapel=$('#tapel').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/keuangan/laporan-harian.php',
				data :  'tglawal=' + tglawal+'&tglakhir='+tglakhir+'&jenis='+jenis+'&tapel='+tapel,
				beforeSend: function()
				{	
					$("#tabel-laporan").html('<p class="text-center"><img src="loading.gif"></p>');
				},
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kd
					$("#tabel-laporan").html(data);
				}
			});
			
		});
		$(document).on('click', '#cetaklaporan', function(e){
		
			e.preventDefault();
			var tglawal=$('#tanggal1').val();
			var tglakhir=$('#tanggal2').val();
			var jenis=$('#jenis').val();
			var tapel=$('#tapel').val();
			PopupCenter('../cetak/cetak-harian.php?tglawal='+tglawal+'&tglakhir='+tglakhir+'&jenis='+jenis+'&tapel='+tapel, 'Cetak Invoice',800,800);
			
		});
  });
  function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
  </script>
</body>
</html>