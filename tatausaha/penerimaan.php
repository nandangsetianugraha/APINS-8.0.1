<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Daftar Penerimaan';
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
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar Penerimaan Tahun Pelajaran <?=$tapel;?></h4>
					  <div class="card-header-form">
						<button class="btn btn-primary btn-icon" data-toggle="modal" data-target="#tambahTema" id="addTemaModalBtn"><i class="fas fa-calendar-plus"></i> Tambah Penerimaan</button>
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>">
						<input type="hidden" name="kelas" id="kelas" class="form-control" value="<?=$ab;?>">
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="temaTable">
							<thead>
								<tr>
									<th>ID</th>
									<th>Jenis Penerimaan</th>
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
        </section>
		<div class="modal fade" id="tambahTema">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tambah Penerimaan</h4>
              </div>
              <form class="form" action="../modul/keuangan/tambahpenerimaan.php" method="POST" id="createTemaForm">
                        <div class="modal-body">
							<div class="form-group form-group-default">
								<label>Jenis Penerimaan</label>
								<input id="penerimaan" autocomplete=off type="text" class="form-control" name="penerimaan">
							</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-border btn-round btn-sm" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-info btn-border btn-round btn-sm">Simpan</button>
                        </div>
						</form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		<div class="modal fade" id="removeTemaModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus</h4>
              </div>
                        <div class="modal-body">
							<p>Hapus Tema ini dari Kelas <?=$ab;?>?</p>
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
		
		<div class="modal fade" id="editTema">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Penerimaan</h4>
              </div>
                        <form class="form-horizontal" action="../modul/keuangan/updatepenerimaan.php" autocomplete="off" method="POST" id="updateTemaForm">
						<div class="modal-body eTema">
							<div class="fetched-data"></div>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Update</button>
                        </div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script>
	var temaTable;
	$(document).ready(function() {
		var tapel=$('#tapel').val();
		temaTable = $('#temaTable').DataTable( {
			"destroy":true,
			"searching": false,
			"ajax": "../modul/keuangan/penerimaan.php",
			"order": []
		} );
		$("#addTemaModalBtn").on('click', function() {
			// reset the form 
			$("#createTemaForm")[0].reset();
			
			// submit form
			$("#createTemaForm").unbind('submit').bind('submit', function() {

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
								$("#tambahTema").modal('hide');

								// reload the datatables
								temaTable.ajax.reload(null, false);
								$("#createTemaForm")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 3000,});
								
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
		}); // /add modal
		
		//edit tema 
		$('#editTema').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/keuangan/edit-penerimaan.php',
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
		 $("#updateTemaForm").unbind('submit').bind('submit', function() {
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
										temaTable.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#editTema").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 3000,});
									}
								} // /success
							}); // /ajax

						return false;
					});

	});
	function removeTema(id = null) {
		if(id) {
			// click on remove button
			$("#removeBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: 'modul/administrasi/hapustema.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 2000,});

							// refresh the table
							temaTable.ajax.reload(null, false);

							// close the modal
							$("#removeTemaModal").modal('hide');

						} else {
							swal(response.messages, {buttons: false,timer: 3000,});
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