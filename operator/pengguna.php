<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Daftar Pengguna';
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
		include "sidebar.php";
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
					  <h4>Daftar Pengguna</h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Username</th>
									<th>Password</th>
									<th>Nama Pengguna</th>
									<th>Level</th>
									<th>Verifikasi</th>
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
					if($idsiswa=="0"){
					}else{
						$biom = mysqli_fetch_array(mysqli_query($koneksi, "select * from pengguna where ptk_id='$idsiswa'"));
						$biop = mysqli_fetch_array(mysqli_query($koneksi, "select * from ptk where ptk_id='$idsiswa'"));
						if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$biop['gambar'])){
							$avatarm=$biop['gambar'];
						}else{
							$avatarm="user-default.png";
						};
				?>
				<div class="col-12 col-md-12 col-lg-4">
					<div class="card profile-widget">
					  <div class="profile-widget-header">
						<div id="uploaded_image">
							<img src="../images/ptk/<?=$avatarm;?>" alt="..." class="rounded-circle profile-widget-picture">
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
					    <div class="profile-widget-name"><?=$biop['nama'];?> 
						  
						</div>
						<div class="py-4">
						  <p class="clearfix">
							<span class="float-left">
							  Tempat Lahir
							</span>
							<span class="float-right text-muted">
							  <?=$biop['tempat_lahir'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  Tanggal Lahir
							</span>
							<span class="float-right text-muted">
							  <?=$biop['tanggal_lahir'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  NIY
							</span>
							<span class="float-right text-muted">
							  <?=$biop['niy_nigk'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  NUPTK
							</span>
							<span class="float-right text-muted">
							  <a href="#"><?=$biop['nuptk'];?></a>
							</span>
						  </p>
						</div>
					  </div>
					  <div class="card-footer text-center pt-0">
						<a href="pengguna" class="btn btn-primary">
						  Kembali
						</a>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-8">
					<div class="card">
					  <div class="padding-20">
						<ul class="nav nav-tabs" id="myTab2" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
							  aria-selected="true">Biodata</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
							  aria-selected="false">Keluarga</a>
						  </li>
						</ul>
						<div class="tab-content tab-bordered" id="myTab3Content">
						  <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Nama Lengkap</label>
								<input type="text" name="nama" class="form-control" value="<?=$biop['nama'];?>" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jk" id="jk">
									<option value="L" <?php if($biop['jenis_kelamin']=='L') echo "selected"; ?>>Laki-laki</option>
									<option value="P" <?php if($biop['jenis_kelamin']=='P') echo "selected"; ?>>Perempuan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NIK</label>
								<input type="text" name="nik" class="form-control" value="<?=$biop['nik'];?>" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat" class="form-control" value="<?=$biop['tempat_lahir'];?>" required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggal" class="form-control datepicker" value="<?=$biop['tanggal_lahir'];?>" required="">
							  </div>
							</div>	
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIY</label>
								<input type="text" name="nis" class="form-control" value="<?=$biop['niy_nigk'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NUPTK</label>
								<input type="text" name="nisn" class="form-control" value="<?=$biop['nuptk'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Alamat Lengkap</label>
								<input type="text" name="alamat" class="form-control" value="<?=$biop['alamat_jalan'];?>">
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<form method="post" class="needs-validation" action="../modul/ptk/updatepassword.php" id="ubahForm">
							<div class="card">
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Username</label>
								<input type="text" name="username" class="form-control" value="<?=$biom['username'];?>">
								<input type="hidden" name="ids" class="form-control" value="<?=$biom['ptk_id'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Password</label>
								<input type="password" name="password" class="form-control" value="<?=$biom['password'];?>">
							  </div>
							</div>
							<div class="card-footer text-right">
								<button class="btn btn-primary">Save Changes</button>
							</div>
							
							</div>
							</form>
						  </div>
						</div>
					  </div>
					  
					</div> <!--akhir card-->
					
  
				</div>
				<?php }} ?>
			</div>
          </div>
        </section>
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
$(document).ready(function(){
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/ptk/pengguna.php",
	  "columnDefs": [
		{ "sortable": false, "targets": [5] }
	  ]
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
        url:"uploadptk.php?idp=<?=$idsiswa;?>",
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
								setTimeout(function () {window.open("pengguna","_self");},1000)
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