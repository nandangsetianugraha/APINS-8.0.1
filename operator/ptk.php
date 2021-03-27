<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Daftar PTK';
//view('template/head', $data);
include "../template/head.php";
$idptk=isset($_GET['idptk']) ? $_GET['idptk'] : '0';
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
            <div class="row mt-sm-4">
				<?php if($idptk=='0'){  ?>
				
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar PTK Tahun Pelajaran <?=$tapel;?></h4>
					  <div class="card-header-form">
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
						<select class="form-control" id="status" name="status">
							<option value="1">Aktif</option>
							<option value="0">Non Aktif</option>
						</select>
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Nama PTK</th>
									<th>TTL</th>
									<th>NIK</th>
									<th>NIY/NIGK</th>
									<th>NUPTK</th>
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
				<?php }else{ ?>
				<?php
					if($idptk=="0"){
					}else{
						$biom = mysqli_fetch_array(mysqli_query($koneksi, "select * from ptk where ptk_id='$idptk'"));
						//$rombel = mysqli_fetch_array(mysqli_query($koneksi, "select * from penempatan where peserta_didik_id='$idsiswa' and tapel='$tapel'"));
						if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$biom['gambar'])){
							$avatarm=$biom['gambar'];
						}else{
							$avatarm="user-default.png";
						};
				?>
				<div class="col-12 col-md-12 col-lg-4">
					<div class="card profile-widget">
					  <div class="profile-widget-header">
						<div id="uploaded_image">
							<img src="<?= base_url(); ?>images/ptk/<?=$avatarm;?>" alt="..." class="rounded-circle profile-widget-picture">
						</div>
						<div class="profile-widget-items">
						  <div class="profile-widget-item">
							<div class="profile-widget-item-label"><br/></div>
							<div class="profile-widget-item-value"><div id="imgChange"><span>Ubah Foto</span>
															<input type="file" accept="image/*" name="upload_image" id="upload_image">
														</div></div>
						  </div>
						</div>
					  </div>
					  <div class="profile-widget-description pb-0">
					    <div class="profile-widget-name"><?=$biom['nama'];?> 
						  
						</div>
						<?php $biop = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengguna where ptk_id='$idptk'")); ?>
							<form method="post" class="needs-validation" action="../modul/ptk/updatepassword.php" id="ubahPass">
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Username</label>
								<input type="text" name="username" class="form-control" value="<?=$biop['username'];?>">
								<input type="hidden" name="ids" class="form-control" value="<?=$idptk;?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Password</label>
								<input type="password" name="password" class="form-control">
							  </div>
							</div>
							
							
					  </div>
					  <div class="card-footer text-center pt-0">
						<div class="row">
						  <div class="form-group col-md-6 col-6">
							<a href="ptk" class="btn btn-primary">Kembali</a>
						  </div>
						  <div class="form-group col-md-6 col-6">
							<button class="btn btn-primary">Simpan</button>
						  </div>
						</div>
					  </div>
					  </form>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-8">
					<form method="post" class="needs-validation" action="../modul/ptk/updatePTK.php" id="ubahForm">
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
						  <li class="nav-item">
							<a class="nav-link" id="SK-tab2" data-toggle="tab" href="#SK" role="tab"
							  aria-selected="false">SK Pengangkatan</a>
						  </li>
						</ul>
						<div class="tab-content tab-bordered" id="myTab3Content">
						  <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
							<div class="row">
							  <div class="form-group col-md-10 col-10">
								<label>Nama Lengkap</label>
								<input type="text" name="nama" class="form-control" value="<?=$biom['nama'];?>" required="">
								<input type="hidden" name="ptkid" class="form-control" value="<?=$biom['ptk_id'];?>">
							  </div>
							  <div class="form-group col-md-2 col-2">
								<label>Gelar</label>
								<input type="text" name="gelar" class="form-control" value="<?=$biom['gelar'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jeniskelamin" id="jeniskelamin">
									<option value="L" <?php if($biom['jenis_kelamin']=='L') echo "selected"; ?>>Laki-laki</option>
									<option value="P" <?php if($biom['jenis_kelamin']=='P') echo "selected"; ?>>Perempuan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NIK</label>
								<input type="text" name="nik" class="form-control" value="<?=$biom['nik'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat" class="form-control" value="<?=$biom['tempat_lahir'];?>" required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggallahir" class="form-control datepicker" value="<?=$biom['tanggal_lahir'];?>" required="">
							  </div>
							</div>	
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Alamat</label>
								<input type="text" name="alamat" class="form-control" value="<?=$biom['alamat_jalan'];?>">
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIY/NIGK</label>
								<input type="text" name="niynigk" autocomplete=off class="form-control" value="<?=$biom['niy_nigk'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NUPTK</label>
								<input type="text" name="nuptk" autocomplete=off class="form-control" value="<?=$biom['nuptk'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>No HP</label>
								<input type="text" name="noHP" class="form-control" value="<?=$biom['no_hp'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Email</label>
								<input type="text" name="email" class="form-control" value="<?=$biom['email'];?>">
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
									<option value="<?=$statuspeg['status_kepegawaian_id'];?>" <?php if($biom['status_kepegawaian_id']==$statuspeg['status_kepegawaian_id']) echo "selected"; ?>><?=$statuspeg['nama'];?></option>
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
									<option value="<?=$statusptk['jenis_ptk_id'];?>" <?php if($biom['jenis_ptk_id']==$statusptk['jenis_ptk_id']) echo "selected"; ?>><?=$statusptk['jenis_ptk'];?></option>
									<?php };?>
								</select>
							  </div>
							</div>	
						</div>
						<div class="tab-pane fade" id="SK" role="tabpanel" aria-labelledby="SK-tab2"> <!-- SK -->
							<div class="table-responsive">
								<table id="SKTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="text-center">Tanggal SK</th>
											<th class="text-center">Nomor SK</th>
											<th class="text-center">Jabatan</th>
											<th class="text-center">Pejabat Pengangkat</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>
																
									</tbody>
								</table>
							</div>
						</div>
					  </div>
					  <div class="card-footer text-right">
						<button class="btn btn-primary">Save Changes</button>
					  </div>
					</div> <!--akhir card-->
					</form>
  
				</div>
				<?php }} ?>
			</div>
          </div>
        </section>
		<!--Tambah SK-->
		<div class="modal fade" id="tambahSK">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah SK</h4>
              </div>
				<form class="form-horizontal" action="../modul/ptk/tambahSK.php" autocomplete="off" method="POST" id="tambahSKForm">
					<div class="fetched-data"></div>
				</form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		<!--Modal Mutasi Guru-->
		<div class="modal fade" id="myModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Mutasi Guru</h4>
              </div>
                        <form class="form-horizontal" action="../modul/ptk/mutasiGuru.php" autocomplete="off" method="POST" id="mutasiGuruForm">
							<div class="fetched-data"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		<!--modal upload foto-->
		<div id="uploadimageModal" class="modal" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Upload & Crop Image</h4>
						</div>
						<div class="modal-body">
							<div id="image_demo" style="width:350px; margin-top:30px"></div>
							<button class="btn btn-success crop_image">Crop & Upload Image</button>
						</div>
						
					</div>
				</div>
			</div>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="croppie.js"></script>
	<script>  
	var manageMemberTable;
	var SKTable;
	var status = $('#status').val();
