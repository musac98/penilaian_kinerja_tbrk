<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-cog"></i> Periode</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT * FROM periode WHERE id_periode = $id ";
			$q = mysqli_query($con, $sql);
			$row = mysqli_fetch_array($q);
			$id_periode = $row['id_periode'];
            $tahun = $row['tahun'];
            $bulan = $row['bulan'];
            $pekan = $row['pekan'];
            $status_periode = $row['status_periode'];
		}else if($ket == "aktif"){
            $id = $_GET['id'];
            $sql = "UPDATE periode SET status_periode = 0";
            $q = mysqli_query($con, $sql);
            if($q){
                $sql = "UPDATE periode SET status_periode = 1 WHERE id_periode = $id";
                $q = mysqli_query($con, $sql);
                if($q){
                    $_SESSION["flash"]["type"] = "success";
                    $_SESSION["flash"]["head"] = "Sukses";
                    $_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
                }else{
                    $_SESSION["flash"]["type"] = "danger";
                    $_SESSION["flash"]["head"] = "Terjadi Kesalahan";
                    $_SESSION["flash"]["msg"] = "Data gagal disimpan!";
                }

            }else{
                $_SESSION["flash"]["type"] = "danger";
                $_SESSION["flash"]["head"] = "Terjadi Kesalahan";
                $_SESSION["flash"]["msg"] = "Data gagal disimpan!";
            }
            echo "<script>document.location='index.php?p=periode';</script>";
            //header("location:index.php?p=periode");
            exit();
        }
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Periode</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=periode&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
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
            				<th>No</th>
            				<th>Tahun Ajar</th>
            				<th>Bulan</th>
                            <th>Pekan</th>
                            <th>Status</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php
            			$i=0;
            			$sql = "SELECT * FROM periode";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr>
            				<td><?= ++$i; ?></td>
                            <td><?= $row['tahun']; ?></td>
                            <td><?= $row['bulan']; ?></td>
                            <td><?= $row['pekan']; ?></td>
            				<td>
                                <?php 
                                    if($row['status_periode']==1){
                                        echo '<span class="badge badge-success">Aktif</span>';
                                    }else{
                                        echo '<span class="badge badge-danger">Tidak Aktif</span>';
                                    }
                                ?>
                            </td>
            				<td>
                                <a href="index.php?p=periode&ket=aktif&id=<?= $row['id_periode'] ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Set Aktif"><i class="fa fa-check"></i></a>
                                <a href="index.php?p=periode&ket=ubah&id=<?= $row['id_periode'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
            	<?php else: ?>
            	<form method="post" action="models/p_periode.php">
                    <input type="hidden" name="id_periode" value="<?= isset($id_periode)?$id_periode:''; ?>">
            		<div class="form-group row">
                        <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="tahun" id="tahun" placeholder="Tahun" value="<?= isset($tahun)?$tahun:''; ?>" >
                                
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="bulan" id="bulan" placeholder="Bulan" value="<?= isset($bulan)?$bulan:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pekan" class="col-sm-2 col-form-label">Pekan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pekan" id="pekan">
                                <option value="">[Pilih Pekan]</option>
                                <?php
                                    $sql = "SELECT * FROM periode GROUP BY pekan";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($id_periode) && $id_periode==$row['id_periode']){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$row['pekan'].'" '.$sel.'>'.$row['pekan'].'</option>';
                                    }  
                                ?>
                            </select>
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
            $(".load-modal").load('models/ajax_user.php?nip='+id);
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_periode.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });
</script>