
<?php
    require_once("../../config/koneksi.php");
?>
<canvas id="myBar2"> </canvas>

<script>
<?php 
include 'cht.home.config.php'; 
// asc
usort($data, function ($a, $b) {
    if ($a['nilai'] > $b['nilai']) {
        return -1;
    } elseif ($a['nilai'] < $b['nilai']) {
        return 1;
    } else {
        return 0;
    }
});

$label_rendah = [];
$nilai_rendah = [];
$nilai_rendah2 = [];
foreach ($data2 as $k => $v) {
	if($k<5){
		$label_rendah[] = $v['nama_guru'];
		$nilai_rendah[] = number_format($v['nilai'], 2);
		$nilai_rendah2[] = $v['nilai'];
	}
}
echo "var label_rendah = [".join(', ', $label_rendah)."];";
echo "var nilai_rendah = [".join(', ', $nilai_rendah)."];";
echo "var nilai_rendah2 = [".join(', ', $nilai_rendah2)."];";
?>
console.log(label_rendah);

	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_rendah,
		datasets: [{
			label: 'Nilai',
			backgroundColor: [window.chartColors.red, window.chartColors.yellow, window.chartColors.green, window.chartColors.blue],
			borderWidth: 1,
			data: nilai_rendah
		}]

	};
	var ctx = document.getElementById('myBar2').getContext('2d');
	ctx.height = 100;
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
			tooltips: {
		        mode: 'label',
		        callbacks: {
		            label: function(tooltipItem, data) {
		               	//return data.datasets[tooltipItem.datasetIndex].label + ": " + numberWithCommas(tooltipItem.yLabel);
		            	return "Nilai "+nilai_rendah2[tooltipItem.datasetIndex];
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
	});
</script>