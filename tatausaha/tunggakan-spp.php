<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Laporan Pembayaran SPP';
//view('template/head', $data);
include "../template/head.php";
$bln=isset($_GET['bln']) ? $_GET['bln'] : date("m");
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
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
					  <h4>Laporan Tunggakan SPP</h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" id="cetaklaporan"><i class="fas fa-print"></i> Cetak</button>
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
								<div class="col-md-5">
									<div class="form-group form-group-default">
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>">
										<input type="hidden" name="jenis" id="jenis" class="form-control" value="1">
										<select class="form-control select2" id="kelas">
											<?php 
											$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
											while($nk=mysqli_fetch_array($sql_mk)){
											?>
											<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
											<?php };?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
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
			
			var bulan=$('#bulan').val();
			var kelas=$('#kelas').val();
			var jenis=$('#jenis').val();
			var tapel=$('#tapel').val();
				$.ajax({
					type : 'GET',
					url : '../modul/keuangan/laporan-spp-tunggakan.php',
					data :  'kelas=' + kelas+'&bulan='+bulan+'&jenis='+jenis+'&tapel='+tapel,
					beforeSend: function()
					{	
						$("#tabel-laporan").html('<p class="text-center"><img src="loading.gif"></p>');
						$('#getLaporan').addClass('disabled btn-progress');
					},
					success: function (data) {

						//jika data berhasil didapatkan, tampilkan ke dalam option select kd
						$("#tabel-laporan").html(data);
						$('#getLaporan').removeClass('disabled btn-progress');
					}
				});
			
			
		});
		$(document).on('click', '#cetaklaporan', function(e){
		
			e.preventDefault();
			var bulan=$('#bulan').val();
			var kelas=$('#kelas').val();
			var jenis=$('#jenis').val();
			var tapel=$('#tapel').val();
			PopupCenter('../cetak/cetak-spp-tunggakan.php?kelas='+kelas+'&bulan='+bulan+'&jenis='+jenis+'&tapel='+tapel, 'Cetak Invoice',800,800);
			
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