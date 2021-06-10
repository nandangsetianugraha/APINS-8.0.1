<?php
  require_once '../../function/functions.php';
  require_once '../../function/db_connect.php';
  date_default_timezone_set('Asia/Jakarta');
 
  $temps = "../../images/berita/";
  function compress($source, $destination, $quality)
	{
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source);
		imagejpeg($image, $destination, $quality);
		return $destination;
	};
  $judul   = addslashes($_POST['judul']);
  $idptk          = $_POST['idptk'];
  $tanggal = date("Y-m-d");
  $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['judul'])));
  $isi          = addslashes($_POST['konten']);
  
  if (!empty($_FILES['image']['name'])) {
	$fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];
	$fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $ext = explode('.', $file);
    $ext = strtolower(end($ext));
	//$dest = '../../berkas/';
	$allowed = array('jpg', 'jpeg', 'png', 'gif');
	if (in_array($fileActualExt, $allowed)) {
		$FileNameNew = uniqid('', true) . "." . $fileActualExt;
		$fileDestination = './' . $FileNameNew;
		compress($fileTmpName, $fileDestination, 25);
		$query = "INSERT INTO berita(penulis,tanggal,judul,slug,isi,images) VALUES('$idptk','$tanggal','$judul','$slug','$isi','$FileNameNew')";
		$query1 = $connect->query($query);
		echo "OK";
	};
  } else {
	$query = "INSERT INTO berita(penulis,tanggal,judul,slug,isi,images) VALUES('$idptk','$tanggal','$judul','$slug','$isi','default.jpg')";
    $query1 = $connect->query($query);
    if($query1 === TRUE) {
		echo "OK";
	}else{
		echo "Gagal Tulis";
	};
  }
?>