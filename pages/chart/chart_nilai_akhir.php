<?php
    require_once("../../config/koneksi.php");
?>
<link href="assets/vendor/d3-chart/gauge.css" rel="stylesheet">
<link href="assets/vendor/d3-chart/bar.css" rel="stylesheet">
<script type="text/javascript" src="assets/vendor/d3-chart/d3.v5.min.js"></script>
<div id="chart-nilai-akhir"></div>
<script type="text/javascript">
	var size = $("#chart-nilai-akhir").width()/2;
    thickness = 60;

	var color = d3.scaleLinear()
	    .domain([0, 1, 2, 3, 4, 5])
	    .range(['#db4639', '#FFCD42', '#A4C42D', '#48ba17', '#12ab24', '#0f9f59']);

	var arc = d3.arc()
	    .innerRadius(size - thickness)
	    .outerRadius(size)
	    .startAngle(-Math.PI / 2);

	var svg = d3.select('#chart-nilai-akhir').append('svg')
	    .attr('width', size * 2)
	    .attr('height', size + 20)
	    .attr('class', 'gauge');


	var chart = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + size + ')')

	var background = chart.append('path')
	    .datum({
	        endAngle: Math.PI / 2
	    })
	    .attr('class', 'background')
	    .attr('d', arc);

	var foreground = chart.append('path')
	    .datum({
	        endAngle: -Math.PI / 2
	    })
	    .style('fill', '#db2828')
	    .attr('d', arc);

	var value = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size * .9) + ')')
	    .append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('class', 'value');


	var kete = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size * 1.05) + ')')
	    .append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('class', 'nhuruf');

	var scale = svg.append('g')
	    .attr('transform', 'translate(' + size + ',' + (size + 15) + ')')
	    .attr('class', 'scale');

	scale.append('text')
	    .text(5)
	    .attr('text-anchor', 'middle')
	    .attr('x', (size - thickness / 2));

	scale.append('text')
	    .text(0)
	    .attr('text-anchor', 'middle')
	    .attr('x', -(size - thickness / 2));
	<?php
		if(isset($_GET['idp'])){
	        $id_periode = $_GET['idp'];
	    }else{
	        $id_periode = get_tahun_ajar_id();
	    }
		$nilai = get_tot_nilai($con, $_SESSION['user'], $id_periode);
		if($nilai=="-"){
			$nilai = 0;
		}
		echo "update_gauge($nilai);";
	?>
	

	function update_gauge(v) {
	    v = d3.format('.1f')(v);
	    //console.log("update", v);
	    foreground.transition()
	        .duration(750)
	        .style('fill', function() {
	            return color(v);
	        })
	        .call(arcTween, v);

	    value.transition()
	        .duration(750)
	        .call(textTween, v);

	    kete.transition()
	        .duration(750)
	        .call(textKet, rentang(v));
	}

	function arcTween(transition, v) {
	    var newAngle = v / 5 * Math.PI - Math.PI / 2;
	    transition.attrTween('d', function(d) {
	        var interpolate = d3.interpolate(d.endAngle, newAngle);
	        return function(t) {
	            d.endAngle = interpolate(t);
	            return arc(d);
	        };
	    });
	}

	function textTween(transition, v) {
		
	    transition.tween('text', function() {
	        var interpolate = d3.interpolate(this.innerHTML, v),
	            split = (v + '').split('.'),
	            round = (split.length > 1) ? Math.pow(10, split[1].length) : 1;
	        return function(t) {
	            this.innerHTML = d3.format('.1f')(Math.round(interpolate(t) * round) / round);
	        };
	    });
	}

	function textKet(transition, v) {
	    transition.tween('text', function() {
	        var interpolate = d3.interpolate(this.innerHTML, v),
	            split = (v + '').split('.'),
	            round = (split.length > 1) ? Math.pow(10, split[1].length) : 1;
	        return function(t) {
	            this.innerHTML = v//d3.format('.1f')(Math.round(interpolate(t) * round) / round);
	        };
	    });
	}

	function rentang(v){
		v = Number(v);
		
		if(v<=5 && v>=682){
			return "Sangat Baik";
		}else if(v<=5 && v>=4.01){
			return "Sangat Baik";
		}else if(v<=4 && v>=3.01){
			return "Baik";
		}else if(v<=3 && v>=2.01){
			return "Cukup";
		}else if(v<=2 && v>=1){
			return "Kurang";
		}else if(v<1){
			return "Sangat Kurang";
		}else{
			return "#";
		}
	}
</script>