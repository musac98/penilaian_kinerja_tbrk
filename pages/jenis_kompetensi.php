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
			$sql = "SELECT * FROM data_penilaian_kinerja a JOIN kriteria b ON a.id_kriteria = b.id_kriteria WHERE id_sub_kriteria = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_sub_kriteria = $row['id_sub_kriteria'];
            $id_kriteria = $row['id_kriteria'];
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
            				<th width="50%">Sub Kriteria</th>
            				<th width="10%">Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT * FROM data_penilaian_kinerja a JOIN kriteria b ON a.id_kriteria = b.id_kriteria ORDER BY a.id_kriteria";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
            				<td><?= $row['nama_kriteria']; ?></td>
            				<td><?= $row['sub_kriteria']; ?></td>
            				<td>
            					<a href="index.php?p=jenis_kompetensi&ket=ubah&id=<?= $row['id_sub_kriteria'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_sub_kriteria'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
            				</td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_jenis_kompetensi.php">
            		<input type="hidden" name="id_sub_kriteria" value="<?= isset($id_sub_kriteria)?$id_sub_kriteria:''; ?>">
				  	<div class="form-group row">
                        <label for="kriteria" class="col-sm-2 col-form-label">Kriteria</label>
                        <div class="col-sm-10">
                            <select name="id_kriteria" id="id_kriteria" class="form-control" >
                            <?php
                                $sql = "SELECT * FROM kriteria";
                                $q = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_array($q)){
                                    $sel = '';
                                    if(isset($kriteria) && $kriteria = $row['id_kriteria']){
                                        $sel = 'selected';
                                    }
                                    echo "<option value=\"$row[id_kriteria]\" $sel >$row[nama_kriteria]</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sub_kriteria" class="col-sm-2 col-form-label">Sub Kriteria</label>
                        <div class="col-sm-10">
                            <textarea name="sub_kriteria" id="sub_kriteria" rows="5" class="form-control" placeholder="Sub Kritria"><?= isset($sub_kriteria)?$sub_kriteria:''; ?></textarea>
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