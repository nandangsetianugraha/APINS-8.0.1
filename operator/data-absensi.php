<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Data Absensi Raport';
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
						  <h4>Data Absensi Raport</h4>
						  <div class="card-header-form">
								<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
								<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
								<div class="form-group">
									<select class="form-control" id="kelas" name="kelas">
										<?php 
										$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
										while($nk=mysqli_fetch_array($sql_mk)){
										?>
										<option value="<?=$nk['nama_rombel'];?>">Kelas <?=$nk['nama_rombel'];?></option>
										<?php };?>
									</select>
								</div>
						  </div>
						</div>
						<div class="card-body">
							 <div class="table-responsive">
										<table id="manageMemberTable" class="display table">
											<thead>
                                            <tr>
													<th class="text-center" width="30%">Nama Siswa</th>
													<th class="text-center">Sakit</th>
													<th class="text-center">Ijin</th>
													<th class="text-center">Tanpa Keterangan</th>
													<th class="text-center"></th>
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
		<div class="modal fade" tabindex="-1" id="syncabsen" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Pengambilan Data Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" action="../modul/siswa/simpan-data-absen.php" autocomplete="off" method="POST" id="absenForm">
					<div class="fetched-data"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
		
		
		<!--Delete Nilai-->
		<div class="modal fade" tabindex="-1" id="editabsen" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Pengambilan Data Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" action="../modul/siswa/edit-data-absen.php" autocomplete="off" method="POST" id="editabsenForm">
					<div class="fetched-data"></div>
                </form>
              </div>
            </div>
          </div>
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
		var tapel = $('#tapel').val();
		var kelas=$('#kelas').val();
		var smt=$('#smt').val();
		manageMemberTable = $("#manageMemberTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/siswa/data-absen.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
				"order": []
			} );
		$('#kelas').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var tapel = $('#tapel').val();
			var kelas=$('#kelas').val();
			var smt=$('#smt').val();
			
			manageMemberTable = $("#manageMemberTable").DataTable({
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/siswa/data-absen.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
				"order": []
			} );
		});
		$('#editabsen').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/siswa/editabsen.php',
                data :  'rowid='+ rowid,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
				$(".smpn").show();
                }
            });
         });
		 $("#editabsenForm").unbind('submit').bind('submit', function() {

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
								$("#editabsen").modal('hide');

								// reload the datatables
								manageMemberTable.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
								$("#editabsen").modal('hide');
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
		 
		$('#syncabsen').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			var rowsmt = $(e.relatedTarget).data('smt');
			var rowtapel = $(e.relatedTarget).data('tapel');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/siswa/syncabsen.php',
                data :  'rowid='+ rowid +'&smt='+rowsmt+'&tapel='+rowtapel,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
				$(".smpn").show();
                }
            });
         });
		$("#absenForm").unbind('submit').bind('submit', function() {

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
								$("#syncabsen").modal('hide');

								// reload the datatables
								manageMemberTable.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
								$("#syncabsen").modal('hide');
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
			// submit form
	});
</script>
</body>
</html>