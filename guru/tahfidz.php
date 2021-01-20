<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Tahfidz';
//view('template/head', $data);
include "../template/head.php";
$peta=3;
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
				<div class="col-12">
					<div class="card">
						<div class="card-header">
						  <h4>Penilaian Tahfidz</h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							<div class="form-row">
								<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
								<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
								<div class="form-group col-md-2">
									<label>Kelas</label>
									<select class="form-control" id="kelas" name="kelas">
										<option value="<?=$kelas;?>">Kelas <?=$kelas;?></option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label>Penilaian</label>
									<select class="form-control" id="mp" name="mp">
										<option value="0">Pilih Penilaian</option>
										<option value="1">Juz Amma</option>
										<option value="2">Hadits Arbain</option>
										<option value="3">Surah Pilihan</option>
										<option value="4">Doa Sehari-hari</option>
										<option value="5">Hadits Pilihan</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label>Surah/Hadits/Doa</label>
									<select class="form-control" id="surah" name="surah">
									
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label>Keterangan Nilai</label>
									<p><span class='badge badge-success'>A</span> : Sangat Lancar   <span class='badge badge-info'>B</span> : Lancar    <span class='badge badge-warning'>C</span> : Cukup Lancar    <span class='badge badge-danger'>D</span> : Kurang Lancar     <span class='badge badge-danger'>E</span> : Tidak Hafal</p>
								</div>
							</div>
							
							
						  <div class="table-responsive">
							<div id="nilaiHarian">
								<div class="alert alert-info alert-dismissible">
									<h4><i class="icon fa fa-info"></i> Informasi</h4>
									Silahkan Pilih Penilaian
								</div>
							</div>
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
  <script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var smt=$('#smt').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/harian/surah.php',
				data :  'mpid=' + mp+'&kelas='+kelas+'&smt='+smt,
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#surah").html(data);
					$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih</div>');
				}
			});
		});
		$('#surah').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var tapel=$('#tapel').val();
			var smt=$('#smt').val();
			var surah=$('#surah').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/harian/NilaiTahfidz.php',
				data :  'mp=' + mp+'&kelas='+kelas+'&smt='+smt+'&surah='+surah+'&tapel='+tapel,
				beforeSend: function()
				{	
					$("#nilaiHarian").html('<div class="alert alert-info alert-dismissible"><h4><i class="fa fa-spinner fa-pulse fa-fw"></i> Memuat Data Nilai Tahfidz Kelas '+kelas+'</h4></div>');
				},
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kd
					$("#nilaiHarian").html(data);
				}
			});
		});
	});
	function highlightEdit(editableObj) {
		$(editableObj).css("background","#FFF0000");
	} 
	function saveJuzamma(editableObj,column,id,kelas,smt,tapel,mpid) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/harian/saveJuzamma.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid,
			success: function(response)  {
				console.log(response);
				if(response=='gagal')
					swal('Nilainya Harus A atau B atau C atau D atau E', {buttons: false,timer: 1000,});
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				$(editableObj).focus;
				
			}          
	   });
	}
	function saveArbain(editableObj,column,id,kelas,smt,tapel,mpid) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/harian/saveArbain.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid,
			success: function(response)  {
				console.log(response);
				if(response=='gagal')
					swal('Nilainya Harus A atau B atau C atau D atau E', {buttons: false,timer: 1000,});
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				$(editableObj).focus;
				
			}          
	   });
	}
	function saveSurah(editableObj,column,id,kelas,smt,tapel,mpid) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/harian/saveSurah.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid,
			success: function(response)  {
				console.log(response);
				if(response=='gagal')
					swal('Nilainya Harus A atau B atau C atau D atau E', {buttons: false,timer: 1000,});
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				$(editableObj).focus;
				
			}          
	   });
	}
	function saveDoa(editableObj,column,id,kelas,smt,tapel,mpid) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/harian/saveDoa.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid,
			success: function(response)  {
				console.log(response);
				if(response=='gagal')
					swal('Nilainya Harus A atau B atau C atau D atau E', {buttons: false,timer: 1000,});
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				$(editableObj).focus;
				
			}          
	   });
	}
	function saveHadits(editableObj,column,id,kelas,smt,tapel,mpid) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/harian/saveHadits.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid,
			success: function(response)  {
				console.log(response);
				if(response=='gagal')
					swal('Nilainya Harus A atau B atau C atau D atau E', {buttons: false,timer: 1000,});
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				$(editableObj).focus;
				
			}          
	   });
	}
</script>
</body>
</html>