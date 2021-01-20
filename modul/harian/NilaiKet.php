<?php 
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$kelas=$_GET['kelas'];
$peta=$_GET['peta'];
$mpid=$_GET['mp'];
$kd=$_GET['kd'];
$tema=$_GET['tema'];
$ab=substr($kelas, 0, 1);
$ada=0;
if($tapel_aktif==$tapel and $smt_aktif==$smt){
	$edit=true;
}else{
	$edit=false;
};
if($kd=="0"){
	echo "<div class='alert alert-info alert-dismissible'><h4><i class='icon fa fa-info'></i> Informasi</h4>Silahkan Pilih KD</div>";
}else{
$sql11="select * from kd where kelas='$ab' and mapel='$mpid' group by kd";
$query11 = $connect->query($sql11);
while($h=$query11->fetch_assoc()) {
    $kdn=$h['kd'];
    $ckkm1=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$mpid' and kd='$kdn' and jenis='1'")->num_rows;
    $ckkm2=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$mpid' and kd='$kdn' and jenis='2'")->num_rows;
    $ckkm3=$connect->query("select * from kkmku where kelas='$ab' and tapel='$tapel' and mapel='$mpid' and kd='$kdn' and jenis='3'")->num_rows;
    if($ckkm1>0){$ada=$ada;}else{$ada=$ada+1;};
    if($ckkm2>0){$ada=$ada;}else{$ada=$ada+1;};
    if($ckkm3>0){$ada=$ada;}else{$ada=$ada+1;};
};
if($ada>0){
	$boleh=false;
}else{
	$boleh=true;
};
    if($boleh==false){
		?>
		<div class="error-page">
			<div class="error-content text-center" style="margin-left: 0;">
				<h3><i class="fa fa-info-circle text-danger"></i> Kesalahan </h3>
				<p>Belum Mengisi KKM <?=$mpm['nama_mapel'];?> Kelas <?=$ab;?>, silahkan isi terlebih dahulu dan lengkapi KKM <?=$mpm['nama_mapel'];?> Kelas <?=$ab;?>.</p>
			</div>
		</div>
	<?php 
	}else{	
		?>

<div class="table-responsive">
<table class="table table-bordered table-hover">
							<thead>
							   <tr>
								<th>Nama Siswa</th>
										<th>Praktek</th>
										<th>Proyek</th>
										<th>Portofolio</th>
								</tr>
							</thead>
							<tbody>	
<?php 
$sql="select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
$query = $connect->query($sql);
while($s=$query->fetch_assoc()) {
	$idp=$s['peserta_didik_id'];
			$sql1 = "select * from nk where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='prak'";
			$nh = $connect->query($sql1);
			$m=$nh->fetch_assoc();
			if(empty($m['nilai'])){
				$nHar='';
			}else{
				$nHar=number_format($m['nilai'],0);
			};
			if($edit){
				$nh='
					<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveHarian(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$mpid.'\',\''.$kd.'\',\'prak\',\''.$tema.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
				';
			}else{
				$nh=$nHar;
			};
			$sql2 = "select * from nk where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='proy'";
			$nh1 = $connect->query($sql2);
			$m1=$nh1->fetch_assoc();
			if(empty($m1['nilai'])){
				$nHar1='';
			}else{
				$nHar1=number_format($m1['nilai'],0);
			};
			if($edit){
				$nh1='
					<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar1.'"  onBlur="saveHarian(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$mpid.'\',\''.$kd.'\',\'proy\',\''.$tema.'\')" onClick="highlightEdit(this);">'.$nHar1.'</span>
				';
			}else{
				$nh1=$nHar1;
			};
			$sql3 = "select * from nk where id_pd='$idp' and smt='$smt' and tapel='$tapel' and mapel='$mpid' and tema='$tema' and kd='$kd' and jns='port'";
			$nh2 = $connect->query($sql3);
			$m2=$nh2->fetch_assoc();
			if(empty($m2['nilai'])){
				$nHar2='';
			}else{
				$nHar2=number_format($m2['nilai'],0);
			};
			if($edit){
				$nh2='
					<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar2.'"  onBlur="saveHarian(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$mpid.'\',\''.$kd.'\',\'port\',\''.$tema.'\')" onClick="highlightEdit(this);">'.$nHar2.'</span>
				';
			}else{
				$nh2=$nHar2;
			};
?>
<tr>
	<td><?=$s['nama'];?></td>
	<td><?=$nh;?></td>
	<td><?=$nh1;?></td>
	<td><?=$nh2;?></td>
</tr>
<?php
};
?>
															
							</tbody>
						</table>
						</div>
<?php };};?>