<?php 
session_start();
require_once '../function/functions.php';
include '../function/db_connect.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Pembayaran';
//view('template/head', $data);
include "../template/head.php";
date_default_timezone_set('Asia/Jakarta');
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
            <div class="col-6">
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Siswa</label>
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
						<?php $jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc(); ?>
						<input type="hidden" name="lstPrinters" id="lstPrinters" value="<?=$jprinter['nama'];?>" />
						<input type="hidden" name="lstPrinterTrays" id="lstPrinterTrays" value="" />
						<input type="hidden" name="txtPdfFileCetakKartu" id="txtPdfFileCetakKartu" value="../cetak/cetak-kartu.pdf" />
						<input type="hidden" name="lstPrinterPapersCetakKartu" id="lstPrinterPapersCetakKartu" value="<?=$jprinter['spp'];?>" />
						<input type="hidden" name="txtPdfFileCetakInvoice" id="txtPdfFileCetakInvoice" value="../cetak/cetak-kartu.pdf" />
						<input type="hidden" name="lstPrinterPapersCetakInvoice" id="lstPrinterPapersCetakInvoice" value="<?=$jprinter['kwitansi'];?>" />
						<select class="form-control select2" id="siswa">
							<option value="0">Pilih Siswa</option>
							<?php 
							$sql_mk=mysqli_query($koneksi, "select * from siswa where status='1' order by nama asc");
							while($nk=mysqli_fetch_array($sql_mk)){
							?>
							<option value="<?=$nk['peserta_didik_id'];?>"><?=$nk['nama'];?></option>
							<?php };?>
						</select>
					</div>
                </div>
				<div class="card">
                  <div class="card-header">
                    <h4>Tunggakan Lain</h4>
                    <div class="card-header-action">
                      <a href="#tambahlain" class="btn btn-primary btn-icon" data-toggle="modal" id="addlainModal"><i class="fas fa-calendar-plus"></i> Lain</a>
                    </div>
                  </div>
                  <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="tabellain">
								<thead>
									<tr>
										<th>Deskripsi</th>
										<th>Tarif</th>
										<th>Bayar</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                    </div>
                  </div>
                </div>
				<div class="card">
                  <div class="card-header">
                    <h4>Tunggakan SPP</h4>
                    <div class="card-header-action">
                      <a href="#cetakkartu" class="btn btn-primary btn-icon" data-toggle="modal" id="cetak-kartu"><i class="fas fa-print"></i> Cetak</a>
					  <a href="#tambahSPP" class="btn btn-primary btn-icon" data-toggle="modal" id="addSPPModal"><i class="fas fa-calendar-plus"></i> SPP</a>
                    </div>
                  </div>
                  <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                      <div class="table-responsive">
							<table class="table table-striped" id="tabelspp">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                    </div>
                  </div>
                </div>
			</div>
			<div class="col-6">
				<div class="card">
                  <div class="card-header">
                    <h4>Pembayaran</h4>
                    <div class="card-header-action">
                      <input type="text" class="form-control datepicker" name="tanggal" id="tanggal">
                    </div>
                  </div>
                  <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                      <div class="table-responsive">
							<table class="table table-striped" id="tabelbayar">
								<thead>
									<tr>
										<th>Deskripsi</th>
										<th>Bayar</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                    </div>
                    <div class="card-footer">
                      <button class="btn btn-icon icon-left btn-primary" id="bayarnow"><i class="far fa-edit"></i> Bayar</button>
					  <!--<button class="btn btn-icon icon-left btn-primary" id="bayarprint"><i class="far fa-edit"></i> Simpan dan Cetak</button>-->
                    </div>
                  </div>
                </div>
				<div class="card">
                  <div class="card-header">
                    <h4>Riwayat Transaksi</h4>
                    <div class="card-header-action">
                      <button class="btn btn-primary btn-icon" id="cetaklaporan"><i class="fas fa-print"></i> Cetak</button>
                    </div>
                  </div>
                  <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped" id="tabelriwayat">
								<thead>
									<tr>
										<th>No Invoice</th>
										<th>Tanggal</th>
										<th>Jumlah</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                    </div>
                  </div>
                </div>
			</div>
          </div>
        </section>
		<div class="modal fade" id="bayarsppModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Bayar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" action="../modul/pembayaran/bayar.php" method="POST" id="bayarsppForm">
                  <div class="form-group">
                    <label>Nama</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
					  <input type="hidden" class="form-control" id="tapel" name="tapel" value="<?=$tapel;?>">
                      <input id="penempatannama" type="text" name="penempatannama" autocomplete=off class="form-control" placeholder="Nama Lengkap">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Bulan</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-lock"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" id="bulan" name="bulan">
                    </div>
                  </div>
				  <div class="form-group">
                    <label>Bayar</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-lock"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" id="bayar" name="bayar">
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary m-t-15 waves-effect">LOGIN</button>
                </form>
              </div>
            </div>
          </div>
        </div>
		
		<div class="modal fade" id="edittarif">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Tarif</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/updatetarif.php" autocomplete="off" method="POST" id="updatetarifForm">
							<div class="fetched-data"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
		  </div>
          <!-- /.modal-dialog -->
		  <div class="modal fade" id="tambahlain">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Tarif</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/tambahlain.php" autocomplete="off" method="POST" id="tambahlainForm">
							<div class="fetched-data1"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
        </div>
		<div class="modal fade" id="tambahSPP">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah SPP</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/tambahSPP_temp.php" autocomplete="off" method="POST" id="tambahSPPForm">
							<div class="fetched-data1"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
        </div>
		<div class="modal fade" id="cetakkartu">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-print"></i> Cetak Kartu SPP</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/cetakkartuspp.php" autocomplete="off" method="POST" id="cetakSPPForm">
							<div class="fetched-data1"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
        </div>
		<div class="modal fade" id="lihatinvoice">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-print"></i> Invoice</h4>
              </div>
                        	<div class="fetched-data1"></div>
						
			</div>
            <!-- /.modal-content -->
          </div>
        </div>
		<div class="modal fade" id="bayarlain">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Bayar</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/bayarlain_temp.php" autocomplete="off" method="POST" id="bayarlainForm">
							<div class="fetched-data"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
		  </div>
		  
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="<?= base_url(); ?>assets/js/zip-full.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/JSPrintManager.js"></script>
  <script src="<?= base_url(); ?>assets/js/bluebird.min.js"></script>
  <script>
	var clientPrinters = null;
    var _this = this;

    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();

    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
	
	//cetak kartu spp 
	function printSPP() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['spp'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/cetak-kartu.pdf", JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    }
	
	//cetak invoice
	function printInvoice() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['kwitansi'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/invoice.pdf", JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    }
	
	//cetak bukti di kartu spp 
	function printKartuSPP() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = "<?=$jprinter['spp'];?>";
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF("../cetak/kartu-spp.pdf", JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
            //myWindow.close();    
        }
    }
	
	var tabelspp;
	var tabellain;
	var tabelbayar;
	var tabelriwayat;
	$(document).ready(function() {
		
		$('#siswa').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();	
			var smt = $('#smt').val();
			var tanggal = $('#tanggal').val();
			tabelspp = $('#tabelspp').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/pembayaran/tunggakan-spp.php?siswa="+siswa+"&tapel="+tapel,
				"order": []
			} );
			tabellain = $('#tabellain').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/pembayaran/tunggakan-lain.php?siswa="+siswa+"&tapel="+tapel,
				"order": []
			} );
			tabelriwayat = $('#tabelriwayat').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/pembayaran/riwayat.php?siswa="+siswa+"&tapel="+tapel,
				"order": []
			} );
			tabelbayar = $('#tabelbayar').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/pembayaran/sementara.php?siswa="+siswa+"&tanggal="+tanggal,
				"order": []
			} );	
		});
		
		$(document).on('click', '#getBayar', function(e){
		
			e.preventDefault();
			
			var ujenis = $(this).data('jenis');
			var ubulan = $(this).data('bulan');			// it will get id of clicked row
			var ubayar = $(this).data('bayar');
			var updid = $(this).data('pdid');
			var utapel = $(this).data('tapel');
			$.ajax({
				type : 'GET',
				url : '../modul/pembayaran/bayar_temp.php',
				data :  'pdid='+updid+'&jenis='+ujenis+'&bulan='+ubulan+'&bayar='+ubayar+'&tapel='+utapel,
				success: function (data) {
					tabelbayar.ajax.reload(null, false);					
				}
			});
			
		});
		$(document).on('click', '#getKartu', function(e){
		
			e.preventDefault();
			
			var uidspp = $(this).data('idspp');
			$.ajax({
				type : 'GET',
				url : '../cetak/cetak-kartu.php',
				data :  'idspp='+uidspp,
				success: function (response) {
					printSPP();												
				}
			});
			//PopupCenter('../cetak/cetak-kartu.php?idspp='+uidspp, 'myPop1',800,800);
			
		});
		$(document).on('click', '#getBayarlain', function(e){
		
			e.preventDefault();
			
			var ujenis = $(this).data('jenis');
			var ubayar = $(this).data('bayar');
			var updid = $(this).data('pdid');
			var utapel = $(this).data('tapel');
			$.ajax({
				type : 'GET',
				url : '../modul/pembayaran/bayarlain_temp.php',
				data :  'pdid='+updid+'&jenis='+ujenis+'&bayar='+ubayar+'&tapel='+utapel,
				success: function (data) {
					tabelbayar.ajax.reload(null, false);					
				}
			});
			
		});
		$(document).on('click', '#bayarnow', function(e){
		
			e.preventDefault();
			
			var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();	
			var tanggal = $('#tanggal').val();
			if(siswa==0){
				swal('Pilih Siswanya dulu', {buttons: false,timer: 2000,});
			}else{
				$.ajax({
					type : 'GET',
					url : '../modul/pembayaran/bayarnow.php',
					data :  'siswa='+siswa+'&tapel='+tapel+'&tanggal='+tanggal,
					dataType: 'json',
					beforeSend: function()
					{	
						$('#bayarnow').addClass('disabled btn-progress');
					},
					success: function (data) {
						$('#bayarnow').removeClass('disabled btn-progress');
						tabelbayar.ajax.reload(null, false);	
						tabelspp.ajax.reload(null, false);
						tabellain.ajax.reload(null, false);
						tabelriwayat.ajax.reload(null, false);
						swal({
							title: 'Berhasil',
							text: 'Pembayaran berhasil disimpan, apakah akan mencetak kwitansi?',
							icon: 'success',
							buttons: ["Batal", "Print"],
							dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) {
								$.ajax({
									type : 'GET',
									url : '../cetak/cetak-invoice.php',
									data :  'idinv='+data.messages,
									success: function (response) {
										printInvoice();												
									}
								});
						  } else {
							
						  }
						});
					}
				});
			}
			
		});
		$(document).on('click', '#bayarprint', function(e){
		
			e.preventDefault();
			
			var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();	
			var tanggal = $('#tanggal').val();
			$.ajax({
				type : 'GET',
				url : '../modul/pembayaran/bayarnow.php',
				data :  'siswa='+siswa+'&tapel='+tapel+'&tanggal='+tanggal,
				success: function (response) {
					tabelbayar.ajax.reload(null, false);	
					tabelspp.ajax.reload(null, false);
					tabellain.ajax.reload(null, false);
					tabelriwayat.ajax.reload(null, false);
					//if(data.success==true){
						PopupCenter('../cetak/cetak-invoice.php?nomor='+response.nomorinv, 'myPop1',800,800);
					//}
				}
			});
			
		});
		$(document).on('click', '#hapusinv', function(e){
		
			e.preventDefault();
			var idinv = $(this).data('idinv');
			swal({
				title: 'Invoice akan dihapus?',
				text: 'Invoice yang sudah dihapus tidak bisa dikembalikan lagi!',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				$.ajax({
					type : 'GET',
					url : '../modul/pembayaran/hapus-invoice.php',
					data :  'idinv='+idinv,
					success: function (data) {
						tabelspp.ajax.reload(null, false);
						tabellain.ajax.reload(null, false);
						tabelriwayat.ajax.reload(null, false);
					}
				});
			  } else {
				
			  }
			});
			
			
		});
		$(document).on('click', '#printinv', function(e){
		
			e.preventDefault();
			var idinv = $(this).data('idinv');
			$.ajax({
				type : 'GET',
				url : '../cetak/cetak-invoice.php',
				data :  'idinv='+idinv,
				success: function (response) {
					printInvoice();												
				}
			});
			//PopupCenter('../cetak/cetak-invoice.php?idinv='+idinv, 'Cetak Invoice',800,800);
			
		});
		$(document).on('click', '#gethapus', function(e){
		
			e.preventDefault();
			
			var uids = $(this).data('ids');
			$.ajax({
				type : 'GET',
				url : '../modul/pembayaran/hapus_bayar_temp.php',
				data :  'ids='+uids,
				success: function (data) {
					tabelbayar.ajax.reload(null, false);					
				}
			});
			
		});
		$(document).on('click', '#hapustarif', function(e){
		
			e.preventDefault();
			
			var uids = $(this).data('id');
			swal({
				title: 'Tarif akan dihapus?',
				text: 'Tarif yang sudah dihapus tidak bisa dikembalikan lagi!',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				$.ajax({
					type : 'GET',
					url : '../modul/pembayaran/hapus_tunggakan_lain.php',
					data :  'ids='+uids,
					success: function (data) {
						tabellain.ajax.reload(null, false);					
					}
				});
			  } else {
				
			  }
			});
			
			
		});
		
		$('#bayarlain').on('show.bs.modal', function (e) {
            var ids = $(e.relatedTarget).data('pdid');
			var jenis = $(e.relatedTarget).data('jenis');
			var tapel = $(e.relatedTarget).data('tapel');
			var bayar = $(e.relatedTarget).data('bayar');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/pembayaran/bayar-tarif-lain.php',
                data :  'ids='+ ids+'&jenis='+jenis+'&tapel='+tapel+'&bayar='+bayar,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		$("#bayarlainForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										//swal(response.messages, {buttons: false,timer: 2000,});
										// reload the datatables
										tabelbayar.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#bayarlain").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		$('#edittarif').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/pembayaran/edit-tarif.php',
                data :  'rowid='+ rowid,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 $("#updatetarifForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 2000,});
										// reload the datatables
										tabellain.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#edittarif").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		
		$('#lihatinvoice').on('show.bs.modal', function (e) {
            var idinv = $(e.relatedTarget).data('idinv');
			
			//menggunakan fungsi ajax untuk pengambilan data
				$.ajax({
					type : 'post',
					url : '../modul/pembayaran/lihat-invoice.php',
					data :  'idinv='+idinv,
					beforeSend: function()
							{	
								$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							},
					success : function(data){
					$('.fetched-data1').html(data);//menampilkan data ke dalam modal
					}
				});
			
         });
		
		$('#cetakkartu').on('show.bs.modal', function (e) {
            var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();
			if(siswa==0){
				$(".fetched-data1").html('<div class="modal-body"><div class="alert alert-danger alert-has-icon"><div class="alert-icon"><i class="far fa-lightbulb"></i></div><div class="alert-body"><div class="alert-title">Error</div>Pilih Siswanya dulu!</div></div></div><div class="modal-footer"><button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button></div>');
			}else{
			//menggunakan fungsi ajax untuk pengambilan data
				$.ajax({
					type : 'post',
					url : '../modul/pembayaran/cetak-spp.php',
					data :  'ids='+ siswa+'&tapel='+tapel,
					beforeSend: function()
							{	
								$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							},
					success : function(data){
					$('.fetched-data1').html(data);//menampilkan data ke dalam modal
					}
				});
			}
         });
		$("#cetakSPPForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										//swal(response.messages, {buttons: false,timer: 2000,});
										// reload the datatables
										//tabelspp.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										//$("#cetakkartu").modal('hide');
										$.ajax({
											type : 'GET',
											url : '../cetak/cetak-kartu-spp.php',
											data :  'ids='+response.ids+'&tapel='+response.tapel+'&jenis='+response.jenis+'&bulan='+response.bln,
											success: function (data) {
												printKartuSPP();												
											}
										});
										//PopupCenter('../cetak/cetak-kartu-spp.php?ids='+response.ids+'&tapel='+response.tapel+'&jenis='+response.jenis+'&bulan='+response.bln, 'myPop1',800,800);
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		
		$('#tambahSPP').on('show.bs.modal', function (e) {
            var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();
			if(siswa==0){
				$(".fetched-data1").html('<div class="modal-body"><div class="alert alert-danger alert-has-icon"><div class="alert-icon"><i class="far fa-lightbulb"></i></div><div class="alert-body"><div class="alert-title">Error</div>Pilih Siswanya dulu!</div></div></div><div class="modal-footer"><button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button></div>');
			}else{
			//menggunakan fungsi ajax untuk pengambilan data
				$.ajax({
					type : 'post',
					url : '../modul/pembayaran/tambah-tarif-SPP.php',
					data :  'ids='+ siswa+'&tapel='+tapel,
					beforeSend: function()
							{	
								$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							},
					success : function(data){
					$('.fetched-data1').html(data);//menampilkan data ke dalam modal
					}
				});
			}
         });
		 $("#tambahSPPForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 2000,});
										// reload the datatables
										tabelspp.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#tambahSPP").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		 $('#tambahlain').on('show.bs.modal', function (e) {
            var siswa = $('#siswa').val();			
			var tapel = $('#tapel').val();
			if(siswa==0){
				$(".fetched-data1").html('<div class="modal-body"><div class="alert alert-danger alert-has-icon"><div class="alert-icon"><i class="far fa-lightbulb"></i></div><div class="alert-body"><div class="alert-title">Error</div>Pilih Siswanya dulu!</div></div></div><div class="modal-footer"><button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button></div>');
			}else{
			//menggunakan fungsi ajax untuk pengambilan data
				$.ajax({
					type : 'post',
					url : '../modul/pembayaran/tambah-tarif-lain.php',
					data :  'ids='+ siswa+'&tapel='+tapel,
					beforeSend: function()
							{	
								$(".fetched-data1").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							},
					success : function(data){
					$('.fetched-data1').html(data);//menampilkan data ke dalam modal
					}
				});
			}
         });
		 $("#tambahlainForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();

						var form = $(this);

							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal(response.messages, {buttons: false,timer: 2000,});
										// reload the datatables
										tabellain.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#tambahlain").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		
	});
	function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
  </script>
</body>
</html>