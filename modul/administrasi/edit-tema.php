<?php
require_once '../../function/db.php';
$idr=$_POST['rowid'];
$cek="SELECT * FROM tema WHERE id_tema='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$utt=mysqli_fetch_array($hasil);
?>
						<div class="modal-body">							<div class="form-group form-group-default">								<label>Tema</label>								<input type="hidden" id="id_tema" name="idtema" class="form-control" value="<?php echo $idr;?>">								<input id="notema" type="text" name="notema" autocomplete=off class="form-control" value="<?=$utt['tema'];?>" placeholder="Tema">							</div>							<div class="form-group form-group-default">								<label>Tema</label>								<input id="namatema" type="text" name="namatema" autocomplete=off class="form-control" value="<?=$utt['nama_tema'];?>" placeholder="Tema">							</div>						</div>