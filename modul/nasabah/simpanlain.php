<?php 

require_once '../../function/db_connect.php';
function random($panjang)
{
   $karakter = 'abcdefghijklmnopqrstuvwxyz1234567890';
   $string = '';
   for($i = 0; $i < $panjang; $i++) {
   $pos = rand(0, strlen($karakter)-1);
   $string .= $karakter{$pos};
   }
    return $string;
};
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$idNasabah=$_POST['idNasabah'];
	$idsis=$_POST['idsis'];
	if(empty($idNasabah) || empty($idsis)){
		$validator['success'] = false;
		$validator['messages'] = "Nasabah ID tidak boleh Kosong!";
	}else{
			$id_pd1=random(8);
			$id_pd2=random(4);
			$id_pd3=random(4);
			$id_pd4=random(4);
			$id_pd5=random(12);
			$id_pd=$id_pd1.'-'.$id_pd2.'-'.$id_pd3.'-'.$id_pd4.'-'.$id_pd5;
			$sql = "select * from nasabah where nasabah_id='$idNasabah'";
			$query = $connect->query($sql);
			$ada=$query->num_rows;
			if($ada>0){
				$validator['success'] = false;
				$validator['messages'] = "ID Nasabah sudah terdaftar!";
			}else{
				$sql2 = "INSERT INTO nasabah VALUES('','$idNasabah','$id_pd','$idsis','3')";				
				$query2 = $connect->query($sql2);
				$validator['success'] = true;
				$validator['messages'] = "Nasabah berhasil ditambahkan";
			};	
	};
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}