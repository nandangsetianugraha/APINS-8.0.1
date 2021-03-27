<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Tambah Siswa Baru';
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
				<div class="col-12 col-md-12 col-lg-4">
					<div class="card profile-widget">
					  <div class="profile-widget-header">
						<div id="uploaded_image">
							<img src="<?= base_url(); ?>images/siswa/user-default.png" alt="..." class="rounded-circle profile-widget-picture">
						</div>
						<div class="profile-widget-items">
						  <div class="profile-widget-item">
							<div class="profile-widget-item-label"><br/></div>
							<div class="profile-widget-item-value"><div id="imgChange"><span>Upload Foto</span>
															<input type="file" accept="image/*" name="upload_image" id="upload_image">
														</div></div>
						  </div>
						</div>
					  </div>
					  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name"> <div class="text-muted d-inline font-weight-normal">
                      </div>
                    </div>
				  </div>
                  <div class="card-footer text-center pt-0">
                  </div>
				  
					</div>
				</div>
			<div class="col-12 col-md-12 col-lg-8">
					<form method="post" class="needs-validation" action="../modul/siswa/tambahSiswa.php" id="tambahSiswaForm">
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
								<input type="text" name="nama" class="form-control" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jk" id="jk">
									<option value="L" >Laki-laki</option>
									<option value="P" >Perempuan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NIK</label>
								<input type="text" name="nik" class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat" class="form-control" required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggal" class="form-control datepicker" required="">
							  </div>
							</div>	
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIS</label>
								<input type="text" name="nis" class="form-control">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NISN</label>
								<input type="text" name="nisn" class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Agama</label>
								<select class="form-control" name="agama" id="agama">
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from agama");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_agama'];?>"><?=$nk['nama_agama'];?></option>
									<?php };?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Pendidikan Sebelumnya</label>
								<input type="text" name="pend_seb" class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Alamat Lengkap</label>
								<input type="text" name="alamat" class="form-control">
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Nama Ayah</label>
								<input type="text" name="ayah" class="form-control">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Nama Ibu</label>
								<input type="text" name="ibu" class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Pekerjaan Ayah</label>
								<select class="form-control" name="pek_ayah" id="pek_ayah">
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from pekerjaan");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_pekerjaan'];?>"><?=$nk['nama_pekerjaan'];?></option>
									<?php };?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Pekerjaan Ibu</label>
								<select class="form-control" name="pek_ibu" id="pek_ibu">
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from pekerjaan");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_pekerjaan'];?>"><?=$nk['nama_pekerjaan'];?></option>
									<?php };?>
								</select>
							  </div>
							</div>	
							<div class="section-title">Alamat Orang Tua</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Jalan/Blok</label>
								<input type="text" name="jalan" class="form-control">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Provinsi</label>
								<select class="form-control" name="provinsi" id="provinsi">
									<option>Pilih Provinsi</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from provinsi");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_prov'];?>"><?=$nk['nama'];?></option>
									<?php }	?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Kabupaten</label>
								<select class="form-control" name="kabupaten" id="kabupaten">
									<option value="0">Pilih Kabupaten</option>
								</select>
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Kecamatan</label>
								<select class="form-control" name="kecamatan" id="kecamatan">
									<option value="0">Pilih Kecamatan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Desa/Kelurahan</label>
								<select class="form-control" name="kelurahan" id="kelurahan">
									<option value="0">Pilih Kelurahan</option>
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
					</form>
  
				</div>
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
        url:"uploadfoto.php?idp=<?=$idku;?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
		  swal('Foto Profil berhasil diubah', {buttons: false,timer: 1000,});
		  setTimeout(function () {window.open("profile","_self");},1000)
        }
      });
    })
  });
		$('#provinsi').change(function(){
			var prov = $('#provinsi').val();
			$.ajax({
				type : 'GET',
				url : '../function/kabupaten.php',
				data :  'prov_id=' + prov,
				success: function (data) {
					$("#kabupaten").html(data);
				}
			});
		});
		$('#kabupaten').change(function(){
			var kab = $('#kabupaten').val();
			$.ajax({
				type : 'GET',
				url : '../function/kecamatan.php',
				data :  'id_kabupaten=' + kab,
				success: function (data) {
					$("#kecamatan").html(data);
				}
			});
		});
		$('#kecamatan').change(function(){
			var desa = $('#kecamatan').val();
			$.ajax({
				type : 'GET',
				url : '../function/desa.php',
				data :  'id_kecamatan=' + desa,
				success: function (data) {
					$("#kelurahan").html(data);
				}
			});
		});
  
  $("#tambahSiswaForm").unbind('submit').bind('submit', function() {
						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 1000,});
										setTimeout(function () {window.open("add-siswa","_self");},1000)
				
									} else {
										swal(response.messages, {buttons: false,timer: 1000,});
									}
								} 
							}); 

						return false;
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
								setTimeout(function () {window.open("add-siswa","_self");},1000)
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