<?php

// koneksi ke database pendataan_siswa
$conn = mysqli_connect('localhost', 'root', '', 'apins7');


function query($param) {
  global $conn;

  $result = mysqli_query($conn, $param);
  $rows = [];

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $rows[] = $row;
    }
  }

  return $rows;
}


function base_url($param = []) {


  /*
    | jika parameter variabel $param kosong, maka gunakan url default yang akan digunakan adalah variabel $base_url
    | tips supaya program ini tidak terjadi error
    | untuk pengguna desktop disarankan untuk merubah isi dari variabel $base_url seperti berikut
    | contoh : http://localhost/folder-htdocs-kalian/aplikasi_pendataan_siswa/
    | dan untuk pengguna mobile disarankan untuk merubah isi dari variabel $base_url seperti berikut
    | contoh : http://localhost:port-webbrowser-kalian/folder-htdocs-kalian/aplikasi_pendataan_siswa/
  */


  $base_url = 'http://localhost:8080/apinnew/';
  $result = (!$param) ? $base_url : $base_url . $param;

  return $result;
}


function view($target, $data = []) {

  // function view akan memanggil file sesuai isi dari parameter $target
  require_once $target . '.php';
}


function flash_lunas() {


  /*
    | jika data siswa yang nrp nya sudah lunas, maka tampilkan flash ini di table siswa tersebut
    | lokasi table ada di data_spp.php
  */


  return '<span class="badge badge-success text-light p-2">lunas</span>';
}


function flash_belum_lunas() {


  /*
    | jika data siswa yang nrp nya belum lunas, maka tampilkan flash ini di table siswa tersebut
    | lokasi table ada di data_spp.php
  */


  return '<span class="badge badge-danger text-light p-2">belum lunas</span>';
}


function set_flashdata($param1, $param2) {

  // memberikan keamanan untuk mengurangi resiko terkena peretasan oleh orang yang tidak bertanggung jawab
  $nama_session = trim(rtrim(stripslashes(htmlspecialchars($param1))));
  $pesan = trim(stripslashes(htmlspecialchars($param2)));

  return $_SESSION[$nama_session] = [
    'pesan' => $pesan
  ];
}


function flashdata($param) {

  // memberikan keamanan untuk mengurangi resiko terkena peretasan oleh orang yang tidak bertanggung jawab
  $nama_session = trim(rtrim(stripslashes(htmlspecialchars($param))));

  // cek apakah ada session dengan nama dari isi parameter variabel $param
  if (isset($_SESSION[$nama_session])) {

    return $_SESSION[$nama_session]['pesan'];
  }
}


function login_validation($username, $password) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($username) && empty($password)) {

      // jika semua field kosong
      set_flashdata('form_admin_error', 'isi semua field terlebih dahulu dengan benar');

      return false;
    }

    if (empty($username)) {

      // jika field email kosong
      set_flashdata('form_admin_error', 'isi username terlebih dahulu dengan benar');

      return false;
    }

    if (empty($password)) {

      // jika field password kosong
      set_flashdata('form_admin_error', 'isi field password terlebih dahulu dengan benar');

      return false;
    }

    // kembalikan nilai boolean true jika lolos dari uji validasi
    return true;

  }
}


function login($username, $password) {

  // cek apakah email ada di database
  $result = query("SELECT * FROM pengguna WHERE username = '$username'")[0];

  if ($result) {


    /*
      | jika variabel $result menghasilkan nilai boolean true
      | maka cek passwordnya
    */


    if ($password !== $result['password']) {

      // jika password tidak cocok atau salah
      set_flashdata('form_admin_error', 'password salah');

      header('Location: login');
      exit();
    }

    if ($password === $result['password']) {


      /*
        | jika password benar
        | maka direct ke halaman admin
      */
      
      
      $_SESSION['login'] = [
        'id' => $result['ptk_id'],
        'nama' => $result['nama_lengkap'],
        'password' => $result['password'],
        'gambar' => $result['gambar'],
        'level' => $result['level']
      ];

      header('Location: index');
      exit();
    }
  } else {

    // jika email tidak ada di database
    set_flashdata('form_admin_error', 'username atau password salah');

    header('Location: login');
    exit();
  }
}


