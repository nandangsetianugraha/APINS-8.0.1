<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Rekapitulasi Nilai Raport';
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
						  <h4>Rekapitulasi Nilai Raport Semester <?=$smt;?></h4>
						  <div class="card-header-form">
							<a href="#" id="cetakT" title="Cetak" class="btn btn-info btn-border btn-round btn-sm">
											<span class="btn-label">
												<i class="fa fa-print"></i>
											</span>
										Cetak
										</a>
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
										<label>Jenis Raport</label>
										<select class="form-control" id="jns" name="jns">
											<option value="0">Pilih Raport</option>
											<option value="k3">Pengetahuan (KI-3)</option>
											<option value="k4">Ketrampilan (KI-4)</option>
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
							<div id="mod-loader-raport" style="display: none; text-align: center;">
								<img src="ajaxloading.gif"><br/>Sedang Proses Generate Nilai Raport......
							</div>
							<div id="diagram" class="table-responsive">
								<table id="Raportku" class="table table-bordered table-hover table-responsive no-padding">
									<thead>
										<tr>
											<th class="text-center" width="30%">Nama Siswa</th>
											<th class="text-center">PAI</th>
											<th class="text-center">PKn</th>
											<th class="text-center">BIN</th>
											<th class="text-center">MTK</th>
											<th class="text-center">IPA</th>
											<th class="text-center">IPS</th>
											<th class="text-center">SBK</th>
											<th class="text-center">PJK</th>
											<th class="text-center">BID</th>
											<th class="text-center">BIG</th>
											<th class="text-center">PBP</th>
											<th class="text-center">Jumlah</th>
											<th class="text-center">Rerata</th>
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
		$('#jns').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var jns = $('#jns').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			
			Raportku = $('#Raportku').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				
				"ajax": "../modul/rekap/rekapnilai.php?tapel="+tapel+"&smt="+smt+"&kelas="+kelas+"&jns="+jns,
				"order": []
			} );
		});
		$( "#cetakT" ).click(function() {
			var jns = $('#jns').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			if(jns==0){
				swal('Silahkan pilih Jenis Rapor nya', {buttons: false,timer: 2000,});
			}else if(jns=='k3'){
				window.open('../cetak/rekapnilai.php?kelas='+kelas+'&tapel='+tapel+'&smt='+smt+'&jns='+jns,' _blank');
			}else{
				window.open('../cetak/rekapnilaik.php?kelas='+kelas+'&tapel='+tapel+'&smt='+smt+'&jns='+jns,' _blank');
			};
		});
	});
</script>
</body>
</html>