<?php

use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\Printer;

class RecieptPrinter {

  /* Create divider */
  protected $divider;

  public function __construct()
  {
    $this->divider = str_repeat("-", 40);
  }

  public function raw_base64( array $data )
  {
      // Make sure you load a Star print connector or you may get gibberish.
      $connector = new DummyPrintConnector();
      $profile = CapabilityProfile::load("TM-U220");
      $printer = new Printer($connector);

      // Create Header
      $printer->initialize();
      $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Set text more bigger
      $printer->setJustification(Printer::JUSTIFY_CENTER); // Set justify text
      $printer->setFont(Printer::FONT_B); // Use FONT B
      $printer->setEmphasis(true); // Set Emphasis (on)
      $printer->text( YOUR_COMPANY_NAME . "\n" );
      $printer->setEmphasis(false); // Set Emphasis (off)
      $printer->feed(1);

      // Create Subheader
      $printer->initialize();
      $printer->setJustification(Printer::JUSTIFY_CENTER); // Set justify text
      $printer->setFont(Printer::FONT_B); // Use FONT B
      $printer->setEmphasis(true); // Set Emphasis (on)
      $printer->text("MELAYANI SEPENUH HATI\n"); // start slogan
      $printer->text( YOUR_ADDRESS ."\n" ); // set address
      $printer->text("Buka Jam 07:30 - 16:30\n"); // set opening hours
      $printer->setEmphasis(false); // Set Emphasis (off)
      $printer->feed(1);

      // Membuat detail operator
      $printer->initialize();
      $printer->setLineSpacing(20);
      $printer->setFont(Printer::FONT_B); // Use FONT B
      $printer->setEmphasis(true); // Set Emphasis (on)
      $printer->text( $this->divider ); // use divider
      $printer->text( $this->_buatBarisSejajar("Operator : ", YOUR_OPERATOR_NAME ) );
      $printer->text( $this->_buatBarisSejajar("Time : ", YOUR_DATE_TIME ) );
      $printer->text( $this->_buatBarisSejajar("Transaction Number  : ", YOUR_TRANSACTION_NUMBER) );
      $printer->text( $this->_buatBarisSejajar("Costumer : ", YOUR_COSTUMER_NAME) );
      $printer->text( $this->divider ); // use divider
      $printer->setEmphasis(false); // Set Emphasis (off)
      $printer->feed(1);

      // Reciept details
      $printer->initialize();
      $printer->setLineSpacing(20);
      $printer->setFont(Printer::FONT_B); // Use FONT B
      $printer->setEmphasis(true); // Set Emphasis (on)
      $number = 1;
      $total = [];
      foreach ($data['details'] as $d) {
          $printer->text( $this->_buatBarisContent( $d['YOUR_ITEM'] , $d['YOUR_SUBTOTAL'] )) );
          $printer->text( '@ ' . $d['YOUR_PRICE_ITEM'] . " x " . $d['YOUR_QTY'] . "\n\n" );
          array_push($total, $d['YOUR_SUBTOTAL']);
          $number++;
      }
      $printer->setEmphasis(false);
      $printer->feed(1);

      // Print Footer
      $printer->initialize();
      $printer->setLineSpacing(20);
      $printer->setFont(Printer::FONT_B);
      $printer->setEmphasis(true);
      $printer->text( $this->divider );

      $totalan = array_sum($total);
      $total_belanja = number_format( $totalan );

      // Total Belanja
      $printer->text( $this->_buatBarisSejajar("TOTAL", $total_belanja) );
      /** 
      // Optional Data
      // Total Pajak
      if ( $data['trx']['pajak'] != 0 ) {
          $printer->text( $this->_buatBarisSejajar("PAJAK", $data['trx']['pajak']) );
      }
      // Total Diskon
      if ( $data['trx']['diskon'] != 0 ) {
          $printer->text( $this->_buatBarisSejajar("DISKON", $data['trx']['diskon']) );
          $printer->text( $this->_buatBarisSejajar("TOTAL DISKON", ( $totalan - $data['trx']['diskon'] )) );
      }
      // Total Potongan Member
      if ( $arrData['trx']['potongan_member'] != 0 ) {
          $printer->text( $this->_buatBarisSejajar("POTONGAN MEMBER", $data['trx']['potongan_member']) );
      }
      */
      // Total Bayar
      $bayar = ( $data['trx']['uang_diterima'] != 0 ) ? number_format( $data['trx']['uang_diterima'] ) : '-';
      $printer->text( $this->_buatBarisSejajar("BAYAR", $bayar) );
      /**
      // Total Kembalian
      if ( $data['trx']['diskon'] != 0 ) { 
        $totalan = ( $totalan - $data['trx']['diskon'] );
      }
      if ( $arrData['trx']['pajak'] != 0 ) {
        $totalan = $totalan + ( ( $data['trx']['pajak'] / 100 ) * $totalan );
      }
      */
      $grand_total = ( $totalan - $data['trx']['potongan_member'] ) + $data['trx']['pajak'];
      $kembalian = $data['trx']['uang_diterima'] - $grand_total;
      $text_kembalian = ( $data['trx']['jenis_pembayaran'] != 'Non Tunai' ) ? number_format( $kembalian ) : '-';

      $printer->text( $this->_buatBarisSejajar("KEMBALI", $text_kembalian) );
      // End Total Kembalian
      /**
      if ( $arrData['trx']['jenis_pembayaran'] == 'Non Tunai' ) {
          $printer->text( $this->_buatBarisSejajar("TEMPO", date( 'd/m/Y', strtotime( $data['trx']['jatuh_tempo']))) );
          $printer->text( $this->_buatBarisSejajar("UANG TITIP", number_format( $data['trx']['uang_titip'] )) );
          $printer->text( $this->_buatBarisSejajar("HUTANG", number_format( $totalan - $trx['uang_titip'] )) );
      }
      */
      $printer->setEmphasis(false);
      $printer->feed(1);

      // Membuat sub footer nota
      $printer->initialize();
      $printer->setLineSpacing(20);
      $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
      $printer->setFont(Printer::FONT_B);
      $printer->setEmphasis(true);
      $printer->text("Thanks for Shopping\n");
      $printer->text("Xample Corp\n");
      $printer->text("Bla bla bla\n");
      $printer->text("Ok.\n");
      $printer->setEmphasis(false);
      $printer->feed(3);

      $printer->cut();
      // Get the data out as a string
      $data = $connector->getData();
      $raw_base64 = base64_encode($data);

      // Close the printer when done.
      $printer->close();

      return $raw_base64;
  }

  private function _buatBarisSejajar( $kolom1, $kolom2 )
  {
      $divider = str_repeat("-", 40);
      $full_width = strlen($divider);
      $half_width = $full_width / 2;

      $rawText = str_pad($kolom1, $half_width);
      $rawText .= str_pad($kolom2, $half_width, " ", STR_PAD_LEFT);
      return $rawText . "\n";
  }

  private function _buatBarisContent( $kolom1, $kolom2 )
  {
      $divider = str_repeat("-", 40);
      $full_width = strlen($divider);
      $half_width = $full_width / 2;
      $lebar_kolom_1 = 18;
      $lebar_kolom_2 = 21;

      // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
      $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
      $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);

      // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
      $kolom1Array = explode("\n", $kolom1);
      $kolom2Array = explode("\n", $kolom2);

      // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
      $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

      // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
      $hasilBaris = array();

      // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
      for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

          // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
          $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1);
          $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

          // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
          $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
      }

      // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
      return implode("\n", $hasilBaris) . "\n";
  }

}