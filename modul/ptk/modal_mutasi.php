<?php
include("../../function/db.php");
$idr=$_POST['rowid'];
$cek="SELECT * FROM ptk WHERE ptk_id='$idr'";
$hasil=mysqli_query($koneksi,$cek);
$bio=mysqli_fetch_array($hasil);
//$ids=$bio['ptk_id'];$jns=$bio['status_keaktifan_id'];
?><div class="modal-body">	<div class="form-group form-group-default">		<label>Nama PTK</label>		<input type="text" name="name" class="form-control" value="<?=$bio['nama'];?>">	</div>	<div class="form-group form-group-default">		<label>Status</label>		<input type="hidden" name="idptk" class="form-control" value="<?=$idr;?>">		<select class="form-control" name="status">			<?php 			$jcek="select * from jns_mutasi";			$hasilk=mysqli_query($koneksi,$jcek);			while($apk=mysqli_fetch_array($hasilk)){ ?>			<option value="<?=$apk['id_mutasi'];?>" <?php if($apk['id_mutasi']==$jns){echo "selected";}; ?>><?=$apk['nama_mutasi'];?></option>			<?php }; ?>		</select>	</div></div><div class="modal-footer">    <button type="button" class="btn btn-danger btn-border btn-sm" data-dismiss="modal">Tutup</button>    <button type="submit" class="btn btn-info btn-border btn-sm">Simpan</button></div>