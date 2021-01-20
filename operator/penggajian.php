<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Penggajian';
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
					  <h4>Penggajian Karyawan</h4>
					  <div class="card-header-form">
						
					  </div>
					</div>
					<div class="card-body">
					  <div class="table-responsive">
						<table id="manageMemberTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
								<th class="text-center">ID Pegawai</th>
									<th class="text-center">Nama Pegawai</th>
									<th class="text-center">Insentif/Jam</th>
									<th class="text-center">Transport</th>
									<th class="text-center">Jabatan</th>
									<th class="text-center">Kepsek</th>
									<th class="text-center">Kehadiran</th>
									<th class="text-center">Ekskul</th>
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
	  "searching": false,
	  "paging":true,
	  "ajax": "../modul/penggajian/tunjangan.php",
	  "order": []
	});
  
});  
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