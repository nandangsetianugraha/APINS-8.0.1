<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Penempatan Siswa';
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
					  <h4>Daftar Siswa yang belum dimapping</h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="manageSiswa">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>Kelas Sebelumnya</th>
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
				<div class="col-md-6 col-lg-12 col-xl-6">
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar Siswa Kelas <?=$kelas;?></h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table class="table table-striped" id="managePenempatan">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
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
		<!--Modal Hapus Siswa-->
		<div class="modal fade" id="outMemberModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Keluar Rombel</h4>
              </div>
                        <div class="modal-body">
							<p>Keluarkan Siswa dari Kelas <?=$kelas;?>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-border btn-round" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-info btn-border btn-round" id="outBtn">Ya</button>
                        </div>
			</div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		<div class="modal fade" id="penempatanMemberModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Tempatkan Siswa</h4>
              </div>
                        <form class="form" action="../modul/siswa/penempatansiswa.php" method="POST" id="penempatanMemberForm">
						<div class="modal-body">
							<div class="form-group form-group-default">
								<label>Nama Siswa</label>
								<input type="hidden" class="form-control" id="tapel" name="tapel" value="<?=$tapel;?>">
								<input id="penempatannama" type="text" name="penempatannama" autocomplete=off class="form-control" placeholder="Nama Lengkap">
							</div>
							<div class="form-group form-group-default">
								<label>Kelas</label>
								<select class="form-control" name="kelas" id="kelas">
									<?php 
									$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' order by nama_rombel asc");
									while($nk=mysqli_fetch_array($sql_mk)){
									?>
									<option value="<?php echo $nk['nama_rombel']; ?>" <?php if($kelas==$nk['nama_rombel']){echo "selected";} ?>>Kelas <?php echo $nk['nama_rombel']; ?></option>
									<?php };?>
								</select>
							</div>
                        </div>
                        <div class="modal-footer penempatanMemberModal">
                            <button type="button" class="btn btn-info btn-border btn-round" data-dismiss="modal">Tidak</button>
                            <button type="submit" class="btn btn-info btn-border btn-round">Ya</button>
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
	
	var manageSiswa;
	var managePenempatan;
	$(document).ready(function() {
		manageSiswa = $("#manageSiswa").DataTable({
			"searching": true,
			"paging":true,
			"ajax": "../modul/siswa/siswakosong.php?tapel=<?=$tapel;?>",
			"order": []
		});
		managePenempatan = $("#managePenempatan").DataTable({
			"searching": true,
			"paging":true,
			"ajax": "../modul/siswa/kelasku.php?kelas=<?=$kelas;?>&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
			"order": []
		});
	});
	function penempatanMember(id = null) {
		if(id) {

			// remove the error 
			$(".form-group").removeClass('has-error').removeClass('has-success');
			$(".text-danger").remove();
			$("#penempatan").modal('hide');
			// remove the id
			$("#member_id").remove();

			// fetch the member data
			$.ajax({
				url: '../modul/siswa/lihatsiswa.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					$("#penempatannama").val(response.nama);
					// mmeber id 
					$(".penempatanMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');
					// here update the member data
					$("#penempatanMemberForm").unbind('submit').bind('submit', function() {
						// remove error messages
						$(".text-danger").remove();
						var form = $(this);
						// validation
						var kelas = $("#kelas").val();
						var tapel = $("#tapel").val();
							$.ajax({
								url: form.attr('action'),
								type: form.attr('method'),
								data: form.serialize(),
								dataType: 'json',
								success:function(response) {
									if(response.success == true) {
										swal('Siswa berhasil dimasukkan ke dalam rombel', {
											buttons: false,
											timer: 3000,
										});
										// reload the datatables
										manageSiswa.ajax.reload(null, false);
										managePenempatan.ajax.reload(null, false);
										// this function is built in function of datatables;
										// remove the error 
										$("#penempatanMemberModal").modal('hide');
										$("#penempatan").modal('show');
									} else {
										swal('Terjadi kesalahan sistem', {
											buttons: false,
											timer: 3000,
										});
									}
								} // /success
							}); // /ajax
						return false;
					});
				} // /success
			}); // /fetch selected member info
		} else {
			swal('Error : Silahkan Refresh Halaman kembali!', {buttons: false,timer: 3000,});
		}
	}
	function outMember(id = null) {
		if(id) {
			// click on remove button
			$("#outBtn").unbind('click').bind('click', function() {
				$.ajax({
					url: '../modul/siswa/outsiswa.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						if(response.success == true) {						
							swal('Siswa berhasil dikeluarkan dari rombel!', {buttons: false,timer: 3000,});
							// refresh the table
							manageSiswa.ajax.reload(null, false);
							managePenempatan.ajax.reload(null, false);

							// close the modal
							$("#outMemberModal").modal('hide');

						} else {
							swal('Terjadi kesalahan sistem!', {
								buttons: false,
								timer: 3000,
							});
						}
					}
				});
			}); // click remove btn
		} else {
			swal('Error : Silahkan Refresh Halaman kembali!', {buttons: false,timer: 3000,});
		};
		
		function editMember(id = null) {
			if(id) {
				// remove the error 
				$(".form-group").removeClass('has-error').removeClass('has-success');
				$(".text-danger").remove();
				// empty the message div
				$(".edit-messages").html("");
				// remove the id
				$("#member_id").remove();
				$.ajax({
					url: 'modul/siswa/lihatsiswa.php',
					type: 'post',
					data: {member_id : id},
					dataType: 'json',
					success:function(response) {
						$("#editnama").val(response.nama);
						$("#edittempat").val(response.tempat);
						$("#edittanggal").val(response.tanggal);
						$("#editjk").val(response.jk);	
						$("#editnis").val(response.nis);	
						$("#editnisn").val(response.nisn);	
						$("#editnik").val(response.nik);	
						$("#editalamat").val(response.alamat);	
						$("#editayah").val(response.nama_ayah);	
						$("#editibu").val(response.nama_ibu);	

						// mmeber id 
						$(".editMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');

						// here update the member data
						$("#editMemberForm").unbind('submit').bind('submit', function() {
							// remove error messages
							$(".text-danger").remove();

							var form = $(this);

							// validation
							var editnama = $("#editnama").val();
							var edittempat = $("#edittempat").val();
							var edittanggal = $("#edittanggal").val();
							var editjk = $("#editjk").val();
							var editnis = $("#editnis").val();
							var editnisn = $("#editnisn").val();
							var editnik = $("#editnik").val();
							var editalamat = $("#editalamat").val();
							var editayah = $("#editayah").val();
							var editibu = $("#editibu").val();
								$.ajax({
									url: form.attr('action'),
									type: form.attr('method'),
									data: form.serialize(),
									dataType: 'json',
									success:function(response) {
										if(response.success == true) {
											$.notify({
												icon: 'flaticon-alarm-1',
												title: 'Sukses',
												message: response.messages,
											},{
												type: 'info',
												placement: {
												from: "bottom",
												align: "left"
											},
												time: 10,
											});

											// reload the datatables
											manageMemberTable.ajax.reload(null, false);
											// this function is built in function of datatables;

											// remove the error 
											$("#editMemberModal").modal('hide');
										} else {
											$.notify({
												icon: 'flaticon-alarm-1',
												title: 'Sukses',
												message: response.messages,
											},{
												type: 'info',
												placement: {
												from: "bottom",
												align: "left"
											},
												time: 10,
											});
										}
									} // /success
								}); // /ajax

							return false;
						});

					} // /success
				}); // /fetch selected member info
			}else{
				swal('Error : Silahkan Refresh Halaman kembali!', {buttons: false,timer: 3000,});
			}
		}
	}
</script>
</body>
</html>