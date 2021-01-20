<?php
require_once '../../function/db.php';
$idr=$_POST['rowid'];
$cek="SELECT * FROM deskripsi_k13 WHERE id_raport='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$utt=mysqli_fetch_array($hasil);
$idsis=$utt['id_pd'];
$nsiswa=mysqli_fetch_array(mysqli_query($koneksi,"select * from siswa where peserta_didik_id='$idsis'"));
?>
						<div class="modal-body">
							<div class="form-group form-group-default">								<label>Nama Siswa</label>								<input type="hidden" name="idraport" class="form-control" value="<?php echo $utt['id_raport'];?>">								<input type="text" class="form-control" value="<?=$nsiswa['nama'];?>" name="nama">							</div>							<div class="form-group form-group-default">								<label>Deskripsi Raport</label>								<textarea name="deskripsi" class="form-control" rows="4" aria-label="With textarea"><?=$utt['deskripsi'];?></textarea>							</div>							
						</div>						<div class="modal-footer">                            <button type="button" class="btn btn-info btn-border btn-round btn-sm" data-dismiss="modal">Tutup</button>							<button type="submit" class="btn btn-info btn-border btn-round btn-sm">Simpan</button>						</div>