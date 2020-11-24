<?php
    require_once("../../config/koneksi.php");
?>
<script src="assets/vendor/chart.js/Chart.min.js"></script>
<script src="assets/vendor/chart.js/utils.js"></script>
<script src="assets/vendor/chart.js/chartjs-plugin-datalabels.js"></script>
<?php include 'cht.config.php'; ?>
<canvas id="myBar"> </canvas>

<script>
	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_wakil,
		datasets: [{
			label: 'Nilai',
			backgroundColor: [window.chartColors.red, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue],
			borderWidth: 1,
			data: nilai_wakil
		}]

	};
	var ctx = document.getElementById('myBar').getContext('2d');
	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: barChartData,
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