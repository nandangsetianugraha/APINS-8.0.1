<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'ID Pegawai';
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
            	  <div class="card">
					<div class="card-header">
					  <h4>ID Pegawai</h4>
					  <div class="card-header-form">
						<a href="#" data-toggle="modal" data-toggle="modal" data-target="#NGuru"><i class="fa fa-plus"></i> Tambah</a>
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table id="manageMemberTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
									<th class="text-center">ID Pegawai</th>
									<th class="text-center">Nama Pegawai</th>
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
        </section>
		<div class="modal fade" id="NGuru">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">ID Pegawai</h4>
              </div>
                        <form class="form" action="../modul/penggajian/simpanID.php" method="POST" id="guruForm">
						<div class="modal-body">
							<div class="form-group">
								<label for="output-device">ID Pegawai</label>
								<input type="text" class="form-control" id="idNasabah" name="idNasabah" placeholder="ID Pegawai" autocomplete=off>
							</div>
							<div class="form-group">
								<label for="output-device">Pilih Guru</label>
								<select id="idsis" class="form-control selectguru" style="width: 100%;" name="idsis">
									<option>Pilih Guru</option>
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from ptk where status_keaktifan_id=1 order by nama asc");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?php echo $nk['ptk_id']; ?>"><?=$nk['nama']; ?></option>
									<?php };?>
								</select>
							</div>
                        </div>
                        <div class="modal-footer ptkModal">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>
                        </div>
						</form>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		<div class="modal fade" id="hapusData">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus ID Pegawai</h4>
              </div>
                        <div class="modal-body">
							<p>Hapus ID Pegawai?<br/>Jika ID Pegawai Dihapus, Otomatis semua data Absensi akan dihapus juga.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-danger waves-effect waves-light" id="outBtn">Ya</button>
                        </div>
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
	
$(document).ready(function(){
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": true,
	  "paging":true,
	  "ajax": "../modul/penggajian/idpegawai.php",
	  "order": []
	});
	$("#guruForm").unbind('submit').bind('submit', function() {
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
										$("#guruForm")[0].reset();
										$('#idsis').val(null).trigger('change');
										$("#NGuru").modal('hide');
										$("#manageMemberTable").dataTable({
											"destroy":true,
										  "searching": true,
										  "paging":true,
										  "ajax": "../modul/penggajian/idpegawai.php",
										  "order": []
										});
										// this function is built in function of datatables;

										// remove the error 
									} else {
										swal(response.messages, {buttons: false,timer: 2000,});
									}
								} // /success
							}); // /ajax

						return false;
					});
  
});  
function outMember(id = null) {
		if(id) {
			// click on remove button
			$("#outBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/penggajian/hapusID.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal(response.messages, {buttons: false,timer: 2000,});

							// refresh the table
							$("#manageMemberTable").dataTable({
								"destroy":true,
							  "searching": true,
							  "paging":true,
							  "ajax": "../modul/penggajian/idpegawai.php",
							  "order": []
							});

							// close the modal
							$("#hapusData").modal('hide');

						} else {
							swal(response.messages, {buttons: false,timer: 2000,});
						}
					}
				});
			}); // click remove btn
		} else {
			alert('Error: Refresh the page again');
		};
		
		
	}
	function highlightEdit(editableObj) {
		$(editableObj).css("background","#FFF0000");
	} 
	function simpankes(editableObj,column,id) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/penggajian/saveTunj.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id,
			success: function(response)  {
				console.log(response);
				// set updated value as old value
				$(editableObj).attr('data-old_value',editableObj.innerHTML);
				$(editableObj).css("background","#FDFDFD");	
				
			}          
	   });
	}
</script>
</body>
</html>