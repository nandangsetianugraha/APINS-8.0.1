<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Rapor Siswa';
//view('template/head', $data);
include "../template/head.php";
$idsiswa=isset($_GET['idsiswa']) ? $_GET['idsiswa'] : '0';
?>
<link rel="stylesheet" href="croppie.css" />
<style>
#imgChange {
	background: url("overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
	bottom: 0;
	color: #FFFFFF;
	display: block;
	height: 30px;
	left: 0;
	line-height: 32px;
	position: absolute;
	text-align: center;
	width: 100%;
}
#imgChange input[type="file"] {
	bottom: 0;
	cursor: pointer;
	height: 100%;
	left: 0;
	margin: 0;
	opacity: 0;
	padding: 0;
	position: absolute;
	width: 100%;
	z-index: 0;
}
</style>
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
            <div class="row mt-sm-4">
				<?php if($idsiswa=='0'){  ?>
				
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4></h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					
					</div>
				  </div>
				</div>
				<?php }else{ ?>
				<?php
					if($idsiswa=="0"){
					}else{
						$biom = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where peserta_didik_id='$idsiswa'"));
						$rombel = mysqli_fetch_array(mysqli_query($koneksi, "select * from penempatan where peserta_didik_id='$idsiswa' and tapel='$tapel'"));
						if(file_exists("https://apins.sdi-aljannah.web.id/images/siswa/".$biom['avatar'])){
							$avatarm=$biom['avatar'];
						}else{
							$avatarm="user-default.png";
						};
				?>
				<div class="col-12 col-md-12 col-lg-4">
					<div class="card profile-widget">
					  <div class="profile-widget-header">
						<div id="uploaded_image">
							<img src="https://apins.sdi-aljannah.web.id/images/siswa/<?=$avatarm;?>" alt="..." class="rounded-circle profile-widget-picture">
						</div>
						<div class="profile-widget-items">
						  <div class="profile-widget-item">
							<div class="profile-widget-item-label">Rombel</div>
							<div class="profile-widget-item-value">
								<?=$rombel['rombel'];?> 
							</div>
						  </div>
						</div>
					  </div>
					  <div class="profile-widget-description pb-0">
						<div class="profile-widget-name"><?=$biom['nama'];?></div>
					    <div class="py-4">
						  <p class="clearfix">
							<span class="float-left">
							  NIS
							</span>
							<span class="float-right text-muted">
							  <?=$biom['nis'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  NISN
							</span>
							<span class="float-right text-muted">
							  <?=$biom['nisn'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  TTL
							</span>
							<span class="float-right text-muted">
							  <?=$biom['tempat'];?>, <?=TanggalIndo($biom['tanggal']);?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  Jenis Kelamin
							</span>
							<span class="float-right text-muted">
							  <?php if($biom['jk']=="L"){echo "Laki-laki";}else{echo "Perempuan";}; ?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Agama</span>
							<span class="float-right text-muted">
							  <?php
								$idagama=$biom['agama'];
								$agama = mysqli_fetch_array(mysqli_query($koneksi, "select * from agama where id_agama='$idagama'"));
							  ?>
							  <?=$agama['nama_agama'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Pend. Sebelumnya</span>
							<span class="float-right text-muted">
							  <?=$biom['pend_sebelum'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Alamat</span>
							<span class="float-right text-muted">
							  <?=$biom['alamat'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Nama Ayah</span>
							<span class="float-right text-muted">
							  <?=$biom['nama_ayah'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Nama Ibu</span>
							<span class="float-right text-muted">
							  <?=$biom['nama_ibu'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Pekerjaan Ayah</span>
							<span class="float-right text-muted">
							  <?php
								$idpa=$biom['pek_ayah'];
								$peka = mysqli_fetch_array(mysqli_query($koneksi, "select * from pekerjaan where id_pekerjaan='$idpa'"));
							  ?>
							  <?=$peka['nama_pekerjaan'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">Pekerjaan Ibu</span>
							<span class="float-right text-muted">
							  <?php
								$idpi=$biom['pek_ibu'];
								$peki = mysqli_fetch_array(mysqli_query($koneksi, "select * from pekerjaan where id_pekerjaan='$idpi'"));
							  ?>
							  <?=$peki['nama_pekerjaan'];?>
							</span>
						  </p>
						</div>
					  </div>
					  <div class="card-footer text-center pt-0">
						<a href="siswa" class="btn btn-primary">
						  Kembali
						</a>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-8">
					<div class="card">
						<div class="card-header">
						  <h4></h4>
						  <div class="card-header-form">
							<input type="hidden" name="ids" id="ids" class="form-control" value="<?=$idsiswa;?>">
							<select class="form-control" id="tapel" name="tapel">
							<?php 
							$sql_mk=mysqli_query($koneksi, "select * from raport_k13 where id_pd='$idsiswa' group by tapel");
							while($nk=mysqli_fetch_array($sql_mk)){
							?>
								<option value="<?=$nk['tapel'];?>" <?php if($tapel==$nk['tapel']){echo "selected";}; ?>>Tahun Pelajaran <?=$nk['tapel'];?></option>
							<?php };?>
							</select>
						  </div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="kompetensiTable">
									<thead>
										<tr>
											<th width="20%">Kompetensi</th>
											<th width="40%">Semester 1</th>
											<th width="40%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="manageMemberTable">
									<thead>
										<tr>
											<th rowspan="3">No</th>
											<th rowspan="3">Mapel</th>
											<th colspan="4">Semester 1</th>
											<th colspan="4">Semester 2</th>
										</tr>
										<tr>
											<th colspan="2">KI-3</th>
											<th colspan="2">KI-4</th>
											<th colspan="2">KI-3</th>
											<th colspan="2">KI-4</th>
										</tr>
										<tr>
											<th>N</th>
											<th>P</th>
											<th>N</th>
											<th>P</th>
											<th>N</th>
											<th>P</th>
											<th>N</th>
											<th>P</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="tabelEkskul">
									<thead>
										<tr>
											<th width="10%">No</th>
											<th width="40%">Ekstrakurikuler</th>
											<th width="25%">Semester 1</th>
											<th width="25%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="tabelSaran">
									<thead>
										<tr>
											<th width="50%">Semester 1</th>
											<th width="50%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="tabelTB">
									<thead>
										<tr>
											<th width="10%">No</th>
											<th width="50%">Aspek Kesehatan</th>
											<th width="20%">Semester 1</th>
											<th width="20%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="tabelPrestasi">
									<thead>
										<tr>
											<th width="10%">No</th>
											<th width="20%">Prestasi</th>
											<th width="35%">Semester 1</th>
											<th width="35%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="tabelAbsensi">
									<thead>
										<tr>
											<th width="10%">No</th>
											<th width="20%">Absensi</th>
											<th width="35%">Semester 1</th>
											<th width="35%">Semester 2</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php }} ?>
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
		var tapel = $('#tapel').val();
		var ids = $('#ids').val();
		$("#kompetensiTable").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/raportk.php?tapel="+tapel+"&ids="+ids
		});
		$("#manageMemberTable").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/raport.php?tapel="+tapel+"&ids="+ids
		});
		$("#tabelEkskul").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/ekskul.php?tapel="+tapel+"&ids="+ids
		});
		$("#tabelSaran").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/saran.php?tapel="+tapel+"&ids="+ids
		});
		$("#tabelTB").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/tb.php?tapel="+tapel+"&ids="+ids
		});
		$("#tabelPrestasi").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/prestasiku.php?tapel="+tapel+"&ids="+ids
		});
		$("#tabelAbsensi").dataTable({
			"destroy":true,
		  "searching": false,
		  "paging":false,
		  "ajax": "../modul/siswa/absensi.php?tapel="+tapel+"&ids="+ids
		});
		$('#tapel').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var tapel = $('#tapel').val();
			var ids = $('#ids').val();
			$("#kompetensiTable").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/raportk.php?tapel="+tapel+"&ids="+ids
			});
			$("#manageMemberTable").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/raport.php?tapel="+tapel+"&ids="+ids
			});
			$("#tabelEkskul").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/ekskul.php?tapel="+tapel+"&ids="+ids
			});
			$("#tabelSaran").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/saran.php?tapel="+tapel+"&ids="+ids
			});
			$("#tabelTB").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/tb.php?tapel="+tapel+"&ids="+ids
			});
			$("#tabelPrestasi").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/prestasiku.php?tapel="+tapel+"&ids="+ids
			});
			$("#tabelAbsensi").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":false,
			  "ajax": "../modul/siswa/absensi.php?tapel="+tapel+"&ids="+ids
			});
		});
	});  
  </script>
</body>
</html>