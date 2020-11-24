<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<?php if($_SESSION['type']==0): ?>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
                            $sql = "SELECT * FROM karyawan";
                            $q = mysqli_query($con, $sql);
                            $nr = mysqli_num_rows($q);
                            echo $nr;
                        ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Kriteria</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
                            $sql = "SELECT * FROM data_penilaian_kinerja";
                            $q = mysqli_query($con, $sql);
                            $nr = mysqli_num_rows($q);
                            echo $nr;
                        ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php elseif($_SESSION['type']==2): ?>

    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/vendor/chart.js/chartjs-plugin-datalabels.js"></script>
    <script src="assets/vendor/chart.js/utils.js"></script>
    <div class="row">
        <div class="col mb-4">
            <div class="card shadow border-bottom-primary">
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group row" style="margin-bottom: 0;">
                            <label for="jabatan" class="col-sm-2 col-form-label">Periode</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="id_priode" id="cbid_priode">
                                    <!-- <option value="">Pilih Periode</option> -->
                                    <?php
                                        $id_periode = get_tahun_ajar_id();
                                        $sql = "SELECT * FROM periode";
                                        $q = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_array($q)){
                                            $val = get_tahun_ajar($row['id_periode']);
                                            if($row['status_periode'] == 1){
                                                echo "<option value='$row[id_periode]' selected style='font-weight:900;'>$val</option>";
                                            }else{
                                                echo "<option value='$row[id_periode]'>$val</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">5 Nilai Tertinggi</h6>
                </div>
                <div class="card-body cht_nilai_tinggi">
                    
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">5 Terendah Terendah</h6>
                </div>
                <div class="card-body cht_nilai_rendah">
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="assets/vendor/select2/select2.min.css">
    <script type="text/javascript" src="assets/vendor/select2/select2.min.js"></script>

    <div class="row">
        <div class="col mb-4">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Perperiode</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group row" style="margin-bottom: 0;">
                            <label for="jabatan" class="col-sm-2 col-form-label">Filter Guru</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="filter_nama_guru" id="filter_nama_guru">
                                    <option value="">[Pilih Guru]</option>
                                <?php
                                    $sql = "SELECT * FROM user WHERE id_jenis_user = 6";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        echo "<option value='$row[nip]'>$row[nama_guru]</option>";
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                     </form>
                     <hr>
                    <div class="cht_nilai_perperiode"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#filter_nama_guru').select2();
            $(".cht_nilai_tinggi").load('pages/chart/chart_nilai_tinggi.php');
            $(".cht_nilai_rendah").load('pages/chart/chart_nilai_rendah.php');
            $(".cht_nilai_perperiode").load('pages/chart/chart_nilai_perperiode.php');
            $("#cbid_priode").change(function(){
                var val = $(this).val();

                $(".cht_nilai_tinggi").load('pages/chart/chart_nilai_tinggi.php?idp='+val);
                $(".cht_nilai_rendah").load('pages/chart/chart_nilai_rendah.php?idp='+val);
            });
            $("#filter_nama_guru").change(function(){
                var val = $(this).val();
                $(".cht_nilai_perperiode").load('pages/chart/chart_nilai_guru.php?nip='+val);
            });
        });
    </script>
<?php elseif($_SESSION['type']==1): ?>
<div class="row">
        <div class="col mb-4">
            <div class="card shadow border-bottom-primary">
                <div class="card-body">
                    <form method="post" action="models/p_jenis_user.php">
                        <div class="form-group row" style="margin-bottom: 0;">
                            <label for="jabatan" class="col-sm-2 col-form-label">Periode</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="id_priode" id="cbid_priode">
                                    <!-- <option value="">Pilih Periode</option> -->
                                    <?php
                                        $id_periode = get_tahun_ajar_id();
                                        $sql = "SELECT * FROM periode";
                                        $q = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_array($q)){
                                            if($row['status_periode'] == 1){
                                                echo "<option value='$row[id_periode]' selected style='font-weight:900;'>$row[tahun_ajar] $row[semester]</option>";
                                            }else{
                                                echo "<option value='$row[id_periode]'>$row[tahun_ajar] $row[semester]</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                     </form>

                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-sm-6 mb-4">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Nilai Akhir</h6>
            </div>
            <div class="card-body cht_nilai_akhir" style="padding:20px 40px;">
                
            </div>
        </div>
    </div>

    <div class="col-sm-6 mb-4">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Nilai Perwakilan</h6>
            </div>
            <div class="card-body cht_nilai_perwakilan">
                <div id="myBarChart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col mb-4">
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Nilai Perkompetensi</h6>
            </div>
            <div class="card-body cht_nilai_perkompetensi">
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".cht_nilai_akhir").load('pages/chart/chart_nilai_akhir.php');
        $(".cht_nilai_perwakilan").load('pages/chart/chart_nilai_perwakilan.php');
        $(".cht_nilai_perkompetensi").load('pages/chart/chart_nilai_perkompetensi.php');
        $("#cbid_priode").change(function(){
            var val = $(this).val();
            $(".cht_nilai_akhir").load('pages/chart/chart_nilai_akhir.php?idp='+val);
            $(".cht_nilai_perwakilan").load('pages/chart/chart_nilai_perwakilan.php?idp='+val);
            $(".cht_nilai_perkompetensi").load('pages/chart/chart_nilai_perkompetensi.php?idp='+val);
        });
    });
</script>
<?php else: ?>
	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
        	<div class="card shadow mb-4">
        		<div class="card-body d-sm-flex">
        			<img src="assets/img/logo.png" alt="Logo" width="300px">
                	<div class="sidebar-brand-text" style="margin-left:100px;text-align:left;font-size: 2em;padding-top:70px">
	                	<strong>Penilaian Kinerja Guru</strong><br>
	                	<small>SMA Gracia Surabaya</small>
                	</div>
        		</div>
			</div>
		</div>
	</div>
<?php endif; ?>