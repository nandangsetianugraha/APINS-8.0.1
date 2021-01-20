<?php 
session_start();
require_once '../function/functions.php';
if (!isset($_SESSION['username'])) {
  header('Location: ../login/');
  exit();
};
$data['title'] = 'Blank';
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
		include "../template/sidebar.php";
		?>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <form method="POST">
			  <table>
			   <tr>
				<td width="60px" valign="top">Hobi</td>
				<td valign="top"> 
				 <label><input type="checkbox" name="hobi[]" value="Nonton">Nonton</label><br>
				 <label><input type="checkbox" name="hobi[]" value="Menulis">Menulis</label><br>
				 <label><input type="checkbox" name="hobi[]" value="Traveling">Traveling</label><br>
				 <label><input type="checkbox" name="hobi[]" value="Otomotif">Otomotif</label><br>
				 <label><input type="checkbox" name="hobi[]" value="Fotografi">Fotografi</label><br>
				 <label><input type="checkbox" name="hobi[]" value="Programming">Programming</label>
				</td>
			   </tr>
			   <tr>
				<td width="60px" valign="top"></td>
				<td valign="top"> 
				 <input type="submit" name="simpan" value="Simpan">
				</td>
			   </tr>
			  </table>
			 </form>
			 <h1>Test</h1>

<input type="file" id="input_img" accept="image/*">
<button class="btn-upload">Upload</button>
<div class="message"></div>
<div class="output"></div>


			 <?php 
			 if(isset($_POST['simpan'])){
				 $value = (count($_POST['hobi']) > 0) ? implode('-', $_POST['hobi']) : ""; 
				echo "<br>$value";
				echo "<hr>";
			 };
			 ?>
          </div>
        </section>
		<?php include "../template/setting.php"; ?>
      </div>
      <?php include "../template/footer.php"; ?>
    </div>
  </div>
  <?php include "../template/script.php";?>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>

$('.btn-upload').click(function(){

    $('.message').html('Processing ..<br/>');

    var file = document.getElementById('input_img');
    var form = new FormData();
    form.append("image", file.files[0])

    var settings = {
        "url": "https://api.imgbb.com/1/upload?key=6035fdd53a726c658db393c7a72818dd",
        "method": "POST",
        "timeout": 0,
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    };

    $.ajax(settings).done(function (response) {
        $('.message').html('Done ..<br/>');
        let data = JSON.parse(response);
        $('.output').html(`<img src="${data.data.display_url}" />`);
        console.log(data);
    });

    return false;
});
</script>
</body>
</html>