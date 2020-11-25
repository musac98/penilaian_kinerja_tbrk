<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-file"></i> Data Penilaian Kinerja </h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT * FROM data_penilaian_kinerja WHERE id_kriteria = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_kriteria = $row['id_kriteria'];
            $kriteria = $row['kriteria'];
            $sub_kriteria = $row['sub_kriteria'];
            $bobot = $row['bobot'];
		}
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Jenis Kompetensi</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=jenis_kompetensi&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
                </div>
            	<?php } ?>
            </div>
            <div class="card-body">
            <?php
            	if(!isset($form)):
            ?>
            	<table class="table dataTable">
            		<thead>
            			<tr>
            				<th width="5%">No</th>
            				<th width="10%">Kriteria</th>
            				<th width="40%">Sub Kriteria</th>
                            <th width="10%">Bobot</th>
            				<th width="10%">Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT * FROM data_penilaian_kinerja";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
            				<td><?= $row['kriteria']; ?></td>
            				<td><?= $row['sub_kriteria']; ?></td>
                            <td><?= $row['bobot']; ?> %</td>
            				<td>
            					<a href="index.php?p=jenis_kompetensi&ket=ubah&id=<?= $row['id_kriteria'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_kriteria'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
            				</td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_jenis_kompetensi.php">
            		<input type="hidden" name="id_kriteria" value="<?= isset($id_kriteria)?$id_kriteria:''; ?>">
				  	<div class="form-group row">
                        <label for="kriteria" class="col-sm-2 col-form-label">Kriteria</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kriteria" id="kriteria" placeholder="Nama Kriteria" value="<?= isset($kriteria)?$kriteria:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sub_kriteria" class="col-sm-2 col-form-label">Sub Kriteria</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="sub_kriteria" id="sub_kriteria" placeholder="Sub Kriteria" value="<?= isset($sub_kriteria)?$sub_kriteria:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bobot" class="col-sm-2 col-form-label">Bobot Kriteria</label>
                        <div class="col-sm-10">
                            <input type="number" min="0" max="100" class="form-control" name="bobot" id="bobot" placeholder="Bobot Kriteria" value="<?= isset($bobot)?$bobot:''; ?>" >
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

<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success btnhapus-link" href="login.html">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_jenis_kompetensi.php?id="+id);
        });
    });
</script>