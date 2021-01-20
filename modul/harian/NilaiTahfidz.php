<?php 
require_once '../../function/db_connect.php';
$tapel=$_GET['tapel'];
$smt=$_GET['smt'];
$kelas=$_GET['kelas'];
$ab=substr($kelas,0,1);
$mpid=$_GET['mp'];
$surah=$_GET['surah'];
if($tapel_aktif==$tapel and $smt_aktif==$smt){
	$edit=true;
}else{
	$edit=false;
};
$mpm=$connect->query("select * from juzamma where id='$mpid'")->fetch_assoc();
if($surah==0){
	echo "<div class='alert alert-info alert-dismissible'><h4><i class='icon fa fa-info'></i> Informasi</h4>Silahkan Pilih Surah</div>";
}else{
?>
<div class="table-responsive no-padding">
		<table class="table table-bordered table-hover">
									<thead>
									   <tr>
										<th>Nama Siswa</th>
											<th>Nilai</th>
										</tr>
									</thead>
									<tbody>	
		<?php 
		$sql="select * from penempatan where rombel='$kelas' and tapel='$tapel' order by nama asc";
		$query = $connect->query($sql);
		while($s=$query->fetch_assoc()) {
			$idp=$s['peserta_didik_id'];
			if($mpid==1){
				$sql1 = "select * from tahfidz where id_pd='$idp' and smt='$smt' and tapel='$tapel' and surah='$surah'";
				$nh = $connect->query($sql1);
				$ada=$nh->num_rows;
				if($ada>0){
					$m=$nh->fetch_assoc();
					$nHar=$m['nilai'];
				}else{
					$nHar="";
				};
				if($edit){
					$nh='
						<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveJuzamma(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$surah.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
					';
				}else{
					$nh=$nHar;
				};
			};
			if($mpid==2){
				$sql1 = "select * from hadits_arbain where id_pd='$idp' and smt='$smt' and tapel='$tapel' and surah='$surah'";
				$nh = $connect->query($sql1);
				$ada=$nh->num_rows;
				if($ada>0){
					$m=$nh->fetch_assoc();
					$nHar=$m['nilai'];
				}else{
					$nHar="";
				};
				if($edit){
					$nh='
						<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveJuzamma(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$surah.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
					';
				}else{
					$nh=$nHar;
				};
			};
			if($mpid==3){
				$sql1 = "select * from surah_pilihan where id_pd='$idp' and smt='$smt' and tapel='$tapel' and surah='$surah'";
				$nh = $connect->query($sql1);
				$ada=$nh->num_rows;
				if($ada>0){
					$m=$nh->fetch_assoc();
					$nHar=$m['nilai'];
				}else{
					$nHar="";
				};
				if($edit){
					$nh='
						<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveJuzamma(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$surah.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
					';
				}else{
					$nh=$nHar;
				};
			};
			if($mpid==4){
				$sql1 = "select * from doa_harian where id_pd='$idp' and smt='$smt' and tapel='$tapel' and surah='$surah'";
				$nh = $connect->query($sql1);
				$ada=$nh->num_rows;
				if($ada>0){
					$m=$nh->fetch_assoc();
					$nHar=$m['nilai'];
				}else{
					$nHar="";
				};
				if($edit){
					$nh='
						<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveJuzamma(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$surah.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
					';
				}else{
					$nh=$nHar;
				};
			};
			if($mpid==5){
				$sql1 = "select * from hadits_pilihan where id_pd='$idp' and smt='$smt' and tapel='$tapel' and surah='$surah'";
				$nh = $connect->query($sql1);
				$ada=$nh->num_rows;
				if($ada>0){
					$m=$nh->fetch_assoc();
					$nHar=$m['nilai'];
				}else{
					$nHar="";
				};
				if($edit){
					$nh='
						<span class="input form-control form-control-sm" contenteditable="true" data-old_value="'.$nHar.'"  onBlur="saveJuzamma(this,\'nilai\',\''.$idp.'\',\''.$ab.'\',\''.$smt.'\',\''.$tapel.'\',\''.$surah.'\')" onClick="highlightEdit(this);">'.$nHar.'</span>
					';
				}else{
					$nh=$nHar;
				};
			};
		?>
		<tr>
			<td><?=$s['nama'];?></td>
			<td><?=$nh;?></td>
		</tr>
		<?php
		};
		?>
																	
									</tbody>
								</table>
								</div>

		
<?php 
};
?>