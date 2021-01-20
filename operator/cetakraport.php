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
						  <h4>Cetak Raport Tahun Pelajaran <?=$tapel;?> Semester <?=$smt;?></h4>
						  <div class="card-header-form">
							<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
							<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
							<select class="form-control" id="kelas" name="kelas">
							<?php 
							$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
							while($nk=mysqli_fetch_array($sql_mk)){
							?>
								<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
							<?php };?>
							</select>
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
							<a href="#" id="cetakT" title="Cetak Penyerahan Raport" class="btn btn-info btn-border btn-round btn-sm">
									<span class="btn-label">
										<i class="fas fa-print"></i>
									</span>
									Cetak Penyerahan Raport
								</a>
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
		var kelas = $('#kelas').val();
		var tapel = $('#tapel').val();
		var smt = $('#smt').val();
		Raportku = $("#Raportku").DataTable({
			"destroy":true,
			"searching": false,
			"paging":false,
			"ajax": "../modul/rekap/Scetak.php?kelas="+kelas+"&tapel="+tapel+"&smt="+smt,
			"order": []
		});
		$( "#cetakT" ).click(function() {
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			if(kelas == 0){
				swal('Pilih Kelas Dahulu', {buttons: false,timer: 1000,});
			}else{
				window.open('../cetak/penyerahanraport.php?kelas='+kelas+'&tapel='+tapel+'&smt='+smt,' _blank');
			}
		});
		$('#kelas').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kelas = $('#kelas').val();
			var tapel = $('#tapel').val();
			var smt = $('#smt').val();
			$("#Raportku").DataTable({
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/rekap/Scetak.php?kelas="+kelas+"&tapel="+tapel+"&smt="+smt,
				"order": []
			});
		});
	});
</script>
</body>
</html>