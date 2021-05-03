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
$pdid=$_GET['pdid'];
$tapel=$_GET['tapel'];
$siswa=$connect->query("select * from siswa where peserta_didik_id='$pdid'")->fetch_assoc();
$kelas=$connect->query("select * from penempatan where peserta_didik_id='$pdid' and tapel='$tapel'")->fetch_assoc();
$jprinter=$connect->query("select * from printer where status='1'")->fetch_assoc();
$nomor=$siswa['nis'].".png";
$thn=isset($_GET['thn']) ? $_GET['thn'] : date("Y");
$bln = array("Juli", "Agustus", "September", "Oktober", "November", "Desember", "Januari", "Februari", "Maret", "April", "Mei", "Juni");
		$pdf=new exFPDF('P','mm',array(110,165));
		//Halaman 1
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);
		$table2=new easyTable($pdf, '{110}');
		$table2->easyCell('','img:logo.jpg,w30;align:C;valign:M');
		$table2->printRow();
		$table2->easyCell('SEKOLAH DASAR ISLAM AL-JANNAH','font-size:12;font-style:B;align:C;');
		$table2->printRow();
		$table2->rowStyle('min-height:3');
		$table2->easyCell('Jl. Raya Gabuswetan No. 1 Desa Gabuswetan Kec. Gabuswetan','font-size:7;align:C;');
		$table2->printRow();
		$table2->rowStyle('min-height:3');
		$table2->easyCell('Indramayu Jabar 45263 Telp/Fax. (0234) 5508501','font-size:7;align:C;');
		$table2->printRow();
		$table2->rowStyle('min-height:3');
		$table2->easyCell('Website: https://sdi-aljannah.web.id email: sdi.aljannah@gmail.com','font-size:7;align:C;');
		$table2->printRow();
		$table2->easyCell('','img:../modul/qrcode/temp/'.$nomor.',w30;align:C;valign:M');
		$table2->printRow();
		$table2->rowStyle('min-height:10');
		$table2->easyCell($siswa['nama'],'font-size:12;font-style:B;align:C;valign:M;border:1');
		$table2->printRow();
		$table2->endTable();
		
		$table2=new easyTable($pdf, '{50,10,50}');
		$table2->rowStyle('min-height:10');
		$table2->easyCell('Kelas '.$kelas['rombel'],'font-size:12;font-style:B;align:C;valign:M;border:1');
		$table2->easyCell('','font-size:12;font-style:B;align:C;valign:M');
		$table2->easyCell($siswa['nis'],'font-size:12;font-style:B;align:C;valign:M;border:1');
		$table2->printRow();
		$table2->endTable(10);
		
		$table2=new easyTable($pdf, '{110}');
		$table2->easyCell('KARTU INFAQ BULANAN','font-size:14;font-style:B;align:C;');
		$table2->printRow();
		$table2->easyCell('TAHUN PELAJARAN '.$tapel,'font-size:14;font-style:B;align:C;');
		$table2->printRow();
		$table2->endTable();
		
		//Halaman 2
		$pdf->AddPage(); 
		$pdf->SetFont('helvetica','',10);

		$table2=new easyTable($pdf, '{110}');
		//$table2->rowStyle('min-height:4'); 
		$table2->easyCell('KARTU INFAQ BULANAN','font-size:10;font-style:B;align:C;');
		$table2->printRow();
		//$table2->rowStyle('min-height:4'); 
		$table2->easyCell('TAHUN AJARAN '.$tapel,'font-size:10;font-style:B;align:C;');
		$table2->printRow();
		$table2->endTable(5);
		
		$table2=new easyTable($pdf, '{30,26,22,26,16}','align:L');
		$table2->rowStyle('min-height:6'); 
		$table2->easyCell('BULAN','font-size:8;valign:M;align:C;border:1');
		$table2->easyCell('TANGGAL','font-size:8;valign:M;align:C;border:1');
		$table2->easyCell('JUMLAH','font-size:8;valign:M;align:C;border:1');
		$table2->easyCell('OPR','font-size:8;valign:M;align:C;border:1');
		$table2->easyCell('PARAF','font-size:8;valign:M;align:C;border:1');
		$table2->printRow();
		for ($x = 1; $x <= 12; $x++) {
			if($x==12){
				if($x % 2 == 0){
					$table2->rowStyle('min-height:6');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LRB');
					$table2->printRow();
				}else{
					$table2->rowStyle('min-height:6;bgcolor:#E6E6E6');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LB');
					$table2->easyCell('','font-size:8;align:c;border:LRB');
					$table2->printRow();
				};
			}else{
				if($x % 2 == 0){
					$table2->rowStyle('min-height:6');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:LR');
					$table2->printRow();
				}else{
					$table2->rowStyle('min-height:6;bgcolor:#E6E6E6');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:L');
					$table2->easyCell('','font-size:8;align:c;border:LR');
					$table2->printRow();
				};
			};
		};
		$table2->endTable();
		
		$table2=new easyTable($pdf, '{10,40,10,50}');
		//$table2->rowStyle('min-height:4'); 
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('Mengetahui,','font-size:8;align:L;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('Gabuswetan, ..........................','font-size:8;align:L;');
		$table2->printRow();
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('Kepala Sekolah','font-size:8;align:L;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('Bendahara Sekolah','font-size:8;align:L;');
		$table2->printRow();
		$table2->rowStyle('min-height:10'); 
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->printRow();
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('UMAR ALI, S.Pd.','font-style:BU;font-size:8;align:L;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('ECI CUNIAH, S.Pd.','font-style:BU;font-size:8;align:L;');
		$table2->printRow();
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('NIP.','font-size:8;align:L;');
		$table2->easyCell('','font-size:8;align:C;');
		$table2->easyCell('NIP.','font-size:8;align:L;');
		$table2->printRow();
		$table2->endTable();
		
		
	
		
		
		
		
			$pdf->Output('F','cetak-spp.pdf');
			//$pdf->Output('D',$namafilenya);
		 


 

?>
<?php 
require_once '../function/functions.php';
$data['title'] = 'Cetak Kartu SPP';
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
              Cetak Kartu SPP<br>
			  <small><?=$siswa['nama'];?></small>
        </div>
		<div class="row">
          <div class="col-12 col-md-8 offset-md-2">
            <div class="card">
                <div class="card-statistic-4">
				  <div class="form-row">
                    <div class="form-group col-md-12">
						<input type="hidden" name="txtPdfFile" id="txtPdfFile" value="cetak-spp.pdf" />
						<label>Printers:</label>
						<select class="form-control select2" name="lstPrinters" id="lstPrinters" onchange="showSelectedPrinterInfo();" >
						<option selected><?=$jprinter['nama'];?></option>
						</select>
					</div>
				  </div>
				  <div class="form-row">
					<div class="form-group col-md-12">
						<label>Supported Papers:</label>
						<select class="form-control select2" name="lstPrinterPapers" id="lstPrinterPapers" >
						<option selected><?=$jprinter['spp'];?></option>
						</select>
					</div>
				  </div>
					<div class="form-group">
						<label>Halaman :</label>
						<input type="text" id="txtPagesRange" />
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