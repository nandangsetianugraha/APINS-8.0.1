<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Beranda';
//view('template/head', $data);
include "../template/head.php";
$jtot=mysqli_query($koneksi, "select * from siswa where status=1");
$jjum=mysqli_num_rows($jtot);
if($jjum==0){
	$jjum=1;
};
$jper=mysqli_query($koneksi, "select * from siswa where jk='P' and status=1");
$jjper=mysqli_num_rows($jper);
$jlak=mysqli_query($koneksi, "select * from siswa where jk='L' and status=1");
$jjlak=mysqli_num_rows($jlak);
$jromb=mysqli_query($koneksi, "select * from rombel where tapel='$tapel'");
$jjromb=mysqli_num_rows($jromb);
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
		  <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Jumlah Rombel</h5>
                          <h2 class="mb-3 font-18"><?=$jjromb;?></h2>
                          <p class="mb-0"><span class="col-green">10%</span> Increase</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url(); ?>assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Laki-laki</h5>
                          <h2 class="mb-3 font-18"><?=$jjlak;?></h2>
                          <p class="mb-0"><span class="col-orange"><?=round(($jjlak/$jjum)*100,2);?>%</span> Siswa</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url(); ?>assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Perempuan</h5>
                          <h2 class="mb-3 font-18"><?=$jjper;?></h2>
                          <p class="mb-0"><span class="col-green"><?=round(($jjper/$jjum)*100,2);?>%</span>
                            Siswa</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url(); ?>assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Jumlah Siswa</h5>
                          <h2 class="mb-3 font-18"><?=$jjum;?></h2>
                          <p class="mb-0"><span class="col-green"><?=$tapel;?></span></p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url(); ?>assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-sm-4">
			<div class="col-12 col-md-12 col-lg-4">
				<div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="<?= base_url(); ?>images/ptk/<?=$avatar;?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Posts</div>
                        <div class="profile-widget-item-value">225</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Followers</div>
                        <div class="profile-widget-item-value">9,3K</div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Following</div>
                        <div class="profile-widget-item-value">3,7K</div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name"><?=$bioku['nama'];?> <div class="text-muted d-inline font-weight-normal">
                        <br> <?=$jns_ptk['jenis_ptk'];?>
                      </div>
                    </div>
					<div class="py-4">
                      <p class="clearfix">
                        <span class="float-left">
                          Birthday
                        </span>
                        <span class="float-right text-muted">
                          <?=$bioku['tanggal_lahir'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Phone
                        </span>
                        <span class="float-right text-muted">
                          <?=$bioku['no_hp'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Mail
                        </span>
                        <span class="float-right text-muted">
                          <?=$bioku['email'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Facebook
                        </span>
                        <span class="float-right text-muted">
                          <a href="#"><?=$bioku['nama'];?></a>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Twitter
                        </span>
                        <span class="float-right text-muted">
                          <a href="#">@<?=$bioku['nama'];?></a>
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="card-footer text-center pt-0">
                    <div class="font-weight-bold mb-2 text-small">Follow <?=$bioku['nama'];?> On</div>
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
                <div class="card-header">
                  <h4><i class="fas fa-bullhorn"></i> Log Activity</h4>
                  <div class="card-header-form">
                   
                  </div>
                </div>
                <div class="card-body">
					<div id="screen"></div>
				</div>
              </div>
            </div>
		  </div>
		  <div class="row mt-sm-4">
			<div class="col-12 col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-bullhorn"></i> Pengumuman</h4>
                  <div class="card-header-form">
                    <a href="#" class="btn btn-info btn-border btn-sm">
												<span class="btn-label">
													<i class="fa fa-plus"></i>
												</span> Pengumuman
											</a>
                  </div>
                </div>
                <div class="card-body">
					<?php 
					$nad=mysqli_query($koneksi, "select * from ptk where jenis_ptk_id='11'");
					$namaadmin=mysqli_fetch_array($nad);
					$brt=mysqli_query($koneksi, "select * from pengumuman order by waktu desc limit 3");
					$jbrt=mysqli_num_rows($brt);
					if($jbrt>0){
					?>
                  <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
					<?php 
					while($pg=mysqli_fetch_array($brt)){
					?>
					<li class="media">
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="../images/ptk/<?=$namaadmin['gambar'];?>">
                        <div class="media-body">
                          <div class="media-right">
                            <div class="text-primary">Approved</div>
                          </div>
                          <div class="media-title mb-1"><?=$namaadmin['nama'];?></div>
                          <div class="text-time"><?=$pg['waktu'];?></div>
                          <div class="media-description text-muted"><?=$pg['berita'];?></div>
                          <div class="media-links">
                            <a href="#">View</a>
                            <div class="bullet"></div>
                            <a href="#">Edit</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#hapusberitaModal" onclick="hapusBerita('<?=$pg['id'];?>')">Trash</a>
                          </div>
                        </div>
                    </li>
					<?php } ?>
					<?php }else{ ?>
					<div class="alert alert-info alert-dismissible">
						<h4><i class="icon fa fa-info-circle"></i> Informasi</h4>
						Belum Ada Pengumuman
					</div>
					<?php } ?>
				  </ul>
                </div>
              </div>
            </div>
		  </div>
        </section>
		<div class="modal fade" id="hapusberitaModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus</h4>
              </div>
                        <div class="modal-body">
							<p>Hapus Berita?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light" id="removeBtn">Ya</button>
                        </div>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script>
	$(document).ready(function(){
		setInterval(function(){
			$("#screen").load('banners.php')
		}, 2000);
	});
  </script>	
  <script>
  function hapusBerita(id = null) {
		if(id) {
			// click on remove button
			$("#removeBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/berita/hapus.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 2000,});

							setTimeout(function () {window.open("./","_self");},1000);
							// close the modal
							$("#hapusberitaModal").modal('hide');

						} else {
							swal(response.messages, {buttons: false,timer: 3000,});
						}
					}
				});
			}); // click remove btn
		} else {
			alert('Error: Refresh the page again');
		}
	}
  </script>
</body>
</html>