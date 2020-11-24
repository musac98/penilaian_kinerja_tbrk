<?php
    require_once("../../config/koneksi.php");
?>
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/vendor/chart.js/utils.js"></script>
<script src="assets/vendor/chart.js/chartjs-plugin-datalabels.js"></script>
<?php 
	include 'cht.config.php'; 

	$var_kompetensi = [];
	$var_nkompetensi = [];
	foreach ($data_kompetensi as $k => $v) {
		$var_kompetensi[] = $v['nama_kompetensi'];
		$n = 0;
		$sa = [];
		foreach ($data_nilai as $a => $b) {
			$sa[$a]=0;
		}
		foreach ($data_nilai as $a => $b) {
			if($a == 'siswa'){
				$sa[$a] += $data_nilai[$a][$k]['na'];
			}else if($a == 'atasan'){
				$sa[$a] += $data_nilai[$a][$k]['na'];
			}else if($a == 'diri_sendiri'){
				$sa[$a] += $data_nilai[$a][$k]['na'];
			}else if($a == 'guru'){
				$sa[$a] += $data_nilai[$a][$k]['na'];
			}
		}

		foreach ($sa as $a => $b) {
			if($a == 'siswa'){
				$n += $b*$met[$a];
			}else if($a == 'atasan'){
				$n += $b*$met[$a];
			}else if($a == 'diri_sendiri'){
				$n += $b*$met[$a];
			}else if($a == 'guru'){
				$n += $b*$met[$a];
			}
		}
		$var_nkompetensi[] = number_format($n, 2);
	}
	echo '<script>';
	echo "var var_kompetensi = [\"".join('", "', $var_kompetensi)."\"];";
	echo "var var_nkompetensi = [".join(', ', $var_nkompetensi)."];";
	echo '</script>';
?>
<canvas id="myBar2" height="200"> </canvas>
<script>
	//var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var color = Chart.helpers.color;
	var barChartKompetensi = {
		labels: var_kompetensi,
		datasets: [{
			label: 'Nilai',
			//backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
			backgroundColor: [window.chartColors.purple, window.chartColors.orange, window.chartColors.red, window.chartColors.green],
			//borderColor: window.chartColors.red,
			borderWidth: 1,
			data: var_nkompetensi
		}]

	};
	var ctx = document.getElementById('myBar2').getContext('2d');

	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: barChartKompetensi,
		options: {
			responsive: true,
			legend: {
				display: false
			},
			title: {
				display: false
			},
			scales: {
				xAxes: [{
		            gridLines: {
		               display: false
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
	            	color: "#FFF",
	            	font: {
						weight: 'bold',
						size:18
					},
	            	anchor: 'end',
	         	}
	      	}
		},
	});
</script>