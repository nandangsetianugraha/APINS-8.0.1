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

	$idinv=$_GET['idinv'];
	$jprinter=$connect->query("select * from printer")->fetch_assoc();
		$pdf=new exFPDF('P','mm',array(215,330));
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);

		$table2=new easyTable($pdf, '{150,65}');
		$table2->rowStyle('font-size:14');
		$table2->easyCell('SD ISLAM AL-JANNAH','align:L;font-style:B');
		$table2->rowStyle('font-size:10');
		$table2->easyCell('BUKTI PEMBAYARAN','rowspan:2;valign:M;align:C;font-style:B;border:1');
		$table2->printRow();
		$table2->rowStyle('font-size:8');
		$table2->easyCell('Jl. Raya Gabuswetan No. 1 Desa Gabuswetan Kec. Gabuswetan Kab. Indramayu - Jawa Barat 45263 Telp. (0234) 5508501 Website: https://sdi-aljannah.web.id Email: sdi.aljannah@gmail.com','align:L;');
		$table2->printRow();
		$table2->endTable();
		
		$invo=$connect->query("select * from invoice where id='$idinv'")->fetch_assoc();
		$nomorinv=$invo['nomor'];
		$namafile=$nomorinv.'.pdf';
		$idpd=$invo['peserta_didik_id'];
		$tapel=$invo['tapel'];
		$namasiswa=$connect->query("select * from siswa where peserta_didik_id='$idpd'")->fetch_assoc();
		$kelas=$connect->query("select * from penempatan where peserta_didik_id='$idpd' and tapel='$tapel'")->fetch_assoc();
		$table2=new easyTable($pdf, '{33,5,33,33,5,33,25,5,50}');
		$table2->easyCell('Diterima dari','align:L;font-style:B;border:T');
		$table2->easyCell(':','align:L;font-style:B;border:T');
		$table2->easyCell($namasiswa['nama'],'colspan:4;align:L;font-style:B;border:T');
		$table2->easyCell('Tgl. Bayar','align:L;font-style:B;border:T');
		$table2->easyCell(':','align:L;font-style:B;border:T');
		$table2->easyCell($invo['tanggal'],'align:L;font-style:B;border:T');
		$table2->printRow();
		
		$table2->easyCell('Nomor Induk','align:L;font-style:B');
		$table2->easyCell(':','align:L;font-style:B');
		$table2->easyCell($namasiswa['nis'],'colspan:4;align:L;font-style:B');
		$table2->easyCell('No. Bukti','align:L;font-style:B');
		$table2->easyCell(':','align:L;font-style:B');
		$table2->easyCell($invo['nomor'],'align:L;font-style:B');
		$table2->printRow();
		
		$table2->easyCell('Kelas','align:L;font-style:B');
		$table2->easyCell(':','align:L;font-style:B');
		$table2->easyCell($kelas['rombel'],'colspan:4;align:L;font-style:B');
		$table2->easyCell('Metode','align:L;font-style:B');
		$table2->easyCell(':','align:L;font-style:B');
		$table2->easyCell('Tunai','align:L;font-style:B');
		$table2->printRow();
		
		$table2->easyCell('Terbilang','align:L;font-style:B');
		$table2->easyCell(':','align:L;font-style:B');
		$table2->easyCell(terbilang($invo['jumlah']).' rupiah','colspan:7;align:L;font-style:B');
		$table2->printRow();
		
		$table2->easyCell('Dengan Rincian Sebagai Berikut:','colspan:9;align:L;border:TB');
		$table2->printRow();
		
		$sql22 = "select * from pembayaran where id_invoice='$nomorinv'";
		$query22 = $connect->query($sql22);
		$nourut=1;
		while($transaksi=$query22->fetch_assoc()) {
			$table2->easyCell($nourut.'. '.$transaksi['deskripsi'],'colspan:8;align:L;');
			$table2->easyCell(rupiah($transaksi['bayar']),'align:L;');
			$table2->printRow();
			$nourut=$nourut+1;
		};
		
		$table2->easyCell('Penyetor,','colspan:3;align:C;font-style:B;border:T');
		$table2->easyCell('Penerima,','colspan:3;align:C;font-style:B;border:T');
		$table2->easyCell('Jumlah','align:R;font-style:B;border:T');
		$table2->easyCell(':','align:L;font-style:B;border:T');
		$table2->easyCell(rupiah($invo['jumlah']),'align:L;font-style:B;border:T');
		$table2->printRow();
		
		$table2->easyCell('','colspan:3;align:C;font-style:B;');
		$table2->easyCell('','colspan:3;align:C;font-style:B;');
		$table2->easyCell('Bayar','align:R;font-style:B;');
		$table2->easyCell(':','align:L;font-style:B;');
		$table2->easyCell(rupiah($invo['jumlah']),'align:L;font-style:B;');
		$table2->printRow();
		
		$table2->easyCell('','colspan:3;align:C;font-style:B;');
		$table2->easyCell('','colspan:3;align:C;font-style:B;');
		$table2->easyCell('Kembali','align:R;font-style:B;border:B');
		$table2->easyCell(':','align:L;font-style:B;border:B');
		$table2->easyCell(rupiah(0),'align:L;font-style:B;border:B');
		$table2->printRow();
		$namaTU=$connect->query("select * from ptk where jenis_ptk_id='5'")->fetch_assoc();
		$table2->easyCell('_______________','colspan:3;align:C;font-style:B;');
		$table2->easyCell($namaTU['nama'],'colspan:3;align:C;font-style:B;');
		$table2->easyCell('','align:R;font-style:B;');
		$table2->easyCell('','align:L;font-style:B;');
		$table2->easyCell('','align:L;font-style:B;');
		$table2->printRow();
		
		$table2->endTable();
		
		
		
		
			$pdf->Output('F','invoice.pdf');
			//$pdf->Output('D',$namafilenya);
		 


 

?>
<?php 
require_once '../function/functions.php';
$data['title'] = 'Cetak Invoice';
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
              Cetak Invoice
        </div>
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-statistic-4">
				  <div class="form-row">
                    <div class="form-group col-md-6">
						<input type="hidden" name="txtPdfFile" id="txtPdfFile" value="invoice.pdf" />
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
						<option selected><?=$jprinter['kwitansi'];?></option>
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