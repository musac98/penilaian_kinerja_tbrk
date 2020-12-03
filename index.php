<?php
    require_once("config/koneksi.php");

    if(!isset($_SESSION['user']) && $_SESSION['user']==""){
        header("location:login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Penilaian Kinerja Karyawan TBRK Roastery">
    <meta name="author" content="Haidir">
    <link rel="shortcut icon" href="assets/img/logo.png">
    <title>TBRK Roastery | Penilaian Kinerja Karyawan</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="assets/vendor/jquery/jquery.min.js"></script>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #ffd430" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" style="color: black" href="index.php">
                <!-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> -->
                <img src="assets/img/logo.png" alt="Logo" width="50px">
                <div class="sidebar-brand-text mx-3" style="text-align:left;font-size: 0.8em;">Penilaian Kinerja</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item" id="home">
                <a class="nav-link" href="index.php" style="color: black">
                    <i class="fas fa-fw fa-tachometer-alt" style="color: black"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <?php if($_SESSION['type']==2):?>
            <!-- Heading -->
            <div class="sidebar-heading" style="color: black">
                Master
            </div>
            <li class="nav-item" id="jenis_user">
                <a class="nav-link" href="index.php?p=jenis_user" style="color: black">
                    <i class="fas fa-fw fa-users" style="color: black"></i>
                    <span>Jabatan</span>
                </a>
            </li>
            <li class="nav-item" id="user">
                <a class="nav-link" href="index.php?p=user" style="color: black">
                    <i class="fas fa-fw fa-user" style="color: black"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            <li class="nav-item" id="kriteria">
                <a class="nav-link" href="index.php?p=kriteria" style="color: black">
                    <i class="fas fa-fw fa-file" style="color: black"></i>
                    <span>Kriteria</span>
                </a>
            </li>
            <li class="nav-item" id="jenis_kompetensi">
                <a class="nav-link" href="index.php?p=jenis_kompetensi" style="color: black">
                    <i class="fas fa-fw fa-file" style="color: black"></i>
                    <span>Data Penilaian Kinerja</span>
                </a>
            </li>
            <li class="nav-item" id="jenis_kompetensi">
                <a class="nav-link" href="index.php?p=toko" style="color: black">
                    <i class="fas fa-fw fa-home" style="color: black"></i>
                    <span>Data Toko</span>
                </a>
            </li>
            <div class="sidebar-heading" style="color: black;">
                Penilaian
            </div>
            <li class="nav-item" id="memilihpen">
                <a class="nav-link" href="index.php?p=memilihpen" style="color: black">
                    <i class="fas fa-fw fa-check-square" style="color: black"></i>
                    <span>Memilih Penilai</span>
                </a>
            </li>
            <li class="nav-item" id="melakukanpen">
                <a class="nav-link" href="index.php?p=melakukanpen" style="color: black">
                    <i class="fas fa-fw fa-check-square" style="color: black"></i>
                    <span>Penilaian Kinerja</span>
                </a>
            </li>
            <li class="nav-item" id="laporan">
                <a class="nav-link" href="index.php?p=laporan" style="color: black">
                    <i class="fas fa-fw fa-file-pdf" style="color: black"></i>
                    <span>Laporan Penilaian Kinerja</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <?php endif; ?>
            <!-- Heading -->
            <?php if($_SESSION['type']!=2 && $_SESSION['type']!=4):?>
            <div class="sidebar-heading" style="color: black">
                Master
            </div>
            <?php if($_SESSION['type']==1):?>
            <li class="nav-item" id="jenis_kompetensi">
                <a class="nav-link" href="index.php?p=toko" style="color: black">
                    <i class="fas fa-fw fa-home" style="color: black"></i>
                    <span>Data Toko</span>
                </a>
            </li>
            <li class="nav-item" id="jenis_kompetensi">
                <a class="nav-link" href="index.php?p=jenis_kompetensi" style="color: black">
                    <i class="fas fa-fw fa-file" style="color: black"></i>
                    <span>Data Penilaian Kinerja</span>
                </a>
            </li>
            <li class="nav-item" id="user">
                <a class="nav-link" href="index.php?p=user" style="color: black">
                    <i class="fas fa-fw fa-user" style="color: black"></i>
                    <span>Karyawan</span>
                </a>
            </li>
            <li class="nav-item" id="kompetensi">
                <a class="nav-link" href="index.php?p=presensi" style="color: black">
                    <i class="fas fa-fw fa-file-alt" style="color: black"></i>
                    <span>Presensi</span>
                </a>
            </li>
            <li class="nav-item" id="periode">
                <a class="nav-link" href="index.php?p=periode" style="color: black">
                    <i class="fas fa-fw fa-cog" style="color: black"></i>
                    <span>Periode</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($_SESSION['type']!=4):?>
            <div class="sidebar-heading" style="color: black;">
                Penilaian
            </div>
            <?php endif; ?>

            <?php if($_SESSION['type']==1):?>
            <li class="nav-item" id="melakukanpen">
                <a class="nav-link" href="index.php?p=melakukanpen" style="color: black">
                    <i class="fas fa-fw fa-check-square" style="color: black"></i>
                    <span>Penilaian Kinerja</span>
                </a>
            </li>
            <li class="nav-item" id="laporan">
                <a class="nav-link" href="index.php?p=laporan" style="color: black">
                    <i class="fas fa-fw fa-file-pdf" style="color: black"></i>
                    <span>Laporan Penilaian Kinerja</span>
                </a>
            </li>
            <?php endif; ?>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <?php endif; ?>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-gradient-dark topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <!-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button> -->
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Alerts -->
                    
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-warning-600 small"><?= $_SESSION['name']; ?></span>
                            <?php if($_SESSION['type']==0): ?>
                            <img class="img-profile rounded-circle" src="assets/img/user.png">
                            <?php elseif($_SESSION['type']==1 || $_SESSION['type']==2 || $_SESSION['type']==3): ?>
                            <img class="img-profile rounded-circle" src="assets/img/teacher.png">
                            <?php elseif($_SESSION['type']==4): ?>
                            <img class="img-profile rounded-circle" src="assets/img/student.png">
                            <?php endif; ?>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="index.php?p=user&ket=ubah&id=<?= $_SESSION['user']; ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid main-content">
            <?php
                $dir = "pages";
                $pages = scandir($dir);
                unset($pages[0],$pages[1]);
                if(isset($_GET['p'])){
                    $p = $_GET['p'].".php";
                    if(in_array($p, $pages)){
                        include "$dir/$p";
                    }else{
                        include "$dir/404.php";
                    }
                }else{
                    include "$dir/home.php";
                }
            
                /*echo '<pre>';
                $sql = "SELECT * FROM data_penilaian_kinerja";
                $q = mysqli_query($con, $sql);
                $id_dpk = [];
                while($row = mysqli_fetch_array($q)){
                    $id_dpk[] = $row['id_sub_kriteria'];
                }

                $sql = "SELECT * FROM penilai_detail WHERE id_penilai_detail NOT IN (69, 70, 71, 72, 73, 74)";
                $q = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($q)){
                    foreach ($id_dpk as $k => $v) {
                        $ni = rand(1, 4);
                        $in = "INSERT INTO penilaian (id_penilai_detail, id_sub_kriteria, hasil_nilai) VALUES ($row[id_penilai_detail], $v, $ni) ";
                        echo "$in<br>";
                        mysqli_query($con, $in);
                    }
                }

                print_r($id_dpk);
                echo '</pre>';*/

                /*echo '<pre>';
                $sql = "SELECT * FROM data_penilaian_kinerja";
                $q = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($q)){
                    $nm = $row['kriteria'];
                    $sql2 = "SELECT * FROM kriteria WHERE nama_kriteria  = '$nm'";
                    $q2 = mysqli_query($con, $sql2);
                    while($row2 = mysqli_fetch_array($q2)){
                        $id = $row2['id_kriteria'];
                        $ids = $row['id_sub_kriteria'];
                        $update = "UPDATE data_penilaian_kinerja SET kriteria = $id WHERE id_sub_kriteria = $ids";
                        mysqli_query($con, $update);
                    }
                }
                echo '</pre>';*/
            ?>

            </div>
            <!-- /.container-fluid -->
          </div>
          <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php?logout=true">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php if(isset($_SESSION["flash"])){ ?>

    <div class="alert alert-<?= $_SESSION["flash"]["type"]; ?> alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION["flash"]["head"]; ?></strong><br><?= $_SESSION["flash"]["msg"]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['flash']); } ?>

    

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.js"></script>
    <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> 

    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('.dataTable').DataTable();
            $('[data-toggle="tooltip"]').tooltip();
            setTimeout(function(){
                $(".alert").hide(500);
            }, 3000);

            var url = document.URL;
            var segments = url.split('?');
            if(segments[1]!=undefined){
                var lk = segments[1].split('&');
                var id = lk[0].replace("p=", "");
                $("#"+id).addClass("active");
            }else{
                $("#home").addClass("active");
            }
        });
    </script>
    
</body>

</html>
