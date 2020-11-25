<!-- Page Heading -->

<style type="text/css">
                    
    .btn-box{
        display: flex;
        flex-direction: column;
        margin-top: 25px;
    }
    .btn-move{
        margin: 10px;
        text-align: center;
    }
</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-hand-point-right"></i> Memilih Penilai</h1>
</div>
<?php
	$ket = "Data";
	if(isset($_GET['ket'])){
		$ket = $_GET['ket'];
		$form = $ket;
		if($ket == "ubah"){
			$id = $_GET['idt'];
			$sql = "SELECT * FROM penilai
                WHERE id_toko = '$id' ";
			$q = mysqli_query($con, $sql);
            $id_penilai = [];
            while($row = mysqli_fetch_array($q)){
                $toko = $row['id_toko'];
                $sql2 = "SELECT * FROM penilai_detail a 
                        JOIN karyawan b ON a.id_kar = b.id_kar 
                        JOIN jabatan c ON b.id_jabatan = c.id_jabatan
                        WHERE c.level = 1 AND a.id_penilai = $row[id_penilai]";
                $q2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_array($q2);
                $id_kar = $row2['id_kar'];
                $id_penilai[] = array(
                                        "id_penilai" => $row['id_penilai'], 
                                        "id_penilai_detail" => $row2['id_penilai_detail'], 
                                        "grup" => $row['grup']
                                    );
            }
            //print_r($id_penilai);
		}
	}

    function gen_option($opt){
        $ret = '';
        foreach ($opt as $k => $v) {
            $ret .= "<option value=\"$v[id_kar]\">$v[nama]</option>";
        }
        return $ret;
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
                    $sql = "SELECT *
                            FROM penilai a
                            JOIN toko b ON a.id_toko = b.id_toko
                            WHERE a.id_periode = $idper";
                    $q = mysqli_query($con, $sql);

                    
                ?>
                </pre>
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Toko</th>
                            <th>Karyawan Dinilai</th>
                            <th>Penilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $j=1;
                        while($row = mysqli_fetch_array($q)){
                    ?>
                        <tr>
                            <?php
                                if($j%2!=0){
                            ?>
                            <td rowspan="2"><?= ++$i; ?></td>
                            <td rowspan="2"><?= $row['lokasi']; ?></td>
                            <td><?= get_dinilai($con, $row['id_penilai']); ?></td>
                            <td><?= get_penilai($con, $row['id_penilai']); ?></td>
                            <td rowspan="2">
                                <a href="index.php?p=memilihpen&ket=ubah&idt=<?= $row['id_toko'] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id_toko'] ?>" data-toggle="tooltip" data-placement="top" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            <?php
                                }else{
                            ?>
                            <td><?= get_dinilai($con, $row['id_penilai']); ?></td>
                            <td><?= get_penilai($con, $row['id_penilai']); ?></td>
                            <?php
                                }
                            ?>
                            
                        </tr>
                    <?php
                        $j++;
                        }
                    ?>
                    </tbody>
                </table>
            	<?php else: ?>
            	<form method="post" id="form_memilihpen" action="models/p_memilihpen.php">
            		<div class="form-group row">
                        <label for="toko" class="col-sm-2 col-form-label">Toko</label>
                        <div class="col-sm-10">
                            <select name="toko" id="toko" class="form-control" <?= isset($toko)?'readonly':''; ?> >
                                <option value="">Pilih Toko</option>
                                <?php
                                    $sql = "SELECT * FROM toko";
                                    $q = mysqli_query($con, $sql);
                                    
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($toko) && $toko==$row['id_toko']){
                                            $sel = 'selected';
                                        }
                                        echo "<option value=\"$row[id_toko]\" $sel >$row[lokasi]</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="load_karyawan">
                        <div class="form-group row">
                            <label for="guru_dinilai" class="col-sm-2 col-form-label">Karyawan Dinilai</label>
                            <?php
                                $group_1 = [];
                                $group_2 = [];
                                if(isset($id_penilai)){
                                    foreach ($id_penilai as $key => $value) {
                                        $i = $key+1;
                                        echo "<input type=\"hidden\" name=\"penilai_$i\" value=\"$value[id_penilai]\" >";
                                        echo "<input type=\"hidden\" name=\"penilai_detail_$i\" value=\"$value[id_penilai_detail]\" >";
                                        $g = $value['grup'];
                                        $sql = "SELECT * 
                                                FROM grup_dinilai a 
                                                JOIN karyawan b ON a.id_kar = b.id_kar 
                                                JOIN penilai c ON a.id_penilai = c.id_penilai
                                                WHERE a.id_penilai = $value[id_penilai] 
                                                AND c.grup = '$g'";
                                        $q = mysqli_query($con, $sql);
                                        while($row = mysqli_fetch_array($q)){
                                            ${"group_".$i}[] = array('id_kar' => $row['id_kar'], 'nama' => $row['nama']);
                                        }
                                    }
                                }
                            ?>
                            <div class="col-sm-4">
                                <label for="">Group 1</label>
                                <select name="group_1[]" id="group_1" class="form-control cb_kar" multiple>
                                    <?= gen_option($group_1); ?>
                                </select>
                            </div>
                            <div class="col-sm-2 btn-box" >
                                <button type="button" class="btn btn-success btn-move" id="btn-left"> > </button>
                                <button type="button" class="btn btn-success btn-move" id="btn-right"> < </button>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Group 2</label>
                                <select name="group_2[]" id="group_2" class="form-control cb_kar" multiple>
                                    <?= gen_option($group_2); ?>
                                </select>
                            </div>
                        </div>
                    </div>                    
                    <hr>
                    <div class="form-group row">
                        <label for="id_kar" class="col-sm-2 col-form-label">Supervisor Penilai</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_kar" id="id_kar" required>
                                <option value="">[Pilih Supervisor]</option>
                                <?php
                                    $sql = "SELECT * FROM karyawan a 
                                    JOIN jabatan b ON a.id_jabatan = b.id_jabatan 
                                    JOIN toko t ON a.id_toko = t.id_toko
                                    WHERE b.level='1'";
                                    $q = mysqli_query($con, $sql);
                                    while($row = mysqli_fetch_array($q)){
                                        $sel = '';
                                        if(isset($id_kar) && $id_kar==$row['id_kar']){
                                            $sel = 'selected';
                                        }
                                        echo '<option value="'.$row['id_kar'].'" '.$sel.'>'.$row['nama'].'</option>';
                                    }  
                                ?>
                            </select>
                        </div>
                    </div>                 
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
        
        $("#toko").change(function(){
            var val = $(this).val();
            if(val==""){
                $(".load_karyawan").html("");
            }else{
                $(".load_karyawan").load("models/ajax_user.php?id_toko="+val);
            }
        });

        $("#form_memilihpen").submit(function(e){
            $("#group_1>option").each(function(){
                $(this).prop("selected", true);
            });

            $("#group_2>option").each(function(){
                $(this).prop("selected", true);
            });
        });

        $(".btn-hapus").click(function(){
            var id = $(this).attr("data-id");
            $('#hapusModal').modal('show');
            $(".btnhapus-link").attr("href", "models/p_memilihpen.php?id="+id);
            //$(".load-modal").load('models/ajax_user.php?nip='+id);
        });
    });

    function pilih_penilai(ref, id_kar, nama){
        var ref_nama = ref.replace("id_kar", "");
        //console.log(ref_nama);
        $("#"+ref_nama).val(nama);
        $("#"+ref).val(id_kar);
        $('#modalCari').modal('hide');
    }


    $(".btn-move").click(function(){
        var id = $(this).attr("id");
        if(id=="btn-left"){
            btn_left();
        }else{
            btn_right();
        }
    });

    $("#group_1").dblclick(function(){
        btn_left();
    });
    
    $("#group_2").dblclick(function(){
        btn_right();
    });


    function btn_left() {
        var selected=$("#group_1").val();
        if(selected.length>0){
            var opt = [];
            selected.forEach(function(i, t){
                var txt = $("#group_1>option[value="+i+"]").text();
                opt.push({id:i, txt:txt});
            });   
            draw_option("#group_1", "#group_2", opt);
        }
    }

    function btn_right() {
        var selected=$("#group_2").val();
        if(selected.length>0){
            var opt = [];
            selected.forEach(function(i, t){
                var txt = $("#group_2>option[value="+i+"]").text();
                opt.push({id:i, txt:txt});
            });   
            draw_option("#group_2", "#group_1", opt);
        }
    }

    function draw_option(src, des, val){
        val.forEach(function(i, t){
            $(src+">option[value="+i.id+"]").remove();
            $(des).append('<option value="'+i.id+'" >'+i.txt+'</option>');
        });
    }
</script>