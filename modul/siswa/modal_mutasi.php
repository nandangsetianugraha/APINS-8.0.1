<?php
include("../../../assets/db.php");
$idr=$_POST['rowid'];
$cek="SELECT * FROM siswa WHERE id='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$bio=mysqli_fetch_array($hasil);
$ids=$bio['peserta_didik_id'];$jns=$bio['status'];
?><div class="modal-body">	<div class="form-group form-group-default">		<label>Nama Siswa</label>		<input type="text" name="name" class="form-control" value="<?=$bio['nama'];?>">	</div>	<div class="form-group form-group-default">		<label>Status</label>		<input type="hidden" name="idptk" class="form-control" value="<?=$ids;?>">		<input type="hidden" name="idp" class="form-control" value="<?=$idr;?>">		<select class="form-control" name="status">			<?php 			$jcek="select * from jns_mutasi";			$hasilk=mysqli_query($koneksi,$jcek);			while($apk=mysqli_fetch_array($hasilk)){ ?>			<option value="<?=$apk['id_mutasi'];?>" <?php if($apk['id_mutasi']==$jns){echo "selected";}; ?>><?=$apk['nama_mutasi'];?></option>			<?php }; ?>		</select>	</div></div><div class="modal-footer">    <button type="button" class="btn btn-danger btn-border btn-round btn-sm" data-dismiss="modal">Tutup</button>    <button type="submit" class="btn btn-info btn-border btn-round btn-sm">Simpan</button></div>