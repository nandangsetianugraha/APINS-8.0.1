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

$tapel=$_GET['tapel'];
//$kelas=$_GET['kelas'];
$bulan=(int) $_GET['bulan'];
//$jenis=$_GET['jenis'];
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
		$pdf=new exFPDF('L','mm',array(215,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',8);

		$table2=new easyTable($pdf, '{30,185}');
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
		
		$table2=new easyTable($pdf, '{215}', 'align:C');
		$table2->easyCell('REKAPITULASI TUNGGAKAN ADMINISTRASI SISWA','align:C');
		$table2->printRow();
		$table2->easyCell('SAMPAI DENGAN ','align:C');
		$table2->printRow();
		$table2->endTable();
		
		$table2=new easyTable($pdf, '{10,60,8,22,22,22,22,22,22,22,22,22,22,22,22,22,20,20,20}', 'align:L;border:1');
		$table2->easyCell('No','align:L');
		$table2->easyCell('Nama Siswa','align:L');
		$table2->easyCell('K','align:L');
		$table2->easyCell('Tabungan','align:L');
		$sql6="select * from jenis_tunggakan";
		$query6 = $connect->query($sql6);
		while($t=$query6->fetch_assoc()) {
			$table2->easyCell($t['nama_tunggakan'],'align:C');
		}
		$table2->easyCell('Jumlah Tunggakan','align:L');
		$table2->easyCell('Sisa Tabungan','align:L');
		$table2->easyCell('Sisa Tunggakan','align:L');
		$table2->printRow(true);
		
		$sql1="select * from rombel where tapel='$tapel' order by nama_rombel asc";
		$query1 = $connect->query($sql1);
		$no=0;
		while($m=$query1->fetch_assoc()) {
			$idromb=$m['nama_rombel'];
			$sql2="select * from penempatan where rombel='$idromb' and tapel='$tapel' order by nama asc";
			$query2 = $connect->query($sql2);
			while($n=$query2->fetch_assoc()) {
				$no=$no+1;
				$table2->easyCell($no,'align:L;');
				$table2->easyCell($n['nama'],'align:L;');
				$table2->easyCell($idromb,'align:C;');
				$table2->easyCell('','align:R;');
				$idpd=$n['peserta_didik_id'];
				$sql3="select * from jenis_tunggakan";
				$query3 = $connect->query($sql3);
				$jsisa=0;
				while($p=$query3->fetch_assoc()) {
					$idtung = $p['id_tunggakan'];
					if($idtung==1){
						$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from penempatan left join tarif_spp on penempatan.peserta_didik_id=tarif_spp.peserta_didik_id where penempatan.peserta_didik_id='$idpd' and penempatan.rombel='$idromb' and penempatan.tapel='$tapel'")->fetch_assoc();
						$totaltunggakan=$jumlahtunggakan['jumlahspp']*$bulan;
						$sql5="select sum(bayar) as dibayar from pembayaran left join penempatan on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.peserta_didik_id='$idpd' and penempatan.rombel='$idromb' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='$idtung' and pembayaran.bulan <= '$bulan'";
						$query5= $connect->query($sql5);
						$jumlahbayar=$query5->fetch_assoc();
					}else{
						$jumlahtunggakan=$connect->query("select sum(tarif) as jumlahspp from penempatan left join tunggakan_lain on penempatan.peserta_didik_id=tunggakan_lain.peserta_didik_id where penempatan.peserta_didik_id='$idpd' and penempatan.rombel='$idromb' and penempatan.tapel='$tapel' and tunggakan_lain.tapel='$tapel' and tunggakan_lain.jenis='$idtung'")->fetch_assoc();
						$totaltunggakan=$jumlahtunggakan['jumlahspp'];
						$sql5="select sum(bayar) as dibayar from pembayaran left join penempatan on penempatan.peserta_didik_id=pembayaran.peserta_didik_id where penempatan.peserta_didik_id='$idpd' and penempatan.rombel='$idromb' and penempatan.tapel='$tapel' and pembayaran.tapel='$tapel' and pembayaran.jenis='$idtung'";
						$query5= $connect->query($sql5);
						$jumlahbayar=$query5->fetch_assoc();
					}
					$jsisa=$jsisa+$totaltunggakan-$jumlahbayar['dibayar'];
					$table2->easyCell(rupiah($totaltunggakan-$jumlahbayar['dibayar']),'align:R;');
				};
				$table2->easyCell(rupiah($jsisa),'align:R;');
				$table2->easyCell('','align:R;');
				$table2->easyCell('','align:R;');
				$table2->printRow();
			};
		}
		$table2->endTable();
		
		
		
		
		
			$pdf->Output();
			//$pdf->Output('D',$namafilenya);
		 


 

?>