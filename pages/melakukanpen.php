<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-check-square"></i> Penilaian</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		$id = $_GET['id'];
        $id_kar = $_SESSION['user'];
        $sql = "SELECT *
                FROM penilai a
                JOIN toko b ON a.id_toko = b.id_toko
                JOIN penilai_detail c ON a.id_penilai = c.id_penilai
                WHERE a.id_penilai = $id AND c.id_kar = '$id_kar' ";
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
                <?php
                if(!isset($_GET['ket'])){
                ?>
                    <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Guru yang Dinilai</h6>
                <?php }else{ ?>
                    <h6 class="m-0 font-weight-bold text-primary">Penilaian Kinerja</h6>
            	<?php } ?>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="assets/rubrik.pdf" target="blank" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Rubrik Penilaian"><i class="fa fa-file-pdf"></i></a>
                </div>
                <?php } ?>
            </div>
            <div class="card-body">
            <?php
            	if(!isset($form)):
            ?>
            	<table class="table dataTable">
            		<thead>
            			<tr>
            				<th>No</th>
                            <th>Toko</th>
            				<th>Karyawan Dinilai</th>
            				<th>Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		<?php


            			$i=0;
                        $ida = get_tahun_ajar_id();
                        $id_kar = $_SESSION['user'];
                        $sql = "SELECT *
                                FROM penilai a
                                JOIN toko b ON a.id_toko = b.id_toko
                                JOIN penilai_detail c ON a.id_penilai = c.id_penilai
                                WHERE a.id_periode = $ida AND c.id_kar = '$id_kar' ";
            			$q = mysqli_query($con, $sql);
            			while($row = mysqli_fetch_array($q)):
            		?>
            			<tr id="<?= $row['id_penilai']; ?>" class="tr-bold">
            				<td><?= ++$i; ?></td>
                            <td><?= $row['lokasi']; ?></td>
                            <td><?= get_dinilai($con, $row['id_penilai']); ?></td>
            				<td>
                                <a href="index.php?p=melakukanpen&ket=tambah&id=<?= $row['id_penilai'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Nilai"><i class="fa fa-pencil-alt"></i></a>
                            </td>
            			</tr>
            		<?php endwhile; ?>
            		</tbody>
            	</table>
                <script type="text/javascript">
                    $(document).ready(function(){
                        <?php
                            $nip_user = $_SESSION['user'];
                            $sql = "SELECT c.id_penilai FROM penilaian a
                                    JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
                                    JOIN penilai c ON b.id_penilai = c.id_penilai
                                    WHERE b.id_kar = '$nip_user' AND c.id_periode = $ida
                                    GROUP BY c.id_penilai
                                    ";
                            
                                        $q = mysqli_query($con, $sql);
                            while($row = mysqli_fetch_array($q)){
                                echo "\$('#$row[id_penilai]').removeClass('tr-bold');";
                            }
                        ?>
                    });
                </script>
            	<?php else: ?>
            	<form method="post" id="form_menilai" action="models/p_melakukanpen.php">
                    <input type="hidden" name="id_penilai_detail" value="<?= $id_penilai_detail; ?>">
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
                            <td><?= get_tahun_ajar(); ?></td>
                        </tr>      
                    </table>
                    <?php
                        
                        $sql = "SELECT * FROM kriteria";
                        $q = mysqli_query($con, $sql);
                    ?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php
                            $i = 0;
                            $data_kompetensi = [];
                            while($row = mysqli_fetch_array($q)):
                                $data_kompetensi[$i]['id_kriteria'] = $row['id_kriteria'];
                                $data_kompetensi[$i]['nama_kriteria'] = $row['nama_kriteria'];
                        ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?= $i==0?'active':''?>" id="kom_<?= $row['id_kriteria']; ?>-tab" data-toggle="tab" href="#kom_<?= $row['id_kriteria']; ?>" role="tab" aria-controls="<?= $row['nama_kriteria']; ?>" aria-selected="true">
                                <?= $row['nama_kriteria']; ?>
                            </a>
                        </li>
                        <?php $i++; endwhile; ?>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <?php
                            foreach ($data_kompetensi as $k => $v):
                        ?>
                        <div class="tab-pane fade <?= $k==0?"show active":''; ?>" id="kom_<?= $v['id_kriteria'];?>" role="tabpanel" aria-labelledby="<?= $v['nama_kriteria'];?>-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Isi Kompetensi</th>
                                        <th colspan="4">Nilai</th>
                                    </tr>
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    $kriteria = $v['id_kriteria'];
                                    $sql = "SELECT * FROM data_penilaian_kinerja WHERE id_kriteria = '$kriteria' ";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)):
                                ?>
                                    <tr>
                                        <td><?= ++$i; ?></td>
                                        <td><?= $row['sub_kriteria']; ?></td>
                                        <td><input class="rb_nilai" type="radio" id="isi_kompetensi_<?= $row['id_sub_kriteria'];?>_1" name="isi_kompetensi_<?= $row['id_sub_kriteria'];?>" value="1" required ></td>
                                        <td><input class="rb_nilai" type="radio" id="isi_kompetensi_<?= $row['id_sub_kriteria'];?>_2" name="isi_kompetensi_<?= $row['id_sub_kriteria'];?>" value="2" required ></td>
                                        <td><input class="rb_nilai" type="radio" id="isi_kompetensi_<?= $row['id_sub_kriteria'];?>_3" name="isi_kompetensi_<?= $row['id_sub_kriteria'];?>" value="3" required ></td>
                                        <td><input class="rb_nilai" type="radio" id="isi_kompetensi_<?= $row['id_sub_kriteria'];?>_4" name="isi_kompetensi_<?= $row['id_sub_kriteria'];?>" value="4" required ></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-primary" name="btnSimpan" value="<?= ucfirst($form); ?>">
                        </div>
                    </div>
				</form>
                <script type="text/javascript">
                    $(document).ready(function(){
                        <?php
                            $nip_user = $_SESSION['user'];
                            $id_periode = get_tahun_ajar_id();;

                            $sql = "SELECT 
                                        a.id_penilaian,
                                        a.id_sub_kriteria,
                                        a.hasil_nilai 
                                    FROM penilaian a
                                    JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
                                    JOIN penilai c ON b.id_penilai = c.id_penilai
                                    WHERE c.id_penilai = $id AND b.id_kar = '$nip_user'";
                            $q = mysqli_query($con, $sql);
                            while($row = mysqli_fetch_array($q)){
                                echo "\$('#isi_kompetensi_$row[id_sub_kriteria]_$row[hasil_nilai]').attr('checked', true);";
                            }   
                        ?>
                    });
                </script>   
            	<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body load-modal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anda yakin ingin menghapus data?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-success btnhapus-link" href="login.html">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".btn-detail").click(function(){
            var id = $(this).attr("data-id");
            $('#modalDetail').modal('show');
            $(".load-modal").load('models/ajax_user.php?nip='+id);
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_user.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
        var inv_id = 0;
        var valid_tab = [];


        $('input[type="submit"]').on('click', function() {
            console.log("before");
            inv_id = 0;
        });

        $("#form_menilai input").on("invalid", function(){
            var invalid_input = $(this).closest('.tab-pane').index();
            var all_tabs = $('.tab-pane');
            var tabs_id = all_tabs[invalid_input].id;
            var id = tabs_id.split("_")[1];
            if(inv_id==0){
                inv_id = id;
            }
            if(inv_id==id){
                $(".nav-link").each(function(){
                    $(this).removeClass('active');
                });
                $(".tab-pane").each(function(){
                    $(this).removeClass('active');
                    $(this).removeClass('show');
                });
                $("#kom_"+inv_id+"-tab").addClass("active");
                $("#kom_"+inv_id).addClass("active");
                $("#kom_"+inv_id).addClass("show");
                //inv_id=0;
                return true;
            }else{
                return false;
            }
        });

        function showTabWithInvalidInput(currentTab, invalidTab) {
            $('#'+currentTab).removeClass('active');
            $('#'+invalidTab).addClass('active');
            $('#'+invalidTab).addClass('show');
        }
    });
</script>