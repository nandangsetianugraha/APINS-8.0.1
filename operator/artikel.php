<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Artikel';
//view('template/head', $data);
include "../template/head.php";

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
          <div class="section-body">
            <div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
						  <h4><i class="fas fa-bullhorn"></i> Daftar Artikel</h4>
							<div class="card-header-action">
							  <a href="buat-artikel" class="btn btn-primary">
								Buat Artikel
							  </a>
							</div>
						</div>
						<div class="card-body">
							<?php 
							$brt1=mysqli_query($koneksi, "select * from berita order by id desc");
							$jbrt1=mysqli_num_rows($brt1);
							if($jbrt1>0){
							?>
							<div class="table-responsive">
								<table class="table table-sm table-striped" id="table-1">
									<thead>
										<tr>
											<th>Artikel</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									$newpost=0;
									while($pg1=mysqli_fetch_array($brt1)){
										$ptk_id=$pg1['penulis'];
										$nad1=mysqli_query($koneksi, "select * from ptk where ptk_id='$ptk_id'");
										$namaadmin1=mysqli_fetch_array($nad1);
										if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$namaadmin1['gambar'])){
											$gbr=$namaadmin1['gambar'];
										}else{
											$gbr="user-default.png";
										};
										$newpost=$newpost+1;
									?>
									<tr>
										
										<td>
											<ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
												<li class="media">
													<img alt="image" class="mr-3 rounded-circle" width="70" src="../images/ptk/<?=$gbr;?>">
													<div class="media-body">
													  <div class="media-title mb-1"><?=$namaadmin1['nama'];?></div>
													  <div class="text-time"><?=TanggalIndo($pg1['tanggal']);?></div>
													  <div class="media-description text-muted"><?=$pg1['judul'];?></div>
													  <div class="media-links">
														<a href="#">View</a>
														<div class="bullet"></div>
														<a href="#">Edit</a>
														<div class="bullet"></div>
														<a href="#" class="text-danger" data-toggle="modal" data-target="#hapusberitaModal" onclick="hapusBerita('5')">Trash</a>
													  </div>
													</div>
												</li>
											</ul>
										</td>
									</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
							
							<?php }else{ ?>
							<div class="alert alert-info alert-dismissible">
								<h4><i class="icon fa fa-info-circle"></i> Informasi</h4>
								Belum Ada Artikel
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
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
					  $("#table-1").dataTable({
						  "searching": true,
						  "paging":true,
						  "order": []
						});
					</script>
</body>
</html>