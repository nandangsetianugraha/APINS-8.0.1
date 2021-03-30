		<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="<?= base_url(); ?>"> <img alt="image" src="<?= base_url(); ?>assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">SIKAS</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="./" class="nav-link"><i data-feather="home"></i><span>Beranda</span></a>
            </li>
			<li class="dropdown">
              <a href="pembayaran" class="nav-link"><i data-feather="shopping-cart"></i><span>Pembayaran</span></a>
            </li>
			<li class="menu-header">Kesiswaan</li>
			<li class="dropdown">
              <a href="siswa" class="nav-link"><i data-feather="users"></i><span>Daftar Siswa</span></a>
            </li>
			<li class="dropdown">
              <a href="tarif" class="nav-link"><i data-feather="shopping-bag"></i><span>Besar Tarif</span></a>
            </li>
			<li class="dropdown">
              <a href="cetak-kartu" class="nav-link"><i data-feather="printer"></i><span>Cetak Kartu</span></a>
            </li>
			<li class="menu-header">Keuangan</li>
			<li class="dropdown">
              <a href="penerimaan" class="nav-link"><i data-feather="gift"></i><span>POS Penerimaan</span></a>
            </li>
			<li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="printer"></i><span>Laporan</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="harian"><i data-feather="printer"></i><span>Pembayaran Harian</span></a></li>
				<li><a class="nav-link" href="tunggakan"><i data-feather="printer"></i><span>Tunggakan Siswa</a></span></li>
				<li><a class="nav-link" href="sisatunggakan"><i data-feather="printer"></i><span>Sisa Tunggakan</a></span></li>
				<li><a class="nav-link" href="laporan-tunggakan"><i data-feather="printer"></i><span>Jumlah Tunggakan</a></span></li>
				<li><a class="nav-link" href="tunggakan-spp"><i data-feather="printer"></i><span>Tunggakan SPP</a></span></li>
              </ul>
            </li>
          </ul>
        </aside>