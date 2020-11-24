<?php

require_once("../config/koneksi.php");

if(isset($_GET['id_pres'])){
	$id_pres = $_GET['id_pres'];
	$sql = "SELECT * FROM karyawan k JOIN presensi p ON k.id_kar = p.id_kar WHERE p.id_pres = '$id_pres'";
	$q = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($q);
?>
<table class="table">
	<tbody>
		<tr>
			<th>Nama Karyawan</th>
			<td>:</td>
			<td><?= $row['nama']; ?></td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td>:</td>
			<td><?= $row['alamat']; ?></td>
		</tr>
		<tr>
			<th>Nomor Telepon</th>
			<td>:</td>
			<td><?= $row['no_telp']; ?></td>
		</tr>
	</tbody>
</table>	
<?php
}

?>