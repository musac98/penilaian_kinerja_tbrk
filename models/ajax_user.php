<?php

require_once("../config/koneksi.php");

if(isset($_GET['id_kar'])){
	$id_kar = $_GET['id_kar'];
	$sql = "SELECT * FROM karyawan a 
	JOIN jabatan b ON a.id_jabatan = b.id_jabatan 
	JOIN toko t ON a.id_toko = t.id_toko
	WHERE id_kar = '$id_kar'";
	$q = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($q);
?>
<table class="table">
	<tbody>
		<tr>
			<th width="15%">Username</th>
			<td width="1%" >:</td>
			<td><?= $row['id_kar']; ?></td>
		</tr>
		<tr>
			<th>Jabatan</th>
			<td>:</td>
			<td><?= $row['jabatan']; ?></td>
		</tr>
		<tr>
			<th>Lokasi Toko</th>
			<td>:</td>
			<td><?= $row['lokasi']; ?></td>
		</tr>
		<tr>
			<th>Password</th>
			<td>:</td>
			<td><?= $row['password']; ?></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td>:</td>
			<td><?= $row['nama']; ?></td>
		</tr>
		<tr>
			<th>Alamat</th>
			<td>:</td>
			<td><?= $row['alamat']; ?></td>
		</tr>
		<tr>
			<th>No Telp</th>
			<td>:</td>
			<td><?= $row['no_telp']; ?></td>
		</tr>
	</tbody>
</table>	
<?php
}

if(isset($_GET['id_toko'])){
?>
    <div class="form-group row">
        <label for="guru_dinilai" class="col-sm-2 col-form-label">Karyawan Dinilai</label>
        <?php
        	$id_toko = $_GET['id_toko'];
            $sql = "SELECT * FROM karyawan a 
                    JOIN jabatan b ON a.id_jabatan = b.id_jabatan 
                    WHERE b.level = 4 AND id_toko = $id_toko";
            $q = mysqli_query($con, $sql);
            $sz = mysqli_num_rows($q);
            $group_1 = [];
            $group_2 = [];
            $num_group = $sz/2;
            $i=1;
            while($row = mysqli_fetch_array($q)){
                if($i <= $num_group){
                    $group_1[] = $row;
                }else{
                    $group_2[] = $row;
                }
                $i++;
            }
        ?>
        <div class="col-sm-4">
            <label for="">Group 1</label>
            <select name="group_1[]" id="group_1" class="form-control cb_kar" multiple>
            <?php 
                foreach($group_1 as $k => $v){
                    echo "<option value=\"$v[id_kar]\">$v[nama]</option>";
                }
            ?>
            </select>
        </div>
        <div class="col-sm-2 btn-box" >
            <button type="button" class="btn btn-success btn-move" id="btn-left"> > </button>
            <button type="button" class="btn btn-success btn-move" id="btn-right"> < </button>
        </div>
        <div class="col-sm-4">
            <label for="">Group 2</label>
            <select name="group_2[]" id="group_2" class="form-control cb_kar" multiple>
            <?php 
                foreach($group_2 as $k => $v){
                    echo "<option value=\"$v[id_kar]\">$v[nama]</option>";
                }
            ?>
            </select>
        </div>
    </div>
    <script type="text/javascript">
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
                $(des).append('<option value="'+i.id+'">'+i.txt+'</option>');
                $(src+">option[value="+i.id+"]").remove();
            });
        }
    </script>
<?php
}
?>