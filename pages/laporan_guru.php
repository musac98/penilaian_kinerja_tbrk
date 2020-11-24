
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
	});
</script>