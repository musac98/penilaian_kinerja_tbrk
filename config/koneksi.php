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



	function get_owener()
	{
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM karyawan a JOIN jabatan b ON a.id_jabatan = b.id_jabatan WHERE level = 2";
		$q = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($q);
		return $row['id_kar'];
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
		return ["C (Cukup)", "B (Baik)", "A (Sangat Baik)"];
	}

	function get_kategori_nilai($n=0){
		$arr = get_kategori();
		if($n=="-"){
			return "Belum dinilai";
		}
		if($n>=4.8 && $n<=7.2){
			return $arr[2];
		}else if($n>=2.4 && $n<=4.79){
			return $arr[1];
		}else{
			return $arr[0];
		}
	}

	class Penilian{
		public $data_kriteria = [];
		public $data_absen = [];
		public $max_nilai = 0;
		public $max_absen = 0;
		public $absen_kurang = 0;
		public $np = 0;
		public $na = [];
		public $hasil_nilai = 0;


		function __construct($con, $id_penilai='', $id_periode='')
		{
			
			$this->get_max_kategori($con);
			// max absen  & get absen
			//$this->get_max_absen($con, $id_penilai, $id_penilai);

			$sql = "SELECT * FROM penilai a JOIN grup_dinilai b ON a.id_penilai = b.id_penilai
					WHERE a.id_penilai = $id_penilai";
			$q = mysqli_query($con, $sql);
			$absen = 0;
			while($row = mysqli_fetch_array($q)){
				$this->max_absen = mysqli_num_rows($q) * 12;
				$id_kar = $row['id_kar'];
				$abs = 0;
				$sql2 = "SELECT jml_masuk FROM presensi WHERE id_kar = '$id_kar' AND id_periode = $id_periode ";
				$q2 = mysqli_query($con, $sql2);
				while($row2 = mysqli_fetch_array($q2)){
					$absen += $row2['jml_masuk'];
					$abs += $row2['jml_masuk'];
				}
				$data_absen[$id_kar]['absen'] = $abs;
				$data_absen[$id_kar]['absen_kurang'] = 12 - $abs;
			}

			$this->np = $this->max_nilai / 12;
			$this->absen_kurang = $this->max_absen - $absen;


			// get nilai
			$na = 0;
			foreach ($this->data_kriteria as $k => $v) {
				$kite = $v['id_kriteria'];
				$sql = "SELECT 
							a.id_penilai_detail,
							d.id_kar as 'dinilai',
							b.id_kar,
							SUM(a.hasil_nilai) AS 'hasil_nilai'
						FROM penilaian a 
						JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
						JOIN data_penilaian_kinerja c ON a.id_sub_kriteria = c.id_sub_kriteria
						JOIN grup_dinilai d ON d.id_grup = b.id_grup
						WHERE d.id_penilai = $id_penilai AND c.id_kriteria = $kite
						GROUP BY a.id_penilai_detail";
				$q = mysqli_query($con, $sql);
				
				$tmp_tot = 0;
				if(mysqli_num_rows($q)>0){
					while($row = mysqli_fetch_array($q)){
						$tmp_tot += $row['hasil_nilai'];
						$this->data_kriteria[$k]["nilai"][$row['dinilai']][$row['id_kar']] = $row['hasil_nilai'];
						$this->data_kriteria[$k]["dinilai"][$row['dinilai']][$row['id_kar']] = $row['hasil_nilai'] * ($v['bobot']/100);
					}
					$na = $tmp_tot * ($this->data_kriteria[$k]['bobot']/100);
				}else{
					$this->data_kriteria[$k]["dinilai"] = []; 
				}
			}

			/// cara 2
			$tmp_na = [];
			foreach ($this->data_kriteria as $a => $b) {
				// dinilai
				foreach ($b['dinilai'] as $c => $d) {
					if(sizeof($d)==2){
						// penilai
						foreach ($d as $e => $f) {
							if(!isset($tmp_na[$c][$e])){
								$tmp_na[$c][$e] = $this->data_kriteria[$a]['dinilai'][$c][$e];
							}else{
								$tmp_na[$c][$e] += $this->data_kriteria[$a]['dinilai'][$c][$e];
							}
						}
					}
				}
			}

			if(!empty($tmp_na)){
				foreach ($tmp_na as $a => $b) {
					$n = array_sum($b)/count($b);
					$n = $n - ($this->np * $data_absen[$a]['absen_kurang']);
					$this->na[$a] = $n;
				}
			}

		}

		public function get_max_kategori($con)
		{
			$sql = "SELECT                                                         
						b.id_kriteria,                                                
						b.nama_kriteria,   
						b.bobot,                                                
						COUNT(a.id_sub_kriteria) AS jml                                   
					FROM data_penilaian_kinerja a
					JOIN kriteria b ON a.id_kriteria = b.id_kriteria
					GROUP BY b.id_kriteria
					ORDER BY b.id_kriteria";
			$q = mysqli_query($con, $sql);
			$this->data_kriteria = [];
			while($row = mysqli_fetch_array($q)){
				$this->data_kriteria[] = array(
										'id_kriteria' => $row['id_kriteria'],
										'kriteria' => $row['nama_kriteria'],
										'bobot' => $row['bobot'],
										'jml' => $row['jml']
										);
			}
			$this->max_nilai = 0;
			foreach ($this->data_kriteria as $k => $v) {
				$a = (4 * $v['jml']) * ($v['bobot']/100);
				$this->max_nilai += $a;
			}
		}

		public function get_max_absen($con, $id_penilai='', $id_periode='')
		{
			
		}

		function get_tot_nilai()
		{
			$return = "-";
			if(!empty($this->na)){
				$return = array_sum($this->na)/2;
			}
			return $return;
		}

		function get_tot_nilai_individu($idk)
		{
			$return = "-";
			if(!empty($this->na)){
				if(isset($this->na[$idk])){
					$return = $this->na[$idk];
				}
			}
			return $return;
		}

		function get_data_kriteria()
		{
			return $this->data_kriteria;
		}

		function get_na_kriteria($id, $pen = '', $din = '')
		{
			foreach ($this->data_kriteria as $k => $v) {
				if($id == $v['id_kriteria']){
					if($din == ''){
						return $v['dinilai'];
					}else{
						if($pen == ''){
							return $v['dinilai'];
						}else{
							return $v['dinilai'][$din][$pen];
						}
					}
				}
			}
		}
	}

	function get_tot_nilai($con, $id_penilai='', $id_periode='')
	{

		// max nilai 
		$sql = "SELECT                                                         
					b.id_kriteria,                                                
					b.nama_kriteria,   
					b.bobot,                                                
					COUNT(a.id_sub_kriteria) AS jml                                   
				FROM data_penilaian_kinerja a
				JOIN kriteria b ON a.id_kriteria = b.id_kriteria
				GROUP BY b.id_kriteria
				ORDER BY b.id_kriteria";
		$q = mysqli_query($con, $sql);
		$data_kriteria = [];
		while($row = mysqli_fetch_array($q)){
			$data_kriteria[] = array(
									'id_kriteria' => $row['id_kriteria'],
									'kriteria' => $row['nama_kriteria'],
									'bobot' => $row['bobot'],
									'jml' => $row['jml']
									);
		}
		$max_nilai = 0;
		foreach ($data_kriteria as $k => $v) {
			$a = (4 * $v['jml']) * ($v['bobot']/100);
			$max_nilai += $a;
		}
		
		// max absen  & get absen
		$sql = "SELECT * FROM penilai a JOIN grup_dinilai b ON a.id_penilai = b.id_penilai
				WHERE a.id_penilai = $id_penilai";
		$q = mysqli_query($con, $sql);
		$absen = 0;
		while($row = mysqli_fetch_array($q)){
			$max_absen = mysqli_num_rows($q) * 12;
			$id_kar = $row['id_kar'];
			$sql2 = "SELECT jml_masuk FROM presensi WHERE id_kar = '$id_kar' AND id_periode = $id_periode ";
			$q2 = mysqli_query($con, $sql2);
			while($row2 = mysqli_fetch_array($q2)){
				$absen += $row2['jml_masuk'];
			}
		}

		$np = $max_nilai / $max_absen;
		$absen_kurang = $max_absen - $absen;
		//echo "$max_nilai * $max_absen = $np | $absen_kurang <br>";
		// get nilai
		$na = 0;
		foreach ($data_kriteria as $k => $v) {
			$kite = $v['id_kriteria'];
			$sql = "SELECT 
						a.id_penilai_detail,
						b.id_kar,
						SUM(a.hasil_nilai) AS 'hasil_nilai'
					FROM penilaian a 
					JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
					JOIN data_penilaian_kinerja c ON a.id_sub_kriteria = c.id_sub_kriteria
					WHERE b.id_penilai = $id_penilai AND c.id_kriteria = $kite
					GROUP BY a.id_penilai_detail";
			$q = mysqli_query($con, $sql);
			
			$tmp_tot = 0;
			while($row = mysqli_fetch_array($q)){
				$tmp_tot += $row['hasil_nilai'];
				$data_kriteria[$k]["penilai"][] = $row['id_kar'];
				$data_kriteria[$k]["total"][$row['id_kar']] = $row['hasil_nilai'];
				$data_kriteria[$k]["na"][$row['id_kar']] = $row['hasil_nilai'] * ($v['bobot']/100);
			}
			$na = $tmp_tot * ($data_kriteria[$k]['bobot']/100);
		}
		/// cara 2
		//print_r($data_kriteria);
		$na = [];
		foreach ($data_kriteria as $a => $b) {
			foreach ($b['penilai'] as $c => $d) {
				//echo $d." = ".$data_kriteria[$a]['na'][$d].'<br>';
				if(!isset($na[$d])){
					$na[$d] = $data_kriteria[$a]['na'][$d];
				}else{
					$na[$d] += $data_kriteria[$a]['na'][$d];
				}
			}
		}
		//print_r($na);
		/*$na = array_sum($na)/count($na);
		echo '<pre>';
		print_r($data_kriteria);
		echo '</pre>';*/

		$return = $na - ($np*$absen_kurang);
		return $return;
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


	function get_dinilai($con, $idp){
        $sql = "SELECT * FROM grup_dinilai a JOIN karyawan b ON a.id_kar = b.id_kar WHERE a.id_penilai = $idp";
        $q = mysqli_query($con, $sql);
        $txt = '';
        while($row = mysqli_fetch_array($q)){
            $txt .= "- $row[nama]<br>";
        }
        return $txt;
    }


	function get_dinilai_2($con, $idp){
        $sql = "SELECT * FROM grup_dinilai a JOIN karyawan b ON a.id_kar = b.id_kar WHERE a.id_penilai = $idp";
        $q = mysqli_query($con, $sql);
        $txt = '[';
        $i=0;
        while($row = mysqli_fetch_array($q)){
            if($i>0)$txt .= ', ';
            $txt .= " \"$row[nama]\" ";
        	$i++;
        }
        $txt .= ']';
        return $txt;
    }

    function get_penilai($con, $idp){
        //$sql = "SELECT * FROM penilai_detail a JOIN karyawan b ON a.id_kar = b.id_kar WHERE a.id_penilai = $idp";
        $sql = "SELECT * 
				FROM penilai_detail a 
				JOIN karyawan b ON a.id_kar = b.id_kar 
				JOIN grup_dinilai c ON a.id_grup = c.id_grup
				WHERE c.id_penilai = $idp
				GROUP BY b.id_kar";
		//echo $sql."<br>";
        $q = mysqli_query($con, $sql);
        $txt = '';
        while($row = mysqli_fetch_array($q)){
            $txt .= "- $row[nama]<br>";
        }
        return $txt;
    }
?>