function list_jenis_kelamin() {
  
  // kumpulan list jenis kelamin
  $list = ['laki - laki', 'perempuan'];
  
  return $list;
}


function list_jurusan() {
  
  // kumpulan list jurusan siswa
  $list = ['teknik informatika', 'teknik planologi', 'teknik industri', 'teknik pangan', 'teknik mesin', 'rpl', 'tkj', 'multimedia'];
  
  return $list;
}


function tambah($data) {
  global $conn;
  
  // memberikan kemanan supaya mengurangi resiko terkena retas oleh orang ang tidak bertanggung jawab
  $nama = trim(stripslashes(htmlspecialchars($data['nama'])));
  $tanggal_lahir = trim(stripslashes(htmlspecialchars($data['ttl'])));
  $jenis_kelamin = trim(stripslashes(htmlspecialchars($data['jk'])));
  $alamat = trim(stripslashes(htmlspecialchars($data['alamat'])));
  $tahun_ajaran = trim(rtrim(stripslashes(htmlspecialchars($data['tahun_ajaran']))));
  $nama_ibu = trim(stripslashes(htmlspecialchars($data['nama_ibu'])));
  $tanggal_lahir_ibu = trim(stripslashes(htmlspecialchars($data['ttl_ibu'])));
  $nama_ayah = trim(stripslashes(htmlspecialchars($data['nama_ayah'])));
  $tanggal_lahir_ayah = trim(stripslashes(htmlspecialchars($data['ttl_ayah'])));
  $kelas = trim(stripslashes(htmlspecialchars($data['kelas'])));
  $jurusan = trim(stripslashes(htmlspecialchars($data['jurusan'])));
  $masuk_sekolah = trim(stripslashes(htmlspecialchars($data['masuk'])));
  $keluar_sekolah = trim(stripslashes(htmlspecialchars($data['keluar'])));
  $spp = trim(rtrim(stripslashes(htmlspecialchars($data['spp']))));
  
  // simpan semua value dari input ke dalam session
  set_value($nama, $tanggal_lahir, $jenis_kelamin, $alamat, $tahun_ajaran, $nama_ibu, $tanggal_lahir_ibu, $nama_ayah, $tanggal_lahir_ayah, $kelas, $jurusan, $masuk_sekolah, $keluar_sekolah, $spp);
  
  if (!validation($nama, $tanggal_lahir, $jenis_kelamin, $alamat, $tahun_ajaran, $nama_ibu, $tanggal_lahir_ibu, $nama_ayah, $tanggal_lahir_ayah, $kelas, $jurusan, $masuk_sekolah, $keluar_sekolah, $spp)) {
    
    // jika fungsi validation() mengembalikan nilai boolean false
    header('Location: ../admin/tambah.php');
    exit();
  } else {
    
    
    /*
      | jika fungsi validation() mengembalikan nilai true
      | jika lolos dari uji validasi
      | maka tambahkan data siswa ke database
    */
    
    
    // perintah query
    $query = "INSERT INTO data_siswa VALUES('', '$nama', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$tahun_ajaran', '$nama_ibu', '$tanggal_lahir_ibu', '$nama_ayah', '$tanggal_lahir_ayah', '$kelas', '$jurusan', '$masuk_sekolah', '$keluar_sekolah', '$spp')";
    
    // jalankan perintah query
    mysqli_query($conn, $query);
    
    
    /*
      | jika fungsi mysqli_affected_rows() mengembalikan nilai angka lebih besar dari 0, maoa data siswa berhasil ditambahkan ke database
      | namun jika fungsi mysqli_affected_rows() mengembalikan nilai angka 0, maka data siswa gagal ditambahkan ke database
    */
    
    
    return mysqli_affected_rows($conn);
  }
}


