<?php 
session_start();
if (isset($_SESSION['peserta_didik_id'])) {
    header("location:../");
}
$data['title'] = 'Login QRCode';
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
<meta charset="utf-8">
<meta name="description" content="Oban">
<meta name="keywords" content="HTML,CSS,JavaScript">
<meta name="author" content="HiBootstrap">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title><?=$data['title'];?> | SD Islam Al-Jannah</title>
<link rel="icon" href="../assets/images/favicon.png" type="image/png" sizes="16x16">

<link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/animate.min.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/owl.carousel.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css" type="text/css" media="all" />

<link rel='stylesheet' href='../assets/css/icofont.min.css' type="text/css" media="all" />

<link rel='stylesheet' href='../assets/css/flaticon.css' type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="all" />

<link rel="stylesheet" href="../assets/css/responsive.css" type="text/css" media="all" />
<!--[if IE]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
</head>
<body>
<?php 
require_once '../template/Mobile_Detect.php';
$detect = new Mobile_Detect;
// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
?>
<div class="preloader">
	<div class="preloader-wrapper">
		<div class="preloader-content">
			<img src="../assets/images/preloader-logo.png" alt="logo">
			<h3>A P I N S</h3>
		</div>
	</div>
</div>
<div class="header-bg header-bg-1"></div>


<div class="fixed-top">
	<div class="appbar-area sticky-black">
		<div class="container">
			<div class="appbar-container">
				<div class="appbar-item appbar-actions">

				</div>
				<div class="appbar-item appbar-page-title mx-auto">
					<h3>Login QRCode</h3>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="body-content">
	<div class="container">

		<div class="page-header">
			<div class="page-header-title page-header-item">
				<h3>Login to APINS</h3>
			</div>
		</div>


		<div class="authentication-form pb-15">
			<div id="message"></div>
			<div id="login-form">
				<canvas></canvas>
				<select class="form-control"></select><hr>
			</div>
			<div class="form-desc"><a href="./" class="btn main-btn main-btn-lg main-btn-red full-width mb-10"><i class="flaticon-google"></i> Login Manual</a></div>
		</div>

	</div>
</div>

<div class="scroll-top" id="scrolltop">
<div class="scroll-top-inner">
<i class="icofont-long-arrow-up"></i>
</div>
</div>


<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/owl.carousel.min.js"></script>

<script src="../assets/js/jquery.ajaxchimp.min.js"></script>

<script src="../assets/js/form-validator.min.js"></script>

<script src="../assets/js/contact-form-script.js"></script>

<script src="../assets/js/script.js"></script>
<script src="../assets/js/qrcodelib.js"></script>
<script src="../assets/js/webcodecamjquery.js"></script>
<script type="text/javascript">
    var arg = {
        resultFunction: function(result) {
            //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
           // $.post("../cek.php", { noijazah: result.code} );
            var redirect = 'cekQRCode.php';
            $.redirectPost(redirect, {pdid: result.code});
        }
    };
    
    var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
    decoder.buildSelectMenu("select");
    decoder.play();
    /*  Without visible select menu
        decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
    */
    $('select').on('change', function(){
        decoder.stop().play();
    });

    // jquery extend function
    $.extend(
    {
        redirectPost: function(location, args)
        {
            var form = '';
            $.each( args, function( key, value ) {
                form += '<input type="hidden" name="'+key+'" value="'+value+'">';
            });
            $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
        }
    });

</script>
<?php }else{ ?>
	<div class="body-content">
		<div class="container">
			<section class="error-page-section pb-15">
			<div class="container">
			<div class="error-page-content">
			 <img src="../assets/images/404.png" alt="404">
			<h2>Error</h2>
			<p>Hanya Bisa diakses via Mobile</p>
			</div>
			</div>
			</section>
		</div>
	</div>
<?php } ?>
</body>
</html>