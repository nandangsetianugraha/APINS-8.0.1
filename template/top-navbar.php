	  <nav class="navbar navbar-expand-lg main-navbar bg-primary sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
		  <span class="navbar-text">
            <?=$tapel;?> Semester <?=$smt;?>
          </span>
        </div>
        <ul class="navbar-nav navbar-right">
			<?php 
			$nad=mysqli_query($koneksi, "select * from ptk where jenis_ptk_id='11'");
			$namaadmin=mysqli_fetch_array($nad);
			$brt=mysqli_query($koneksi, "select * from pengumuman order by waktu desc limit 3");
			$jbrt=mysqli_num_rows($brt);
			?>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
              <span class="badge headerBadge1">
                <?=$jbrt;?> </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
				<?php 
					if($jbrt>0){
						while($pg=mysqli_fetch_array($brt)){
					?>
                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="../images/ptk/<?=$namaadmin['gambar'];?>" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user"><?=$pg['judul'];?></span> <span class="time messege-text"><?=limit_words($pg['berita'],12);?>...</span>
                    <span class="time"><?=$pg['waktu'];?></span>
                  </span>
                </a> 
					<?php }} ?>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?= base_url(); ?>images/ptk/<?=$avatar;?>"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title"><?=$bioku['nama'];?></div>
              <a href="profile" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="activity" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> <a href="setting" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>