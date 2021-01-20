<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Cetak Tahfidz';
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
						  <h4>Cetak Raport Tahfidz</h4>
						  <div class="card-header-form">
							<div id="box"><a href="#" id="cetakT" title="Contacts" class="btn btn-info btn-border btn-round btn-sm">
											<span class="btn-label">
												<i class="fa fa-print"></i>
											</span>
										Cetak
										</a></div>
						  </div>
						</div>
						<div class="card-body">
							<div class="form-row">
								<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
								<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
								<div class="form-group col-md-2">
									<label>Kelas</label>
									<select class="form-control" id="kelas" name="kelas">
										<option value="0">Pilih Kelas</option>
										<?php 
										$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
										while($nk=mysqli_fetch_array($sql_mk)){
										?>
										<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
										<?php };?>
									</select>
								</div>
								<div class="form-group col-md-8">
									<label>Nama Siswa</label>
									<select class="form-control" id="idsis" name="idsis">
										
										
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Keterangan Nilai</label>
									<p><span class='badge badge-success'>A</span> : Sangat Lancar   <span class='badge badge-info'>B</span> : Lancar    <span class='badge badge-warning'>C</span> : Cukup Lancar    <span class='badge badge-danger'>D</span> : Kurang Lancar     <span class='badge badge-danger'>E</span> : Tidak Hafal</p>
								</div>
							</div>
							
							
						  <div class="table-responsive">
							<div id="nilaiHarian">
								<div class="alert alert-info alert-dismissible">
									<h4><i class="icon fa fa-info"></i> Informasi</h4>
									Silahkan Pilih Kelas
								</div>
							</div>
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
	$(document).ready(function() {
		$('#box').hide();
		$('#kelas').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			
			$.ajax({
				type : 'GET',
				url : 'siswat.php',
				data :  'kelas='+kelas+'&tapel='+tapel,
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#idsis").html(data);
					if(kelas==0){
					$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih Kelas</div>');
					}else{
					$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih Siswa</div>');
					};
				}
			});
		});
		$('#idsis').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var idsis = $('#idsis').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/rekap/Tahfidz.php',
				data :  'idp=' + idsis+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel,
				beforeSend: function()
				{	
					$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4><i class="fa fa-spinner fa-pulse fa-fw"></i> Memuat Data Nilai Tahfidz....</h4></div>');
				},
				success: function (data) {
					if(idsis=="0"){
						$("#box").hide();
						$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4>Silahkan pilih siswanya dahulu</h4></div>');
					}else{
					//jika data berhasil didapatkan, tampilkan ke dalam option select kd
					$("#box").show();
					$("#nilaiHarian").html(data);
					};
				}
			});
		});
		$( "#cetakT" ).click(function() {
			var idsis = $('#idsis').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			window.open('../cetak/tahfidz.php?idp='+idsis+'&kelas='+kelas+'&tapel='+tapel+'&smt='+smt,' _blank');
		});
	});
</script>
</body>
</html>