function set_value($nama, $ttl, $jk, $alamat, $tahun_ajaran, $ibu, $ttl_ibu, $ayah, $ttl_ayah, $kelas, $jurusan, $masuk, $keluar, $spp) {
  
  // ketika fungsi set_value() ini dipanggil atau dijalankan, maka fungsi ini akan mengembalikan nilai berupa session
  return $_SESSION['value'] = [
    'nama' => $nama,
    'tanggal_lahir' => $ttl,
    'jenis_kelamin' => $jk,
    'alamat' => $alamat,
    'tahun_ajaran' => $tahun_ajaran,
    'nama_ibu' => $ibu,
    'tanggal_lahir_ibu' => $ttl_ibu,
    'nama_ayah' => $ayah,
    'tanggal_lahir_ayah' => $ttl_ayah,
    'kelas' => $kelas,
    'jurusan' => $jurusan,
    'masuk_sekolah' => $masuk,
    'keluar_sekolah' => $keluar,
    'spp' => $spp
  ];
}


function validation($nama, $ttl, $jk, $alamat, $tahun_ajaran, $ibu, $ttl_ibu, $ayah, $ttl_ayah, $kelas, $jurusan, $masuk, $keluar, $spp) {
  
  // cek apakah form tersebut menggunakan method post, jika memang memakai method post, maka lanjutkan uji validasi ini
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // uji validasi semua field
    if (empty($nama) && empty($ttl) && empty($alamat) && empty($tahun_ajaran) && empty($ibu) && empty($ttl_ibu) && empty($ayah) && empty($ttl_ayah) && empty($kelas) && empty($masuk) && empty($keluar) && empty($spp)) {
      
      // jika semua field kosong
      set_flashdata('form_error', 'isi semua field terlebih dahulu');
      
      return false;
    }
    
    // uji validasi untuk field nama
    if (empty($nama)) {
      
      // jika field nama kosong
      set_flashdata('form_error', 'isi field nama terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
      
      // jika field nama diisi selain dengan huruf
      set_flashdata('form_error', 'field nama hanya boleh diisi dengan huruf saja');
      
      return false;
    } else if (strlen($nama) <= 4) {
      
      // jika nama terlalu pendek
      set_flashdata('form_error', 'nama terlalu pendek');
      
      return false;
    }
    
    // uji validasi untuk field tanggal lahir
    if (empty($ttl)) {
      
      // jika field tanggal lahir kosong
      set_flashdata('form_error', 'isi field tanggal lahir terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $ttl)) {
      
      // jika field tanggal lahir diisi selain dengan huruf dan angka
      set_flashdata('form_error', 'field tanggal lahir hanya boleh diisi dengan huruf dan angka saja');
      
      return false;
    }
    
    // uji validasi untuk field alamat
    if (empty($alamat)) {
      
      // jika field alamaf kosong
      set_flashdata('form_error', 'isi field alamat terlebih dahulu');
      
      return false;
    } else if (strlen($alamat) <= 5) {
      
      // jika alamat terlalu pendek
      set_flashdata('form_error', 'alamat terlalu pendek');
      
      return false;
    }
    
    // uji validasi untuk field tahun ajaran
    if (empty($tahun_ajaran)) {
      
      // jika field tahun ajaran kosong
      set_flashdata('form_error', 'isi field tahun ajaran terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[0-9]*$/", $tahun_ajaran)) {
      
      // jika field diisi selain angka dan diberi spasi
      set_flashdata('form_error', 'field tahun ajaran hanya boleh diisi dengan angka saja dan tidak boleh dengan spasi');
      
      return false;
    } else if (strlen($tahun_ajaran) <= 3) {
      
      // jika tahun ajaran terlalu pendek
      set_flashdata('form_error', 'tahun ajaran terlalu pendek');
      
      return false;
    }
    
    // uji validasi untuk field nama ibu
    if (empty($ibu)) {
      
      // jika field nama ibu kosong
      set_flashdata('form_error', 'isi field nama ibu terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $ibu)) {
      
      // jika field nama ibu diisi selain dengan huruf
      set_flashdata('form_error', 'field nama ibu hanya boleh diisi dengan huruf saja');
      
      return false;
    }
    
    // uji validasi untuk field tanggal lahir ibu
    if (empty($ttl_ibu)) {
      
      // jika field tanggal lahir ibu kosong
      set_flashdata('form_error', 'isi field tanggal lahir ibu terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $ttl_ibu)) {
      
      // jika field tanggal lahir ibu diisi selain dengan huruf dan angka
      set_flashdata('form_error', 'field tanggal lahir ibu hanya boleh diisi dengan huruf dan angka saja');
      
      return false;
    }
    
    // uji validasi untuk field nama ayah
    if (empty($ayah)) {
      
      // jika field nama ayah kosong
      set_flashdata('form_error', 'isi field nama ayah terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $ayah)) {
      
      // jika field nama ayah diiso selain dengan huruf
      set_flashdata('form_error', 'field nama ayah hanya boleh diisi dengan huruf aaja');
      
      return false;
    }
    
    // uji validasi untuk field tanggal lahir ayah
    if (empty($ttl_ayah)) {
      
      // jika field tanggal lahir ayah kosong
      set_flashdata('form_error', 'isi field tanggal lahir ayah terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $ttl_ayah)) {
      
      // jika field tanggal lahir ayah diisi selain huruf dan angka
      set_flashdata('form_error', 'field tanggal lahir ayah hanya boleh diisi dengan huruf dan angka saja');
      
      return false;
    }
    
    // uji validasi untuk field kelas
    if (empty($kelas)) {
      
      // jika field kelas kosong
      set_flashdata('form_error', 'isi field kelas terlebih dahulu');
      
      return false;
    }
    
    // uji validasi untuk field jurusan
    if (empty($jurusan)) {
      
      // jika field jurusan kosong
      set_flashdata('form_error', 'isi field jurusan terlebih dahulu');
      
      return false;
    }
    
    // uji validasi untuk field masuk sekolah
    if (empty($masuk)) {
      
      // jika field masuk sekolah kosong
      set_flashdata('form_error', 'isi field masuk sekolah terlebih dahulu');
      
      return false;
    }
    
    // uji validasi untuk field keluar sekolah / lulus sekolah
    if (empty($keluar)) {
      
      // jika field keluar sekolah / lulus sekolah kosong
      set_flashdata('form_error', 'isi field keluar sekolah terlebih dahulu');
      
      return false;
    }
    
    // uji validasi untuk field spp
    if (empty($spp)) {
      
      // jika field spp kosong
      set_flashdata('form_error', 'isi field spp terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[0-9]*$/", $spp)) {
      
      // jika field spp diisi selain dengan angka
      set_flashdata('form_error', 'field spp hanya boleh diisi dengan angka saja dan tanpa spasi');
      
      return false;
    }
    
    // jika lolos dari semua uji validasi
    return true;
    
  }
}


function hapus($id) {
  global $conn;
  
  // perintah query
  $query = "DELETE FROM data_siswa WHERE id = '$id'";
  
  // jalankan perintah query
  mysqli_query($conn, $query);
  
  /*
    | jika fungsi mysqli_affected_rows() mengembalikan nilai angka lebih besar dari 0, maoa data siswa berhasil dihapus dari database
    | namun jika fungsi mysqli_affected_rows() mengembalikan nilai angka 0, maka data siswa gagal dihapus dari database
  */
  
  return mysqli_affected_rows($conn);
}


function ubah($data, $id) {
  global $conn;
  
  // memberikan kemanan supaya mengurangi resiko terkena retas oleh orang ang tidak bertanggung jawab
  $nama = trim(stripslashes(htmlspecialchars($data['nama'])));
  $tanggal_lahir = trim(stripslashes(htmlspecialchars($data['ttl'])));
  $jenis_kelamin = trim(stripslashes(htmlspecialchars($data['jk'])));
  $alamat = trim(stripslashes(htmlspecialchars($data['alamat'])));
  $tahun_ajaran = trim(rtrim(stripslashes(htmlspecialchars($data['tahun_ajaran']))));
  $nama_ibu = trim(stripslashes(htmlspecialchars($data['nama_ibu'])));
  $tanggal_lahir_ibu = trim(stripslashes(htmlspecialchars($data['ttl_ibu'])));
  $nama_ayah = trim(stripslashes(htmlspecialchars($data['nama_ayah'])));
  $tanggal_lahir_ayah = trim(stripslashes(htmlspecialchars($data['ttl_ayah'])));
  $kelas = trim(stripslashes(htmlspecialchars($data['kelas'])));
  $jurusan = trim(stripslashes(htmlspecialchars($data['jurusan'])));
  $masuk_sekolah = trim(stripslashes(htmlspecialchars($data['masuk'])));
  $keluar_sekolah = trim(stripslashes(htmlspecialchars($data['keluar'])));
  $spp = trim(rtrim(stripslashes(htmlspecialchars($data['spp']))));
  
  if (!validation($nama, $tanggal_lahir, $jenis_kelamin, $alamat, $tahun_ajaran, $nama_ibu, $tanggal_lahir_ibu, $nama_ayah, $tanggal_lahir_ayah, $kelas, $jurusan, $masuk_sekolah, $keluar_sekolah, $spp)) {
    
    // jika fungsi validation() mengembalikan nilai boolean false
    header('Location: ../admin/ubah.php?id=' . $id);
    exit();
  } else {
    
    
    /*
      | jika fungsi validation() mengembalikan nilai true
      | jika lolos dari uji validasi
      | maka update data siswa ke database
    */
    
    
    // perintah query
    $query = "UPDATE data_siswa SET
                nama = '$nama',
                ttl = '$tanggal_lahir',
                jk = '$jenis_kelamin',
                alamat = '$alamat',
                tahun_ajaran = '$tahun_ajaran',
                nama_ibu = '$nama_ibu',
                ttl_ibu = '$tanggal_lahir_ibu',
                nama_ayah = '$nama_ayah',
                ttl_ayah = '$tanggal_lahir_ayah',
                kelas = '$kelas',
                jurusan = '$jurusan',
                masuk = '$masuk_sekolah',
                keluar = '$keluar_sekolah',
                spp = '$spp'
              WHERE id = '$id'";
              
    // jalankan perintah query
    mysqli_query($conn, $query);
    
    
    /*
      | jika fungsi mysqli_affected_rows() mengembalikan nilai angka lebih besar dari 0, maoa data siswa berhasil diubah dari database
      | namun jika fungsi mysqli_affected_rows() mengembalikan nilai angka 0, maka data siswa gagal diubah dari database
    */
    
    
    return mysqli_affected_rows($conn);
  }
}


function ubah_profile($data, $password, $gambar_lama, $level, $id) {
  global $conn;
  
  // memberikan kemanan supaya mengurangi resiko terkena retas oleh orang ang tidak bertanggung jawab
  $nama = trim(stripslashes(htmlspecialchars($data['nama'])));
  $email = trim(rtrim(stripslashes(htmlspecialchars($data['email']))));
    
  if (!profile_form_validation($nama, $email)) {
    
    // jika fungsi profile_form_validation() mengembalikan nilai boolean false
    header('Location: ../admin/atur_profile.php?id=' . $id);
    exit();
  } else {
    
    
    /*
      | jika fungsi profile_form_validation() mengembalikan nilai true
      | jika lolos dari uji validasi
    */
    
    
    $result = ($_FILES['gambar']['error'] === 4) ? $gambar = $gambar_lama : $gambar = upload();
    
    if (!$result) {
      
      // jika variabel $result mengembalikan nilai boolean false
      header('Location: ../admin/atur_profile.php?id=' . $id);
      exit();
    }
    
    // perintah query
    $query = "UPDATE admin SET
                nama = '$nama',
                email = '$email',
                password = '$password',
                gambar = '$result',
                level = '$level'
              WHERE id = '$id'";
              
    // jalankan perintah query
    mysqli_query($conn, $query);
    
    
    /*
      | jika fungsi mysqli_affected_rows() mengembalikan nilai angka lebih besar dari 0, maoa data siswa berhasil diubah dari database
      | namun jika fungsi mysqli_affected_rows() mengembalikan nilai angka 0, maka data siswa gagal diubah dari database
    */
    
    
    return mysqli_affected_rows($conn);
  }
}


function profile_form_validation($nama, $email) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // uji validasi field nama
    if (empty($nama)) {
      
      // jika field nama kosong
      set_flashdata('admin_error', 'isi field nama terlebih dahulu');
      
      return false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
      
      // jika field nama diisi selain huruf
      set_flashdata('admin_error', 'field nama hanya boleh diisi huruf saja');
      
      return false;
    }
    
    // uji validasi field email
    if (empty($email)) {
      
      // jika field email kosong
      set_flashdata('admin_error', 'isi field email terlebih dahulu');
      
      return false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
      // jika field email diisi selain denhan email yang valid
      set_flashdata('admin_error', 'bukan berupa email yang valid');
      
      return false;
    }
    
    // kembalikan berupa nilai noolean true jika lolos dari uji validasi
    return true;
    
  }
}


function upload() {
  $nama_file = $_FILES['gambar']['name'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_name = $_FILES['gambar']['tmp_name'];
  
  if ($error === 4) {
    
    
    // jika pengguna tidak mengupload file apapun
    set_flashdata('upload_error', 'harap upload gambar terlebih dahulu');
    
    return false;
  }
  
  
  // kumpulan ekstensi yang boleh untuk diupload, selain itu tidak boleh
  $ekstensi_gambar_valid = ['jpg', 'jpeg', 'png', 'gif'];
  
  
  /*
      | pecah isi dari variabel $nama_file menjadi array terlebih dahulu
      | jika di dalam variabel $nama_file ditemukan tanda . atau titik, maka pecah isi dari variabel $nama_file menjadi array
      | contoh : candra.jpg, maka akan dirubah seperti ini ['candra', 'jpg']
  */
  
  
  $ekstensi_gambar = explode('.', $nama_file);
  
  
  /*
      | strtolower berfungsi sebagai pengecil semua huruf, yanh tadinya seperti ini CANDRA.JPG, menjadi seperti imi candra.jpg
      | end berfungsi untuk mengambil index terakhir di sebuah array variabel $ekstensi_gambar
      | end digunakan untuk mengambil sebuah ekstensi file yang diupload oleh pengguna untuk dicek, apakah ekstensi nya berupa gambar atau tidak
      | contoh : candra.dwi.cahyo.jpg, maka akan di jadikan array terlebih dahulu seperti berikut ['candra', 'dwi', 'cahyo', 'jpg'], maka yang diambil oleh tag end adalah jpg
  */
  
  
  $ekstensi_gambar = strtolower(end($ekstensi_gambar));
  
  if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
    
    
    // jika file yang diupload oleh pengguna bukanlah gambar
    set_flashdata('upload_error', 'yang anda upload bukanlah berupa file gambar');
    
    return false;
  }
  
  if ($ukuran_file > 5000000) {
    
    
    // jika file yang diupload oleh pengguna terlalu besar
    set_flashdata('upload_error', 'ukuran file gambar terlalu nesar');
    
    return false;
  }
  
  
  // generate ke nama baru
  $nama_file_baru = 'created_by_candradwicahyo_' . uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_gambar;
  
  move_uploaded_file($tmp_name, '../assets/images/profile-admin/' . $nama_file_baru);
  
  return $nama_file_baru;
}
