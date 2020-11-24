<?php

	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$host	= 'localhost';
	$user	= 'root';
	$pass	= '';
	$db		= 'dbtbrk';

	$con=mysqli_connect($host, $user, $pass, $db);
	// Check connection
	if (mysqli_connect_errno()){
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

  	function direct($link){
  		echo '<script>document.location="'.$link.'"</script>';
  	}

  	function get_tahun_ajar($id="")
	{
		$con = $GLOBALS['con'];
		if($id!=''){
			$sql = "SELECT * FROM periode WHERE id_periode = $id";
		}else{
			$sql = "SELECT * FROM periode WHERE status_periode = 1";
		}
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		$thn = (int)$row['tahun'];
		$thn++;
		return $row['tahun'].", Bulan ".$row['bulan'].", Pekan ".$row['pekan'];
	}


	function get_tahun_ajar_id()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM periode WHERE status_periode = 1";
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		return $row['id_periode'];
	}

	function get_max_guru()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM user a WHERE id_jenis_user = 6";
		$q = mysqli_query($con, $sql);
		return mysqli_num_rows($q);
	}

	function get_max_siswa()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM user a WHERE id_jenis_user = 11";
		$q = mysqli_query($con, $sql);
		return mysqli_num_rows($q);
	}

	function get_jml_penilai_guru()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM periode WHERE status_periode = 1";
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		return 1;
	}

	function get_jml_penilai_siswa()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM periode WHERE status_periode = 1";
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		return explode(";", $row['setting_jml'])[1];
	}

	function get_kategori(){
		return ["Kurang", "Cukup", "Baik", "Sangat Baik"];
	}

	function get_kategori_nilai($n=0){
		$arr = get_kategori();
		if($n>4.8 && $n<=7.2){
			return $arr[3];
		}else if($n>2.4 && $n<=4.79){
			return $arr[2];
		}else if($n>0 && $n<=2.39){
			return $arr[1];
		}else{
			return $arr[0];
		}
	}

	function get_tot_nilai($con, $nip_user='', $id_periode='')
	{
		$sql = "SELECT 
					a.id_kompetensi,
					a.nama_kompetensi,
					a.bobot_kompetensi,
					COUNT(b.id_isi) AS 'atasan',
					(SELECT COUNT(*) AS 'jml' FROM isi_kompetensi c WHERE c.ket LIKE '%1%' AND c.id_kompetensi = a.id_kompetensi) AS 'guru',
					(SELECT COUNT(*) AS 'jml' FROM isi_kompetensi c WHERE c.ket LIKE '%2%' AND c.id_kompetensi = a.id_kompetensi) AS 'siswa',
					(SELECT COUNT(*) AS 'jml' FROM isi_kompetensi c WHERE c.ket LIKE '%1%' AND c.id_kompetensi = a.id_kompetensi) AS 'diri_sendiri'
				FROM jenis_kompetensi a
				JOIN isi_kompetensi b ON a.id_kompetensi = b.id_kompetensi
				GROUP BY a.id_kompetensi";
		$q = mysqli_query($con, $sql);
		$data_kompetensi = [];
		while($row = mysqli_fetch_array($q)){
			$data_kompetensi[$row['id_kompetensi']] = $row;
		}
		//print_r($data_kompetensi);
		$sql = "SELECT
					c.nip,
					b.nip AS 'penilai',
					f.jabatan,
					f.level,
					d.id_kompetensi,
					SUM(a.hasil_nilai) AS nilai
				FROM penilaian a
				JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
				JOIN penilai c ON b.id_penilai = c.id_penilai
				JOIN isi_kompetensi d ON d.id_isi = a.id_isi
				JOIN user e ON b.nip = e.nip
				JOIN jenis_user f ON e.id_jenis_user = f.id_jenis_user
				WHERE c.nip = '$nip_user' AND id_periode = $id_periode
				GROUP BY c.nip,b.nip,d.id_kompetensi";
		$q = mysqli_query($con, $sql);
		$i=0;
		$tmp_data = [];
		$data_nilai = [];
		if(mysqli_num_rows($q)<1){
			return "-";
		}
		while($row = mysqli_fetch_array($q)){
			$idkom = $row['id_kompetensi'];
			$tmp_data[] = $row;
			if($row['level'] == 1){
				if($row['penilai'] == $row['nip']){
					$data_nilai['diri_sendiri'][$idkom]['nilai'] = 0;
					$data_nilai['diri_sendiri'][$idkom]['rata'] = 0;
					$data_nilai['diri_sendiri'][$idkom]['na'] = 0;
				}else{
					$data_nilai['guru'][$idkom]['nilai'] = 0;
					$data_nilai['guru'][$idkom]['rata'] = 0;
					$data_nilai['guru'][$idkom]['na'] = 0;
				}
			}else if($row['level']==2 || $row['level']==3){
				$data_nilai['atasan'][$idkom]['nilai'] = 0;
				$data_nilai['atasan'][$idkom]['rata'] = 0;
				$data_nilai['atasan'][$idkom]['na'] = 0;
			}else if($row['level']==4){
				$data_nilai['siswa'][$idkom]['nilai'] = 0;
				$data_nilai['siswa'][$idkom]['rata'] = 0;
				$data_nilai['siswa'][$idkom]['na'] = 0;
			}
		}
		foreach ($tmp_data as $k => $row) {
			$idkom = $row['id_kompetensi'];
			if($row['level'] == 1){
				if($row['penilai'] == $row['nip']){
					$nilai_rata = $row['nilai'];
					$data_nilai['diri_sendiri'][$idkom]['nilai'] += $nilai_rata;
					$data_nilai['diri_sendiri'][$idkom]['rata']++;
				}else{
					$nilai_rata = $row['nilai'];
					$data_nilai['guru'][$idkom]['nilai'] += $nilai_rata;
					$data_nilai['guru'][$idkom]['rata']++;
				}
			}else if($row['level']==2 || $row['level']==3){
				$nilai_rata = $row['nilai'];
				$data_nilai['atasan'][$idkom]['nilai'] += $nilai_rata;
				$data_nilai['atasan'][$idkom]['rata']++;
			}else if($row['level']==4){
				$nilai_rata = $row['nilai'];
				$data_nilai['siswa'][$idkom]['nilai'] += $nilai_rata;
				$data_nilai['siswa'][$idkom]['rata']++;
			}
		}
		foreach ($data_nilai as $k => $v) {
			foreach ($v as $a => $b) {
				$na = ($b['nilai']/$b['rata'])/$data_kompetensi[$a][$k];
				$data_nilai[$k][$a]['na'] = $na;
			}
		}
		

		foreach ($data_nilai as $k => $v) {
			$tot = 0;
			foreach ($v as $a => $b) {
				$tot += $b['na'] * ($data_kompetensi[$a]['bobot_kompetensi']/100);
			}
			$data_nilai[$k]['total'] = $tot;
		}

		$sql = "SELECT * FROM periode WHERE id_periode = $id_periode";
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		$met = [];
		if($row['setting']!=''){
			$set = explode(";", $row['setting']);
			$met['atasan'] = $set[0]/100;
			$met['guru'] = $set[1]/100;
			$met['diri_sendiri'] = $set[2]/100;
			$met['siswa'] = $set[3]/100;
		}else{
			$met['atasan'] = 0.5;
			$met['guru'] = 0.3;
			$met['diri_sendiri'] = 0.1;
			$met['siswa'] = 0.1;
		}
		
		$tot = 0;
		foreach ($data_nilai as $k => $v) {
			$t = $v['total'] * $met[$k];
			$tot += $v['total'] * $met[$k]; 
		}
		return number_format($tot, 2);		
	}

	function gen_color($i){
		$color = ['#4dc9f6','#f67019','#f53794','#537bc4','#acc236','#166a8f','#00a950','#58595b','#8549ba'];
		if($i<sizeof($color)){
			return $color[$i];
		}else{
			$mod = $i%8;
			$sep = $i%10;
			$cl = $color[$mod];
			$tg = ($sep%3);
			$tg = $tg + $tg + 1;
			if($tg==1){
				$tg1=3;
				$tg2=5;
			}else if($tg==3){
				$tg1=5;
				$tg2=1;
			}else{
				$tg1=1;
				$tg2=3;
			}

			$w[$tg] = substr($cl, $tg, 2);
			$w[$tg1] = substr($cl, $tg1, 2);
			$w[$tg2] = substr($cl, $tg2, 2);


			$w[$tg] = $mod + $sep + $i + hexdec($w[$tg]);
			$w[$tg1] = $mod + $sep + $i + hexdec($w[$tg1]);
			$w[$tg2] = $mod + $sep + $i + hexdec($w[$tg2]);

			$w[$tg] = $w[$tg]>255?$w[$tg1]%255:$w[$tg];
			$w[$tg1] = $w[$tg1]>255?$w[$tg1]%255:$w[$tg1];
			$w[$tg2] = $w[$tg2]>255?$w[$tg1]%255:$w[$tg2];

			$w[$tg] = dechex($w[$tg]);
			$w[$tg1] = dechex($w[$tg1]);
			$w[$tg2] = dechex($w[$tg2]);

			$w[$tg] = strlen($w[$tg])==1?$w[$tg]."0":$w[$tg];
			$w[$tg1] = strlen($w[$tg1])==1?$w[$tg1]."0":$w[$tg1];
			$w[$tg2] = strlen($w[$tg2])==1?$w[$tg2]."0":$w[$tg2];

			$nc = join($w);
			return "#".$nc;
		}
	}
?>