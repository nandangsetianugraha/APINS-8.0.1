<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Besar Tarif';
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
            <div class="row">
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Besar Tarif</h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" data-toggle="modal" data-target="#tambahSPP" id="addSPPModal"><i class="fas fa-calendar-plus"></i> Tarif</button>
					  </div>
					</div>
					<div class="card-body">
						<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<label>Kelas</label>
										<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
										<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
										<select class="form-control" id="kelas" name="kelas">
											<option value="0">Pilih Rombel</option>
											<?php 
											$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
											while($nk=mysqli_fetch_array($sql_mk)){
											?>
											<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
											<?php };?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-default">
										<label>Jenis Tunggakan</label>
										<select class="form-control" id="jtung" name="jtung">
											
										</select>
									</div>
								</div>
							</div> <!--Akhir Row-->
					  <div class="table-responsive">
						<table class="table table-striped" id="SPPku">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>Biaya</th>
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
		<div class="modal fade" id="tambahSPP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tarif SPP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
			  <form class="form" action="../modul/pembayaran/tambahspp.php" method="POST" id="createSPPForm">
              <div class="modal-body">
				<div class="form-group form-group-default">
					<label>Kelas</label>
					<select class="form-control" name="rombel">
						<?php 
						$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
						while($nk=mysqli_fetch_array($sql_mk)){
						?>
						<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
						<?php };?>
					</select>
				</div>
				<div class="form-group form-group-default">
					<label>Jenis Tunggakan</label>
					<select class="form-control" name="jenis">
						<?php 
						$sql_mk=mysqli_query($koneksi, "select * from jenis_tunggakan");
						while($nk=mysqli_fetch_array($sql_mk)){
						?>
						<option value="<?=$nk['id_tunggakan'];?>"><?=$nk['nama_tunggakan'];?></option>
						<?php };?>
					</select>
				</div>
				<div class="form-group form-group-default">
					<label>Tarif SPP</label>
					<input type="hidden" name="tapel" autocomplete=off class="form-control" value="<?=$tapel;?>">
					<input type="text" name="tarifspp" autocomplete=off class="form-control" placeholder="Biaya">
				</div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
			  </form>
            </div>
          </div>
        </div>
		<div class="modal fade" id="edittariflain">
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
		  <div class="modal fade" id="tambahtariflain">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Tarif</h4>
              </div>
                        <form class="form-horizontal" action="../modul/pembayaran/tambah-tarif.php" autocomplete="off" method="POST" id="addtarifForm">
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
  
  <script>
  var SPPku;
  $(document).ready(function() {
	  var kelas=$('#kelas').val();
	  var tapel=$('#tapel').val();
	  var tung=$('#jtung').val();
  	  SPPku = $("#SPPku").DataTable({
		"destroy":true,
		"searching": false,
		"paging":false,
		"ajax": "../modul/pembayaran/tarif.php?kelas="+kelas+"&tapel="+tapel+"&jenis="+tung,
		"order": []
	  });
	  $('#kelas').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
		$.ajax({
				type : 'GET',
				url : '../function/tunggakan.php',
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#jtung").html(data);
				}
			});
	  });
	  $('#jtung').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
		var kelas=$('#kelas').val();
		var tapel=$('#tapel').val();
		var tung=$('#jtung').val();
			
		SPPku = $("#SPPku").DataTable({
			"destroy":true,
			"searching": false,
			"paging":false,
			"ajax": "../modul/pembayaran/tarif.php?kelas="+kelas+"&tapel="+tapel+"&jenis="+tung,
			"order": []
		  });
	  });
	  $('#tambahtariflain').on('show.bs.modal', function (e) {
            var idsiswa = $(e.relatedTarget).data('idsiswa');
			var jenis = $(e.relatedTarget).data('jenis');
			var tapel = $(e.relatedTarget).data('tapel');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/pembayaran/tambahtarif.php',
                data :  'idsiswa='+ idsiswa+'&jenis='+jenis+'&tapel='+tapel,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
	  $("#addtarifForm").unbind('submit').bind('submit', function() {
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
										SPPku.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#tambahtariflain").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
	  $('#edittariflain').on('show.bs.modal', function (e) {
            var idspp = $(e.relatedTarget).data('idspp');
			var jenis = $(e.relatedTarget).data('jenis');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/pembayaran/edittarif.php',
                data :  'idspp='+ idspp+'&jenis='+jenis,
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
										SPPku.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#edittariflain").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
		$(document).on('click', '#hapustarif', function(e){
		
			e.preventDefault();
			
			var uids = $(this).data('idspp');
			var jenis = $(this).data('jenis');
			$.ajax({
				type : 'GET',
				url : '../modul/pembayaran/hapus_tunggakan.php',
				data :  'ids='+uids+'&jenis='+jenis,
				success: function (data) {
					SPPku.ajax.reload(null, false);					
				}
			});
			
		});
	  $("#addSPPModal").on('click', function() {
			// reset the form 
			$("#createSPPForm")[0].reset();
			// submit form
			$("#createSPPForm").unbind('submit').bind('submit', function() {
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
								$("#tambahSPP").modal('hide');
								$("#createSPPForm")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 3000,});
								
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
		}); // /add modal
  });
  </script>
</body>
</html>