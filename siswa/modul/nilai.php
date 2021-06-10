							<?php 
							require_once '../template/db_connect.php';
							$idinv=$_POST['idinv'];
							$idku=$_POST['pdid'];
							$rombel=substr($_POST['kelas'],0);
							?>
							<div class="modal-header">
								<div class="modal-header-title">
									<i class="flaticon-invoice"></i> <?=$idinv;?>
									<form>
									<div class="form-group mb-15">
										<input type="hidden" id="rmb" value="<?=$rombel;?>">
										<input type="hidden" id="tapel" value="<?=$tapel_aktif;?>">
										<input type="hidden" id="smt" value="<?=$smt_aktif;?>">
										<input type="hidden" id="pdid" value="<?=$idku;?>">
										<select class="form-control" id="mapel">
											<?php 
											$sql = "select * from mapel order by id_mapel asc";
											$query = $connect->query($sql);
											while($s=$query->fetch_assoc()) {
												if($rombel<4 and ($s['id_mapel']==5 or $s['id_mapel']==6)){
												}else{
											?>
											<option value="<?=$s['id_mapel'];?>"><?=$s['nama_mapel'];?></option>
											<?php }} ?>
										</select>
									</div>
									</form>
								</div>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div id="transaksi"></div>
							</div>
							
							
							<script>
							$(document).ready(function() {
								var rombel = $('#rmb').val();
								var smt = $('#smt').val();
								var tapel = $('#tapel').val();
								var mapel = $('#mapel').val();
								viewTr();
								function viewTr(){
									$.get("modul/getnilai.php?jenis=<?=$idinv;?>&kelas=<?=$rombel?>"+"&smt="+smt+"&tapel="+tapel+"&mapel="+mapel+"&pdid=<?=$idku?>", function(data) {
										$("#transaksi").html(data);
									});
								};
								$('#mapel').change(function(){
									//Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
									var rombel = $('#rmb').val();
									var smt = $('#smt').val();
									var tapel = $('#tapel').val();
									var mapel = $('#mapel').val();
									viewTr();
									function viewTr(){
										$.get("modul/getnilai.php?jenis=<?=$idinv;?>&kelas=<?=$rombel?>"+"&smt="+smt+"&tapel="+tapel+"&mapel="+mapel+"&pdid=<?=$idku?>", function(data) {
											$("#transaksi").html(data);
										});
									};
								});
							});
							</script>