

<?php if($_SESSION['type']==2 || $_SESSION['type']==1): ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
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
        <div class="col-sm-12 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Perkaryawan</h6>
                </div>
                <div class="card-body cht_nilai_karyawan"></div>
            </div>
        </div>
        <div class="col-sm-12 mb-4">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Pertoko</h6>
                </div>
                <div class="card-body cht_nilai_toko"></div>
            </div>
        </div>
        <div class="col-sm-12 mb-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Pertim</h6>
                </div>
                <div class="card-body cht_nilai_tim"></div>
            </div>
        </div>
    </div>

    

    <script type="text/javascript">
        $(document).ready(function(){
            //$('#filter_nama_guru').select2();
            $(".cht_nilai_karyawan").load('pages/chart/chart_nilai_tinggi.php');
            $(".cht_nilai_toko").load('pages/chart/chart_nilai_toko.php');
            $(".cht_nilai_tim").load('pages/chart/chart_nilai_tim.php');
            //$(".cht_nilai_perperiode").load('pages/chart/chart_nilai_perperiode.php');
            $("#cbid_priode").change(function(){
                var val = $(this).val();

                $(".cht_nilai_karyawan").load('pages/chart/chart_nilai_tinggi.php?idp='+val);
                $(".cht_nilai_toko").load('pages/chart/chart_nilai_toko.php?idp='+val);
                $(".cht_nilai_tim").load('pages/chart/chart_nilai_tim.php?idp='+val);
            });
            /*$("#filter_nama_guru").change(function(){
                var val = $(this).val();
                $(".cht_nilai_perperiode").load('pages/chart/chart_nilai_guru.php?nip='+val);
            });*/
        });
    </script>
<?php else: ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard
            <br>
            <?php $iddp = isset($_GET['idp'])?$_GET['idp']:''; ?>
            <small id="per_txt">Periode : <?= get_tahun_ajar($iddp); ?></small>
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tim</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                $idkar = $_SESSION['user'];
                                $id_periode = get_tahun_ajar_id();
                                $sql = "
                                    SELECT * FROM penilai a JOIN grup_dinilai b ON a.id_penilai = b.id_penilai
                                    WHERE b.id_kar = '$idkar' AND a.id_periode = $id_periode
                                ";
                                //echo $sql;
                                $q = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($q);
                                echo get_dinilai($con, $row['id_penilai']);
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
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nilai Tim</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                $sql = "
                                    SELECT * FROM penilai a JOIN grup_dinilai b ON a.id_penilai = b.id_penilai
                                    WHERE b.id_kar = '$idkar' AND a.id_periode = $id_periode
                                ";
                                $q = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($q);
                                $tot = "-"; 
                                $nil_id = "-"; 
                                if(mysqli_num_rows($q)>0){
                                    $pen = new Penilian($con, $row['id_penilai'], $id_periode);
                                    $tot = $pen->get_tot_nilai();
                                    $tot = $tot."<br>".get_kategori_nilai($tot);
                                    $nil_id = $pen->get_tot_nilai_individu($row['id_kar']);
                                    $nil_id = $nil_id."<br>".get_kategori_nilai($nil_id);
                                }
                                echo $tot;
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
         <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Nilai Individu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                                echo $nil_id;
                            ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

	<div class="row">
		<div class="col-xl-12 col-md-12 mb-4">
        	<div class="card shadow mb-4">
        		<div class="card-body d-sm-flex">
        			<img src="assets/img/logo.png" alt="Logo" width="300px">
                	<div class="sidebar-brand-text" style="margin-left:100px;text-align:left;font-size: 2em;padding-top:70px">
	                	<strong>Penilaian Kinerja</strong><br>
	                	<small>TBRK Roastery</small>
                	</div>
        		</div>
			</div>
		</div>
	</div>
<?php endif; ?>