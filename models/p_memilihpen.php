<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$nip = isset($_POST['id_guru_dinilai'])?$con->real_escape_string($_POST['id_guru_dinilai']):'';
	$guru_penilai = [];
	for($i = 1; $i <= get_jml_penilai_guru(); $i++){
		$guru_penilai[] = isset($_POST['id_guru_penilai_'.$i])?$con->real_escape_string($_POST['id_guru_penilai_'.$i]):'';;
	}
	$siswa_penilai = [];
	for($i = 1; $i <= get_jml_penilai_siswa(); $i++){
		$siswa_penilai[] = isset($_POST['id_siswa_penilai_'.$i])?$con->real_escape_string($_POST['id_siswa_penilai_'.$i]):'';;
	}
	$msg = '';
	mysqli_autocommit($con,FALSE);
	if($_POST['btnSimpan']=="Tambah"){
		$idp = get_tahun_ajar_id();
		$sql = "INSERT INTO penilai (nip, id_periode) VALUES ('$nip', $idp)";
		$q = mysqli_query($con, $sql);
		$id = mysqli_insert_id($con);
	}else if($_POST['btnSimpan']=="Ubah"){
		$msg .= "Ubah";
		$id = $_POST['id_penilai'];
		$sql = "SELECT * FROM penilai_detail WHERE id_penilai = $id";
		$q = mysqli_query($con, $sql);
		$_nip = [];
		while($row = mysqli_fetch_array($q)){
		 	$_nip[] = $row['id_penilai_detail'];
		}
		$sql = "DELETE FROM penilai_detail WHERE id_penilai_detail IN (".join(",",$_nip).")";
		$q = mysqli_query($con, $sql);
	}
	$proses = [];
	if($q){
		mysqli_commit($con);
		$sql = "SELECT * FROM user a JOIN jenis_user b ON a.id_jenis_user = b.id_jenis_user WHERE b.level IN(2,3) ";
		$q = mysqli_query($con, $sql);
		$atasan = [];
		while($row = mysqli_fetch_array($q)){
			$atasan[] = $row['nip'];
		}
		/*--- Diri Sendiri ----*/
		$sql = "INSERT INTO penilai_detail (id_penilai, nip) VALUES ($id, '$nip')"; 	
		if($q = mysqli_query($con, $sql)){
			$proses[] = 1;
		}else{
			$proses[] = 0;
			$msg .= mysqli_error($con);
		}

		foreach ($atasan as $k => $v) {
			$sql = "INSERT INTO penilai_detail (id_penilai, nip) VALUES ($id, '$v')"; 	
			if($q = mysqli_query($con, $sql)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
			}
		}

		foreach ($guru_penilai as $k => $v) {
			$sql = "INSERT INTO penilai_detail (id_penilai, nip) VALUES ($id, '$v')"; 	
			if($q = mysqli_query($con, $sql)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
			}
		}
		foreach ($siswa_penilai as $k => $v) {
			$sql = "INSERT INTO penilai_detail (id_penilai, nip) VALUES ($id, '$v')"; 
			if($q = mysqli_query($con, $sql)){
				$proses[] = 1;
			}else{
				$proses[] = 0;
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
			$_SESSION["flash"]["msg"] = "Data gagal disimpan! <br>$msg";
		}
	}else{
		mysqli_rollback($con);
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan! <br>$msg";
	}
	
	header("location:../index.php?p=memilihpen");

}

if(isset($_GET['id'])){
	$nip = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM penilai WHERE id_penilai = '$nip'";

	$proses = mysqli_query($con, $sql);
	if($proses){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil dihapus!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal dihapus!";
	}
	header("location:../index.php?p=memilihpen");
}

?>