<?php
    require_once("../config/koneksi.php");
    if(isset($_GET['detail'])){
        $id = $_GET['detail'];
        $sql = "SELECT a.id_penilai, a.nip, b.nama_guru, c.jabatan FROM penilai a JOIN user b ON a.nip = b.nip JOIN jenis_user c ON b.id_jenis_user = c.id_jenis_user 
        WHERE a.nip = $id";
        $q = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($q);
        $nip = $row['nip'];
        $nama_guru = $row['nama_guru'];
        $jabatan = $row['jabatan'];
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
    <title>SMA GRACIA | Cetak Laporan Penilaian Kinerja Guru 360</title>

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
            padding: 0.15rem;
        }

        .table tr:last-child{
            border-bottom: 1px solid #e3e6f0;
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
                <h4>Laporan Penilaian Kinerja Guru Tahun Ajar <?= get_tahun_ajar(); ?></h4>
                <h3><strong>SMA GRACIA Surabaya</strong></h3>
                <p>Jl. Gubeng Pojok No.15, Ketabang, Kec. Genteng, Kota Surabaya, Jawa Timur</p>
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
        <hr>
        <p class="per">Detail Penilaian</p>
        
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
                            echo "<td class='text-right'>".number_format($row[$nm],2)."</td>";
                        }
                    ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
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
