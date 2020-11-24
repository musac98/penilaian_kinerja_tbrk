<?php

require_once("../config/koneksi.php");

if(isset($_GET['id'])):
	$id = $_GET['id'];
	$ref = $_GET['ref'];
	$sql_add = "WHERE b.level NOT IN (2,3)";
	if($id=="1"){
		$sql_add = "WHERE b.level = 1";
		if(isset($_GET['id_kar'])){
			$id_kar = $_GET['d'];
			$pen = explode("_", $_GET['id_kar']);
			$np = "$id_kar";
			foreach ($pen as $k => $v) {
				if($v!=""){
					$np .= ",$v";
				}
			}
			$sql_add .= " AND a.id_kar NOT IN($np)";
		}else{
			$idp = get_tahun_ajar_id();
			$sql = "SELECT * FROM penilai WHERE id_periode = $idp";
			$q = mysqli_query($con, $sql);
			if(mysqli_num_rows($q)>0){
				$id_kar = [];
				while($row = mysqli_fetch_array($q)){
					$id_kar[] = $row['id_kar'];
				}
				$np = "";
				foreach ($id_kar as $k => $v) {
					if($v!=""){
						if($k==0){
							$np .= "$v";
						}else{
							$np .= ",$v";
						}
					}
				}
				$sql_add .= " AND a.id_kar NOT IN($np)";
			}
		}
	}
	
	$sql = "SELECT * FROM karyawan a JOIN jabatan b ON a.id_jabatan = b.id_jabatan $sql_add";
	//echo $sql;
	$q = mysqli_query($con, $sql);
?>
<table class="table dttb">
	<thead>
		<tr>
			<th>Id Karyawan</th>
			<th>Nama</th>
			<th>Jabatan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$sql = "SELECT * FROM karyawan a JOIN jabatan b ON a.id_jabatan = b.id_jabatan WHERE b.level='4'";
		$q = mysqli_query($con, $sql);
		while($row = mysqli_fetch_array($q)):
	?>
		<tr>
			<td><?= $row['id_kar']; ?></td>
            <td><?= $row['nama']; ?></td>
			<td><?= $row['jabatan']; ?></td>
			<td>
                <button type="button" onclick="pilih_penilai('<?= $ref; ?>', '<?= $row["id_kar"]; ?>', '<?= $row["nama"]; ?>')" class="btn btn-sm btn-success btn-detail" data-toggle="tooltip" data-placement="top" title="Pilih">
                    <i class="fa fa-check"></i>
                </button>
            </td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>	
<?php
	endif;
?>
<script type="text/javascript">
    $(document).ready(function(){
        var table = $('.dttb').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
