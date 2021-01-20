<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Gaji Bulanan';
//view('template/head', $data);
include "../template/head.php";
$bln=isset($_GET['bln']) ? $_GET['bln'] : date("m");
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
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
            	  <div class="card">
					<div class="card-header">
					  <h4>Gaji Bulanan</h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" id="cetakRekapGaji"><i class="fas fa-print"></i> Rekap Gaji</button>
						<button class="btn btn-primary btn-icon" id="cetakSlipGaji"><i class="fas fa-print"></i> Slip Gaji</button>
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<label>Bulan</label>
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
										<select class="form-control" name="bln" id="bulan">
												<option value="07" <?php if($bln==="08"){echo "selected";}; ?>>Juli</option>
												<option value="08" <?php if($bln==="09"){echo "selected";}; ?>>Agustus</option>
												<option value="09" <?php if($bln==="10"){echo "selected";}; ?>>September</option>
												<option value="10" <?php if($bln==="11"){echo "selected";}; ?>>Oktober</option>
												<option value="11" <?php if($bln==="12"){echo "selected";}; ?>>November</option>
												<option value="12" <?php if($bln==="01"){echo "selected";}; ?>>Desember</option>
												<option value="01" <?php if($bln==="02"){echo "selected";}; ?>>Januari</option>
												<option value="02" <?php if($bln==="03"){echo "selected";}; ?>>Februari</option>
												<option value="03" <?php if($bln==="04"){echo "selected";}; ?>>Maret</option>
												<option value="04" <?php if($bln==="05"){echo "selected";}; ?>>April</option>
												<option value="05" <?php if($bln==="06"){echo "selected";}; ?>>Mei</option>
												<option value="06" <?php if($bln==="07"){echo "selected";}; ?>>Juni</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-default">
									<label>Tahun</label>
									<select class="form-control" name="thn" id="tahun">
											<?php
											$now=date('Y');
											for ($a=2012;$a<=$now;$a++){
											?>
												<option value="<?=$a;?>" <?php if(($thn)==$a){echo "selected";}; ?>><?=$a;?> </option>
											<?php 
											}
											?>
											</select>
									</div>
								</div>
							</div> <!--Akhir Row-->
					  <div class="table-responsive">
						<table id="manageMemberTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
									<th class="text-center">ID Pegawai</th>
									<th class="text-center">Nama Pegawai</th>
									<th class="text-center">Hari Kerja</th>
									<th class="text-center">Absen Kerja</th>
									<th class="text-center">Absen Ekskul</th>
									<th class="text-center">Terlambat</th>
									<th class="text-center">Pulang Cepat</th>
								</tr>
                            </thead>
                            <tbody>
										
                            </tbody>
                        </table>
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
	var manageMemberTable;
$(document).ready(function(){
	var bulan=$('#bulan').val();
	var tahun=$('#tahun').val();
	manageMemberTable = $("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/penggajian/bulanan.php?bln="+bulan+"&thn="+tahun,
	  "order": []
	});
	$('#bulan').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			$("#manageMemberTable").dataTable({
			  "destroy":true,
			  "searching": false,
			  "paging":true,
			  "ajax": "../modul/penggajian/bulanan.php?bln="+bulan+"&thn="+tahun,
			  "order": []
			});
	});
	$('#tahun').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			$("#manageMemberTable").dataTable({
			  "destroy":true,
			  "searching": false,
			  "paging":true,
			  "ajax": "../modul/penggajian/bulanan.php?bln="+bulan+"&thn="+tahun,
			  "order": []
			});
	});
	$(document).on('click', '#cetakRekapGaji', function(e){
		
			e.preventDefault();
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			PopupCenter('../cetak/rekapgaji.php?bln='+bulan+'&thn='+tahun, 'Cetak Invoice',800,800);
			
		});
	$(document).on('click', '#cetakSlipGaji', function(e){
		
			e.preventDefault();
			var bulan=$('#bulan').val();
			var tahun=$('#tahun').val();
			PopupCenter('../cetak/slipgaji.php?bln='+bulan+'&thn='+tahun, 'Cetak Invoice',800,800);
			
		});
  
});  
	function PopupCenter(pageURL, title,w,h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	};
	function highlightEdit(editableObj) {
		$(editableObj).css("background","#FFF0000");
	} 
	function simpankes(editableObj,column,id,bln,thn) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/penggajian/saveBul.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&bln='+bln+'&thn='+thn,
			success: function(response)  {
				console.log(response);
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				
			}          
	   });
	}
</script>
</body>
</html>