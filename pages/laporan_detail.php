<?php
if(isset($_GET['detail'])){
    $id = $_GET['detail'];
    $id_periode = $_GET['idp'];
    $id_kar = $_SESSION['user'];
    $sql = "SELECT *
            FROM penilai a
            JOIN toko b ON a.id_toko = b.id_toko
            JOIN penilai_detail c ON a.id_penilai = c.id_penilai
            WHERE a.id_penilai = $id AND a.id_periode = $id_periode ";
    $q = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($q);
    $karyawan = get_dinilai($con, $row['id_penilai']);
    $toko = $row['lokasi'];
    $id_penilai_detail = $row['id_penilai_detail'];
}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Detail</h6>
                <div class="dropdown no-arrow">
                    <a href="pages/pdf.php?detail=<?= $id; ?>&idp=<?= $id_periode; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Export PDF"><i class="fa fa-file-pdf"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="10%">Karyawan</th>
                        <td width="1%">:</td>
                        <td><?= $karyawan; ?></td>
                    </tr>   
                    <tr>
                        <th>Toko</th>
                        <td>:</td>
                        <td><?= $toko; ?></td>
                    </tr> 
                    <tr>
                        <th>Periode</th>
                        <td>:</td>
                        <td><?= get_tahun_ajar($id_periode); ?></td>
                    </tr>      
                </table>
            </div>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penilaian</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kriteria</th>
                            <th>Sub Kriteria</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 0;

                        $sql = "SELECT * FROM penilai_detail a JOIN penilai b ON a.id_penilai = b.id_penilai
                                JOIN karyawan c ON a.id_kar = c.id_kar
                                JOIN jabatan d ON c.id_jabatan = d.id_jabatan
                                JOIN toko e ON b.id_toko = e.id_toko
                                WHERE b.id_penilai = $id
                                ORDER BY e.id_toko, c.nama
                                 ";  

                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                            $sql2 = "SELECT
                                *
                                FROM penilaian a
                                JOIN data_penilaian_kinerja c ON a.id_kriteria = c.id_kriteria
                                WHERE a.id_penilai_detail = $row[id_penilai_detail] ";
                            $q2 = mysqli_query($con, $sql2);
                            $nr = mysqli_num_rows($q2);
                    ?>
                        <tr>
                            <td rowspan="<?= $nr; ?>" ><?= ++$i; ?></td>
                            <td rowspan="<?= $nr; ?>" ><?= $row['nama']; ?></td>
                            <td rowspan="<?= $nr; ?>" ><?= $row['jabatan']; ?></td>
                        <?php $j = 0; while($row2 = mysqli_fetch_array($q2)): ?>
                            <?php if($j!=0): ?>
                                <tr>
                            
                            <?php endif; ?>
                                <td><?= $row2['kriteria']; ?></td>
                                <td><?= $row2['sub_kriteria']; ?></td>
                                <td><?= $row2['bobot']; ?></td>
                            </tr>
                        <?php $j++; endwhile; ?>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>