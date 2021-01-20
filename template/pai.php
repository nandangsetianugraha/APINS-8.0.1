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
            <li class="menu-header">Penilaian</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Administrasi K13</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="kompetensi">Kompetensi Dasar</a></li>
                <li><a class="nav-link" href="pemetaan">Pemetaan KD</a></li>
                <li><a class="nav-link" href="kkm">KKM</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Penilaian Sikap</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="spiritual">Spiritual</a></li>
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
            <li class="menu-header">Cetak Laporan</li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Generate Raport</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="raportspiritual">Spiritual</a></li>
                <li><a class="nav-link" href="raportpengetahuan">Pengetahuan</a></li>
                <li><a class="nav-link" href="raportketrampilan">Ketrampilan</a></li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </aside>