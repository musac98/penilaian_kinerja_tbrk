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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Total Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $sql = "SELECT
                                   a.id_penilai,
                                   b.nip,
                                   b.nama_guru,
                                   a.id_periode
                                FROM penilai a
                                JOIN user b ON a.nip = b.nip
                                WHERE a.id_periode = $id_periode
                                GROUP BY b.nip
                                ";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                            $tot = get_tot_nilai($con, $row['nip'], $id_periode);
                            $nip = $row['nip'];
                            $nama_guru = $row['nama_guru'];
                            if($tot=='-'){
                                $nip = '<a href="index.php?p=notification_all">'.$nip.'</a>';
                                $nama_guru = '<a href="index.php?p=notification_all">'.$nama_guru.'</a>';
                            }
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $nip; ?></td>
                            <td><?= $nama_guru; ?></td>
                            <td><?= $tot; ?></td>
                            <td>
                                <a href="index.php?p=laporan&detail=<?= $row['nip'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                                <a href="pages/pdf.php?detail=<?= $row['nip'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Export Pdf"><i class="fa fa-file-pdf"></i></a>
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