<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Saran dan Pesan';
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
						  <h4>Saran dan Pesan di Raport</h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							 <div class="table-responsive">
										<table id="manageMemberTable" class="display table">
											<thead>
                                            <tr>
													<th class="text-center" width="30%">Nama Siswa</th>
													<th class="text-center">Saran</th>
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
		<div class="modal fade" tabindex="-1" id="mod-saran" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Tambah Saran dan Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" action="../modul/saran/simpan.php" autocomplete="off" method="POST" id="saranForm">
						<div class="fetched-data"></div>
                        
						</form>
              </div>
            </div>
          </div>
        </div>
		
		
		<!--Delete Nilai-->
		<div class="modal fade" id="removeSaranModal">
          <div class="modal-dialog">
            <div class="modal-content">
                        <div class="modal-body">
							<p>Hapus Saran?</p>
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
				"ajax": "../modul/saran/saran.php?kelas=<?=$kelas;?>&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
				"order": []
			} );
		$('#mod-saran').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('pdid');
			var rowsmt = $(e.relatedTarget).data('smt');
			var rowtapel = $(e.relatedTarget).data('tapel');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/saran/tambah.php',
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
		$("#saranForm").unbind('submit').bind('submit', function() {

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
								$("#mod-saran").modal('hide');

								// reload the datatables
								manageMemberTable.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
								$("#mod-saran").modal('hide');
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
			// submit form
	});
	function removeSaran(id = null) {
		if(id) {
			// click on remove button
			$("#removeBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/saran/hapus.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 2000,});

							// refresh the table
							manageMemberTable.ajax.reload(null, false);

							// close the modal
							$("#removeSaranModal").modal('hide');

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