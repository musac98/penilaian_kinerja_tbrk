<?php
    require_once("../../config/koneksi.php");
?>
<canvas id="myLine"></canvas>
<pre>
<?php 
$sql = "SELECT * FROM user WHERE id_jenis_user = 6";
$q = mysqli_query($con, $sql);
$guru = [];
while($row = mysqli_fetch_array($q)){
	$guru[$row['nip']] = array(
					'nip' => $row['nip'],
					'nama_guru' => $row['nama_guru'],
					);
}


$sql = "SELECT * FROM periode ORDER BY tahun_ajar DESC, semester DESC LIMIT 0,5";
$q = mysqli_query($con, $sql);
$periode = [];
while($row = mysqli_fetch_array($q)){
	$tmp_nilai = [];
	foreach ($guru as $k => $v) {
		$nilai = get_tot_nilai($con, $v['nip'], $row['id_periode']);
		$tmp_nilai[] = $nilai=='-'?0:number_format($nilai, 2);
	}
	$avg = array_sum($tmp_nilai)/sizeof($tmp_nilai);
	$periode[$row['id_periode']] = array(
						'id_periode' => $row['id_periode'],
						'nama_periode' => get_tahun_ajar($row['id_periode']),
						'avg' => number_format($avg, 2)
						);
}

$periode = array_reverse($periode, true);

?>
</pre>
<script>
<?php

$label_periode = [];
foreach ($periode as $k => $v) {
	$label_periode[] = $v['nama_periode'];
	$nilai_avg[] = $v['avg'];
}
echo "var label_periode = [\"".join('", "', $label_periode)."\"];";
?>


	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_periode,
		datasets: [{
			label: "Nilai Rata-rata",
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			fill:false,
			data:[<?= join(',', $nilai_avg); ?>]
		}]
	};
	console.log(barChartData);
	var ctx = document.getElementById('myLine');
	var myBar = new Chart(ctx, {
		type: 'line',
		data: barChartData,
		options: {
			responsive: true,
			legend: {
				display: true,
				position: "bottom"
			},
			title: {
				display: "false"
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
		            gridLines: {
		               display: true
		            },
		         }],
			  	yAxes: [{
					ticks: {
					  	min: 0,
					  	max: 5,
					  	
					}
			  	}]
			},
			plugins: {
	        	datalabels: {
	            	display: true,
	            	align: 'start',
	            	color: "#000",
	            	font: {
						weight: 'bold',
						size:12
					},
	            	anchor: 'end',
	         	}
	      	}
		},


	});
		
</script>