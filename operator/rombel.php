<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Pelaporan Format F1';
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
						  <h4>Daftar Rombel Tahun Pelajaran <?=$tapel;?></h4>
						  <div class="card-header-form">
							<a href="#" data-toggle="modal" data-target="#tambahKelas" title="Contacts" id="<?=$tapel;?>" class="btn btn-info btn-border btn-round btn-sm">
										<span class="btn-label">
											<i class="fa fa-plus"></i>
										</span>
										Rombel
									</a>
						  </div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="KelasTable" class="display table">
											<thead>
											   <tr>
													<th>Nama Rombel</th>
													<th>Kurikulum</th>
													<th>Wali Kelas</th>
													<th>Pendamping</th>
													<th>Guru PAI</th>
													<th>Guru Penjas</th>
													<th>Guru Bahasa Inggris</th>
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
		<!--Tambah Kelas-->
		<div class="modal fade" id="tambahKelas">
          <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah Rombel</h4>
				</div>
                <form class="form-horizontal" action="../modul/setting/tambahKelas.php" autocomplete="off" method="POST" id="createKelasForm">
					<div class="fetched-data"></div>
				</form>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		<!--Edit Kelas-->
		<div class="modal fade" id="editKelas">
          <div class="modal-dialog">
            <div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Rombel</h4>
				</div>
                <form class="form-horizontal" action="../modul/setting/updateKelas.php" autocomplete="off" method="POST" id="updateKelasForm">
					<div class="fetched-data"></div>
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
<script type="text/javascript" language="javascript" class="init">
	var KelasTable;
	$(document).ready(function() {
		KelasTable = $('#KelasTable').DataTable( {
			"destroy":true,
			"searching": false,
			"paging":false,
			"ajax": "../modul/setting/daftarKelas.php?tapel=<?=$tapel;?>",
			"order": []
		} );
		$('#tambahKelas').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/setting/modal_Kelas.php',
                data :  'tapel=<?=$tapel;?>',
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		
		$("#createKelasForm").unbind('submit').bind('submit', function() {

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
								$("#tambahKelas").modal('hide');

								// reload the datatables
								KelasTable.ajax.reload(null, false);
								//$("#createKDForm")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
		
		$('#editKelas').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/setting/edit_Kelas.php',
                data :  'id='+rowid,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		$("#updateKelasForm").unbind('submit').bind('submit', function() {

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
								$("#editKelas").modal('hide');

								// reload the datatables
								KelasTable.ajax.reload(null, false);
								//$("#createKDForm")[0].reset();
								// this function is built in function of datatables;

							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
	});
</script>
</body>
</html>