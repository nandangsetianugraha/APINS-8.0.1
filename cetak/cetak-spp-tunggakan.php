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
	
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
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

	$tapel=$_GET['tapel'];
$kelas=$_GET['kelas'];
$bulan=(int) $_GET['bulan'];
$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
		$pdf=new exFPDF('L','mm',array(215,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);

		$table2=new easyTable($pdf, '{30,300}');
		$table2->easyCell('','img:logo.jpg,w20;rowspan:4;align:C;border:B');
		$table2->easyCell('SD ISLAM AL-JANNAH','font-size:14;align:L;');
		$table2->printRow();
		$table2->easyCell('Jl. Raya Gabuswetan No. 1 Desa Gabuswetan Kec. Gabuswetan','align:L');
		$table2->printRow();
		$table2->easyCell('Kab. Indramayu - Jawa Barat 45263 Telp. (0234) 5508501','align:L');
		$table2->printRow();
		$table2->easyCell('Website: https://sdi-aljannah.web.id Email: sdi.aljannah@gmail.com','align:L;border:B');
		$table2->printRow();
		$table2->endTable();
		
		$table2=new easyTable($pdf, '{330}', 'align:C');
		$table2->easyCell('LAPORAN SPP KEWAJIBAN ADMINISTRASI SISWA','align:C');
		$table2->printRow();
		$table2->easyCell('KELAS '.$kelas,'align:C');
		$table2->printRow();
		$table2->endTable();
		
			$table2=new easyTable($pdf, '{10,80,20,20,20,20,20,20,20,20,20,20,20,20}', 'align:L;border:1');
			$table2->easyCell('No','align:C');
			$table2->easyCell('Nama Siswa','align:C');
			$table2->easyCell('JUL','align:C');
			$table2->easyCell('AGS','align:C');
			$table2->easyCell('SEP','align:C');
			$table2->easyCell('OKT','align:C');
			$table2->easyCell('NOV','align:C');
			$table2->easyCell('DES','align:C');
			$table2->easyCell('JAN','align:C');
			$table2->easyCell('FEB','align:C');
			$table2->easyCell('MAR','align:C');
			$table2->easyCell('APR','align:C');
			$table2->easyCell('MEI','align:C');
			$table2->easyCell('JUN','align:C');
			$table2->printRow(true);
			
			$sql2="select * from penempatan where rombel='$kelas' and tapel='$tapel'";
			$query2 = $connect->query($sql2);
			$nomor=1;
			while($n=$query2->fetch_assoc()) {
				$ids = $n['peserta_didik_id'];
				$tarifnya=$connect->query("select * from tarif_spp where peserta_didik_id='$ids'")->fetch_assoc();
				$table2->rowStyle('font-size:8');
				$table2->easyCell($nomor,'align:L');
				$nomor=$nomor+1;
				$table2->easyCell($n['nama'],'align:L');
				$sql22="select * from bulan_spp order by id_bulan asc";
				$query22 = $connect->query($sql22);
				$tot=0;
				$sisa=0;
				while($y=$query22->fetch_assoc()) {
					$idbln=$y['id_bulan'];
					$cekspp=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$idbln'")->num_rows;
					if($cekspp>0){
						$sppnya=$connect->query("select * from pembayaran where peserta_didik_id='$ids' and tapel='$tapel' and jenis='1' and bulan='$idbln'")->fetch_assoc();
						//$jbulan[$idbln]+=$sppnya['bayar'];
						$table2->easyCell($sppnya['tanggal'],'align:C');
					}else{
						$table2->easyCell('','align:C');
					}
				}
				$table2->printRow();
			}
			$table2->easyCell('Jumlah','colspan:2;align:C');
			$sql24="select * from bulan_spp order by id_bulan asc";
			$query24 = $connect->query($sql24);
			while($z=$query24->fetch_assoc()) {
				$idblns=$z['id_bulan'];
				$sppnyas=$connect->query("select sum(bayar) as dibayar from penempatan left join pembayaran on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.rombel='$kelas' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='1' and pembayaran.bulan='$idblns'")->fetch_assoc();
				$table2->easyCell(number_format($sppnyas['dibayar'],0,',','.'),'align:C');
			}
			$table2->printRow(true);
			$table2->endTable(4);
		
		
		
	
		
		
		
		
			$pdf->Output();
			//$pdf->Output('D',$namafilenya);
		 


 

?>