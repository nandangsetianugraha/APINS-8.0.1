<?php
 include 'fpdf/fpdf.php';
 include 'exfpdf.php';
 include 'easyTable.php';
 include '../function/db_connect.php';
 function TanggalIndo($tanggal)
	{
		$bulan = array ('Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split = explode('-', $tanggal);
		return $split[2] . ' ' . $bulan[ (int)$split[1]-1 ] . ' ' . $split[0];
	};
function rupiah($angka){
	
	$hasil_rupiah = number_format($angka,0,',','.');
	return $hasil_rupiah;
 
};
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
	
function namahari($tanggal){
    
    //fungsi mencari namahari
    //format $tgl YYYY-MM-DD
    //harviacode.com
    
    $tgl=substr($tanggal,8,2);
    $bln=substr($tanggal,5,2);
    $thn=substr($tanggal,0,4);

    $info=date('w', mktime(0,0,0,$bln,$tgl,$thn));
    
    switch($info){
        case '0': return "Minggu"; break;
        case '1': return "Senin"; break;
        case '2': return "Selasa"; break;
        case '3': return "Rabu"; break;
        case '4': return "Kamis"; break;
        case '5': return "Jumat"; break;
        case '6': return "Sabtu"; break;
    };
    
};

$idinv = $_GET['idinv'];
$idcetak = $_GET['idcetak'];
$idtrans = $_GET['idtrans'];
$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
		$pdf=new exFPDF('P','mm',array(110,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',8);

		$table2=new easyTable($pdf, '{70,40}');
		$table2->rowStyle('min-height:15');
		$table2->easyCell('','align:L;font-style:B;');
		$table2->easyCell('BUKU TABUNGAN','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->printRow();
		$table2->endTable();
		
		$table2=new easyTable($pdf, '{6,22,5,20,22,22,13}');
		$table2->rowStyle('min-height:5');
		$table2->easyCell('#','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('Tgl','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('K','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('Setor','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('Ambil','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('Saldo','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->easyCell('Ket.','valign:M;align:C;font-style:B;font-color:#FFFFFF;');
		$table2->printRow(true);
		
		$datatab=$connect->query("select sum(masuk) as setor, sum(keluar) as ambil from tabungan where nasabah_id='$idinv'")->fetch_assoc();
		$h=$connect->query("select * from tabungan where id='$idtrans'")->fetch_assoc();
		$saldo=$datatab['setor']-$datatab['ambil'];
		for ($x = 1; $x <= $idcetak; $x++) {
			if($x==$idcetak){
				$table2->rowStyle('min-height:5');
				$table2->easyCell($x,'valign:M;align:L');
				$table2->easyCell($h['tanggal'],'valign:M;align:L');
				$table2->easyCell($h['kode'],'valign:M;align:C');
				$table2->easyCell(rupiah($h['masuk']),'valign:M;align:R');
				$table2->easyCell(rupiah($h['keluar']),'valign:M;align:R');
				$table2->easyCell(rupiah($saldo),'valign:M;align:R');
				$table2->easyCell('Admin','valign:M;align:R');
				$table2->printRow();
			}else{
				$table2->rowStyle('min-height:5');
				$table2->easyCell('','valign:M;align:L');
				$table2->easyCell('','valign:M;align:L');
				$table2->easyCell('','valign:M;align:C');
				$table2->easyCell('','valign:M;align:R');
				$table2->easyCell('','valign:M;align:R');
				//$saldo=$saldo+($h['masuk']-$h['keluar']);
				$table2->easyCell('','valign:M;align:R');
				$table2->easyCell('','valign:M;align:R');
				$table2->printRow();
			}			
		}
		
		$table2->endTable();
		$pdf->Output('F','cetak-tabungan.pdf');
			//$pdf->Output('D',$namafilenya);
		 


 

?>