<?php include 'koneksi.php'; ?>

        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama mahasiswa</th>
              <th>Alamat</th>
              <th>Jenis Kelamin</th>
              <th>Jurusan</th>
              <th>Foto</th>
            </tr>  
          </thead>
          <tbody>
            <?php
              $page = (isset($_POST['page']))? $_POST['page'] : 1;
              $limit = 5; 
              $limit_start = ($page - 1) * $limit;
              $no = $limit_start + 1;

              $query = "SELECT * FROM tbl_mahasiswa ORDER BY nama_mahasiswa ASC LIMIT $limit_start, $limit";
              $dewan1 = $db1->prepare($query);
              $dewan1->execute();
              $res1 = $dewan1->get_result();
              while ($row = $res1->fetch_assoc()) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row["nama_mahasiswa"]; ?></td>
                <td><?php echo $row["alamat"]; ?></td>
                <td><?php echo $row["jenis_kelamin"]; ?></td>
                <td><?php echo $row["jurusan"]; ?></td>
                <td><img src='<?php echo $row["avatar"]; ?>' height="30px"></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php
          $query_jumlah = "SELECT count(*) AS jumlah FROM tbl_mahasiswa";
          $dewan1 = $db1->prepare($query_jumlah);
          $dewan1->execute();
          $res1 = $dewan1->get_result();
          $row = $res1->fetch_assoc();
          $total_records = $row['jumlah'];
        ?>
        <p>Total baris : <?php echo $total_records; ?></p>
        <nav class="mb-5">
          <ul class="pagination justify-content-end">
            <?php
              $jumlah_page = ceil($total_records / $limit);
              $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
              $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1;
              $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page;
        
              

              if($page == 1){
                echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
              } else {
                $link_prev = ($page > 1)? $page - 1 : 1;
                echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
              }

              for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' active' : '';
                echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
              }

              if($page == $jumlah_page){
                echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
              } else {
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
              }
            ?>
          </ul>
        </nav>