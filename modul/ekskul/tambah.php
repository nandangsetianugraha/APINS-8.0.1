<?php
include("../../function/db.php");
$smt=$_POST['smt'];
$tapel=$_POST['tapel'];
$idr=$_POST['rowid'];
$cek="SELECT * FROM siswa WHERE peserta_didik_id='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$bio=mysqli_fetch_array($hasil);
$ids=$bio['peserta_didik_id'];
?>
						<div class="modal-body">							<div class="form-group form-group-default">								<label>Nama</label>								<input type="text" name="nama" class="form-control" value="<?=$bio['nama'];?>">								<input type="hidden" name="idpd" class="form-control"  value="<?=$bio['peserta_didik_id'];?>">								<input type="hidden" name="smt" class="form-control"  value="<?=$smt;?>">								<input type="hidden" name="tapel" class="form-control"  value="<?=$tapel;?>">							</div>							<div class="form-group form-group-default">								<label>Kegiatan Ekstrakurikuler</label>								<select class="form-control" name="ide">								<?php 								$namaekskul=mysqli_query($koneksi, "SELECT * FROM ekskul order by id_ekskul asc");								while($mk=mysqli_fetch_array($namaekskul)){								?>								<option value="<?=$mk['id_ekskul'];?>"><?=$mk['nama_ekskul'];?></option>								<?php }; ?>								</select>							</div>							<div class="form-group form-group-default">								<label>Keterangan</label>								<textarea name="keterangan" class="form-control" aria-label="With textarea"></textarea>							</div>                        </div>                        <div class="modal-footer">                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>							<button type="submit" class="btn btn-danger waves-effect waves-light">Simpan</button>						</div>					
