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
$jenis=$_GET['jenis'];
$jtunggakan=$connect->query("select * from jenis_tunggakan where id_tunggakan='$jenis'")->fetch_assoc();
$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
$hari=date('Y-m-d');
//$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
		$pdf=new exFPDF('P','mm',array(215,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);

		//$table2=new easyTable($pdf, '{30,185}');
		//$table2->easyCell('','img:logo.jpg,w20;rowspan:4;align:C;border:B');
		//$table2->easyCell('SD ISLAM AL-JANNAH','font-size:14;align:L;');
		//$table2->printRow();
		//$table2->easyCell('Jl. Raya Gabuswetan No. 1 Desa Gabuswetan Kec. Gabuswetan','align:L');
		//$table2->printRow();
		//$table2->easyCell('Kab. Indramayu - Jawa Barat 45263 Telp. (0234) 5508501','align:L');
		//$table2->printRow();
		//$table2->easyCell('Website: https://sdi-aljannah.web.id Email: sdi.aljannah@gmail.com','align:L;border:B');
		//$table2->printRow();
		//$table2->endTable();
		
		$table2=new easyTable($pdf, '{215}', 'align:C');
		$table2->easyCell('LAPORAN KEWAJIBAN ADMINISTRASI SISWA','align:C');
		$table2->printRow();
		$table2->easyCell('JENIS TUNGGAKAN : '.$jtunggakan['nama_tunggakan'],'align:C');
		$table2->printRow();
		$table2->easyCell('Dicetak Tanggal '.TanggalIndo($hari),'font-size:6;align:C');
		$table2->printRow();
		$table2->endTable();
		
		$totaltarif=0;
		$jumlahtotal=0;
		$dibayar=0;
		$jumlahsisa=0;
		$table2=new easyTable($pdf, '{80,30,35,35,35}', 'align:L');
		$table2->easyCell('Nama Siswa','align:L;border:BT');
		$table2->easyCell('Kelas','align:L;border:BT');
		$table2->easyCell('Tarif/Biaya','align:C;border:BT');
		$table2->easyCell('Pembayaran','align:C;border:BT');
		$table2->easyCell('Sisa','align:C;border:BT');
		$table2->printRow(true);
		
		$sql1="select * from penempatan where tapel='$tapel' order by rombel asc";
		$query1 = $connect->query($sql1);
		while($m=$query1->fetch_assoc()) {
			$idpd=$m['peserta_didik_id'];
			if($jenis==1){
				$jumlahtunggakan=$connect->query("select * from tarif_spp where peserta_didik_id='$idpd'")->fetch_assoc();
				$totaltarif=12*$jumlahtunggakan['tarif'];
			}else{
				$jumlahtunggakan=$connect->query("select * from tunggakan_lain where peserta_didik_id='$idpd' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
				$totaltarif=$jumlahtunggakan['tarif'];
			};
			$jumlahbayar=$connect->query("select sum(bayar) as jumlahbayar from pembayaran where peserta_didik_id='$idpd' and tapel='$tapel' and jenis='$jenis'")->fetch_assoc();
			$sisa=$totaltarif-$jumlahbayar['jumlahbayar'];
			$jumlahtotal=$jumlahtotal+$totaltarif;
			$dibayar=$dibayar+$jumlahbayar['jumlahbayar'];
			$jumlahsisa=$jumlahsisa+$sisa;
			if($sisa==0){
			}else{
				$table2->easyCell($m['nama'],'align:L;');
				$table2->easyCell($m['rombel'],'align:L;');
				$table2->easyCell(rupiah($totaltarif),'align:R;');
				$table2->easyCell(rupiah($jumlahbayar['jumlahbayar']),'align:R;');
				$table2->easyCell(rupiah($sisa),'align:R;');
				$table2->printRow();
			}
		}
		$table2->easyCell('JUMLAH','colspan:2;align:C;border:BT');
		$table2->easyCell(rupiah($jumlahtotal),'align:R;border:BT');
		$table2->easyCell(rupiah($dibayar),'align:R;border:BT');
		$table2->easyCell(rupiah($jumlahsisa),'align:R;border:BT');
		$table2->printRow();
		
		$table2->endTable();
		
	
		
		
		
		
			$pdf->Output('F','tunggakan-kategori.pdf');
			//$pdf->Output('D',$namafilenya);
		 


 

?>
<?php 
require_once '../function/functions.php';
$data['title'] = 'Cetak Tunggakan '.$jtunggakan['nama_tunggakan'];
//view('template/head', $data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>APINS - <?=$data['title'];?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/app.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/pretty-checkbox/pretty-checkbox.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='<?= base_url(); ?>assets/img/fav.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container">
        <div class="login-brand">
              Cetak Jumlah Tunggakan<br/>
			  <small><?=$jtunggakan['nama_tunggakan'];?></small>
        </div>
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-statistic-4">
				  <div class="form-row">
                    <div class="form-group col-md-6">
						<input type="hidden" name="txtPdfFile" id="txtPdfFile" value="tunggakan-kategori.pdf" />
						<label>Printers:</label>
						<select class="form-control select2" name="lstPrinters" id="lstPrinters" onchange="showSelectedPrinterInfo();" >
							<option selected><?=$jprinter['nama'];?></option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label>Supported Trays:</label>
						<select class="form-control select2" name="lstPrinterTrays" id="lstPrinterTrays" >
						</select>
					</div>
				  </div>
				  <div class="form-row">
					<div class="form-group col-md-6">
						<label>Supported Papers:</label>
						<select class="form-control select2" name="lstPrinterPapers" id="lstPrinterPapers" >
							<option><?=$jprinter['kwitansi'];?></option>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label>Print Rotation (Clockwise):</label>
						<select class="form-control select2" name="lstPrintRotation" id="lstPrintRotation" >
							<option>None</option>
							<option>Rot90</option>
							<option>Rot180</option>
							<option>Rot270</option>
						</select>
					</div>
				  </div>
					<div class="form-group">
						<label>Pages Range: [e.g. 1,2,3,10-15]</label>
						<input type="text" id="txtPagesRange" />
					</div>
					<div class="form-group">
						<label><input id="chkPrintInReverseOrder" type="checkbox" value=""> Print In Reverse Order?</label>
					</div>
					<div class="form-group">
						<label><input id="chkPrintAnnotations" type="checkbox" value=""> Print Annotations? <span><em>Windows Only</em></span></label>
					</div>
					<div class="form-group">
						<label><input id="chkPrintAsGrayscale" type="checkbox" value=""> Print As Grayscale? <span><em>Windows Only</em></span></label>
					</div>
                </div>
				<div class="card-footer text-right">
					<button class="btn btn-primary mr-1" type="button" onclick="print();"><i class="fas fa-print"></i> Cetak</button>
				</div>
              </div>
			  
          </div>
		</div>
      </div>
    </section>
  </div>
  <?php include "../template/script.php";?>
  <script src="zip-full.min.js"></script>
<script src="JSPrintManager.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>

<script>

var clientPrinters = null;
    var _this = this;

    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();

    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }

    //Do printing...
    function print() {
        if (jspmWSStatus()) {

            //Create a ClientPrintJob
            var cpj = new JSPM.ClientPrintJob();

            //Set Printer info
            var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
            myPrinter.paperName = $('#lstPrinterPapers').val();
            myPrinter.trayName = $('#lstPrinterTrays').val();
                
            cpj.clientPrinter = myPrinter;

            //Set PDF file
            var my_file = new JSPM.PrintFilePDF($('#txtPdfFile').val(), JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
            my_file.printRange = $('#txtPagesRange').val();
            my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
            my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
            my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

            cpj.files.push(my_file);

            //Send print job to printer!
            cpj.sendToClient();
                
        }
    }

    function showSelectedPrinterInfo() {
        // get selected printer index
        var idx = $("#lstPrinters")[0].selectedIndex;
        // get supported trays
        var options = '';
        for (var i = 0; i < clientPrinters[idx].trays.length; i++) {
            options += '<option>' + clientPrinters[idx].trays[i] + '</option>';
        }
        $('#lstPrinterTrays').html(options);
        // get supported papers
        options = '';
        for (var i = 0; i < clientPrinters[idx].papers.length; i++) {
            options += '<option>' + clientPrinters[idx].papers[i] + '</option>';
        }
        $('#lstPrinterPapers').html(options);
    }

</script>
</body>
</html>