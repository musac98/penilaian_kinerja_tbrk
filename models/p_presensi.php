<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_pres = isset($_POST['id_pres'])?$con->real_escape_string($_POST['id_pres']):'';	
	$id_kar = isset($_POST['id_kar'])?$con->real_escape_string($_POST['id_kar']):'';
	$jml_masuk = isset($_POST['jml_masuk'])?$con->real_escape_string($_POST['jml_masuk']):'';

	if($id_pres=="" || $jml_masuk==""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=presensi");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO presensi (id_kar, jml_masuk) VALUES ($id_kar, $jml_masuk)";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE presensi SET jml_masuk = '$jml_masuk' WHERE id_pres = '$id_pres'";
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

header("location:../index.php?p=presensi");
}

if(isset($_GET['id_pres'])){
	$id_pres = isset($_GET['id_pres'])?$con->real_escape_string($_GET['id_pres']):'';
	$jml_masuk = isset($_GET['jml_masuk'])?$con->real_escape_string($_GET['jml_masuk']):'';
	$presen = $jml_masuk +1;
	$sql = "UPDATE presensi SET jml_masuk = '$presen' WHERE id_pres = '$id_pres'";
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
	header("location:../index.php?p=presensi");
}

?>