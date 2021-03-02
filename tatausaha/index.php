<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
$data['title'] = 'Beranda';
//view('template/head', $data);
include "../template/head.php";
date_default_timezone_set('Asia/Jakarta');
$labels = ["Juli","Agustus","September","Oktober","November","Desember","Januari","Februari","Maret","April","Mei","Juni"];
$label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
for($bulan = 1;$bulan < 13;$bulan++)
{
	$query = mysqli_query($koneksi,"select sum(bayar) as jumlah from pembayaran where MONTH(tanggal)='$bulan' and tapel='$tapel' and jenis='1'");
	$row = $query->fetch_array();
	$jumlah_produk[] = $row['jumlah'];
	$query1 = mysqli_query($koneksi,"select sum(bayar) as jumlahnya from pembayaran where MONTH(tanggal)='$bulan' and tapel='$tapel' and jenis<>'1'");
	$row1 = $query1->fetch_array();
	$jumlahlain[] = $row1['jumlahnya'];
}
$kemarin = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
$sekarang=date('Y-m-d');
$bulannow=date('m');
$blnkemarin=(int) $bulannow-1;
$blnsppnow=(int) $bulannow-1;
if($blnsppnow==0){
	$blnsppkemarin=11;
}else{
	$blnsppkemarin=$blnsppnow-1;
};
if($blnkemarin==0){
	$blnkemarin=12;
};
if($blnkemarin<10){
	$blnnya="0".$blnkemarin;
}else{
	$blnnya=$blnkemarin;
};
$jper=mysqli_query($koneksi, "select * from siswa where jk='P' and status=1");
$jjper=mysqli_num_rows($jper);
$jlak=mysqli_query($koneksi, "select * from siswa where jk='L' and status=1");
$jjlak=mysqli_num_rows($jlak);
$total=$jjlak+$jjper;
if($total==0){
	$total=1;
};
$jromb=mysqli_query($koneksi, "select * from rombel where tapel='$tapel'");
$jjromb=mysqli_num_rows($jromb);
$lapkemarinini=mysqli_query($koneksi, "select sum(bayar) as totalbayarkemarin from pembayaran where tanggal >= '$kemarin' and tanggal <= '$kemarin' and tapel='$tapel'");
$kemarinini=mysqli_fetch_assoc($lapkemarinini);
$laphariini=mysqli_query($koneksi, "select sum(bayar) as totalbayar from pembayaran where tanggal >= '$sekarang' and tanggal <= '$sekarang' and tapel='$tapel'");
$hariini=mysqli_fetch_assoc($laphariini);
$lapbulanlalu=mysqli_query($koneksi, "select sum(bayar) as totalbulanlalu from pembayaran where MONTH(tanggal)='$blnnya' and tapel='$tapel'");
$bulanlalu=mysqli_fetch_assoc($lapbulanlalu);
$lapbulanini=mysqli_query($koneksi, "select sum(bayar) as totalbulan from pembayaran where MONTH(tanggal)='$bulannow' and tapel='$tapel'");
$bulanini=mysqli_fetch_assoc($lapbulanini);
if($kemarinini['totalbayarkemarin']>$hariini['totalbayar']){
	$statushari='<i class="fa fa-arrow-down"></i>';
}else{
	$statushari='<i class="fa fa-arrow-up"></i>';
}
if($bulanlalu['totalbulanlalu']>$bulanini['totalbulan']){
	$statusbulan='<i class="fa fa-arrow-down"></i>';
}else{
	$statusbulan='<i class="fa fa-arrow-up"></i>';
}
if($jumlah_produk[$blnsppnow]>$jumlah_produk[$blnsppkemarin]){
	$statusspp='<i class="fa fa-arrow-up"></i>';
}else{
	$statusspp='<i class="fa fa-arrow-down"></i>';
}
if($jumlahlain[$blnsppnow]>$jumlahlain[$blnsppkemarin]){
	$statuslain='<i class="fa fa-arrow-up"></i>';
}else{
	$statuslain='<i class="fa fa-arrow-down"></i>';
}
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
		include "../template/sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
		  <div class="row ">
			<div class="col-xl-3 col-lg-6">
				<div class="card l-bg-purple">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Hari Ini</h4>
                      <span><?=rupiah($hariini['totalbayar']);?></span>
                      <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0 text-sm">
                        <span class="mr-2"><?=$statushari;?> <?=rupiah($kemarinini['totalbayarkemarin']);?></span>
                        <span class="text-nowrap">Kemarin</span>
                      </p>
                    </div>
                  </div>
				 </div>
			</div>
			<div class="col-xl-3 col-lg-6">
				<div class="card l-bg-orange">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Bulan Ini</h4>
                      <span><?=rupiah($bulanini['totalbulan']);?></span>
                      <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0 text-sm">
                        <span class="mr-2"><?=$statusbulan;?> <?=rupiah($bulanlalu['totalbulanlalu']);?></span>
                        <span class="text-nowrap">Bulan Lalu</span>
                      </p>
                    </div>
                  </div>
				 </div>
			</div>
			<div class="col-xl-3 col-lg-6">
				<div class="card l-bg-purple">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">SPP Bulan Ini</h4>
                      <span><?=rupiah($jumlah_produk[$blnsppnow]);?></span>
                      <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0 text-sm">
                        <span class="mr-2"><?=$statusspp;?> <?=rupiah($jumlah_produk[$blnsppkemarin]);?></span>
                        <span class="text-nowrap">Bulan Lalu</span>
                      </p>
                    </div>
                  </div>
				 </div>
			</div>
			<div class="col-xl-3 col-lg-6">
				<div class="card l-bg-orange">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Lainnya Bulan Ini</h4>
                      <span><?=rupiah($jumlahlain[$blnsppnow]);?></span>
                      <div class="progress mt-1 mb-1" data-height="8">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                          aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <p class="mb-0 text-sm">
                        <span class="mr-2"><?=$statuslain;?> <?=rupiah($jumlahlain[$blnsppkemarin]);?></span>
                        <span class="text-nowrap">Bulan Lalu</span>
                      </p>
                    </div>
                  </div>
				 </div>
			</div>
          </div>
          <div class="row mt-sm-4">
			<div class="col-12 col-md-12 col-lg-4">
				<div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="https://apins.sdi-aljannah.web.id/images/ptk/<?=$avatar;?>" class="rounded-circle profile-widget-picture">
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
                  <h4><i class="fas fa-chart-line"></i> Grafik Penerimaan SPP</h4>
                  
                </div>
                <div class="card-body">
					<canvas id="myChart"></canvas>
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
  <script src="../assets/js/Chart.js"></script>
  <script>
  $("#manageMemberTable").dataTable({
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/siswa/siswad.php?kelas=<?=$kelas;?>&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "order": []
	});
  </script>
  <script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'Penerimaan SPP',
					data: <?php echo json_encode($jumlah_produk); ?>,
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>