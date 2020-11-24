<script>
<?php
	$nip_user = $_SESSION['user'];
	if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }
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
	$var_wakil = "";
	$var_nwakil = "";
	foreach ($data_nilai as $k => $v) {
		$t = $v['total'] * $met[$k];
		if($tot==0){
			$var_wakil .= '"'.ucwords(str_replace("_", " ", $k)).'"';
			$var_nwakil .= number_format($t, 2);
		}else{
			$var_wakil .= ', "'.ucwords(str_replace("_", " ", $k)).'"';
			$var_nwakil .= ', '.number_format($t, 2);
		}
		$tot += $t;
	}
	//print_r($data_nilai['siswa'][1]['nilai']);
	echo "var label_wakil = [$var_wakil];";
	echo "var nilai_wakil = [$var_nwakil];";

?>
</script>