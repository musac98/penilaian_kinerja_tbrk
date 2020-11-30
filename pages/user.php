<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-users"></i> Karyawan</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT * FROM karyawan WHERE id_kar = '$id' ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_kar = $row['id_kar'];
            $id_jabatan = $row['id_jabatan'];
            $id_toko = $row['id_toko'];
            $password = $row['password'];
            $nama = $row['nama'];
            $alamat = $row['alamat'];
            $no_telp = $row['no_telp'];
		}
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Karyawan</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=user&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
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
            				<th>Username</th>
            				<th>Nama</th>
            				<th>Jabatan</th>
                            <th>Alamat Toko</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT * FROM karyawan a 
                        JOIN jabatan b ON a.id_jabatan = b.id_jabatan
                        JOIN toko t ON a.id_toko = t.id_toko
                        WHERE b.id_jabatan between 2 AND 3";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr>
            				<td><?= $row['id_kar']; ?></td>
                            <td><?= $row['nama']; ?></td>
            				<td><?= $row['jabatan']; ?></td>
                            <td><?= $row['lokasi']; ?></td>
            				<td>
                                <button type="button" class="btn btn-sm btn-secondary btn-detail" data-id="<?= $row['id_kar'] ?>" data-toggle="tooltip" data-placement="top" title="Detail">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <a href="index.php?p=user&ket=ubah&id=<?= $row['id_kar'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_kar'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_user.php">
            		<div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id_kar" id="id_kar" placeholder="Username" <?= isset($id_kar)?"value='$id_kar' readonly":''; ?> >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_jabatan" id="id_jabatan">
                                <option value="">[Pilih Jabatan]</option>
                                <?php
                                    $sql = "SELECT * FROM jabatan WHERE id_jabatan between 2 AND 3";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($id_jabatan) && $id_jabatan==$row['id_jabatan']){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$row['id_jabatan'].'" '.$sel.'>'.$row['jabatan'].'</option>';
                                    }  
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasitoko" class="col-sm-2 col-form-label">Toko</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_toko" id="id_toko">
                                <option value="">[Pilih Toko]</option>
                                <?php
                                    $sql = "SELECT * FROM toko";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($id_toko) && $id_toko==$row['id_toko']){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$row['id_toko'].'" '.$sel.'>'.$row['lokasi'].'</option>';
                                    }  
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?= isset($password)?$password:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_guru" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?= isset($nama)?$nama:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" rows="5"><?= isset($alamat)?$alamat:''; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_telp" class="col-sm-2 col-form-label">No Telp</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No Telp" value="<?= isset($no_telp)?$no_telp:''; ?>" >
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
                <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
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
        $(".btn-detail").click(function(){
            var id = $(this).attr("data-id");
            $('#modalDetail').modal('show');
            $(".load-modal").load('models/ajax_user.php?id_kar='+id);
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_user.php?id_kar="+id);
        });
    });
</script>