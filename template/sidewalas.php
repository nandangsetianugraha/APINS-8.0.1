		<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= base_url(); ?>"> <img alt="image" src="<?= base_url(); ?>assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">APINS</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="./" class="nav-link"><i data-feather="monitor"></i><span>Beranda</span></a>
            </li>
			<?php if($norombel){}else{ ?>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>Manajemen Kelas</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="siswa">Daftar Siswa</a></li>
				<li><a class="nav-link" href="penempatan">Penempatan</a></li>
                <li><a class="nav-link" href="absensi">Absensi</a></li>
              </ul>
            </li>
            <li class="menu-header">Penilaian</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Administrasi K13</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="tema">Tema</a></li>
                <li><a class="nav-link" href="kompetensi">Kompetensi Dasar</a></li>
                <li><a class="nav-link" href="pemetaan">Pemetaan KD</a></li>
                <li><a class="nav-link" href="kkm">KKM</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Penilaian Sikap</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="sosial">Sosial</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Penilaian Pengetahuan</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="pengetahuan">Pengetahuan</a></li>
                <li><a class="nav-link" href="ketrampilan">Ketrampilan</a></li>
                <li><a class="nav-link" href="pts">Tengah Semester</a></li>
                <li><a class="nav-link" href="pas">Akhir Semester</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>Penilaian Tahfidz</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="tahfidz">Tahfidz</a></li>
                <li><a class="nav-link" href="cetaktahfidz">Cetak Tahfidz</a></li>
              </ul>
            </li>
			<li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Data Isian Semester</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="kesehatan">Kesehatan</a></li>
                <li><a class="nav-link" href="prestasi">Prestasi</a></li>
                <li><a class="nav-link" href="ekskul">Ekstrakurikuler</a></li>
                <li><a class="nav-link" href="saran">Saran dan Pesan</a></li>
              </ul>
            </li>
            <li class="menu-header">Cetak Laporan</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Generate Raport</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="raportsosial">Sosial</a></li>
                <li><a class="nav-link" href="raportpengetahuan">Pengetahuan</a></li>
                <li><a class="nav-link" href="raportketrampilan">Ketrampilan</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="pie-chart"></i><span>Cetak</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="cetakraport">Cetak Raport</a></li>
                <li><a class="nav-link" href="rekapraport">Rekap Raport</a></li>
                <li><a class="nav-link" href="formatf1">Format F1</a></li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </aside>