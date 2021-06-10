$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var username = $("#username").val(), password = $("#password").val();

        if ((username === "") || (password === "")) {
            $("#message").html('<div class="alert alert-danger" role="alert"><h4 class="alert-heading">Error</h4><p>Silahkan masukkan nama pengguna dan kata sandi dengan benar</p></div>');
        } else {
            $.ajax({
                type: "POST",
                url: "checklogin.php",
                data: "username=" + username + "&password=" + password,
                dataType: 'JSON',
                success: function (html) {
                    //console.log(html.response + ' ' + html.username+ ' ' + html.lokasi);
                    if (html.response === 'true') {
                        $("#message").html('<div class="alert alert-success" role="alert"><h4 class="alert-heading">Login Sukses!</h4><p>Anda akan dialihkan ke Halaman Utama</p></div>');
						setTimeout(function () {
							location.reload();
						},3000);
						return html.username;
                    } else {
                        $("#message").html(html.response);
						//$("#login-form").show();
                    }
                },
                error: function (textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                },
                beforeSend: function () {
                    $("#message").html("<p class='text-center'><img src='loading.gif'></p>");
					$("#login-form").hide();
                }
            });
        }
        return false;
    });
});
