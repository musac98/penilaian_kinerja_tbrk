<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-users"></i> Jenis User</h1>
</div>
<?php
    $ket = "Data";
    if(isset($_GET['ket'])){
        $ket = $_GET['ket'];
        $form = $ket;
        if($ket == "ubah"){
            $id = $_GET['id'];
            $sql = "SELECT * FROM jabatan WHERE id_jabatan = $id ";
            $q = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($q);
            $id_jabatan = $row['id_jabatan'];
            $jabatan = $row['jabatan'];
            $level = $row['level'];
        }
    }

?>
<div class="row row_angket">
    <div class="col mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Jabatan</h6>
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
                            <th>Jabatan</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT * FROM jabatan ORDER BY Level ASC";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['jabatan']; ?></td>
                            <td><?= $row['level']; ?></td>
                            <td>
                                <a href="index.php?p=jenis_user&ket=ubah&id=<?= $row['id_jabatan'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <form method="post" action="models/p_jenis_user.php">
                    <input type="hidden" name="id_jabatan" value="<?= isset($id_jabatan)?$id_jabatan:''; ?>">
                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?= isset($jabatan)?$jabatan:''; ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="level" id="level" placeholder="Level" value="<?= isset($level)?$level:''; ?>" >
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