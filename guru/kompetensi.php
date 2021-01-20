<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Kompetensi';
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
				<div class="col-md-12 col-lg-12 col-xl-12">
					<div class="card">
						<div class="card-header">
						  <h4>Kompetensi Dasar</h4>
						  <div class="card-header-form">
							<form class="form-inline">
								<div class="form-group">
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
								<div class="form-group">
									<?php if($level==98 or $level==97){ ?>
									<select class="form-control" id="mp" name="mp">
										<option value="0">==Pilih Mapel==</option>
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
										<option value="0">==Pilih Mapel==</option>
										<option value="1">Pendidikan Agama Islam</option>
									</select>
									<?php }; ?>
									<?php if($level==95){ //mapel PJOK ?>
									<select class="form-control" id="mp" name="mp">
										<option value="0">==Pilih Mapel==</option>
										<option value="8">Pend. Jasmani Olahraga dan Kesehatan</option>
									</select>
									<?php }; ?>
									<?php if($level==94){ //mapel Inggris ?>
									<select class="form-control" id="mp" name="mp">
										<option value="0">==Pilih Mapel==</option>
										<option value="10">Bahasa Inggris</option>
									</select>
									<?php }; ?>
								</div>
							</form>
						  </div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6 col-lg-12 col-xl-6">
								  <div class="card">
									<div class="card-header">
									  <h4>KD Pengetahuan</h4>
									  <div class="card-header-form">
										<button data-toggle="modal" data-target="#tambahKD" id="k3" title="Pengetahuan" class="btn btn-info btn-border btn-sm">
												<span class="btn-label">
													<i class="fa fa-plus"></i>
												</span>
												Pengetahuan
											</button>
									  </div>
									</div>
									<div class="card-body">
									  <div class="table-responsive">
										<table class="table table-striped" id="KDTable">
											<thead>
												<tr>
													<th>KD</th>
													<th>Deskripsi</th>
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
								<div class="col-md-6 col-lg-12 col-xl-6">
								  <div class="card">
									<div class="card-header">
									  <h4>KD Ketrampilan</h4>
									  <div class="card-header-form">
										<button href="#" data-toggle="modal" data-target="#tambahKDk" title="Ketrampilan" id="k4" class="btn btn-info btn-border btn-sm">
												<span class="btn-label">
													<i class="fa fa-plus"></i>
												</span>
												Ketrampilan
											</button>
									  </div>
									</div>
									<div class="card-body">
									  <div class="table-responsive">
										<table class="table table-striped" id="KDTablek">
											<thead>
											    <tr>
													<th>KD</th>
													<th>Deskripsi</th>
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
					</div>
				</div>
			</div>
          </div>
        </section>
		<!--Modal Tambah KD Peng-->
		<div class="modal fade" id="tambahKD">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">KD Pengetahuan Kelas <?php echo $ab;?></h4>
              </div>
                        <form class="form-horizontal" action="../modul/administrasi/tambahKDp.php" autocomplete="off" method="POST" id="createKDForm">
						<div class="modal-body editSiswa">
							<div class="fetched-data"></div>
						</div>
                        
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		<!--Modal tambah KD Ket-->
		<div class="modal fade" id="tambahKDk">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">KD Ketrampilan Kelas <?php echo $ab;?></h4>
              </div>
                        <form class="form-horizontal" action="../modul/administrasi/tambahKDk.php" autocomplete="off" method="POST" id="createKDFormk">
						<div class="modal-body editSiswa">
							<div class="fetched-data"></div>
						</div>
                        
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		
		<!--Delete KD-->
		<div class="modal fade" id="removeKDModal">
          <div class="modal-dialog">
            <div class="modal-content">
                        <div class="modal-body">
							<p>Hapus KD ini dari Kelas <?=$ab;?>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light" id="removeBtn">Ya</button>
                        </div>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		
		<!--Edit KD Pengetahuan-->
		<div class="modal fade" id="editKD">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Kompetensi Dasar</h4>
              </div>
                        <form class="form-horizontal" action="../modul/administrasi/updateKD.php" autocomplete="off" method="POST" id="updateKDForm">
							<div class="fetched-data"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script>
	var KDTable;
	var KDTablek;
	$(document).ready(function() {
		var mp = $('#mp').val();
		if(mp==0){
			$("#k3").hide();
			$("#k4").hide();
		}else{
			$("#k3").show();
			$("#k4").show();
		}
		<?php if($level==98 or $level==97){ ?>
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			if(mp==0){
				$("#k3").hide();
				$("#k4").hide();
			}else{
				$("#k3").show();
				$("#k4").show();
			}
			KDTable = $('#KDTable').DataTable( {
						"destroy":true,
						"searching": false,
						"paging":false,
						"ajax": "../modul/administrasi/daftarKD.php?kelas="+kelas+"&aspek=3&mp="+mp,
						"order": []
					} );
					KDTablek = $('#KDTablek').DataTable( {
						"destroy":true,
						"searching": false,
						"paging":false,
						"ajax": "../modul/administrasi/daftarKD.php?kelas="+kelas+"&aspek=4&mp="+mp,
						"order": []
					} );
		});
		<?php }else{ ?>
		$('#kelas').change(function(){
			//Mengambil value dari option select kd kemudian parameternya dikirim menggunakan ajax
			var kelas=$('#kelas').val();
			var level=<?=$level;?>;
			
			$.ajax({
				type : 'GET',
				url : '../function/mpl.php',
				data :  'kelas=' +kelas+'&level='+level,
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#mp").html(data);
					$("#KDPeng").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih Mata Pelajaran</div>');
					$("#KDKet").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih Mata Pelajaran</div>');
				}
			});
		});
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			if(mp==0){
				$("#k3").hide();
				$("#k4").hide();
			}else{
				$("#k3").show();
				$("#k4").show();
			}
			KDTable = $('#KDTable').DataTable( {
						"destroy":true,
						"searching": false,
						"paging":false,
						"ajax": "../modul/administrasi/daftarKD.php?kelas="+kelas+"&aspek=3&mp="+mp,
						"order": []
					} );
					KDTablek = $('#KDTablek').DataTable( {
						"destroy":true,
						"searching": false,
						"paging":false,
						"ajax": "../modul/administrasi/daftarKD.php?kelas="+kelas+"&aspek=4&mp="+mp,
						"order": []
					} );
			
		});
		<?php }; ?>
		$('#tambahKD').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/administrasi/modal_KDP.php',
                data :  'peta='+ rowid+'&mp='+mp+'&kelas='+kelas,
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
                url : '../modul/administrasi/modal_KDK.php',
                data :  'peta='+ rowid+'&mp='+mp+'&kelas='+kelas,
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
                url : '../modul/administrasi/edit-kd.php',
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
	function removeKD(id = null) {
		if(id) {
			// click on remove button
			$("#removeBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/administrasi/hapusKD.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 2000,});

							// refresh the table
							KDTable.ajax.reload(null, false);
							KDTablek.ajax.reload(null, false);

							// close the modal
							$("#removeKDModal").modal('hide');

						} else {
							swal(response.messages, {buttons: false,timer: 2000,});
						}
					}
				});
			}); // click remove btn
		} else {
			alert('Error: Refresh the page again');
		}
	}
</script>
</body>
</html>