<?php 
include '../../function/db.php';
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
if (isset($_GET['tgl'])) {
  $tanggal = $_GET['tgl'];
  $query = mysqli_query($koneksi, "SELECT * FROM tabungan WHERE tanggal='".$tanggal."'");
  $jumlah=mysqli_num_rows($query);
  $query1 = mysqli_query($koneksi, "SELECT sum(IF(kode='1',masuk,0)) as setoran FROM tabungan WHERE tanggal='".$tanggal."'");
  $setor=mysqli_fetch_array($query1);
  $query2 = mysqli_query($koneksi, "SELECT sum(IF(kode='2',keluar,0)) as penarikan FROM tabungan WHERE tanggal='".$tanggal."'");
  $ambil=mysqli_fetch_array($query2);
  $saldo=$setor['setoran']-$ambil['penarikan'];
?>
<div class="col-sm-4 col-xs-12">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> Setoran</span>
                    <h5 class="description-header"><?=rupiah($setor['setoran']);?></h5>
                    <span class="description-text">SETORAN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
<div class="col-sm-4 col-xs-12">
                  <div class="description-block border-right">
                    <span class="description-percentage text-red"><i class="fa fa-caret-up"></i> Penarikan</span>
                    <h5 class="description-header"><?=rupiah($ambil['penarikan']);?></h5>
                    <span class="description-text">PENARIKAN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
<div class="col-sm-4 col-xs-12">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> Total</span>
                    <h5 class="description-header"><?=rupiah($saldo);?></h5>
                    <span class="description-text"><?=$jumlah;?> TRANSAKSI</span>
                  </div>
                  <!-- /.description-block -->
                </div>

<?php 
};
?>