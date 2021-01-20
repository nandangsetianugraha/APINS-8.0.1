$(document).ready(function () {
    "use strict";
    $("#submit").click(function () {

        var username = $("#username").val(), password = $("#password").val(), tapel = $("#tapel").val(), smt = $("#smt").val();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Please enter a username and a password</div>");
        } else {
            $.ajax({
                type: "POST",
                url: "checklogin.php",
                data: "username=" + username + "&password=" + password + "&tapel=" + tapel + "&smt=" + smt,
                dataType: 'JSON',
                success: function (html) {
                    //console.log(html.response + ' ' + html.username+ ' ' + html.lokasi);
                    if (html.response === 'true') {
                        $("#message").html('<div class="empty-state" data-height="100"><div class="empty-state-icon"><i class="fas fa-check-double"></i></div><h2>Login Berhasil</h2><p class="lead">Anda akan dialihkan ke Halaman Admin</p></div>');
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
