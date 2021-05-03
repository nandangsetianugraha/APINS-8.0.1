<?php 
session_start();
require_once '../function/functions.php';
include '../function/db_connect.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Tabungan';
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
          <div class="section-body">
            <div class="row">
				<div class="col-6">
					<div class="card">
						<div class="card-header">
						  <h4>Tabungan</h4>
						  <div class="card-header-form">
							<?php $jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc(); ?>
							<input type="hidden" name="txtPdfFile" id="txtPdfFile" value="../cetak/cetak-tabungan.pdf" />
							<input type="hidden" name="lstPrinters" id="lstPrinters" value="<?=$jprinter['nama'];?>" />
							<input type="hidden" name="lstPrinterTrays" id="lstPrinterTrays" value="" />
							<input type="hidden" name="lstPrinterPapers" id="lstPrinterPapers" value="<?=$jprinter['tabungan'];?>" />
						  </div>
						</div>
						<div class="card-body">
							<ul class="list-unstyled list-unstyled-border user-list" id="message-list">
								<li class="media">
									<img alt="image" src="../assets/img/users/user-1.png"
									  class="mr-3 user-img-radious-style user-list-img">
									<div class="media-body">
									  <div class="mt-0 font-weight-bold nama-nasabah">Masukkan ID Nasabah</div>
									  <div class="text-small saldosiswa"></div>
									</div>
								</li>
							</ul>
							<form class="form" action="tabungan" method="GET" id="tabID">
							<div class="row">
							  <div class="form-group col-md-12 col-12">
								<label>Tanggal Transaksi</label>
								<input type="text" class="form-control datepicker" name="tglbro" id="tanggal">
							  </div>
							  <div class="form-group col-md-4 col-4">
								<label>Jenis Transaksi</label>
								<select class="form-control select2" name="jenis" id="jenis" style="width: 100%;">
									<option value="1">Setoran</option>
									<option value="2">Pengambilan</option>
								</select>
							  </div>
							  <div class="form-group col-md-4 col-4">
								<label>ID Nasabah</label>
								<input type="text" id="idNasabah" name="idNasabah" placeholder="ID Nasabah" autocomplete=off autofocus="autofocus" class="form-control">
								<span class="form-control-feedback loading"></span>
							  </div>
							  <div class="form-group col-md-4 col-4">
								<label>Setoran (Rp.)</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control" name="pagu" id="rupiah" placeholder="" aria-label="" autocomplete=off>
									<div class="input-group-append">
									  <button class="btn btn-primary" type="submit" id="simpanTab">Rp</button>
									</div>
								</div>
							  </div>
							</div>
							</form>
							<table id="ceksaldo" class="table table-striped table-hover">
							  <thead>
								<tr>
								  <th>Tanggal</th>
								  <th>Kode</th>
								  <th>Setor</th>
								  <th>Ambil</th>
								  <th>Saldo</th>
								</tr>
							  </thead>
							  <tbody id="hasilsaldo">
								<tr>
								  <td colspan="5"><center>Belum Ada Data</center></td>
								</tr>
							  </tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card">
						<div class="card-header">
						  <h4 id="riwayat">Riwayat Transaksi</h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							<div class="box-body table-responsive">
								<table id="tabelTransaksi" class="table table-sm table-bordered table-hover">
									<thead>
													   <tr>
															<th class="text-center">Nasabah</th>
															<th class="text-center">Kode</th>
															<th class="text-center">Setor</th>
															<th class="text-center">Ambil</th>
															<th class="text-center"></th>
														</tr>
													</thead>
													<tbody>
													
													</tbody>
													<tfoot align="right">
														<tr>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
															<th></th>
														</tr>
													</tfoot>
								</table>
							</div>
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
<script src="<?= base_url(); ?>assets/js/zip-full.min.js"></script>
<script src="<?= base_url(); ?>assets/js/JSPrintManager.js"></script>
<script src="<?= base_url(); ?>assets/js/bluebird.min.js"></script>
<script type="text/javascript">
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

    //Do printing...
    function print() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = $('#lstPrinterPapers').val();
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF($('#txtPdfFile').val(), JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
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
		
		var rupiah = document.getElementById('rupiah');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value, '');
		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
		}
		
		function usernameInitialization() {
		  var timer;
		  var doneTypingInterval = 1000;
		  var $input = $('#idNasabah');

		  $input.on('keyup', function () {
			  clearTimeout(timer);
			  if($(this).val().length>3 && $(this).val()!== ''){
				  timer = setTimeout(doneTyping,doneTypingInterval);
				  $("span.loading").addClass("fa fa-spinner fa-spin");
			  }else{
				  $("span.loading").removeClass("fa fa-spinner fa-spin");
			  }
		  });

		  $input.on('keydown',function () {
			  clearTimeout(timer);
		  });
		}
		
		function doneTyping() {
		  $.post("../modul/tabungan/ceknasabah.php",$("#tabID").serialize(),function (res) {
			  $("span.loading").removeClass("fa fa-spinner fa-spin");
			  response = $.parseJSON(res);
			  if(response.status!=="no_nasabah"){
				  $(".nama-nasabah").html("["+response.IDnasabah+"] "+response.namaLengkap);
				  $(".saldosiswa").html(response.saldo);
				  //clearTimeout(timer);
				  $("#rupiah").focus();
				  
				  // console.log(response);
			  }else{
				  $(".nama-nasabah").html("Nasabah tidak terdaftar");
				  $(".saldosiswa").html(response.saldo);
				  $("#idNasabah").select();
				  // console.log(response);
			  }
		  });
		}
		function eraseText() {
			document.getElementById("idNasabah").value = "";
			document.getElementById("rupiah").value = "";
		}
		function PopupCenter(pageURL, title,w,h) {
			var left = (screen.width/2)-(w/2);
			var top = (screen.height/2)-(h/2);
			var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
		};
		
		var tabelTransaksi;
	$(document).ready(function() {
		var tanggal = $('#tanggal').val();
		$('#riwayat').html('Riwayat Transaksi '+tanggal);
		tabelTransaksi = $('#tabelTransaksi').DataTable( {
				"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(), data;
					 
								// converting to interger to find total
								var intVal = function ( i ) {
									return typeof i === 'string' ?
										i.replace(/[\Rp,]/g, '')*1 :
										typeof i === 'number' ?
											i : 0;
								};
					 
								// computing column Total of the complete result 
								var setorTotal = api
									.column(2)
									.data()
									.reduce( function (a, b) {
										return intVal(a) + intVal(b);
									}, 0 );
									
								var ambilTotal = api
									.column(3)
									.data()
									.reduce( function (a, b) {
										return intVal(a) + intVal(b);
									}, 0 );
									
								// Update footer by showing the total with the reference of the column index 
								$( api.column( 0 ).footer() ).html('Total');
									//$( api.column( 1 ).footer() ).html('');
									$( api.column( 2 ).footer() ).html(setorTotal);
									$( api.column( 3 ).footer() ).html(ambilTotal);
									//$( api.column( 4 ).footer() ).html('');
								},
				"destroy":true,
				"searching": true,
				"paging":true,
				"ajax": "../modul/tabungan/tabhariini.php?tanggal_now="+tanggal,
				"order": []
			} );
		$('#idNasabah').on('keyup', function() {
			if($(this).val().length>3 && $(this).val()!== ''){
			$.ajax({
			  type: 'POST',
			  url: '../modul/tabungan/lihatsaldo.php',
			  data: {
				search: $(this).val()
			  },
			  cache: false,
			  beforeSend: function()
				{	
					$("#hasilsaldo").html('<td colspan="5"><center><i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...</center></td>');
				},
			  success: function(data) {
				$('#hasilsaldo').html(data);
			  }
			});
			};
		  });
		/*$('input[type=text]').on('keydown', function(e) {
			if (e.which == 13) {
				e.preventDefault();
				$('input[name="pagu"]').focus();
			}
		});*/
		$(document).on('click', '#gethapus', function(e){
		
			e.preventDefault();
			
			var uids = $(this).data('ids');
			swal({
				title: 'Transaksi akan dihapus?',
				text: 'Transaksi yang sudah dihapus tidak bisa dikembalikan lagi!',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				$.ajax({
					type : 'GET',
					url : '../modul/tabungan/hapus_transaksi.php',
					data :  'ids='+uids,
					dataType : 'json',
					success: function (response) {
						tabelTransaksi.ajax.reload(null, false);
						$(".nama-nasabah").html("["+response.idN+"] "+response.nama);
						$(".saldosiswa").html(response.saldo);
						var idnas = $('#idNasabah').val();
						$.ajax({
						  type: 'POST',
						  url: '../modul/tabungan/lihatsaldo.php',
						  data: {
							search: response.idN
						  },
						  cache: false,
						  beforeSend: function()
							{	
								$("#hasilsaldo").html('<td colspan="5"><center><i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...</center></td>');
							},
						  success: function(data) {
							$('#hasilsaldo').html(data);
							$('#idNasabah').val(response.idN);
							$("#idNasabah").focus();
						  }
						});						
					}
				});
			  } else {
				
			  }
			});
			
		});
		$('#tanggal').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var tanggal = $('#tanggal').val();
			$('#riwayat').html('Riwayat Transaksi '+tanggal);
			$("#idNasabah").focus();
			tabelTransaksi = $('#tabelTransaksi').DataTable( {
				"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(), data;
					 
								// converting to interger to find total
								var intVal = function ( i ) {
									return typeof i === 'string' ?
										i.replace(/[\Rp,]/g, '')*1 :
										typeof i === 'number' ?
											i : 0;
								};
					 
								// computing column Total of the complete result 
								var setorTotal = api
									.column(2)
									.data()
									.reduce( function (a, b) {
										return intVal(a) + intVal(b);
									}, 0 );
									
								var ambilTotal = api
									.column(3)
									.data()
									.reduce( function (a, b) {
										return intVal(a) + intVal(b);
									}, 0 );
									
								// Update footer by showing the total with the reference of the column index 
								$( api.column( 0 ).footer() ).html('Total');
									//$( api.column( 1 ).footer() ).html('');
									$( api.column( 2 ).footer() ).html(setorTotal);
									$( api.column( 3 ).footer() ).html(ambilTotal);
									//$( api.column( 4 ).footer() ).html('');
								},
				"destroy":true,
				"searching": true,
				"paging":true,
				"ajax": "../modul/tabungan/tabhariini.php?tanggal_now="+tanggal,
				"order": []
			} );
		});
		$("#simpanTab").on('click', function() {
			// reset the form 
			
			// submit form
			$("#tabID").unbind('submit').bind('submit', function() {

				$(".text-danger").remove();

				var form = $(this);

				

					//submi the form to server
					$.ajax({
						url : "../modul/tabungan/simpan.php",
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {

							// remove the error 
							$(".form-group").removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								
								// reset the form
								//$("#tambahAbsen").modal('hide');

								// reload the datatables
								var tanggal = $('#tanggal').val();
								//viewTr();
								tabelTransaksi.ajax.reload(null, false);
								$.ajax({
								  type: 'POST',
								  url: '../modul/tabungan/lihatsaldo.php',
								  data: {
									search: response.idN
								  },
								  cache: false,
								  success: function(data) {
									$('#hasilsaldo').html(data);
								  }
								});
								$(".saldosiswa").html(response.saldo);
								eraseText();
								
								swal({
									title: 'Berhasil',
									text: 'Tabungan berhasil diinput, apakah akan mencetak di Buku Tabungan?',
									icon: 'success',
									closeOnClickOutside: false,
									buttons: ["Batal", "Cetak"],
									dangerMode: true,
								})
								.then((willDelete) => {
								  if (willDelete) {
									  //swal(response.messages, {buttons: false,timer: 500,});
									  swal("Nomor Pencetakan:", {
										  content: "input",
										  closeOnClickOutside: false,
										})
										.then((value) => {
										  //swal(`You typed: ${value}`);
										  $.ajax({
											type : 'GET',
											url : '../cetak/cetak-tabungan.php',
											data :  'idinv='+response.idN+'&idtrans='+response.idtrans+'&idcetak='+value,
											success: function (data) {
												print();
												$("#idNasabah").focus();												
											}
										  });
										});
									  //PopupCenter('../cetak/cetak-tabungan.php?idinv='+response.idN, 'myPop1',800,800);
									  $("#idNasabah").focus();
								  } else {
									$("#idNasabah").focus();
								  }
								});
								$("#idNasabah").focus();

							} else {
								
								$("#rupiah").select();
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
		}); // /add modal
		
		

		
		
	});
	function hapusTab(id = null) {
		if(id) {
			// click on remove button
			$("#hapusBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/tabungan/hapusdata.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							
							tabelTransaksi.ajax.reload(null, false);
							
							$(".nama-nasabah").html("["+response.idN+"] "+response.nama);
							$(".saldosiswa").html(response.saldo);
							// close the modal
							$("#hapusTabModal").modal('hide');
							$.ajax({
								  type: 'POST',
								  url: '../modul/tabungan/lihatsaldo.php',
								  data: {
									search: response.idN
								  },
								  cache: false,
								  success: function(data) {
									$('#hasilsaldo').html(data);
								  }
								});

						} else {
							
						}
					}
				});
			}); // click remove btn
		} else {
			alert('Error: Refresh the page again');
		}
	}
	function hapusTr(id = null) {
		if(id) {
			// click on remove button
			$("#hapusT").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/tabungan/hapus.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							
							manageMemberTable.ajax.reload(null, false);
							viewTr();
							function viewTr(){
									var tanggal = $('#tanggal').val();
									$.get("../modul/tabungan/transaksi.php?tgl="+tanggal, function(data) {
										$("#transaksi").html(data);
									});
							}
							// close the modal
							$("#hapusTrans").modal('hide');
							

						} else {
							
						}
					}
				});
			}); // click remove btn
		} else {
			alert('Error: Refresh the page again');
		}
	}
	
	
	$(function () {
      usernameInitialization();
      $("#idNasabah").focus();
  })
</script>
</body>
</html>