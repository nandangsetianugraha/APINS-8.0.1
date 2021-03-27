<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$ids=$_POST['ids'];
	$username=strip_tags($connect->real_escape_string($_POST['username']));
	$password=strip_tags($connect->real_escape_string($_POST['password']));
	$newpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$cek = $connect->query("select * from pengguna where ptk_id='$ids'")->num_rows;
	if($cek>0){
		if(empty($username) || empty($password)){
			$validator['success'] = false;
			$validator['messages'] = "Username atau Password tidak boleh kosong";
		}else{
			$namaptk = $connect->query("select * from ptk where ptk_id='$ids'")->fetch_assoc();
			$namanya = $namaptk['nama'];
			$levelnya = $namaptk['jenis_ptk_id'];
			$sql1 = "UPDATE pengguna SET username='$username', password='$newpw', nama_lengkap='$namanya', level='$levelnya' WHERE ptk_id='$ids'";
			$query1 = $connect->query($sql1);
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Username atau Password berhasil diubah!";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		};
	}else{
		if(empty($username) || empty($password)){
			$validator['success'] = false;
			$validator['messages'] = "Username atau Password tidak boleh kosong";
		}else{
			$namaptk = $connect->query("select * from ptk where ptk_id='$ids'")->fetch_assoc();
			$namanya = $namaptk['nama'];
			$levelnya = $namaptk['jenis_ptk_id'];
			$query1 = $connect->query("INSERT INTO pengguna(ptk_id,username,password,nama_lengkap,level,verified,gambar) VALUES('$ids','$username','$newpw','$namanya','$levelnya','1','user-default.png')");
			if($query1 === TRUE) {			
				$validator['success'] = true;
				$validator['messages'] = "Pengguna atas nama $namanya berhasil ditambahkan";		
			} else {		
				$validator['success'] = false;
				$validator['messages'] = "Kok Error ya???";
			};
		};
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}