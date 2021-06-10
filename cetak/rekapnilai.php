<?php
 include 'fpdf/fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';
 include '../function/db_connect.php';
 
	$kelas=$_GET['kelas'];
	$ab=substr($kelas, 0, 1);
	$tapel=$_GET['tapel'];
	$smt=$_GET['smt'];
		$namamapel=$connect->query("select * from mapel order by id_mapel asc")->fetch_assoc();
		$namafilenya="Rekapitulasi Nilai Raport Pengetahuan ".$kelas.".pdf";
		$pdf=new exFPDF('L','mm',array(330,215));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);

		$table2=new easyTable($pdf, 2);
		$table2->easyCell('REKAPITULASI NILAI RAPORT PENGETAHUAN '.$kelas,'colspan:2;align:C;font-style:B');
		$table2->printRow();
		$table2->easyCell('Semester : '.$smt,'align:L;');
		$table2->easyCell(' Tahun Pelajaran : '.$tapel,'align:R');
		$table2->printRow();
		$table2->endTable();
		
		$table3=new easyTable($pdf, '{96, 14,14,14,14,14,14,14,14,14,14,14,14,14,12}','align:L;border:1');
		$table3->rowStyle('font-size:10');
		$table3->easyCell('Nama Siswa','rowspan:3;align:C');
		$table3->easyCell('Mata Pelajaran','colspan:22;align:C');
		$table3->easyCell('Jumlah','rowspan:3;align:C');
		$table3->easyCell('Rata2','rowspan:3;align:C');
		$table3->easyCell('Rank','rowspan:3;align:C');
		$table3->printRow();
		$table3->rowStyle('font-size:10');
		for ($i=1; $i < 11; $i++) { 
		  $mapelnya=$connect->query("select * from mapel where id_mapel='$i'")->fetch_assoc();
		  $table3->easyCell($mapelnya['kd_mapel'],'colspan:2;align:C');
		};
		$table3->printrow();
		$table3->rowStyle('font-size:10');
		for ($j=1; $j < 22; $j++) { 
		  if($j%2==0){
			$table3->easyCell('KI4','align:C');
		  }else{
			$table3->easyCell('KI3','align:C');
		  }
		};
		$table3->printrow(true);
		
		$table3->endTable();
		//selesai isi tabel siswa
		
		
		//Tertanda Wali Kelas 
		$ttd=new easyTable($pdf, '{50,71,6,72,111}');
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('Gabuswetan, ............................ 20.......','align:C; valign:T');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('Guru Kelas '.$kelas,'align:C; valign:T');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->printRow();
		
		$ttd->rowStyle('font-size:12');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('');
		$ttd->easyCell('___________________________','align:C; valign:T');
		$ttd->printRow();
		$ttd->endTable();
		$pdf->Output();
			//$pdf->Output('D',$namafilenya);
		 


 

?>