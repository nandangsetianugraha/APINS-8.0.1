					<?php 
					include "../function/db.php";
					$brt1=mysqli_query($koneksi, "select * from log order by logDate desc");
					$jbrt1=mysqli_num_rows($brt1);
					if($jbrt1>0){
					?>
					<div class="table-responsive">
						<table class="table table-sm table-striped" id="table-1">
							<thead>
								<tr>
									<th width="24%">Tanggal</th>
									<th>Aktivitas</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							while($pg1=mysqli_fetch_array($brt1)){
								$ptk_id=$pg1['ptk_id'];
								$nad1=mysqli_query($koneksi, "select * from ptk where ptk_id='$ptk_id'");
								$namaadmin1=mysqli_fetch_array($nad1);
								if(file_exists( $_SERVER{'DOCUMENT_ROOT'} . "/images/ptk/".$namaadmin1['gambar'])){
									$gbr=$namaadmin1['gambar'];
								}else{
									$gbr="user-default.png";
								};
							?>
							<tr>
								
								<td><?=$pg1['logDate'];?></td>
                                <td>
									<ul class="list-unstyled list-unstyled-border user-list" id="message-list">
										<li class="media">
											<img alt="image" src="../images/ptk/<?=$gbr;?>" class="mr-3 user-img-radious-style user-list-img">
											<div class="media-body">
											  <div class="mt-0 font-weight-bold"><?=$namaadmin1['nama'];?></div>
											  <div class="text-small"><?=$pg1['activity'];?></div>
											</div>
										</li>
									</ul>
								</td>
							</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					
					<?php }else{ ?>
					<div class="alert alert-info alert-dismissible">
						<h4><i class="icon fa fa-info-circle"></i> Informasi</h4>
						Belum Ada Pengumuman
					</div>
					<?php } ?>
					<script>
					  $("#table-1").dataTable({
						  "searching": true,
						  "paging":true,
						  "order": []
						});
					</script>