<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-file-alt"></i> Presensi</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id_pres = $_GET['id'];
			$sql = "SELECT * FROM karyawan k JOIN presensi p ON k.id_kar = p.id_kar WHERE id_pres = $id_pres ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_pres = $row['id_pres'];
            $id_kar = $row['id_kar'];
            $jml_masuk = $row['jml_masuk'];
		}   
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Presensi</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
            	<?php } ?>
            </div>
            <div class="card-body">
            <?php
            	if(!isset($form)):
            ?>
            	<table class="table dataTable">
            		<thead>
            			<tr>
            				<th>No</th>
            				<th>Nama Karyawan</th>
            				<th>Jumlah Masuk</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
                        $idd = "SELECT * FROM karyawan WHERE nama = '{$_SESSION['name']}'";
                        $p = mysqli_query($con,$idd);
                        while ($row = mysqli_fetch_array($p)) {
                            $idtk = $row['id_toko'];
                        }
            			$sql = "SELECT *,
                                    k.id_kar AS idk FROM karyawan k 
                                JOIN jabatan j ON k.id_jabatan  = j.id_jabatan
                                LEFT JOIN presensi p ON k.id_kar = p.id_kar 
                                WHERE k.id_toko = $idtk AND j.level = 4";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
                            
                            $id_pres = $row['id_pres']==null?"kar_".$row['idk']:$row['id_pres']; 
                            $jml_masuk = $row['jml_masuk']==null?'0':$row['jml_masuk']; 
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $jml_masuk; ?></td>
            				<td>
                                <button type="button" class="btn btn-sm btn-secondary btn-detail" data-id="<?= $row['idk'] ?>" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-success btn-tambah" data-jml="<?= $jml_masuk ?>" data-id="<?= $id_pres ?>" data-toggle="tooltip" data-placement="top" title="Tambah">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <?php if(substr($id_pres, 0, 3) != "kar"): ?>
                                <a href="index.php?p=presensi&ket=ubah&id=<?= $id_pres ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <?php endif; ?>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_presensi.php">
                    <input type="hidden" name="id_pres" value="<?= isset($id_pres)?$id_pres:''; ?>">
                    <div class="form-group row">
                        <label for="karyawan" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_kar" id="id_kar">
                                <option value="">[Pilih Karyawan]</option>
                                <?php
                                    $sql = "SELECT * FROM karyawan";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($id_kar) && $id_kar==$row['id_kar']){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$row['id_toko'].'" '.$sel.'>'.$row['nama'].'</option>';
                                    }  
                                ?>
                            </select>
                        </div>
                    </div>
            		<div class="form-group row">
                        <label for="Jumlah Masuk" class="col-sm-2 col-form-label">Jumlah Masuk</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jml_masuk" id="jml_masuk" placeholder="Jumlah Masuk" value="<?= isset($jml_masuk)?$jml_masuk:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
                            <input type="submit" class="btn btn-primary" name="btnSimpan" value="<?= ucfirst($form); ?>">
                        </div>
                    </div>
				</form>
            	<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Presensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body load-modal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin ingin menambahkan kehadiran ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success btntambah-link" href="index.php">Tambah</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-detail").click(function(){
            var id = $(this).attr("data-id");
            $('#modalDetail').modal('show');
            $(".load-modal").load('models/ajax_presensi.php?id_pres='+id);
        });
    });
    $(document).ready(function(){
        $(".btn-tambah").click(function(){
            var id = $(this).attr("data-id");
            var jml = $(this).attr("data-jml");
            $('#modalTambah').modal('show');
            var url = "models/p_presensi.php?id_pres="+id+"&jml_masuk="+jml;
            console.log(url);
            $(".btntambah-link").attr("href", url);
        });
    });
</script>