<?php
if(isset($_GET['detail'])){
    $id = $_GET['detail'];
    $id_periode = $_GET['idp'];
    $sql = "SELECT a.id_penilai, a.nip, b.nama_guru, c.jabatan FROM penilai a JOIN user b ON a.nip = b.nip JOIN jenis_user c ON b.id_jenis_user = c.id_jenis_user 
    WHERE a.nip = $id";
    $q = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($q);
    $nip = $row['nip'];
    $nama_guru = $row['nama_guru'];
    $jabatan = $row['jabatan'];
}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Detail</h6>
                <div class="dropdown no-arrow">
                    <a href="pages/pdf.php?detail=<?= $nip; ?>&idp=<?= $id_periode; ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Export PDF"><i class="fa fa-file-pdf"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th width="10%">NIP</th>
                        <td width="1%">:</td>
                        <td><?= $nip; ?></td>

                        <input type="hidden" name="nip" value="<?= $nip; ?>">
                    </tr>      
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td><?= $nama_guru; ?></td>
                    </tr>   
                    <tr>
                        <th>Jabatan</th>
                        <td>:</td>
                        <td><?= $jabatan; ?></td>
                    </tr>      
                </table>
            </div>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Penilaian</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <?php
                            $sumif = "";
                            $sql = "SELECT * FROM jenis_kompetensi";
                            $q = mysqli_query($con, $sql);
                            $nr = mysqli_num_rows($q);
                            
                        ?>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">NIP</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Jabatan</th>
                            <th colspan="<?= $nr; ?>" class="text-center">Kompetensi</th>
                        </tr>
                        <tr>
                        <?php
                            $i = 0;
                            $komp = [];
                            while($row = mysqli_fetch_array($q)){
                                echo "<th class='text-center'>$row[nama_kompetensi]</th>";
                                $komp[] = $row;
                                $tbh = ($i==0)?'':", ";
                                $sumif .= $tbh."SUM(IF(d.id_kompetensi = $row[id_kompetensi], a.hasil_nilai, 0)) AS '$row[nama_kompetensi]' ";
                                $i++;
                            }
                        ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 0;
                        $sql = "SELECT
                                    c.nip AS 'dinilai',
                                    b.nip,
                                    e.nama_guru,
                                    f.jabatan,
                                    $sumif
                                FROM penilai_detail b
                                JOIN penilai c ON b.id_penilai = c.id_penilai
                                JOIN user e ON b.nip = e.nip
                                JOIN jenis_user f ON e.id_jenis_user = f.id_jenis_user
                                JOIN penilaian a ON a.id_penilai_detail = b.id_penilai_detail
                                JOIN isi_kompetensi d ON a.id_isi = d.id_isi
                                WHERE c.nip = '$nip' AND id_periode = $id_periode
                                GROUP BY c.nip, b.nip
                                ORDER BY f.level";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)):
                            $jbt = $row['dinilai'] == $row['nip']?"Diri Sendiri":$row['jabatan'];
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nip']; ?></td>
                            <td><?= $row['nama_guru']; ?></td>
                            <td><?= $jbt; ?></td>
                            <?php
                                foreach ($komp as $k => $v) {
                                    $nm = $v['nama_kompetensi'];
                                    echo "<td class='text-right'>".number_format($row[$nm], 2)."</td>";
                                }
                            ?>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>