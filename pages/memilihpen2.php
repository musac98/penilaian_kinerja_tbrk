<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-hand-point-right"></i> Memilih Penilai</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['id'];
			$sql = "SELECT a.*, b.id_penilai_detail, b.id_kar as 'id_kar_penilai', c.nama as 'dinilai', d.nama as 'penilai', e.jabatan, e.level 
                FROM penilai a 
                JOIN penilai_detail b ON a.id_penilai = b.id_penilai  
                JOIN karyawan c ON a.id_kar = c.id_kar 
                JOIN karyawan d ON b.id_kar = d.id_kar 
                JOIN jabatan e ON d.id_jabatan = e.id_jabatan 
                WHERE a.id_penilai = $id ORDER BY a.id_kar, e.level ASC";
			$q = mysqli_query($con, $sql);
			$gr = 1;
            $sw = 1;
            while($row = mysqli_fetch_array($q)){
                $sup_penilai = $row['penilai'];
                $id_sup_penilai = $row['id_kar_penilai'];
                if($row['level']==4){
                    if($id_sup_penilai != $row['id_kar_dinilai']){
                        ${"karyawan_dinilai_$gr"} = $row['dinilai'];
                        ${"id_karyawan_dinilai_$gr"} = $row['id_penilai'];
                        $gr++;
                    }
                }
            }
		}
	}

