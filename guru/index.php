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
$sq2=mysqli_query($koneksi, "select * from penempatan JOIN siswa USING(peserta_didik_id) where siswa.jk='L' and penempatan.rombel='$kelas' and penempatan.tapel='$tapel'");
$sq3=mysqli_query($koneksi, "select * from penempatan JOIN siswa USING(peserta_didik_id) where siswa.jk='P' and penempatan.rombel='$kelas' and penempatan.tapel='$tapel'");
$juml=mysqli_num_rows($sq2);
$jump=mysqli_num_rows($sq3);
$jtot=mysqli_query($koneksi, "select * from siswa where status=1");
$jjum=mysqli_num_rows($jtot);
if($jjum==0){
	$jjum=1;
};
$jper=mysqli_query($koneksi, "select * from siswa where jk='P' and status=1");
$jjper=mysqli_num_rows($jper);
$jlak=mysqli_query($koneksi, "select * from siswa where jk='L' and status=1");
$jjlak=mysqli_num_rows($jlak);
$total=$juml+$jump;
if($total==0){
	$total=1;
};
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
		  <?php if($norombel){ ?>
		  <div class="alert alert-warning">
            <div class="alert-title">Warning</div>
            Anda Belum ditempatkan di rombel manapun
          </div>
		  <?php }else{ ?>
		  <?php if($level==98 or $level==97){ ?>
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Rombel</h5>
                          <h2 class="mb-3 font-18"><?=$kelas;?></h2>
                          <p class="mb-0"><span class="col-green"><?=$jjromb;?></span> Rombel</p>
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
                          <h2 class="mb-3 font-18"><?=$juml;?></h2>
                          <p class="mb-0"><span class="col-orange"><?=round(($juml/$total)*100,2);?>%</span> Siswa</p>
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
                          <h2 class="mb-3 font-18"><?=$jump;?></h2>
                          <p class="mb-0"><span class="col-green"><?=round(($jump/$total)*100,2);?>%</span>
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
                          <h2 class="mb-3 font-18"><?=$total;?></h2>
                          <p class="mb-0"><span class="col-green"><?=round(($total/$jjum)*100,2);?>%</span> Siswa</p>
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
		  <?php }} ?>
          <div class="row mt-sm-4">
			<div class="col-12 col-md-12 col-lg-4">
				<div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="<?= base_url(); ?>images/ptk/<?=$avatar;?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Posts</div>
                        <div class="profile-widget-item-value"><?=rand(10,100);?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Followers</div>
                        <div class="profile-widget-item-value"><?=rand(10,10000);?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Following</div>
                        <div class="profile-widget-item-value"><?=rand(10,1000);?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name"><?=$bioku['nama'];?> <br><div class="text-muted d-inline font-weight-normal">
                        <?=$jns_ptk['jenis_ptk'];?>
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
				<!-- Support tickets -->
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-bullhorn"></i> Pengumuman</h4>
                  <form class="card-header-form">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                  </form>
                </div>
                <div class="card-body">
					<?php 
					$nad=mysqli_query($koneksi, "select * from ptk where jenis_ptk_id='11'");
					$namaadmin=mysqli_fetch_array($nad);
					$brt=mysqli_query($koneksi, "select * from pengumuman order by waktu desc limit 3");
					$jbrt=mysqli_num_rows($brt);
					if($jbrt>0){
						while($pg=mysqli_fetch_array($brt)){
					?>
                  <div class="support-ticket media pb-1 mb-3">
                    <img src="../images/ptk/<?=$namaadmin['gambar'];?>" class="user-img mr-2" alt="">
                    <div class="media-body ml-3">
						<div class="badge badge-pill <?php if($pg['tipe']=="Pengumuman") {echo "badge-success";}elseif($pg['tipe']=="Bug") {echo "badge-warning";}elseif($pg['tipe']=="Fix") {echo "badge-primary";}else{echo "badge-info";} ?> mb-1 float-right"><?=$pg['tipe'];?></div>
                      <span class="font-weight-bold">#89754</span>
                      <a href="javascript:void(0)"><?=$pg['judul'];?></a>
                      <p class="my-1"><?=$pg['berita'];?></p>
                      <small class="text-muted">Created by <span class="font-weight-bold font-13"><?=$namaadmin['nama'];?></span>
                        &nbsp;&nbsp; - <?=$pg['waktu'];?></small>
                    </div>
                  </div>
						<?php } ?>
					<?php }else { ?>
					<div class="alert alert-info alert-dismissible">
						<h4><i class="icon fa fa-info-circle"></i> Informasi</h4>
						Belum Ada Pengumuman
					</div>
					<?php } ?>
                </div>
                <a href="javascript:void(0)" class="card-footer card-link text-center small ">View
                  All</a>
              </div>
              <!-- Support tickets -->
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
  $("#manageMemberTable").dataTable({
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/siswa/siswad.php?kelas=<?=$kelas;?>&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "order": []
	});
  </script>
</body>
</html>