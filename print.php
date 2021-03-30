<?php 
//session_start();
require_once 'function/functions.php';

$data['title'] = 'Blank';
//view('template/head', $data);
include "template/kepala.php";
?>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include "template/navbar-atas.php"; ?>
	  
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
				
				<div style="text-align:center">
					<h1>Advanced PDF Printing from Javascript</h1>
					<hr />
					<div>
						<div>
							<label for="txtPdfFile">PDF File URL:</label>
							<input type="text" name="txtPdfFile" id="txtPdfFile" value="https://neodynamic.com/temp/LoremIpsum.pdf" />
						</div>
						<div>
							<label for="lstPrinters">Printers:</label>
							<select name="lstPrinters" id="lstPrinters" onchange="showSelectedPrinterInfo();" ></select>
						</div>
						<div>
							<label for="lstPrinterTrays">Supported Trays:</label>
							<select name="lstPrinterTrays" id="lstPrinterTrays" ></select>
						</div>
						<div>
							<label for="lstPrinterPapers">Supported Papers:</label>
							<select name="lstPrinterPapers" id="lstPrinterPapers" ></select>
						</div>
						<div>
							<label for="lstPrintRotation">Print Rotation (Clockwise):</label>
							<select name="lstPrintRotation" id="lstPrintRotation" >
								<option>None</option>
								<option>Rot90</option>
								<option>Rot180</option>
								<option>Rot270</option>
							</select>
						</div>
					</div>
					<div>
						<div>
							<label for="txtPagesRange">Pages Range: [e.g. 1,2,3,10-15]</label>
							<input type="text"  id="txtPagesRange">
						</div>
						<div>
							<div >
								<label><input id="chkPrintInReverseOrder" type="checkbox" value="">Print In Reverse Order?</label>
							</div>
						</div>
						<div>
							<div >
								<label><input id="chkPrintAnnotations" type="checkbox" value="">Print Annotations? <span><em>Windows Only</em></span></label>
							</div>
						</div>
						<div>
							<div >
								<label><input id="chkPrintAsGrayscale" type="checkbox" value="">Print As Grayscale? <span><em>Windows Only</em></span></label>
							</div>
						</div>

					</div>
					<hr />
					<button type="button" onclick="print();">Print Now...</button>
				</div>
                            
			</div>
          </div>
        </section>
		<?php include "template/setting.php"; ?>
      </div>
      <?php include "template/kaki.php"; ?>
    </div>
  </div>
  <?php include "template/script.php";?>
  


<script src="zip-full.min.js"></script>
<script src="JSPrintManager.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>

<script>

var clientPrinters = null;
    var _this = this;

    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();
    JSPM.JSPrintManager.WS.onStatusChanged = function () {
        if (jspmWSStatus()) {
            //get client installed printers
            JSPM.JSPrintManager.getPrintersInfo().then(function (printersList) {
                clientPrinters = printersList;
                var options = '';
                for (var i = 0; i < clientPrinters.length; i++) {
                    options += '<option>' + clientPrinters[i].name + '</option>';
                }
                $('#lstPrinters').html(options);
                _this.showSelectedPrinterInfo();
            });
        }
    };

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