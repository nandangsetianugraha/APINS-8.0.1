<?php
 use setasign\Fpdi\Fpdi;

 require_once('fpdf/fpdf.php');
 require_once('fpdi2/autoload.php');
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
$pointawal=69;
$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
//$pdf->setSourceFile('cetak-buku-tabungan.pdf');
// import page 1
//$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
//$pdf->useTemplate($tplIdx,0,0,215);
// now write some text above the imported page
$pdf->SetFont('Helvetica','',8);
$pdf->SetXY(16,$pointawal);
$pdf->Write(0, '1');
$pdf->SetXY(25,$pointawal);
$pdf->Write(0, '2021-04-01');
$pdf->SetXY(55,$pointawal);
$pdf->Write(0, '1');
$pdf->SetXY(70,$pointawal);
$pdf->Write(0, '300.000');
$pdf->SetXY(105,$pointawal);
$pdf->Write(0, '250.000');
$pdf->SetXY(140,$pointawal);
$pdf->Write(0, '50.000');
$pdf->SetXY(175,$pointawal);
$pdf->Write(0, 'Ika Yuliani');
//baris 2
$pdf->SetXY(16,$pointawal+7);
$pdf->Write(0, '2');
$pdf->Output();