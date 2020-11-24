<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fa fa-file-pdf"></i> Laporan Penilaian Kinerja
		<br>
		<?php $iddp = isset($_GET['idp'])?$_GET['idp']:''; ?>
		<small id="per_txt">Periode : <?= get_tahun_ajar($iddp); ?></small>
    </h1>
</div>
<?php

if(!isset($_GET['detail'])){
	/*if($_SESSION['type']==2 || $_SESSION['type']==3){
		include 'laporan_atasan.php';
	}else if($_SESSION['type']==1){
		include 'laporan_guru.php';
	}*/
?>

<div class="row">
	<div class="col mb-4">
		<div class="card shadow">
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
<div class="load_laporan"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".load_laporan").load('pages/laporan_atasan.php');
		$("#cbid_priode").change(function(){
			var val = $(this).val();
			var txt = $(this).children("option:selected").html();
			$("#per_txt").html("Periode : "+txt);
			$(".load_laporan").load('pages/laporan_atasan.php?idp='+val);
		});
	});
</script>
<?php
	//include 'laporan_atasan.php';
}else{
	include 'laporan_detail.php';
}


?>