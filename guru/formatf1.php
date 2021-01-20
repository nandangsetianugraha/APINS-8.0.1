<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Pelaporan Format F1';
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
						  <h4>Pelaporan Format F1 Semester <?=$smt;?></h4>
						  <div class="card-header-form">
							<div id="box">
										<a href="#" id="cetakT" title="Cetak" class="btn btn-info btn-border btn-round btn-sm">
											<span class="btn-label">
												<i class="fa fa-print"></i>
											</span>
										Cetak
										</a>
									</div>
						  </div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<label>Kelas</label>
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
										<select class="form-control" id="kelas" name="kelas">
											<option value="<?=$kelas;?>"><?=$kelas;?></option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Laporan</label>
										<select class="form-control" id="mp" name="mp">
											<option value="0">Pilih Laporan</option>
											<option value="1">Penilaian Tengah Semester</option>
											<option value="2">Penilaian Akhir Semester</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-default">
									<label>KKM Sekolah</label>
									<?php
									$mkkm=mysqli_fetch_array(mysqli_query($koneksi, "select min(nilai) as kkmsekolah from kkm where tapel='$tapel'"));
									if(empty($mkkm['kkmsekolah'])){
										$kkmsaya=0;
									}else{
										$kkmsaya=$mkkm['kkmsekolah'];
									};
									?>
									<input type="text" class="form-control" value="<?=$kkmsaya;?>">
									</div>
								</div>
							</div> <!--Akhir Row-->
							<div class="table-responsive">
								<table id="Raportku" class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="3" class="text-center">Mata Pelajaran</th>
											<th rowspan="3" class="text-center">Target Kurikulum (%)</th>
											<th colspan="3" class="text-center">Nilai</th>
											<th colspan="5" class="text-center">Ketuntasan</th>
											<th rowspan="3" class="text-center">Tarap Serap Kurikulum</th>
											<th rowspan="3" class="text-center">Keterangan</th>
										</tr>
										<tr>
											<th colspan="3" class="text-center">PTS/PAS</th>
											<th rowspan="2" class="text-center">KKM</th>
											<th rowspan="2" class="text-center">Jumlah Siswa</th>
											<th colspan="2" class="text-center">Nilai</th>
											<th rowspan="2" class="text-center">%</th>
										</tr>
										<tr>
											<th class="text-center">NTT</th>
											<th class="text-center">NTR</th>
											<th class="text-center">RT2</th>
											<th class="text-center">KKM (+)</th>
											<th class="text-center">KKM (-)</th>
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
		$('#box').hide();
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			if(mp=="0"){
				$("#box").hide();
			}else{
				$("#box").show();
			}
			Raportku = $('#Raportku').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/rekap/f1.php?tapel="+tapel+"&smt="+smt+"&kelas="+kelas+"&jns="+mp,
				"order": []
			} );
		});
		$( "#cetakT" ).click(function() {
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			window.open('../cetak/form-f1.php?tipe='+mp+'&kelas='+kelas+'&tapel='+tapel+'&smt='+smt,' _blank');
		});
	});
</script>
</body>
</html>