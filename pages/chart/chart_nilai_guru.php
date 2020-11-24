<?php
    require_once("../../config/koneksi.php");
    if(!isset($_GET['nip'])){
    	echo "Guru tidak ditemukan!";
    	exit();
    }

    $nip = $_GET['nip'];
	$sql = "SELECT * FROM user WHERE nip = '$nip'";
	$q = mysqli_query($con, $sql);
	$nr = mysqli_num_rows($q);
	if($nr==0){
		echo "Guru tidak ditemukan!";
	    exit();
	}
	while($row = mysqli_fetch_array($q)){
		$guru[$row['nip']] = array(
						'nip' => $row['nip'],
						'nama_guru' => $row['nama_guru'],
						);
	}
?>
<canvas id="myLine"></canvas>
<pre>
<?php 

$sql = "SELECT * FROM periode ORDER BY tahun_ajar DESC, semester DESC LIMIT 0,5";
$q = mysqli_query($con, $sql);
$periode = [];
while($row = mysqli_fetch_array($q)){
	foreach ($guru as $k => $v) {
		$nilai = get_tot_nilai($con, $v['nip'], $row['id_periode']);
		$guru[$k]['nilai'] = $nilai=='-'?0:number_format($nilai, 2);
	}
	$periode[$row['id_periode']] = array(
						'id_periode' => $row['id_periode'],
						'nama_periode' => get_tahun_ajar($row['id_periode']),
						'guru' => $guru
						);
}

$periode = array_reverse($periode, true);

?>
</pre>

<script>
<?php

$label_periode = [];
$data_nilai = [];
echo "var dataset_nilai = [];";
foreach ($periode as $k => $v) {
	$label_periode[] = $v['nama_periode'];

}
$i=0;
foreach ($guru as $a => $b) {
	echo "dataset_nilai.push({";
	echo "label: '$b[nama_guru]',";
	echo "backgroundColor: '".gen_color($i)."',";
	echo "borderColor: '".gen_color($i)."',";
	echo "fill: false,";
	echo "data: [";
	foreach ($periode as $k => $v) {
		echo $v['guru'][$a]['nilai'].', ';
	}
	echo "]";
	echo "});";
	$i++;
}
echo "var label_periode = [\"".join('", "', $label_periode)."\"];";
?>

	var numberWithCommas = function(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	};

	var color = Chart.helpers.color;
	var barChartData = {
		labels: label_periode,
		datasets: dataset_nilai
	};
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