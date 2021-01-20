<?php 
		switch ($level) {
			case 94: //guru Bahasa Inggris
				include "../template/mapel.php";
				break;
			case 95: //guru PJOK
				include "../template/mapel.php";
				break;
			case 96: //guru PAI
				include "../template/pai.php";
				break;
			case 97: //guru Pendamping
				include "../template/sidewalas.php";
				break;
			case 98: //guru Kelas
				include "../template/sidewalas.php";
				break;
			case 99: //guru Kepsek
				include "../template/kepsek.php";
				break;
			case 5: //guru Tata Usaha
				include "../template/tatausaha.php";
				break;
			default:
				include "../template/operator.php"; 
				break;
		};
		?>