?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= ucfirst($ket); ?> Penilai</h6>
                <?php
                if(!isset($_GET['ket'])){
                ?>
                <div class="dropdown no-arrow">
                    <a href="index.php?p=memilihpen&ket=tambah" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tambah Data"><i class="fa fa-plus"></i></a>
                </div>
            	<?php } ?>
            </div>
            <div class="card-body">
            <?php
            	if(!isset($form)):
            ?>
                <pre>
                <?php
                    $idper = get_tahun_ajar_id();
                    $sql = "SELECT a.*, b.id_penilai_detail, b.id_kar as 'id_kar_dinilai', c.nama as 'penilai', d.nama as 'dinilai', e.jabatan, e.level 
                FROM penilai a 
                JOIN penilai_detail b ON a.id_penilai = b.id_penilai  
                JOIN karyawan c ON a.id_kar = c.id_kar 
                JOIN karyawan d ON b.id_kar = d.id_kar 
                JOIN jabatan e ON d.id_jabatan = e.id_jabatan 
                WHERE a.id_penilai = $idper ORDER BY a.id_kar, e.level ASC";
                    $q = mysqli_query($con, $sql);
                    $tmp = [];
                    $data = [];
                    if(mysqli_num_rows($q)>0){
                        while($row = mysqli_fetch_array($q)){
                            $tmp[] = $row;
                        }
                        foreach ($tmp as $k => $v) {
                            if($v['id_kar']==$v['id_kar_dinilai']){
                                $idp = $v['id_penilai'];
                                $data[] = array(
                                                'id_penilai' => $v['id_penilai'],
                                                'id_kar' => $v['id_kar'],
                                                'id_periode' => $v['id_periode'],
                                                'penilai' => $v['penilai'],
                                                'data' => []
                                                );
                            } 
                        }

                        foreach ($data as $k => $v) {
                            foreach ($tmp as $a => $b) {
                                if($v['id_penilai']==$b['id_penilai']){
                                    $data[$k]['data'][] = array(
                                                                'id_penilai_detail' => $b['id_penilai_detail'],
                                                                'id_kar_dinilai' => $b['id_kar_dinilai'],
                                                                'dinilai' => $b['dinilai'],
                                                                'jabatan' => $b['jabatan'],
                                                                );
                                }
                            }
                        }

                    }
                    //print_r($data);
                ?>
                </pre>
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Karyawan Dinilai</th>
                            <th>Penilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        foreach ($data as $k => $v) {
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $v['penilai']; ?></td>
                            <td>
                                <?php
                                    foreach ($v['data'] as $a => $b) {
                                        if($v['nip']!=$b['nip_dinilai']){
                                            $pen = $b['jabatan'];
                                        }else{
                                            $pen = "Diri Sendiri";
                                        }
                                        echo "$b[dinilai] ($pen)<br>";
                                    }
                                ?>
                            </td>
                            <td rowspan="<?= $rs; ?>">
                                <a href="index.php?p=memilihpen&ket=ubah&id=<?= $v['id_penilai'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $v['id_penilai'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            	<?php else: ?>
            	<form method="post" action="models/p_memilihpen.php">
                    
                    <input type="hidden" required  name="id_penilai" value="<?= isset($id_penilai)?$id_penilai:''; ?>">

            		<div class="form-group row">
                        <label for="guru_dinilai" class="col-sm-2 col-form-label">Guru Dinilai</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <input type="text" required  class="form-control" id="guru_dinilai" name="guru_dinilai" placeholder="Guru Dinilai" value="<?= isset($guru_dinilai)?$guru_dinilai:'';?>" aria-label="Guru Dinilai" aria-describedby="btn-adn-1">
                                <input type="hidden" required  name="id_guru_dinilai" id="id_guru_dinilai" value="<?= isset($id_guru_dinilai)?$id_guru_dinilai:'';?>" >
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-cari" data-id="1" data-ref="id_guru_dinilai" type="button" id="btn-adn-1" data-toggle="tooltip" data-placement="top" title="Cari"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                        for($jm = 1; $jm <= get_jml_penilai_guru(); $jm++){
                    ?>
                        <div class="form-group row">
                            <label for="guru_penilai_<?= $jm; ?>" class="col-sm-2 col-form-label">Guru Penilai <?= $jm; ?></label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <input type="text" required  class="form-control" name="guru_penilai_<?= $jm; ?>" id="guru_penilai_<?= $jm; ?>" placeholder="Guru Penilai <?= $jm; ?>" value="<?= isset(${"guru_penilai_".$jm})?${"guru_penilai_".$jm}:''; ?>" aria-label="Guru Penilai <?= $jm; ?>" aria-describedby="btn-adn-2-<?= $jm; ?>" >
                                    <input type="hidden" required  name="id_guru_penilai_<?= $jm; ?>" id="id_guru_penilai_<?= $jm; ?>" value="<?= isset(${"id_guru_penilai_".$jm})?${"id_guru_penilai_".$jm}:'';?>" >
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary btn-cari" data-id="1" data-ref="id_guru_penilai_<?= $jm; ?>" type="button" id="btn-adn-2-<?= $jm; ?>" data-toggle="tooltip" data-placement="top" title="Cari"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    
                    <hr>

                    <?php
                        for($jm = 1; $jm <= get_jml_penilai_siswa(); $jm++){
                    ?>
                    <div class="form-group row">
                        <label for="siswa_penilai_<?= $jm; ?>" class="col-sm-2 col-form-label">Siswa Penilai <?= $jm; ?></label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <input type="text" required  class="form-control" name="siswa_penilai_<?= $jm; ?>" id="siswa_penilai_<?= $jm; ?>" placeholder="Siswa Penilai <?= $jm; ?>" value="<?= isset(${"siswa_penilai_".$jm})?${"siswa_penilai_".$jm}:''; ?>" aria-label="Siswa Penilai <?= $jm; ?>" aria-describedby="btn-adn-5-<?= $jm; ?>" >
                                <input type="hidden" required  name="id_siswa_penilai_<?= $jm; ?>" id="id_siswa_penilai_<?= $jm; ?>" value="<?= isset(${"id_siswa_penilai_".$jm})?${"id_siswa_penilai_".$jm}:'';?>" >
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-cari" data-id="2" data-ref="id_siswa_penilai_<?= $jm; ?>" type="button" id="btn-adn-5-<?= $jm; ?>" data-toggle="tooltip" data-placement="top" title="Cari"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        }
                    ?>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
                            <input type="submit" class="btn btn-primary" name="btnSimpan" value="<?= ucfirst($form); ?>">
                        </div>
                    </div>
				</form>
            	<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCari" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data User</h5>
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
        $(".btn-cari").click(function(){
            var id = $(this).attr("data-id");
            var ref = $(this).attr("data-ref");
            if(ref=='id_guru_dinilai'){
                $('#modalCari').modal('show');
                $(".load-modal").load('models/ajax_penilai.php?id='+id+"&ref="+ref);
            }else if (ref!='id_guru_dinilai' && id == 1){
                if($("#id_guru_dinilai").val() != ""){
                    var nip_d = $("#id_guru_dinilai").val();
                    var nip = "";
                    <?php
                        for($jm = 1; $jm <= get_jml_penilai_guru(); $jm++){
                            if($jm==1){
                                echo "nip += \$(\"#id_guru_penilai_$jm\").val();";
                            }else{
                                echo "nip += \"_\"+\$(\"#id_guru_penilai_$jm\").val();";
                            }
                        }
                    ?>
                    console.log(nip);
                    $('#modalCari').modal('show');
                    var link = 'models/ajax_penilai.php?id='+id+"&ref="+ref+"&d="+nip_d+"&nip="+nip;
                    $(".load-modal").load(link);
                }
            }else if (ref!='id_guru_dinilai' && id == 2){
                if($("#id_guru_dinilai").val() != ""){
                    var nip_a = [];
                    for(var i = 1; i <= <?= get_jml_penilai_siswa(); ?>; i++){
                        nip_a.push($("#id_siswa_penilai_"+i).val());
                    }
                    var nip = nip_a.join("_");
                    $('#modalCari').modal('show');
                    var link = 'models/ajax_penilai.php?id='+id+"&ref="+ref+"&nip="+nip;
                    $(".load-modal").load(link);
                }
            }
        });
        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_memilihpen.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });

    function pilih_penilai(ref, nip, nama){
        var ref_nama = ref.replace("id_", "");
        //console.log(ref_nama);
        $("#"+ref_nama).val(nama);
        $("#"+ref).val(nip);
        $('#modalCari').modal('hide');
    }
</script>