<?php
$apiKey = ILPo7HD_iw0r7UnnE7-5De-7nplhutXoHg9twScL2Ro;

$credentials = new PrintNode\Credentials\ApiKey( $apiKey );
$client = new PrintNode\Client( $credentials );
$printJob = new PrintNode\Entity\PrintJob( $client );

$rawPrintGenerator = new RecieptPrinter();
$receipt = $rawPrintGenerator->raw_base64( $data );

$printJob->printer = PRINTER_ID;
$printJob->contentType = 'raw_base64';
$printJob->content = $receipt;
$printJob->source = "Your printer source";
$printJob->title = "Your title job";

$printJobId = $client->createPrintJob($printJob);
echo $printJobId;