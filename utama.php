<nav class="navbar navbar-dark bg-danger">
  <a class="navbar-brand text-white" href="index.php">
    Dewan Komputer
  </a>
</nav>
<div class="container">
  <h3 align="center" class="mt-3">Dewan Demo Pagination Dengan Ajax</h3>

  <div class="table-responsive" id="data"></div>  
</div>
<script>
 $(document).ready(function(){
      load_data();
      function load_data(page){
           $.ajax({
                url:"data.php",
                method:"POST",
                data:{page:page},
                success:function(data){
                     $('#data').html(data);
                }
           })
      }
      $(document).on('click', '.halaman', function(){
           var page = $(this).attr("id");
           load_data(page);
      });
 });
 </script>