		<form action="?page=pengeluaran&i=delete&kirim=1" method="post">
			<table align=center class=Login>
			<tr>
				<td colspan=2>Delete</td>
			</tr>
			<tr>
				<td>Atribut : </td>
				<td>
					<select name="atribut" id="atribut">
						<option value="Id">Id</option>
						<option value="Tanggal">Tanggal</option>
						<option value="Id_Barang">Id Barang</option>
						<option value="Jumlah">Jumlah</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nilai : </td><td><input type="text" name="nilai" id="nilai"></td>
			</tr>
			<tr>
				<td colspan=2><button class="button"> Hapus </button></td>
			</tr>
			</table>
			<?php
				include "include/koneksi.php";
				include "include/penjualan.php";
				
				if(@$_GET['id'] != ""){
					echo "<script>document.getElementById('nilai').value='".$_GET['id']."';</script>";
				}
				
				if(@$_GET["kirim"] == 1){
					if(@$_POST["atribut"] != "" && @$_POST["nilai"] != ""){
						$Koneksi = new Hubungi();
						$Koneksi->Konek("bolu_pisang");
								
						$atribut = $_POST["atribut"];
						$nilai = $_POST["nilai"];
						
						$query = "SELECT COUNT(*) FROM Pengeluaran WHERE $atribut = '$nilai' ";
						$exquery = mysql_query($query);
						if($exquery){
							$hasil = mysql_fetch_array($exquery);
							if($hasil[0] > 0){
								$query2 = "SELECT * FROM Pengeluaran WHERE $atribut = '$nilai' ";
								$exquery2 = mysql_query($query2);
								if($exquery2){
									$kueh = "DELETE FROM `Pengeluaran` WHERE $atribut = '$nilai' ";
									$exkueh = mysql_query($kueh);
									if($exkueh){
										while($hasil2 = mysql_fetch_array($exquery2)){
											$query3 = "SELECT COUNT(*) FROM Pengeluaran WHERE Id > ".$hasil2['Id'];
											$exquery3 = mysql_query($query3);
											if($exquery3){
												$hitung = mysql_fetch_array($exquery3);
												if($hitung[0] > 0){
													$query4 = "UPDATE Pengeluaran SET Id = (Id-1) WHERE Id > ".$hasil2['Id'];
													$exquery4 = mysql_query($query4);
													if($exquery4){
														echo "Anda telah berhasil menghapus data<br>";
													}
													else{
														echo "Anda tidak berhasil menghapus data<br>";
													}
												}
												else{
													echo "Anda telah berhasil menghapus data<br>";
												}
											}
										}
									}
									else{
										echo "Anda tidak berhasil menghapus data<br>";
									}
								}
								else{
									echo "Anda tidak berhasil menghapus data<br>";
								}
							}
							else{
								echo "Anda tidak berhasil menghapus data<br>";
							}
						}
						else{
							echo "Anda tidak berhasil menghapus data<br>";
						}
								
						mysql_close($Koneksi->getKonek());
					}
				}
			?>
		</form>
