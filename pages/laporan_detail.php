<?php
if(isset($_GET['detail'])){
    $id = $_GET['detail'];
    $id_periode = $_GET['idp'];
    $id_kar = $_SESSION['user'];
    $sql = "SELECT *
            FROM penilai a
            JOIN toko b ON a.id_toko = b.id_toko
            JOIN grup_dinilai d ON a.id_penilai = d.id_penilai
            JOIN penilai_detail c ON d.id_grup = c.id_grup
            JOIN karyawan e ON d.id_kar = e.id_kar
            WHERE c.id_grup = $id AND a.id_periode = $id_periode ";
    $q = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($q);
    $karyawan = $row['nama'];
    $toko = $row['lokasi'];
    $id_penilai_detail = $row['id_penilai_detail'];
    $id_penilai = $row['id_penilai'];
}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Detail</h6>
                <div class="dropdown no-arrow">
                    <a href="pages/pdf.php?detail=<?= $id; ?>&idp=<?= $id_periode; ?>" target="blank" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Export PDF"><i class="fa fa-file-pdf"></i></a>
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
                <?php
                        $i = 0;
                        $pen = new Penilian($con, $id_penilai, $id_periode);
                        $sql = "SELECT *,
                                f.id_kar AS 'dinilai'
                                FROM penilai_detail a 
                                JOIN grup_dinilai f ON f.id_grup = a.id_grup
                                JOIN penilai b ON f.id_penilai = b.id_penilai
                                JOIN karyawan c ON a.id_kar = c.id_kar
                                JOIN jabatan d ON c.id_jabatan = d.id_jabatan
                                JOIN toko e ON b.id_toko = e.id_toko
                                WHERE f.id_grup = $id
                                ORDER BY e.id_toko, a.id_kar";  
                        $q = mysqli_query($con, $sql);
                        $data = [];
                        $i = 0;
                        while($row = mysqli_fetch_array($q)){
                            $data[$i] = array(
                                            'id_penilai_detail' => $row['id_penilai_detail'], 
                                            'nama' => $row['nama'], 
                                            'jabatan' => $row['jabatan'], 
                                            );

                            $sql2 = "SELECT
                                *
                                FROM penilaian a
                                JOIN data_penilaian_kinerja c ON a.id_sub_kriteria = c.id_sub_kriteria
                                JOIN kriteria d ON c.id_kriteria = d.id_kriteria
                                WHERE a.id_penilai_detail = $row[id_penilai_detail] ";
                            $q2 = mysqli_query($con, $sql2);
                            $j = 0;
                            while($row2 = mysqli_fetch_array($q2)){
                                $data[$i]['nilai'][$row2['nama_kriteria']]['na'] = $pen->get_na_kriteria($row2['id_kriteria'], $row['id_kar'], $row['dinilai']);
                                $data[$i]['nilai'][$row2['nama_kriteria']]['detail'][] = array(
                                                                                                'sub_kriteria' => $row2['sub_kriteria'],
                                                                                                'hasil_nilai' => $row2['hasil_nilai'] 
                                                                                                );
                                $data[$i]['nr_utama'] = $j+1;
                                $j++;
                            }
                            $i++;
                        }
                    ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Kriteria</th>
                            <th>Sub Kriteria</th>
                            <th>Nilai</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $ret = '';
                    foreach ($data as $k => $v) {
                        $ret .=  '<tr>';

                        $ret .=  '<td rowspan="'.$v['nr_utama'].'" >'.($k+1).'</td>';
                        $ret .=  '<td rowspan="'.$v['nr_utama'].'" >'.$v['nama'].'</td>';
                        $ret .=  '<td rowspan="'.$v['nr_utama'].'" >'.$v['jabatan'].'</td>';

                        $j=0;
                        foreach ($v['nilai'] as $a => $b) {
                            if($j!=0){
                                $ret .=  '<tr>';
                            } 
                            $rs = sizeof($b['detail'])>1?'rowspan="'.sizeof($b['detail']).'"':'';
                            $ret .=  '<td '.$rs.' >'.$a.'</td>';
                            $k = 0;
                            foreach ($b['detail'] as $c => $d) {
                                if($k!=0){
                                    $ret .=  '<tr>';
                                }
                                $ret .=  '<td>'.$d['sub_kriteria'].'</td>';
                                $ret .=  '<td>'.$d['hasil_nilai'].'</td>';

                                if($k==0){
                                    $ret .=  '<td '.$rs.' >'.$b['na'].'</td>';
                                    $ret .=  '</tr>';
                                }else{
                                    $ret .=  '</tr>';
                                }
                                $k++;
                            }
                            $j++;
                        }
                    }
                    //echo htmlentities($ret);
                    echo $ret;
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Total</th>
                            <th><?= $pen->get_tot_nilai(); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>