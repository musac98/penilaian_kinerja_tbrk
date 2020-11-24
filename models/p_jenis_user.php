<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_jabatan = isset($_POST['id_jabatan'])?$con->real_escape_string($_POST['id_jabatan']):'';
	$jabatan = isset($_POST['jabatan'])?$con->real_escape_string($_POST['jabatan']):'';
	$level = isset($_POST['level'])?$con->real_escape_string($_POST['level']):'';

	if($jabatan=='' || $level==""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=jenis_user");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO jabatan (jabatan, level) VALUES ('$jabatan', '$level')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE jabatan SET jabatan = '$jabatan', level = '$level' WHERE id_jabatan = $id_jabatan";
		$proses = mysqli_query($con, $sql);
	}

	if($proses){
		$_SESSION["flash"]["type"] = "success";
		$_SESSION["flash"]["head"] = "Sukses";
		$_SESSION["flash"]["msg"] = "Data berhasil disimpan!";
	}else{
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
	}

	header("location:../index.php?p=jenis_user");
}

?>