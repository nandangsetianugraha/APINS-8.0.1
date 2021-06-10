<div class="modal fade" id="sidebarDrawer" tabindex="-1" aria-labelledby="sidebarDrawer" aria-hidden="true">
	<div class="modal-dialog side-modal-dialog">
		<div class="modal-content">
			<div class="modal-header sidebar-modal-header">
			<div class="sidebar-profile-info">
			<div class="sidebar-profile-thumb">
			<img src="https://apins.sdi-aljannah.web.id/images/siswa/<?=$avatar;?>" alt="profile">
			</div>
			<div class="sidebar-profile-text">
			<h3><?=$siswa['nama'];?></h3>
			<p><?=$siswa['nisn'];?></p>
			</div>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="sidebar-profile-wallet">
				<div class="add-card-info">
					<p>Saldo Tabungan</p>
					<h3>Rp0</h3>
				</div>
			</div>
			<div class="modal-body">
				<div class="sidebar-nav">
					<div class="sidebar-nav-item">
						<h3>Oban Menu</h3>
						<ul class="sidebar-nav-list">
							<li><a href="./" class="active"><i class="flaticon-house"></i> Beranda</a></li>
							<li><a href="nilai.php"><i class="flaticon-invoice"></i> Nilai</a></li>
							<li><a href="tunggakan.php"><i class="flaticon-menu-1"></i> Tunggakan</a></li>
							<li><a href="transaksi.php"><i class="flaticon-credit-card"></i> Riwayat</a></li>
							<li><a href="profil.php"><i class="flaticon-settings"></i> Profil</a></li>
							<li><a href="logout.php"><i class="flaticon-logout"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>