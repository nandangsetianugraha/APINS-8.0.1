<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Raport Spiritual';
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
						  <h4>Raport Spiritual Tahun Pelajaran <?=$tapel;?> Semester <?=$smt;?></h4>
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
							<div id="mod-loader-raport" style="display: none; text-align: center;">
								<img src="ajaxloading.gif"><br/>Sedang Proses Generate Nilai Raport......
							</div>
							<div id="diagram" class="table-responsive">
								<table id="Raportku" class="display table">
									<thead>
									   <tr>
											<th width="25%">Nama</th>
											<th>Deskripsi</th>
											<th width="5%"></th>
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
		<div class="modal fade" id="editRaport">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Raport</h4>
              </div>
                        <form class="form-horizontal" action="../modul/raport/updateSikap.php" autocomplete="off" method="POST" id="updateSikapForm">
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
	var Raportku;
	$(document).ready(function() {
		var kelas = $('#kelas').val();
		var tapel = $('#tapel').val();
		var smt = $('#smt').val();
		Raportku = $("#Raportku").DataTable({
			"destroy":true,
			"searching": false,
			"paging":false,
			"ajax": "../modul/raport/RaportSpiritual.php?kelas="+kelas+"&tapel="+tapel+"&smt="+smt,
			"order": []
		});
		$('#kelas').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kelas = $('#kelas').val();
			var tapel = $('#tapel').val();
			var smt = $('#smt').val();
			Raportku = $("#Raportku").DataTable({
				"destroy":true,
				"searching": false,
				"paging":false,
				"ajax": "../modul/raport/RaportSpiritual.php?kelas="+kelas+"&tapel="+tapel+"&smt="+smt,
				"order": []
			});
		});
		$(document).on('click', '#getRaport', function(e){
		
			e.preventDefault();
			
			var ukelas = $(this).data('kelas');
			var utapel = $(this).data('tapel');			// it will get id of clicked row
			var usmt = $(this).data('smt');
			var updid = $(this).data('pdid');
			$('#mod-loader-raport').show();
			$('#diagram').hide();
			
			$.ajax({
				url: '../modul/raport/Generate-KI1.php',
				type: 'POST',
				data: 'kelas='+ukelas+'&tapel='+utapel+'&smt='+usmt+'&pdid='+updid,
				dataType: 'html'
			})
			.done(function(data){
				//console.log(data);	
				$('#mod-loader-raport').hide();
				$('#diagram').show();
				Raportku.ajax.reload(null, false);
				swal(response.messages, {buttons: false,timer: 2000,});		
			})
			.fail(function(){
				$('#mod-loader-raport').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
				$('#mod-loader-raport').show();
				$('#diagram').hide();
			});
			
		});
		//edit Raport
		$('#editRaport').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
			//menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : '../modul/raport/edit-sikap.php',
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
		 //Update Raport 
		 $("#updateSikapForm").unbind('submit').bind('submit', function() {
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
										Raportku.ajax.reload(null, false);
										// this function is built in function of datatables;

										// remove the error 
										$("#editRaport").modal('hide');
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
	});
</script>
</body>
</html>