$(document).ready(function(){
	$("#manageMemberTable").dataTable({
		"destroy":true,
		"searching": true,
		"paging":true,
		"ajax": "../modul/ptk/ptk.php?status="+status,
		stateSave: true,
		"order": []
	});
	$('#status').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var status = $('#status').val();
			$("#manageMemberTable").dataTable({
				"destroy":true,
			  "searching": true,
			  "paging":true,
			  "ajax": "../modul/ptk/ptk.php?status="+status,
				"order": []
			});
	});
	SKTable = $("#SKTable").DataTable({
		"destroy":true,
		"searching": false,
		"paging":false,
		"ajax": "../modul/ptk/lihatSK.php?idp=<?=$idptk;?>",
		"order": []
	});
	$('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/ptk/modal_mutasi.php',
                data :  'rowid='+ rowid,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
	

    $image_crop = $('#image_demo').croppie({
		enableExif: true,
		viewport: {
		  width:200,
		  height:200,
		  type:'square' //circle
		},
		boundary:{
		  width:300,
		  height:300
		}
	});

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"uploadfoto.php?idp=<?=$idptk;?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
		  swal('Foto Profil berhasil diubah', {buttons: false,timer: 1000,});
        }
      });
    })
  });
  
	$("#mutasiGuruForm").unbind('submit').bind('submit', function() {

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
								$("#myModal").modal('hide');
								//manageMemberTable.ajax.reload(null, false);
								setTimeout(function () {window.open("ptk","_self");},100)
								// reset the form
							
							} else {
								swal(response.messages, {buttons: false,timer: 1000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
	$("#ubahForm").unbind('submit').bind('submit', function() {

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
	$("#ubahPass").unbind('submit').bind('submit', function() {

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
								//setTimeout(function () {window.open("pengguna","_self");},500)
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
  <script>
  
  
  </script>
</body>
</html>