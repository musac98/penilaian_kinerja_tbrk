<?php
    require_once("../config/koneksi.php");
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }


?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Keseluruhan</h6>
                <div class="dropdown no-arrow">
                    <a href="pages/pdf.php?idp=<?= $id_periode; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Export PDF"><i class="fa fa-file-pdf"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Total Nilai</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT *
                                FROM penilai a
                                JOIN toko b ON a.id_toko = b.id_toko
                                WHERE a.id_periode = $id_periode
                                ";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                            $pen = new Penilian($con, $row['id_penilai'], $id_periode);
                            $tot = $pen->get_tot_nilai();
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= get_dinilai($con, $row['id_penilai']); ?></td>
                            <td><?= $tot; ?></td>
                            <td><?= get_kategori_nilai($tot); ?></td>
                            <td>
                                <a href="index.php?p=laporan&detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                                <?php if($row['sts']!=0): ?>
                                <a href="pages/pdf.php?detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Export Pdf"><i class="fa fa-file-pdf"></i></a>
                                <?php else: ?>
                                <a href="index.php?p=laporan&acc=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Konfirmasi"><i class="fa fa-check"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>