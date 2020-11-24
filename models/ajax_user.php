<?php

require_once("../config/koneksi.php");

if(isset($_GET['id_kar'])){
	$id_kar = $_GET['id_kar'];
	$sql = "SELECT * FROM karyawan a 
	JOIN jabatan b ON a.id_jabatan = b.id_jabatan 
	JOIN toko t ON a.id_toko = t.id_toko
	WHERE id_kar = '$id_kar'";
	$q = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($q);
?>
<table class="table">
	<tbody>
		<tr>
			<th>Username</th>
			<td width="1%" >:</td>
			<td><?= $row['id_kar']; ?></td>
		</tr>
		<tr>
			<th>Jabatan</th>
			<td>:</td>
			<td><?= $row['jabatan']; ?></td>
		</tr>
		<tr>
			<th>Lokasi Toko</th>
			<td>:</td>
			<td><?= $row['lokasi']; ?></td>
		</tr>
		<tr>
			<th>Password</th>
			<td>:</td>
			<td><?= $row['password']; ?></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td>:</td>
			<td><?= $row['nama']; ?></td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td>:</td>
			<td><?= $row['alamat']; ?></td>
		</tr>
		<tr>
			<th>No Telp</th>
			<td>:</td>
			<td><?= $row['no_telp']; ?></td>
		</tr>
	</tbody>
</table>	
<?php
}

?>