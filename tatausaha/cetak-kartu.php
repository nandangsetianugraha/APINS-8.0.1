<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Cetak Kartu';
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
		include "../template/sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <div class="card-header-form">
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>NIS</th>
									<th>NISN</th>
									<th>TTL</th>
									<th>Kelas</th>
									<th>&nbsp;</th>
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
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
<script>  
$(document).ready(function(){
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": true,
	  "paging":true,
	  "ajax": "../modul/siswa/daftar-siswa.php?smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "columnDefs": [
		{ "sortable": false, "targets": [5] }
	  ]
	});
	$(document).on('click', '#getQR', function(e){
		e.preventDefault();
		var updid = $(this).data('pdid');
		var unis = $(this).data('nis');
		$.ajax({
			type : 'GET',
			url : '../modul/qrcode/buatQRCode.php',
			data :  'pdid='+updid+'&nis='+unis,
			dataType: 'json',
			success: function (data) {
				swal(data.messages, {buttons: false,timer: 500,});				
			}
		});
	});
	$(document).on('click', '#getBlanko', function(e){
		e.preventDefault();
		var updid = $(this).data('pdid');
		var utapel = $(this).data('tapel');
		$.ajax({
			type : 'GET',
			url : '../modul/pembayaran/cek-kartu.php',
			data :  'pdid='+updid+'&tapel='+utapel,
			dataType: 'json',
			success: function (data) {
				if(data.success===true){
					PopupCenter('../cetak/cetak-spp.php?pdid='+data.pdid+'&tapel='+data.tapel, 'Cetak Blanko Kartu',800,800);
				}else{
					swal(data.messages, {buttons: false,timer: 500,});
				}				
			}
		});
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