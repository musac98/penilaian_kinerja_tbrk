<?php
    require_once("../config/koneksi.php");
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
            $data = [];
            $kategori = array_combine(get_kategori(), [0,0,0,0]);

            $tot = mysqli_num_rows($q);
            $j=0;
            while($row = mysqli_fetch_array($q)){
                $data[$j] = $row;
                $nilai = get_tot_nilai($con, $row['nip'], $id_periode);
                $data[$j]['nilai'] = $nilai;
                $txt_nilai = get_kategori_nilai($nilai);
                $data[$j]['txt_nilai'] = $txt_nilai;
                $kategori[$txt_nilai] += 1;
                $j++;
            }
            $rekap = "";
            $j=0;
            foreach ($kategori as $key => $v) {
                $persen = ($v/$tot) * 100;
                $rekap .= $j>0?' | ':' ';
                $rekap .= $key." = ".number_format($persen)."%";
                $j++;
            }

        ?>
        <p class="per">Periode : <?= $nama_periode; ?></p>
        <?php
        
        ?>
        <p class="per">Rekap :<?= $rekap; ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Total Nilai</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i=0;
                foreach ($data as $row):
                    
            ?>
                <tr>
                    <td><?= ++$i; ?></td>
                    <td><?= $row['nip']; ?></td>
                    <td><?= $row['nama_guru']; ?></td>
                    <td><?= $row['nilai']; ?></td>
                    <td><?= $row['txt_nilai']; ?></td>
                </tr>
            <?php
                endforeach;
            ?>
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
