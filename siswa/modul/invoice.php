						<?php
						require_once '../template/db_connect.php';
						$idinv=$_POST['idinv'];
						$invoice = $connect->query("select * from invoice where nomor='$idinv'")->fetch_assoc();
						$query = $connect->query("select * from pembayaran where id_invoice='$idinv'");
						?>
						<div class="notification-modal-header">
							<h3>Nomor Invoice : <?=$invoice['nomor'];?></h3>
							<p><?=$invoice['tanggal'];?></p>
						</div>
						<div class="notification-modal-details">
							<?php
							while($s=$query->fetch_assoc()) {								
							?>
							<div class="progress-card progress-card-red mb-15">
								<div class="progress-card-info">
									<div class="progress-info-text">
										<p><?=$s['deskripsi'];?></p>
									</div>
								</div>
								<div class="progress-card-amount"><?=rupiah($s['bayar']);?></div>
							</div>
							<?php } ?>
						</div>