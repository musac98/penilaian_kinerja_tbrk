<?php
    require_once("../config/koneksi.php");
    if(isset($_GET['detail'])){
        $id = $_GET['detail'];
        $id_periode = $_GET['idp'];
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Penilaian Kinerja Guru 360 SMA GRACIA Surabaya">
    <meta name="author" content="Musa">
    <link rel="shortcut icon" href="../assets/img/logo.png">
    <title>TBRK Roastery | Penilaian Kinerja Karyawan</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">

    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <style>
        h4{font-size: 0.8rem}
        .cop>h4{font-size: 0.8rem}
        .cop>h3{font-size: 1.2rem}
        .cop>p{font-size: 0.7rem}
        .per{font-size: 0.7rem;color:#000; font-weight: bold;}
        .main{
            width: 100% !important;
            margin-top: 20px;
            padding: 0;
        }
        .cop{
            padding-bottom: 10px;
            text-align: center;
        }
        .cop>h4, .cop>h3, .cop>p{
            margin: 0;
            color:#000;
        }
        .row-cop{
            border-bottom: 2px;
            border-bottom-color: #000;
            border-bottom-style:groove;
        }
        .table{
            color:#000;
        }
        .table th, .table td{
            font-size: 0.7rem;
            padding: 0.5rem;
        }

        .table tr:last-child{
            border-bottom: 1px solid #e3e6f0;
        }

        .table thead th{
            border-bottom: 2px solid #000;
        }
        .table-bordered th, .table-bordered td{
            border: 1px solid #000;
            font-size: 0.7rem;
            padding: 0.5rem;
            margin: 0;
        }

        @page {
          size: 21cm 29.7cm;
          margin: 0;
        }
    </style>
</head>
<body>
    <div class="container main">
        <div class="row row-cop">
            <div class="col-1">
                <img src="../assets/img/logo.png" alt="Logo" width="100%">
            </div>
            <div class="col-sm cop">
                <h4>Laporan Penilaian Kinerja Periode <?= get_tahun_ajar(); ?></h4>
                <h3><strong>TBRK Roastery</strong></h3>
                <!-- <p>Jl. Gubeng Pojok No.15, Ketabang, Kec. Genteng, Kota Surabaya, Jawa Timur</p> -->
            </div>
            <div class="col-1">
            </div>
        </div>
        <br>
        <?php
            if(isset($_GET['idp'])){
                $id_periode = $_GET['idp'];
            }else{
                $id_periode = get_tahun_ajar_id();
            }
            $nama_periode = get_tahun_ajar($id_periode);

            
        ?>
        <p class="per">Periode : <?= $nama_periode; ?></p>
        
        
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
        <hr>
        <p class="per">Detail Penilaian</p>
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

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>    
</body>

</html>
