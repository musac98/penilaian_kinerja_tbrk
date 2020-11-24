<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$nip = isset($_POST['nip'])?$con->real_escape_string($_POST['nip']):'';
	$pen = $_SESSION['user'];
	$idp = get_tahun_ajar_id();
	$sql = "SELECT * FROM penilai_detail a JOIN penilai b ON a.id_penilai = b.id_penilai 
			WHERE a.nip = '$pen' AND b.nip = '$nip' AND b.id_periode = $idp ";
	$q = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($q);
	$id_penilai_detail = $row['id_penilai_detail'];
	

	mysqli_autocommit($con,FALSE);
	$proses = [];
	foreach ($_POST as $k => $v) {
		$exp = explode("_", $k);
		if(sizeof($exp)==3 && "$exp[0]_$exp[1]" == "isi_kompetensi"){
			$sql = "SELECT id_nilai FROM penilaian WHERE id_penilai_detail = $id_penilai_detail AND id_isi = $exp[2]";
			$q = mysqli_query($con, $sql);
			while($row = mysqli_fetch_array($q)){
				$sql = "DELETE FROM penilaian WHERE id_nilai = $row[id_nilai]";
				if(mysqli_query($con, $sql)){
					$proses[] = 1;
				}else{
					$proses[] = 0;
				}
			}
			$sql = "INSERT INTO penilaian (id_penilai_detail, id_isi, hasil_nilai) VALUES ($id_penilai_detail, $exp[2], $v)";
			if(mysqli_query($con, $sql)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
			}
		}
	}
	if(!in_array(0, $proses)){
		mysqli_commit($con);
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
	}else{
		mysqli_rollback($con);
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
	}
	header("location:../index.php?p=melakukanpen");
}

?>