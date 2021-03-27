<?php 
session_start();
include("../function/db.php");
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Tambah PTK';
//view('template/head', $data);
include "../template/head.php";
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
		include "sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<form method="post" class="needs-validation" action="../modul/ptk/tambahPTK.php" id="tambahPTKForm">
					<div class="card">
					  <div class="padding-20">
						<ul class="nav nav-tabs" id="myTab2" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
							  aria-selected="true">Biodata</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
							  aria-selected="false">Jenis Pegawai</a>
						  </li>
						</ul>
						<div class="tab-content tab-bordered" id="myTab3Content">
						  <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
							<div class="row">
							  <div class="form-group col-md-10 col-10">
								<label>Nama Lengkap</label>
								<input type="text" name="nama" class="form-control" autocomplete=off required="">
							  </div>
							  <div class="form-group col-md-2 col-2">
								<label>Gelar</label>
								<input type="text" name="gelar" autocomplete=off class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jeniskelamin" id="jeniskelamin">
									<option value="L" >Laki-laki</option>
									<option value="P" >Perempuan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NIK</label>
								<input type="text" name="nik" class="form-control" autocomplete=off>
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat" class="form-control" autocomplete=off required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggallahir" class="form-control datepicker" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Alamat</label>
								<input type="text" name="alamat" class="form-control" autocomplete=off>
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIY/NIGK</label>
								<input type="text" name="niynigk" autocomplete=off class="form-control" >
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NUPTK</label>
								<input type="text" name="nuptk" autocomplete=off class="form-control" >
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>No HP</label>
								<input type="text" name="noHP" class="form-control" >
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Email</label>
								<input type="text" name="email" class="form-control" >
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-6">
								<label>Status Pegawai</label>
								<select class="form-control" name="statuspegawai">
									<?php 
									$stpg=mysqli_query($koneksi, "select * from status_kepegawaian");
									while($statuspeg = mysqli_fetch_array($stpg)){
									?>
									<option value="<?=$statuspeg['status_kepegawaian_id'];?>"><?=$statuspeg['nama'];?></option>
									<?php };?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-6">
								<label>Jenis Pegawai</label>
								<select class="form-control" name="jenispegawai">
									<?php 
									$stptk=mysqli_query($koneksi, "select * from jenis_ptk");
									while($statusptk = mysqli_fetch_array($stptk)){
									?>
									<option value="<?=$statusptk['jenis_ptk_id'];?>"><?=$statusptk['jenis_ptk'];?></option>
									<?php };?>
								</select>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  <div class="card-footer text-right">
						<button class="btn btn-primary">Save Changes</button>
					  </div>
					</div> <!--akhir card-->
				</div>
				</form>
			</div>
          </div>
        </section>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
    <script src="croppie.js"></script>
	<script>  
$(document).ready(function(){  
  $("#tambahPTKForm").unbind('submit').bind('submit', function() {
				var form = $(this);
					//submi the form to server
					$.ajax({
						url : form.attr('action'),
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {
							// remove the error 
							if(response.success == true) {
								swal(response.messages, {buttons: false,timer: 1000,});
								setTimeout(function () {window.open("ptk","_self");},500)
								// reset the form
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