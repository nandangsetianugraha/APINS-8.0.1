<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Data Kesehatan';
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
						  <h4>Data Kesehatan</h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							 <div class="table-responsive">
										<table id="manageMemberTable" class="display table">
											<thead>
                                            <tr>
												<th class="text-center">Nama Siswa</th>
												<th class="text-center">Tinggi (cm)</th>
												<th class="text-center">Berat (Kg)</th>
												<th class="text-center">Pendengaran</th>
												<th class="text-center">Penglihatan</th>
												<th class="text-center">Gigi</th>
												<th class="text-center">Lainnya</th>
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
		<!--Modal tambah Kesehatan-->
		<div class="modal fade" tabindex="-1" id="mod-kesehatan" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Tambah Data Kesehatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" action="../modul/siswa/simpankesehatan.php" autocomplete="off" method="POST" id="kesehatanForm">
					<div class="fetched-data"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
		
		
		<!--Edit Kesehatan-->
		<div class="modal fade" id="editKesehatan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Data Kesehatan</h4>
              </div>
                        <form class="form-horizontal" action="../modul/siswa/updatekesehatan.php" autocomplete="off" method="POST" id="updatekesehatan">
							<div class="edit-data"></div>
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
<script type="text/javascript" language="javascript" class="init">
	var manageMemberTable;
	$(document).ready(function() {
		manageMemberTable = $("#manageMemberTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/siswa/kesehatan.php?kelas=<?=$kelas;?>&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
				"order": []
			} );
	});
	$('#mod-kesehatan').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('pdid');
			var rowsmt = $(e.relatedTarget).data('smt');
			var rowtapel = $(e.relatedTarget).data('tapel');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/siswa/tambahkesehatan.php',
                data :  'rowid='+ rowid +'&smt='+rowsmt+'&tapel='+rowtapel,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							$(".smpn").hide();
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
				$(".smpn").show();
                }
            });
         });
	$('#editKesehatan').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('pdid');
			var rowsmt = $(e.relatedTarget).data('smt');
			var rowtapel = $(e.relatedTarget).data('tapel');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/siswa/editkesehatan.php',
                data :  'rowid='+ rowid +'&smt='+rowsmt+'&tapel='+rowtapel,
				beforeSend: function()
						{	
							$(".edit-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
							$(".smpn").hide();
						},
                success : function(data){
                $('.edit-data').html(data);//menampilkan data ke dalam modal
				$(".smpn").show();
                }
            });
         });
		 
	$("#kesehatanForm").unbind('submit').bind('submit', function() {

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
								$("#mod-kesehatan").modal('hide');

								// reload the datatables
								manageMemberTable.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
			// submit form
	$("#updatekesehatan").unbind('submit').bind('submit', function() {

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
								$("#editKesehatan").modal('hide');

								// reload the datatables
								manageMemberTable.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
			// submit form
</script>
</body>
</html>