<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';

	mysqli_autocommit($con,FALSE);
	$proses = [];
	foreach ($_POST as $k => $v) {
		$exp = explode("_", $k);
		if(sizeof($exp)==3 && "$exp[0]_$exp[1]" == "isi_kompetensi"){
			$idpd = $_POST['id_penilai_detail'];
			$idk = $exp[2];

			$sql = "SELECT id_penilaian FROM penilaian WHERE id_penilai_detail = $idpd AND id_kriteria = $idk";

			$q = mysqli_query($con, $sql);
			while($row = mysqli_fetch_array($q)){
				$sql = "DELETE FROM penilaian WHERE id_penilaian = $row[id_penilaian]";
				if(mysqli_query($con, $sql)){
					$proses[] = 1;
				}else{
					$proses[] = 0;
				}
			}

			$sql = "INSERT INTO penilaian (id_penilai_detail, id_kriteria, hasil_nilai) VALUES ($idpd, $idk, $v)";
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