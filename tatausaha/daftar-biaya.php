<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Daftar Biaya';
//view('template/head', $data);
include "../template/head.php";
?>
<link rel="stylesheet" href="croppie.css" />
<style>
#imgChange {
	background: url("overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
	bottom: 0;
	color: #FFFFFF;
	display: block;
	height: 30px;
	left: 0;
	line-height: 32px;
	position: absolute;
	text-align: center;
	width: 100%;
}
#imgChange input[type="file"] {
	bottom: 0;
	cursor: pointer;
	height: 100%;
	left: 0;
	margin: 0;
	opacity: 0;
	padding: 0;
	position: absolute;
	width: 100%;
	z-index: 0;
}
</style>
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
            <div class="row mt-sm-4">
				
				<div class="col-12">
				  <div class="card">
					<div class="card-header">
					  <h4>Daftar Siswa Tahun Pelajaran <?=$tapel;?></h4>
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
						<table class="table table-striped" id="manageMemberTable">
							<thead>
							   <tr>
									<th>Nama Siswa</th>
									<th>NIS</th>
									<th>NISN</th>
									<th>TTL</th>
									<th>JK</th>
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
		
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="croppie.js"></script>
	<script>  
$(document).ready(function(){
	var kelas = $('#kelas').val();
	$("#manageMemberTable").dataTable({
		"destroy":true,
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/keuangan/tarif.php?kelas="+kelas+"&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
	  "columnDefs": [
		{ "sortable": false, "targets": [5] }
	  ]
	});
	$('#kelas').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kelas = $('#kelas').val();
			$("#manageMemberTable").dataTable({
				"destroy":true,
			  "searching": false,
			  "paging":true,
			  "ajax": "../modul/siswa/siswa.php?kelas="+kelas+"&smt=<?=$smt;?>&tapel=<?=$tapel;?>",
			  "columnDefs": [
				{ "sortable": false, "targets": [5] }
			  ]
			});
	});
	$('#provinsi').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var prov = $('#provinsi').val();
			$.ajax({
				type : 'GET',
				url : '../function/kabupaten.php',
				data :  'prov_id=' + prov,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kabupaten").html(data);
				}
			});
	});

	$('#kabupaten').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var kab = $('#kabupaten').val();
			$.ajax({
				type : 'GET',
				url : '../function/kecamatan.php',
				data :  'id_kabupaten=' + kab,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kecamatan").html(data);
				}
			});
	});

	$('#kecamatan').change(function(){
			//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
			var desa = $('#kecamatan').val();
			$.ajax({
				type : 'GET',
				url : '../function/desa.php',
				data :  'id_kecamatan=' + desa,
				success: function (data) {
					//jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
					$("#kelurahan").html(data);
					// alert($('#provinsi option:selected').text() + $('#kabupaten option:selected').text() + $('#kecamatan option:selected').text() + $('#desa option:selected').text());
				}
			});
	});
    $image_crop = $('#image_demo').croppie({
		enableExif: true,
		viewport: {
		  width:200,
		  height:200,
		  type:'square' //circle
		},
		boundary:{
		  width:300,
		  height:300
		}
	});

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload.php?idp=<?=$idsiswa;?>",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
          $('#uploaded_image').html(data);
		  swal('Foto Profil berhasil diubah', {buttons: false,timer: 1000,});
        }
      });
    })
  });
  
  $("#ubahForm").unbind('submit').bind('submit', function() {

				var form = $(this);

				

					//submi the form to server
					$.ajax({
						url : form.attr('action'),
						type : form.attr('method'),
						data : form.serialize(),
						dataType : 'json',
						success:function(response) {

							// remove the error 
							
							if(response.success == true) {
								swal(response.messages, {buttons: false,timer: 1000,});
								setTimeout(function () {window.open("siswa","_self");},1000)
								// reset the form
							
							} else {
								swal(response.messages, {buttons: false,timer: 1000,});
							}  // /else
						} // success  
					}); // ajax subit 				
				


				return false;
			}); // /submit form for create member

});  
</script>
  <script>
  
  
  </script>
</body>
</html>