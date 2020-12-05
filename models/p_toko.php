<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_toko = isset($_POST['id_toko'])?$con->real_escape_string($_POST['id_toko']):'';
	$lokasi = isset($_POST['lokasi'])?$con->real_escape_string($_POST['lokasi']):'';
	$setting_jml = isset($_POST['setting_jml'])?$con->real_escape_string($_POST['setting_jml']):'';

	if($lokasi==""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=toko");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO toko (lokasi,setting_jml)  VALUES ('$lokasi','$setting_jml')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE toko SET lokasi = '$lokasi', setting_jml = '$setting_jml' WHERE id_toko = '$id_toko'";
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
	header("location:../index.php?p=toko");
}

if(isset($_GET['id_toko'])){
	$id_toko = isset($_GET['id_toko'])?$con->real_escape_string($_GET['id_toko']):'';
	$sql = "DELETE FROM toko WHERE id_toko = '$id_toko'";

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
	header("location:../index.php?p=toko");
}

?>