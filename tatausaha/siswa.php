<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Daftar Siswa';
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
					  <h4>Daftar Siswa Tahun Pelajaran <?=$tapel;?></h4>
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
					  <div class="table-responsive">
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>NIS</th>
									<th>NISN</th>
									<th>TTL</th>
									<th>JK</th>
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
						$biom = mysqli_fetch_array(mysqli_query($koneksi, "select * from siswa where peserta_didik_id='$idsiswa'"));
						$rombel = mysqli_fetch_array(mysqli_query($koneksi, "select * from penempatan where peserta_didik_id='$idsiswa' and tapel='$tapel'"));
						if(file_exists( "https://apins.sdi-aljannah.web.id/images/siswa/".$biom['avatar'])){
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
							<div class="profile-widget-item-label"><br/></div>
							<div class="profile-widget-item-value"><div id="imgChange"><span>Ubah Foto</span>
															<input type="file" accept="image/*" name="upload_image" id="upload_image">
														</div></div>
						  </div>
						</div>
					  </div>
					  <div class="profile-widget-description pb-0">
					    <div class="profile-widget-name"><?=$biom['nama'];?></div>
						<div class="py-4">
						  <p class="clearfix">
							<span class="float-left">
							  Tempat Lahir
							</span>
							<span class="float-right text-muted">
							  <?=$biom['tempat'];?>
							</span>
						  </p>
						  <p class="clearfix">
							<span class="float-left">
							  Tanggal Lahir
							</span>
							<span class="float-right text-muted">
							  <?=$biom['tanggal'];?>
							</span>
						  </p>
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
							  <a href="#"><?=$biom['nisn'];?></a>
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
					<form method="post" class="needs-validation" action="../modul/siswa/updatesiswa.php" id="ubahForm">
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
								<input type="text" name="nama" class="form-control" value="<?=$biom['nama'];?>" required="">
								<input type="hidden" name="ids" class="form-control" value="<?=$biom['peserta_didik_id'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jk" id="jk">
									<option value="L" <?php if($biom['jk']=='L') echo "selected"; ?>>Laki-laki</option>
									<option value="P" <?php if($biom['jk']=='P') echo "selected"; ?>>Perempuan</option>
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
								<input type="text" name="tempat" class="form-control" value="<?=$biom['tempat'];?>" required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggal" class="form-control datepicker" value="<?=$biom['tanggal'];?>" required="">
							  </div>
							</div>	
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIS</label>
								<input type="text" name="nis" class="form-control" value="<?=$biom['nis'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NISN</label>
								<input type="text" name="nisn" class="form-control" value="<?=$biom['nisn'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Agama</label>
								<select class="form-control" name="agama" id="agama">
									<option value="0" <?php if($biom['agama']==0) echo "selected"; ?>>Belum Diisi</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from agama");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_agama'];?>" <?php if($biom['agama']==$nk['id_agama']) echo "selected"; ?>><?=$nk['nama_agama'];?></option>
									<?php };?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Pendidikan Sebelumnya</label>
								<input type="text" name="pend_seb" class="form-control" value="<?=$biom['pend_sebelum'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Alamat Lengkap</label>
								<input type="text" name="alamat" class="form-control" value="<?=$biom['alamat'];?>">
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Nama Ayah</label>
								<input type="text" name="ayah" class="form-control" value="<?=$biom['nama_ayah'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Nama Ibu</label>
								<input type="text" name="ibu" class="form-control" value="<?=$biom['nama_ibu'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Pekerjaan Ayah</label>
								<select class="form-control" name="pek_ayah" id="pek_ayah">
									<option value="0" <?php if($biom['pek_ayah']==0 || empty($biom['pek_ayah'])) echo "selected"; ?>>Belum Diisi</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from pekerjaan");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_pekerjaan'];?>" <?php if($biom['pek_ayah']==$nk['id_pekerjaan']) echo "selected"; ?>><?=$nk['nama_pekerjaan'];?></option>
									<?php };?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Pekerjaan Ibu</label>
								<select class="form-control" name="pek_ibu" id="pek_ibu">
									<option value="0" <?php if($biom['pek_ibu']==0 || empty($biom['pek_ibu'])) echo "selected"; ?>>Belum Diisi</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from pekerjaan");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_pekerjaan'];?>" <?php if($biom['pek_ibu']==$nk['id_pekerjaan']) echo "selected"; ?>><?=$nk['nama_pekerjaan'];?></option>
									<?php };?>
								</select>
							  </div>
							</div>	
							<div class="section-title">Alamat Orang Tua</div>
							<?php $id_prov=$biom['provinsi']; ?>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Provinsi</label>
								<select class="form-control" name="provinsi" id="provinsi">
									<option>Pilih Provinsi</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from provinsi");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id_prov'];?>" <?php if($id_prov==$nk['id_prov']){echo "selected";}; ?>><?=$nk['nama'];?></option>
									<?php }	?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Kabupaten</label>
								<select class="form-control" name="kabupaten" id="kabupaten">
									<?php 
									$id_kab=$biom['kabupaten'];
									$sql_mk=mysqli_query($koneksi, "select * from kabupaten where id_provinsi='$id_prov'");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id'];?>" <?php if($id_kab==$nk['id']){echo "selected";}; ?>><?=$nk['nama'];?></option>
									<?php }	?>
								</select>
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Kecamatan</label>
								<select class="form-control" name="kecamatan" id="kecamatan">
									<?php 
									$id_kec=$biom['kecamatan'];
									$sql_mk=mysqli_query($koneksi, "select * from kecamatan where id_kabupaten='$id_kab'");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id'];?>" <?php if($id_kec==$nk['id']){echo "selected";}; ?>><?=$nk['nama'];?></option>
									<?php }	?>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Desa/Kelurahan</label>
								<select class="form-control" name="kelurahan" id="kelurahan">
									<?php 
									$id_desa=$biom['kelurahan'];
									$sql_mk=mysqli_query($koneksi, "select * from desa where id_kecamatan='$id_kec'");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?=$nk['id'];?>" <?php if($id_desa==$nk['id']){echo "selected";}; ?>><?=$nk['nama'];?></option>
									<?php }	?>
								</select>
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Jalan/Blok</label>
								<input type="text" name="jalan" class="form-control" value="<?=$biom['jalan'];?>">
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
	var kelas = $('#kelas').val();
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": true,
	  "paging":true,
	  "ajax": "../modul/siswa/siswa.php?kelas="+kelas+"&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "columnDefs": [
		{ "sortable": false, "targets": [5] }
	  ]
	});
	$('#kelas').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kelas = $('#kelas').val();
			$("#manageMemberTable").dataTable({
				"destroy":true,
			  "searching": true,
			  "paging":true,
			  "ajax": "../modul/siswa/siswa.php?kelas="+kelas+"&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
			  "columnDefs": [
				{ "sortable": false, "targets": [5] }
			  ]
			});
	});
	$('#provinsi').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var prov = $('#provinsi').val();
			$.ajax({
				type : 'GET',
				url : '../function/kabupaten.php',
				data :  'prov_id=' + prov,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kabupaten").html(data);
				}
			});
	});

	$('#kabupaten').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kab = $('#kabupaten').val();
			$.ajax({
				type : 'GET',
				url : '../function/kecamatan.php',
				data :  'id_kabupaten=' + kab,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kecamatan").html(data);
				}
			});
	});

	$('#kecamatan').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var desa = $('#kecamatan').val();
			$.ajax({
				type : 'GET',
				url : '../function/desa.php',
				data :  'id_kecamatan=' + desa,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kelurahan").html(data);
					// alert($('#provinsi option:selected').text() + $('#kabupaten option:selected').text() + $('#kecamatan option:selected').text() + $('#desa option:selected').text());
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
        url:"upload.php?idp=<?=$idsiswa;?>",
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
								setTimeout(function () {window.open("siswa","_self");},1000)
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