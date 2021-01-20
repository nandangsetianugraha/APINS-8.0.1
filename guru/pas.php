<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'PAS';
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
						  <h4>Penilaian Akhir Semester</h4>
						  <div class="card-header-form">
							
						  </div>
						</div>
						<div class="card-body">
							<div class="form-row">
								<input type="hidden" name="tapel" id="tapel" class="form-control" value="<?=$tapel;?>" placeholder="Username">
								<input type="hidden" name="smt" id="smt" class="form-control" value="<?=$smt;?>" placeholder="Username">
								<div class="form-group col-md-2">
									<label for="inputEmail4">Kelas</label>
									<?php if($level==96){?>
									<select class="form-control" id="kelas" name="kelas">
										<option value="0">Pilih Rombel</option>
										<?php 
										$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and pai='$idku' order by nama_rombel asc");
										while($nk=mysqli_fetch_array($sql_mk)){
										?>
										<option value="<?=$nk['nama_rombel'];?>"><?=$nk['nama_rombel'];?></option>
										<?php };?>
									</select>
									<?php }elseif($level==95){ ?>
									<select class="form-control" id="kelas" name="kelas">
										<option value="0">Pilih Rombel</option>
										<?php 
										$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and penjas='$idku' order by nama_rombel asc");
										while($nk=mysqli_fetch_array($sql_mk)){
										?>
										<option value="<?=$nk['nama_rombel'];?>"><?=$nk['nama_rombel'];?></option>
										<?php };?>
									</select>
									<?php }elseif($level==94){ ?>
									<select class="form-control" id="kelas" name="kelas">
										<option value="0">Pilih Rombel</option>
										<?php 
										$sql_mk=mysqli_query($koneksi, "select * from rombel where tapel='$tapel' and inggris='$idku' order by nama_rombel asc");
										while($nk=mysqli_fetch_array($sql_mk)){
										?>
										<option value="<?=$nk['nama_rombel'];?>"><?=$nk['nama_rombel'];?></option>
										<?php };?>
									</select>
									<?php }else{ ?>
									<select class="form-control" id="kelas" name="kelas">
										<option value="<?=$kelas;?>"><?=$kelas;?></option>
									</select>
									<?php }; ?>
								  </div>
								  <div class="form-group col-md-4">
									<label for="inputPassword4">Mata Pelajaran</label>
									<?php if($level==98 or $level==97){ ?>
									<select class="form-control" id="mp" name="mp">
										<option value="0">==Pilih Mapel==</option>
									<?php 
									$sql2 = "select * from mapel";
									$qu3 = mysqli_query($koneksi,$sql2) or die("database error:". mysqli_error($koneksi));
									while($po=mysqli_fetch_array($qu3)){
										$idmp=$po['id_mapel'];
										if($idmp==1 or $idmp==10){
											
										}else{
											if($ab<4 and ($idmp==5 or $idmp==6)){
												
											}else{
												if($ab>3 and $idmp==8){
													
												}else{
									?>
										<option value="<?=$po['id_mapel'];?>"><?=$po['nama_mapel'];?></option>
									<?php };
									};
									};
									};?>
									</select>
									<?php }; ?>
									<?php if($level==96){ //mapel PAI ?>
									<select class="form-control" id="mp" name="mp">
									</select>
									<?php }; ?>
									<?php if($level==95){ //mapel PJOK ?>
									<select class="form-control" id="mp" name="mp">
									</select>
									<?php }; ?>
									<?php if($level==94){ //mapel Inggris ?>
									<select class="form-control" id="mp" name="mp">
									</select>
									<?php }; ?>
								</div>
							</div>
							
							
						  <div class="table-responsive">
							<div id="nilaiPTS">
								<div class="alert alert-info alert-dismissible">
									<h4><i class="icon fa fa-info"></i> Informasi</h4>
									Silahkan Pilih Mata Pelajaran
								</div>
							</div>
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
  <script type="text/javascript" language="javascript" class="init">
	$(document).ready(function() {
		<?php if($level==98 or $level==97){ ?>
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var smt=<?=$smt;?>;
			var peta=<?=$peta;?>;
			var tapel=$('#tapel').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/semester/NilaiPAS.php',
				data :  'mp=' + mp+'&kelas='+kelas+'&smt='+smt+'&peta='+peta+'&tapel='+tapel,
				beforeSend: function()
				{	
					$("#nilaiPTS").html('<div class="alert alert-info alert-dismissible"><h4><i class="fa fa-spinner fa-pulse fa-fw"></i> Memuat Data Nilai PAS Kelas '+kelas+'</h4></div>');
				},
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kd
					$("#nilaiPTS").html(data);
				}
			});
		});
		
		<?php }else{ ?>
		$('#kelas').change(function(){
			//Mengambil value dari option select kd kemudian parameternya dikirim menggunakan ajax
			var kelas=$('#kelas').val();
			var level=<?=$level;?>;
			
			$.ajax({
				type : 'GET',
				url : '../function/mpls.php',
				data :  'kelas=' +kelas+'&level='+level,
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select mp
					$("#mp").html(data);
					$("#kd").html('');
					$("#nilaiPTS").html('<div class="alert alert-info alert-dismissible"><h4><i class="icon fa fa-info"></i> Informasi</h4>Silahkan Pilih Mata Pelajaran</div>');
				}
			});
		});
		$('#mp').change(function(){
			//Mengambil value dari option select mp kemudian parameternya dikirim menggunakan ajax
			var mp = $('#mp').val();
			var kelas=$('#kelas').val();
			var smt=<?=$smt;?>;
			var peta=<?=$peta;?>;
			var tapel=$('#tapel').val();
			
			$.ajax({
				type : 'GET',
				url : '../modul/semester/NilaiPAS.php',
				data :  'mp=' + mp+'&kelas='+kelas+'&smt='+smt+'&peta='+peta+'&tapel='+tapel,
				beforeSend: function()
				{	
					$("#nilaiPTS").html('<div class="alert alert-info alert-dismissible"><h4><i class="fa fa-spinner fa-pulse fa-fw"></i> Memuat Data Nilai PAS Kelas '+kelas+'</h4></div>');
				},
				success: function (data) {

					//jika data berhasil didapatkan, tampilkan ke dalam option select kd
					$("#nilaiPTS").html(data);
				}
			});
		});
		<?php }; ?>
	});
	function highlightEdit(editableObj) {
		$(editableObj).css("background","#FFF0000");
	} 
	function saveUA(editableObj,column,id,kelas,smt,tapel,mpid,kd) {
		// no change change made then return false
		if($(editableObj).attr('data-old_value') === editableObj.innerHTML)
		return false;
		// send ajax to update value
		$(editableObj).css("background","#FFF url(loader.gif) no-repeat right");
		$.ajax({
			url: "../modul/semester/saveNPAS.php",
			cache: false,
			data:'column='+column+'&value='+editableObj.innerHTML+'&id='+id+'&kelas='+kelas+'&smt='+smt+'&tapel='+tapel+'&mp='+mpid+'&kd='+kd,
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