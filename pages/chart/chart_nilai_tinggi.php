
<?php
    require_once("../../config/koneksi.php");
include 'cht.home.config.php'; 
?>

<canvas id="myBar3"></canvas>

<script>
<?php 
usort($data3, function ($a, $b) {
    if ($a['nilai'] > $b['nilai']) {
        return -1;
    } elseif ($a['nilai'] < $b['nilai']) {
        return 1;
    } else {
        return 0;
    }
});



$label_tinggi = [];
$nilai_tinggi = [];
$nilai_tinggi2 = [];
$color = [];
foreach ($data3 as $k => $v) {
	$label_tinggi[] = $v['nama_guru'];
	$nilai_tinggi[] = number_format($v['nilai'],2);
	$nilai_tinggi2[] = $v['nilai'];
	$color[] = gen_color($k);
	/*if($k<5){
	}*/
}
echo "var label_tinggi = [\"".join('", "', $label_tinggi)."\"];";
echo "var nilai_tinggi = [".join(', ', $nilai_tinggi)."];";
echo "var nilai_tinggi2 = [".join(', ', $nilai_tinggi2)."];";
echo "var color_nil = [\"".join('", "', $color)."\"];";
?>
	var numberWithCommas = function(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	};

	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_tinggi,
		datasets: [{
			label: 'Nilai',
			backgroundColor: color_nil,
			borderWidth: 1,
			data: nilai_tinggi
		}]

	};
	var ctx = document.getElementById('myBar3');
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