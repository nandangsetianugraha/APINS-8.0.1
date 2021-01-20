<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Catatan Sosial';
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
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Penilaian Sikap Sosial Kelas <?=$kelas;?></h4>
					  <div class="card-header-form">
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
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
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="sosTable">
							<thead>
								<tr>
									<th class="text-center" width="45%">Nama Siswa</th>
									<th class="text-center">Catatan Perilaku</th>
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
		<!--Modal tambah Sikap-->
		<div class="modal fade" id="tambahNilai">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Nilai Sosial</h4>
              </div>
                        <form class="form-horizontal" action="../modul/administrasi/tambahsos.php" autocomplete="off" method="POST" id="createSosForm">
							<div class="fetched-data"></div>
						</form>
						
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		<!--Delete Nilai-->
		<div class="modal fade" id="removeNilaiModal">
          <div class="modal-dialog">
            <div class="modal-content">
                        <div class="modal-body">
							<p>Hapus Nilai Sosial?</p>
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
	var sosTable;
	$(document).ready(function() {
		var kelas = $('#kelas').val();
		var tapel = $('#tapel').val();
		var smt = $('#smt').val();
		sosTable = $('#sosTable').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/administrasi/sosial.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
				"order": []
			} );
		$('#tambahNilai').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('pdid');
			var rowsmt = $(e.relatedTarget).data('smt');
			var rowtapel = $(e.relatedTarget).data('tapel');
			var rowkelas = $(e.relatedTarget).data('kelas');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'get',
                url : '../modul/administrasi/modal_sos.php',
                data :  'peta=2&kelas='+rowkelas+'&smt='+rowsmt+'&tapel='+rowtapel+'&idpd='+rowid,
				beforeSend: function()
						{	
							$(".fetched-data").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading ...');
						},
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
		 $('#kelas').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kelas = $('#kelas').val();
			var tapel = $('#tapel').val();
			var smt = $('#smt').val();
			$('#sosTable').DataTable( {
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/administrasi/sosial.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
				"order": []
			} );
		});
		 $("#createSosForm").unbind('submit').bind('submit', function() {

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
								var kelas = $('#kelas').val();
								var tapel = $('#tapel').val();
								var smt = $('#smt').val();
								swal(response.messages, {buttons: false,timer: 2000,});

								// reset the form
								$("#tambahNilai").modal('hide');

								// reload the datatables
								$('#sosTable').DataTable( {
									"destroy":true,
									"searching": false,
									"paging":false,
									"ajax": "../modul/administrasi/sosial.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
									"order": []
								} );
								
							} else {
								swal(response.messages, {buttons: false,timer: 2000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
	});
	function removeSos(id = null) {
		if(id) {
			// click on remove button
			$("#removeBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/administrasi/hapussos.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {		
							var kelas = $('#kelas').val();
							var tapel = $('#tapel').val();
							var smt = $('#smt').val();
							swal(response.messages, {buttons: false,timer: 2000,});

							// refresh the table
							$('#sosTable').DataTable( {
								"destroy":true,
								"searching": false,
								"paging":false,
								"ajax": "../modul/administrasi/sosial.php?kelas="+kelas+"&smt="+smt+"&tapel="+tapel,
								"order": []
							} );

							// close the modal
							$("#removeNilaiModal").modal('hide');

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