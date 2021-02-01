<?php 
session_start();
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
require_once '../function/functions.php';
$data['title'] = 'Beranda';
//view('template/head', $data);
include "../template/heads.php";
//include "../function/db.php";
$pdid=$siswa['peserta_didik_id'];
$bln=(int) date("m");
$blns = array("Januari", "Februari", "Maret", "April", "Mei", "Juni","Juli", "Agustus", "September", "Oktober", "November", "Desember");
switch ($bln) {
	case 1: //guru Bahasa Inggris
		$blnspp=7;
		break;
	case 2: //guru Bahasa Inggris
		$blnspp=8;
		break;
	case 3: //guru Bahasa Inggris
		$blnspp=9;
		break;
	case 4: //guru Bahasa Inggris
		$blnspp=10;
		break;
	case 5: //guru Bahasa Inggris
		$blnspp=11;
		break;
	case 6: //guru Bahasa Inggris
		$blnspp=12;
		break;
	case 7: //guru Bahasa Inggris
		$blnspp=1;
		break;
	case 8: //guru Bahasa Inggris
		$blnspp=2;
		break;
	case 9: //guru Bahasa Inggris
		$blnspp=3;
		break;
	case 10: //guru Bahasa Inggris
		$blnspp=4;
		break;
	case 11: //guru Bahasa Inggris
		$blnspp=5;
		break;
	case 12: //guru Bahasa Inggris
		$blnspp=6;
		break;
	default:
		$blnspp=0; 
		break;
};
$spp=$koneksi->query("select * from tarif_spp where peserta_didik_id='$pdid'")->fetch_assoc();
$sppbln=$koneksi->query("select * from pembayaran where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='1' and bulan='$blnspp'")->num_rows;
$rincian=$koneksi->query("select * from pembayaran where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='1' and bulan='$blnspp'")->fetch_assoc();
$jumlah=0;
$sisa=0;
$nomor=0;
$bayarnya=0;
$jumlahs=0;
$sisas=0;
$nomors=0;
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "../template/top-navbars.php"; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php 
		include "../template/sidebars.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
		  <div class="row">
			<div class="col-12 col-md-12 col-lg-8">
			  
			  <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-bullhorn"></i> Informasi Tunggakan</h4>
                  <div class="card-header-form">
                  </div>
                </div>
                <div class="card-body">
					<?php 
					if($sppbln>0){
					?>
					<div class="alert alert-info alert-has-icon">
                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">Terima Kasih</div>
                        Anda sudah membayar Infaq Bulanan Bulan <?=$blns[$bln-1];?> pada tanggal <?=TanggalIndo($rincian['tanggal']);?>
                      </div>
                    </div>
					<?php }else{ ?>
					<div class="alert alert-warning alert-has-icon">
                      <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">Warning</div>
                        Infaq Bulanan Bulan <?=$blns[$bln-1];?> Belum dibayar.<br/>
						Segera lakukan pembayaran Infaq Bulanan paling lambat tanggal 10 setiap bulannya
                      </div>
                    </div>
					<div class="table-responsive">
						<table class="table table-sm" id="laporan">
							<thead>
							   <tr>
									<th>Nama Pembayaran</th>
									<th>Bulan</th>
									<th>Tarif/Biaya</th>
									<th>Pembayaran</th>
									<th>Sisa</th>
								</tr>
							</thead>
							<tbody>
					<?php 
						for($i = 1; $i < $blnspp+1; $i++){
							$sppblns=$koneksi->query("select * from pembayaran where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='1' and bulan='$i'")->num_rows;
							if($sppblns>0){
							}else{
								$blnspps=$koneksi->query("select * from bulan_spp where id_bulan='$i'")->fetch_assoc();
								$jumlahs=$jumlahs+$spp['tarif'];
								$sisas=$sisas+$spp['tarif'];
								$nomors=$nomors+1;
					?>
								<tr>
									<td>Infaq Bulanan Tahun <?=$tapel;?></td>
									<td><?=$blnspps['bulan'];?></td>
									<td style="text-align:right"><?=rupiah($spp['tarif']);?></td>
									<td style="text-align:right">-</td>
									<td style="text-align:right"><?=rupiah($spp['tarif']);?></td>
								</tr>
					<?php 
							}
						}
					?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2">Jumlah</td>
									<td style="text-align:right"><?=rupiah($jumlahs);?></td>
									<td style="text-align:right">-</td>
									<td style="text-align:right"><?=rupiah($sisas);?></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<?php 
					}
					?>
					<div class="table-responsive">
						<table class="table table-sm" id="laporan">
							<thead>
							   <tr>
									<th>Nama Pembayaran</th>
									<th>Tarif/Biaya</th>
									<th>Pembayaran</th>
									<th>Sisa</th>
								</tr>
							</thead>
							<tbody>	
					<?php 
					$sql11="select * from jenis_tunggakan where id_tunggakan > 1";
					$query11 = $koneksi->query($sql11);
					while($h=$query11->fetch_assoc()) {
						$idt=$h['id_tunggakan'];
						$cek=$koneksi->query("select * from pembayaran where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='$idt'")->num_rows;
						$tarifnya=$koneksi->query("select * from tunggakan_lain where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
						if($tarifnya['tarif']==0){
							
						}else{
							if($cek>0){
								$bayar=$koneksi->query("select sum(bayar) as sudahbayar from pembayaran where peserta_didik_id='$pdid' and tapel='$tapel' and jenis='$idt'")->fetch_assoc();
								$sudah=$bayar['sudahbayar'];
								if($sudah==$tarifnya['tarif']){
								}else{
									$sisanya=$tarifnya['tarif']-$sudah;
									$jumlah=$jumlah+$tarifnya['tarif'];
									$sisa=$sisa+$sisanya;
									$bayarnya=$bayarnya+$sudah;
									$nomor=$nomor+1;
					?>
								<tr>
									<td><?=$h['nama_tunggakan'];?> Tahun <?=$tapel;?></td>
									<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
									<td style="text-align:right"><?=rupiah($sudah);?></td>
									<td style="text-align:right"><?=rupiah($sisanya);?></td>
								</tr>
					<?php 
								}
							}else{
								$jumlah=$jumlah+$tarifnya['tarif'];
								$sisa=$sisa+$tarifnya['tarif'];
								$nomor=$nomor+1;
					?>
								<tr>
									<td><?=$h['nama_tunggakan'];?> Tahun <?=$tapel;?></td>
									<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
									<td style="text-align:right"><?=rupiah(0);?></td>
									<td style="text-align:right"><?=rupiah($tarifnya['tarif']);?></td>
								</tr>
					<?php 
							}
						}
					}
					if($sisa==0){
					?>
								<tr>
									<td colspan="4" style="text-align:center">Tidak ada Tunggakan</td>
								</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td>Jumlah</td>
							<td style="text-align:right"><?=rupiah($jumlah);?></td>
							<td style="text-align:right"><?=rupiah($bayarnya);?></td>
							<td style="text-align:right"><?=rupiah($sisa);?></td>
						</tr>
					</tfoot>
					</table>
					</div>
                </div>
              </div>
			  
              <div class="card">
                <div class="card-header">
                  <h4><i class="fas fa-bullhorn"></i> Pengumuman</h4>
                  <div class="card-header-form">
                  </div>
                </div>
                <div class="card-body">
                </div>
              </div>
            </div>
		    <div class="col-12 col-md-12 col-lg-4">
				<div class="card profile-widget">
                  <div class="profile-widget-header">
                    <img alt="image" src="<?= base_url(); ?>images/siswa/<?=$avatar;?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">NIS</div>
                        <div class="profile-widget-item-value"><?=$siswa['nis'];?></div>
                      </div>
					  <div class="profile-widget-item">
                        <div class="profile-widget-item-label">NISN</div>
                        <div class="profile-widget-item-value"><?=$siswa['nisn'];?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description pb-0">
                    <div class="profile-widget-name"><?=$siswa['nama'];?> <div class="text-muted d-inline font-weight-normal">
                        <br> Kelas <?=$kelas['rombel'];?>
                      </div>
                    </div>
					<div class="py-4">
                      <p class="clearfix">
                        <span class="float-left">
                          Tempat Lahir
                        </span>
                        <span class="float-right text-muted">
                          <?=$siswa['tempat'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Tanggal Lahir
                        </span>
                        <span class="float-right text-muted">
                          <?=$siswa['tanggal'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Nama Ayah
                        </span>
                        <span class="float-right text-muted">
                          <?=$siswa['nama_ayah'];?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Nama Ibu
                        </span>
                        <span class="float-right text-muted">
                          <?=$siswa['nama_ibu'];?>
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="card-footer text-center pt-0">
                    <div class="font-weight-bold mb-2 text-small">Follow <?=$siswa['nama'];?> On</div>
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
		  </div>
        </section>
		
        <?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  
</body>
</html>