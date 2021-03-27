<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'KKM';
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
				<div class="col-md-8 col-lg-12 col-xl-8">
				  <div class="card">
					<div class="card-header">
					  <h4>KKM Tahun Pelajaran <?=$tapel;?></h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-default">
									<label>Kelas</label>
									<?php if($level==94 or $level==95 or $level==96){?>
									<select class="form-control" id="kelas" name="kelas">
										<?php 
										for($i = 1; $i < 7; $i++) {
										?>
										<option value="<?=$i;?>">Kelas <?=$i;?></option>
										<?php };?>
									</select>
									<?php }else{ ?>
									<select class="form-control" id="kelas" name="kelas">
										<option value="<?=$ab;?>">Kelas <?=$ab;?></option>
									</select>
									<?php }; ?>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group form-group-default">
								<label>Mata Pelajaran</label>
								<?php if($level==98 or $level==97){ ?>
									<select class="form-control" id="mp" name="mp">
									<?php 
									$sql2 = "select * from mapel";
									$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));
									while($po=mysqli_fetch_array($qu3)){
										$idmp=$po['id_mapel'];
										if($idmp==1 or $idmp==10){
											
										}else{
											if($ab<4 and ($idmp==5 or $idmp==6)){
												
											}else{
												if($ab>3 and $idmp==8){
													
												}else{
									?>
										<option value="<?=$po['id_mapel'];?>"><?=$po['nama_mapel'];?></option>
									<?php };
									};
									};
									};?>
									</select>
									<?php }; ?>
									<?php if($level==96){ //mapel PAI ?>
									<select class="form-control" id="mp" name="mp">
										<option value="1">Pendidikan Agama Islam</option>
									</select>
									<?php }; ?>
									<?php if($level==95){ //mapel PJOK ?>
									<select class="form-control" id="mp" name="mp">
										<option value="8">Pend. Jasmani Olahraga dan Kesehatan</option>
									</select>
									<?php }; ?>
									<?php if($level==94){ //mapel Inggris ?>
									<select class="form-control" id="mp" name="mp">
										<option value="10">Bahasa Inggris</option>
									</select>
									<?php }; ?>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-default">
									<label>Cetak</label>
									<a href="../cetak/cetakKKM.php?kelas=<?=$ab;?>&mapel=2&tapel=<?=$tapel;?>" class="btn btn-icon icon-left btn-primary">
									<i class="fa fa-print"></i> Cetak</a>
								</div>
							</div>
						</div> <!--Akhir Row-->
						<div class="row ">
						<?php
									$kkkm=mysqli_fetch_array(mysqli_query($koneksi, "select min(nilai) as kkmkelas from kkm where kelas='$ab' and tapel='$tapel'"));
									$mkkm=mysqli_fetch_array(mysqli_query($koneksi, "select min(nilai) as kkmsekolah from kkm where tapel='$tapel'"));
									if(empty($mkkm['kkmsekolah'])){
										$kkmsaya=0;
									}else{
										$kkmsaya=$mkkm['kkmsekolah'];
									};
									if(empty($kkkm['kkmkelas'])){
										$kkmkelas=0;
									}else{
										$kkmkelas=$kkkm['kkmkelas'];
									};
									?>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
							  <div class="card">
								<div class="card-statistic-4">
								  <div class="align-items-center justify-content-between">
									<div class="row ">
									  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
										<div class="card-content">
										  <h5 class="font-15">KKM Kelas</h5>
										  <h2 class="mb-3 font-18"><?=$kkmkelas;?></h2>
										  <p class="mb-0"><span class="col-green">10%</span> Increase</p>
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
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
							  <div class="card">
								<div class="card-statistic-4">
								  <div class="align-items-center justify-content-between">
									<div class="row ">
									  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
										<div class="card-content">
										  <h5 class="font-15">KKM Sekolah</h5>
										  <h2 class="mb-3 font-18"><?=$kkmsaya;?></h2>
										  <p class="mb-0"><span class="col-green">10%</span> Increase</p>
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
						</div>
						
					  <div class="table-responsive">
						<table class="table table-striped" id="KKMTable">
							<thead>
								<tr>
									<th>KD</th>
									<th>Kompetensi Dasar</th>
									<th>Karakteristik Muatan/Mata Pelajaran (Kompleksitas)</th>
									<th>Karakteristik Peserta Didik (Intake)</th>
									<th>Kondisi Satuan Pendidikan</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					  </div>
					</div>
				  </div>
				</div>
				<div class="col-md-4 col-lg-12 col-xl-4">
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar KKM</h4>
					  <div class="card-header-form">
						<button class="btn btn-icon icon-left btn-primary" id="tblrefresh"><i class="fas fa-retweet"></i></button>
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="KDTablek">
							<thead>
							    <tr>
									<th>Mata Pelajaran</th>
									<th>KKM</th>
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
	var KKMTable;
	var KDTablek;
	$(document).ready(function() {
		var mp = $('#mp').val();
		var kelas=$('#kelas').val();
		KDTablek = $('#KDTablek').DataTable( {
			"destroy":true,
			"searching": false,
			"paging":false,
			"ajax": "../modul/administrasi/kkmk.php?kelas="+kelas+"&tapel=<?=$tapel;?>&level=<?=$level;?>",
			"order": []
		} );
		KKMTable = $("#KKMTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":   false,
				"ajax": "../modul/administrasi/kkmku.php?kelas="+kelas+"&tapel=<?=$tapel;?>&mapel="+mp,
				"order": []
			});
		$( "#tblrefresh" ).click(function() {
			var kelas=$('#kelas').val();
			KDTablek = $('#KDTablek').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/administrasi/kkmk.php?kelas="+kelas+"&tapel=<?=$tapel;?>&level=<?=$level;?>",
				"order": []
			} );
		});
		<?php if($level==98 or $level==97){ ?>
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			
			KKMTable = $("#KKMTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":   false,
				"ajax": "../modul/administrasi/kkmku.php?kelas="+kelas+"&tapel=<?=$tapel;?>&mapel="+mp,
				"order": []
			});
					
		});
		<?php }else{ ?>
		$('#kelas').change(function(){
			//Mengambil value dari option select kd kemudian parameternya dikirim menggunakan ajax
			var kelas=$('#kelas').val();
			var level=<?=$level;?>;
			var mp=$('#mp').val();
			KKMTable = $("#KKMTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":   false,
				"ajax": "../modul/administrasi/kkmku.php?kelas="+kelas+"&tapel=<?=$tapel;?>&mapel="+mp,
				"order": []
			});
			KDTablek = $('#KDTablek').DataTable( {
						"destroy":true,
						"searching": false,
						"paging":false,
						"ajax": "../modul/administrasi/kkmk.php?kelas="+kelas+"&tapel=<?=$tapel;?>&level=<?=$level;?>",
						"order": []
					} );
			$.ajax({
				type : 'GET',
				url : '../function/mpl.php',
				data :  'kelas=' +kelas+'&level='+level,
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#mp").html(data);
				}
			});
		});
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			
			KKMTable = $("#KKMTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":   false,
				"ajax": "../modul/administrasi/kkmku.php?kelas="+kelas+"&tapel=<?=$tapel;?>&mapel="+mp,
				"order": []
			});
					
		});
		<?php }; ?>
		$('#tambahKD').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/administrasi/modal_Peta.php',
                data :  'peta=3&mp='+mp+'&kelas='+kelas+"&smt=<?=$smt;?>",
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 $('#tambahKDk').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/administrasi/modal_Peta.php',
                data :  'peta=4&mp='+mp+'&kelas='+kelas+"&smt=<?=$smt;?>",
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		$("#createKDForm").unbind('submit').bind('submit', function() {

				$(".text-danger").remove();

				var form = $(this);

				

					//submi the form to server
					$.ajax({
						url : form.attr('action'),
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {

							// remove the error 
							$(".form-group").removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								swal(response.messages, {buttons: false,timer: 2000,});

								// reset the form
								$("#tambahKD").modal('hide');

								// reload the datatables
								KDTable.ajax.reload(null, false);
								$("#createKDForm")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
			// submit form
			$("#createKDFormk").unbind('submit').bind('submit', function() {

				$(".text-danger").remove();

				var form = $(this);

				

					//submi the form to server
					$.ajax({
						url : form.attr('action'),
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {

							// remove the error 
							$(".form-group").removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								swal(response.messages, {buttons: false,timer: 2000,});
								// reset the form
								$("#tambahKDk").modal('hide');

								// reload the datatables
								KDTablek.ajax.reload(null, false);
								$("#createKDFormk")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for Ketrampilan
		
		
		//edit KD
		$('#editKD').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/administrasi/edit-peta.php',
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
		 //Update Tema 
		 $("#updateKDForm").unbind('submit').bind('submit', function() {
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
										KDTable.ajax.reload(null, false);
										KDTablek.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#editKD").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});

	});
	function highlightEdit(editableObj) {
			$(editableObj).css("background","#FFF0000");
		} 
	function saveKKM(editableObj,column,kelas,tapel,mpid,kda,jenis) {
			// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/administrasi/saveKKM.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&kelas='+kelas+'&tapel='+tapel+'&mp='+mpid+'&kda='+kda+'&jenis='+jenis,
			success: function(response)  {
				console.log(response);
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				
			}          
	});
	};
</script>
</body>
</html>