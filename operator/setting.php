<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Setting Aplikasi';
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
							<img src="<?= base_url(); ?>images/logo/<?=$cfg['logo'];?>" alt="..." class="rounded-circle profile-widget-picture">
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
                    <div class="profile-widget-name"><?=$cfg['nama_sekolah'];?> <br>
					  <div class="text-muted d-inline font-weight-normal">
                        <?=$cfg['alamat_sekolah'];?>
                      </div>
                    </div>
					<div class="py-4">
                      <p class="clearfix">
                        <span class="float-left">
                          Tahun Pelajaran
                        </span>
                        <span class="float-right text-muted">
                          <?=$cfg['tapel'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Semester
                        </span>
                        <span class="float-right text-muted">
                          <?=$cfg['semester'];?>
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="card-footer text-center pt-0">
                    <div class="font-weight-bold mb-2 text-small">Follow <?=$cfg['nama_sekolah'];?> On</div>
                    <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon mr-1 btn-github">
                      <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                      <i class="fab fa-instagram"></i>
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
							  aria-selected="false">SK Pengangkatan</a>
						  </li>
						</ul>
						<div class="tab-content tab-bordered" id="myTab3Content">
						  <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Nama Lengkap</label>
								<input type="text" name="nama" class="form-control" value="<?=$bioku['nama'];?>" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Jenis Kelamin</label>
								<select class="form-control" name="jk" id="jk">
									<option value="L" <?php if($bioku['jenis_kelamin']=='L') echo "selected"; ?>>Laki-laki</option>
									<option value="P" <?php if($bioku['jenis_kelamin']=='P') echo "selected"; ?>>Perempuan</option>
								</select>
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NIK</label>
								<input type="text" name="nik" class="form-control" value="<?=$bioku['nik'];?>" required="">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>Tempat Lahir</label>
								<input type="text" name="tempat" class="form-control" value="<?=$bioku['tempat_lahir'];?>" required="">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Tanggal Lahir</label>
								<input type="text" name="tanggal" class="form-control datepicker" value="<?=$bioku['tanggal_lahir'];?>" required="">
							  </div>
							</div>	
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>NIY/NIGK</label>
								<input type="text" name="nis" class="form-control" value="<?=$bioku['niy_nigk'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>NUPTK</label>
								<input type="text" name="nisn" class="form-control" value="<?=$bioku['nuptk'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-6 col-12">
								<label>No HP</label>
								<input type="text" name="pend_seb" class="form-control" value="<?=$bioku['no_hp'];?>">
							  </div>
							  <div class="form-group col-md-6 col-12">
								<label>Email</label>
								<input type="text" name="pend_seb" class="form-control" value="<?=$bioku['email'];?>">
							  </div>
							</div>
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Jenis PTK</label>
								<input type="text" name="alamat" class="form-control" value="<?=$jns_ptk['jenis_ptk'];?>">
							  </div>
							</div>
						  </div>
						  <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2"> <!-- Keluarga -->
							<div class="table-responsive">
								<table class="table table-sm">
								<thead>
								  <tr>
									<th scope="col">Tanggal</th>
									<th scope="col">Nomor SK</th>
									<th scope="col">Jabatan</th>
									<th scope="col">Pejabat Pengangkat</th>
									<th scope="col">Print</th>
								  </tr>
								</thead>
								<tbody>
								<?php 
								$sql_sk=mysqli_query($koneksi, "select * from sk where ptk_id='$idku' order by tanggal_sk desc");
								while($skku = mysqli_fetch_array($sql_sk)){
									$idsk=$skku['id_sk'];
								?>
									<tr>
										<th scope="row"><?=$skku['tanggal_sk'];?></th>
										<td><?=$skku['no_sk'];?></td>
										<td><?=$skku['jabatan'];?></td>
										<td><?=$skku['pengangkat'];?></td>
										<td><a href="../cetak/cetakSK.php?id=<?=$idsk;?>&idptk=<?=$idku;?>" class="btn btn-info btn-border btn-round btn-sm"><i class="fas fa-print"></i></a></td>
									</tr>
								<?php } ?>
								</tbody>
								</table>
							</div>
						  </div>
						</div>
					  </div>
					</div> <!--akhir card-->
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
        url:"uploadlogo.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
		  swal('Logo berhasil diubah', {buttons: false,timer: 1000,});
		  setTimeout(function () {window.open("setting","_self");},1000)
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
</body>
</html>