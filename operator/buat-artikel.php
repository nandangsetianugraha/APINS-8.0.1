<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Buat Artikel';
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
                    <h4>Tulis Artikel</h4>
                  </div>
                  <div class="card-body">
					<div id="informasi"></div>
					<div id="tampil">
					<form id="form-data" action="javascript:void(0);" enctype="multipart/form-data">
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="judul" id="judul" class="form-control">
						<input type="hidden" name="idptk" id="idptk" class="form-control" value="<?=$idku;?>">
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Artikel</label>
                      <div class="col-sm-12 col-md-7">
                        <textarea name="konten" id="konten" class="summernote"></textarea>
                      </div>
                    </div>
					<div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                      <div class="col-sm-12 col-md-7">
                        <div id="image-preview" class="image-preview">
                          <label for="image-upload" id="image-label">Choose File</label>
                          <input type="file" name="image" id="image-upload" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button type="submit" class="btn btn-primary">Buat Artikel</button>
                      </div>
                    </div>
					</form>
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
  <script src="<?= base_url(); ?>assets/js/page/create-post.js"></script>
  <script>
	$('#form-data').submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        //console.log(data);
        $.ajax({
            type: 'POST',
            url: '../modul/berita/simpan-artikel.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function(){
                $("#tampil").hide();
				$("#informasi").show();
				$("#informasi").html('<div class="alert alert-info" role="alert"><strong><i class="fa fa-spinner fa-pulse fa-fw"></i> Sedang Menyimpan Artikel ...</strong></div>');
            },
            success: function(data) {
                //$('#modaltugas').modal('hide');
                if (data = 'ok') {
                    //toastr.success(data);
					$("#informasi").html('<div class="alert alert-success" role="alert"><strong><i class="fa fa-info"></i> Artikel berhasil dibuat!</strong></div>');
                    setTimeout(function() {
						window.location.href = "artikel";
                    //    window.location.reload();
                    }, 2000);
                } else {
                    //toastr.error("tugas gagal dibuat");
					$("#tampil").show();
					$("#informasi").html('<div class="alert alert-danger" role="alert"><strong><i class="fa fa-info"></i> Artikel Gagal dibuat!</strong></div>');
                }
                //toastr.error(data);


            }
        });
        return false;
    });
</script>
</body>
</html>