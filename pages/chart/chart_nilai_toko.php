
<?php
    require_once("../../config/koneksi.php");
include 'cht.home.config.php'; 
?>

<canvas id="myBar"></canvas>

<script>
<?php 




$label_tinggi = [];
$nilai_tinggi = [];
$nilai_tinggi2 = [];
foreach ($data as $k => $v) {
	if($k<5){
		$label_tinggi[] = $v['nama_guru'];
		$nilai_tinggi[] = number_format($v['nilai'],2);
		$nilai_tinggi2[] = $v['nilai'];
	}
}
echo "var label_tinggi = [\"".join('", "', $label_tinggi)."\"];";
echo "var nilai_tinggi = [".join(', ', $nilai_tinggi)."];";
echo "var nilai_tinggi2 = [".join(', ', $nilai_tinggi2)."];";
?>
	var numberWithCommas = function(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	};

	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_tinggi,
		datasets: [{
			label: 'Nilai',
			backgroundColor: [window.chartColors.red, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue],
			borderWidth: 1,
			data: nilai_tinggi
		}]

	};
	var ctx = document.getElementById('myBar');
	ctx.height = 100;
	var myBar = new Chart(ctx, {
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
			tooltips: {
		        mode: 'label',
		        callbacks: {
		            label: function(tooltipItem, data) {
		               	//return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
		            	return "Nilai "+nilai_tinggi2[tooltipItem.datasetIndex];
		            }
		        }
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
					  	max: 8,
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
/*		*/
      	
	});
</script>