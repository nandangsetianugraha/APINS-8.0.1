<?php
require_once '../../function/db.php';
$idr=$_POST['rowid'];
$cek="SELECT * FROM jenis_tunggakan WHERE id_tunggakan='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$utt=mysqli_fetch_array($hasil);
?>
						<div class="modal-body">							<input type="hidden" id="id_tema" name="idtema" class="form-control" value="<?php echo $idr;?>">							<div class="form-group form-group-default">								<label>Penerimaan</label>								<input id="namatema" type="text" name="namatema" autocomplete=off class="form-control" value="<?=$utt['nama_tunggakan'];?>" placeholder="Tema">							</div>						</div>