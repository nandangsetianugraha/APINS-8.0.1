<?php 

require_once '../../function/db_connect.php';
//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());
	$namaprinter=$connect->real_escape_string($_POST['namaprinter']);
	if($query === TRUE) {			
	
	// close the database connection
	$connect->close();

	echo json_encode($validator);

}