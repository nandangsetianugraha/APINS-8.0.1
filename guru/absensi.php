<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Absensi';
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
				<div class="col-md-6 col-lg-12 col-xl-6">
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar Siswa Kelas <?=$kelas;?></h4>
					  <div class="card-header-form">
						<input type="text" name="tglabsen" id="tglabsen" class="form-control datepicker">
						<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>">
						<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>">
						<input type="hidden" name="kelas" id="kelas" class="form-control" value="<?=$kelas;?>">
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="absenTable">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
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
					  <h4>Absensi Kelas <?=$kelas;?></h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="dataabsen">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>Absensi</th>
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
		<div class="modal fade" id="tambahAbsen">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Absensi Siswa</h4>
              </div>
                        <form class="form-horizontal" action="../modul/siswa/tambahabsen.php" autocomplete="off" method="POST" id="createAbsenForm">
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
	var absenTable;
	var dataabsen;
	$(document).ready(function() {
		var tabsen=$('#tglabsen').val();
		var smt=$('#smt').val();
		var tapel=$('#tapel').val();
		var kelas=$('#kelas').val();
		absenTable = $('#absenTable').DataTable( {
			"destroy":true,
			"searching": true,
			"paging":false,
			"ajax": "../modul/siswa/absensiku.php?kelas="+kelas+"&tapel="+tapel+"&tgl="+tabsen,
			"order": []
		} );
		dataabsen = $('#dataabsen').DataTable( {
			"destroy":true,
			"searching": true,
			"paging":false,
			"ajax": "../modul/siswa/dataabsen.php?kelas="+kelas+"&tapel="+tapel+"&tgl="+tabsen,
			"order": []
		} );
		$('#tglabsen').change(function(){
			//Mengambil value dari option select kd kemudian parameternya dikirim menggunakan ajax
			var tabsen=$('#tglabsen').val();
			var smt=$('#smt').val();
			var tapel=$('#tapel').val();
			var kelas=$('#kelas').val();
			absenTable = $('#absenTable').DataTable( {
				"destroy":true,
				"searching": true,
				"paging":false,
				"ajax": "../modul/siswa/absensiku.php?kelas="+kelas+"&tapel="+tapel+"&tgl="+tabsen,
				"order": []
			} );
			dataabsen = $('#dataabsen').DataTable( {
				"destroy":true,
				"searching": true,
				"paging":false,
				"ajax": "../modul/siswa/dataabsen.php?kelas="+kelas+"&tapel="+tapel+"&tgl="+tabsen,
				"order": []
			} );
		});
		$('#tambahAbsen').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('pdid');
			var rowtgl = $(e.relatedTarget).data('tgls');
			var rowtapel = $(e.relatedTarget).data('tapel');
			var rowkelas = $(e.relatedTarget).data('kelas');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/siswa/modal_absen.php',
                data :  'rowid='+ rowid +'&kelas='+rowkelas+'&tapel='+rowtapel+'&tgl='+rowtgl,
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
		 $("#createAbsenForm").unbind('submit').bind('submit', function() {

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
								swal(response.messages, {buttons: false,timer: 500,});
								// reset the form
								$("#tambahAbsen").modal('hide');

								// reload the datatables
								absenTable.ajax.reload(null, false);
								dataabsen.ajax.reload(null, false);
								
							} else {
								swal(response.messages, {buttons: false,timer: 500,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member
	});
</script>

</body>
</html>