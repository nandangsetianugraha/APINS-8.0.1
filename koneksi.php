<!DOCTYPE html>
<html>
  	<head>
    	<title>Toast Notification for Check Internet Connection with Bootstrap 4 & javascript</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
      	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  	</head>
  	<body>
  		<div class="container">
  			<br />
  			<br />
    		<h1 align="center">Toast Notification for Check Internet Connection with Bootstrap 4 & javascript</h1>
    		<br />    		
    	</div>
    	
  	</body>
</html>

<div class="toast" style="position: absolute; top: 25px; right: 25px;">
    <div class="toast-header">
        <i class="bi bi-wifi"></i>&nbsp;&nbsp;&nbsp;
        <strong class="mr-auto"><span class="text-success">You're online now</span></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Hurray! Internet is connected.
    </div>
</div>

<script>

var status = 'online';
var current_status = 'online';

function check_internet_connection()
{
    if(navigator.onLine)
    {
        status = 'online';
    }
    else
    {
        status = 'offline';
    }

    if(current_status != status)
    {
        if(status == 'online')
        {
            $('i.bi').addClass('bi-wifi');
            $('i.bi').removeClass('bi-wifi-off');
            $('.mr-auto').html("<span class='text-success'>You are online now</span>");
            $('.toast-body').text('Hurray! Internet is connected.');
        }
        else
        {
            $('i.bi').addClass('bi-wifi-off');
            $('i.bi').removeClass('bi-wifi');
            $('.mr-auto').html("<span class='text-danger'>You are offline now</span>");
            $('.toast-body').text('Opps! Internet is disconnected.')
        }

        current_status = status;

        $('.toast').toast({
            autohide:false
        });

        $('.toast').toast('show');
    }
}

check_internet_connection();

setInterval(function(){
    check_internet_connection();
}, 1000);

</script>