<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_kriteria = isset($_POST['id_kriteria'])?$con->real_escape_string($_POST['id_kriteria']):'';
	$nama_kriteria = isset($_POST['nama_kriteria'])?$con->real_escape_string($_POST['nama_kriteria']):'';
	$bobot = isset($_POST['bobot'])?$con->real_escape_string($_POST['bobot']):'';

	if($nama_kriteria == "" ||  $bobot == ""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=kriteria");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO kriteria (nama_kriteria, bobot)  VALUES ('$nama_kriteria', '$bobot')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE kriteria SET nama_kriteria = '$nama_kriteria', bobot = '$bobot'  WHERE id_kriteria = '$id_kriteria'";
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

	header("location:../index.php?p=kriteria");
}

if(isset($_GET['id'])){
	$id_kriteria = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM kriteria WHERE id_kriteria = '$id_kriteria'";

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
	header("location:../index.php?p=kriteria");
}

?>