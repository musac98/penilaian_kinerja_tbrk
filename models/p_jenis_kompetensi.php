<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_sub_kriteria = isset($_POST['id_sub_kriteria'])?$con->real_escape_string($_POST['id_sub_kriteria']):'';
	$id_kriteria = isset($_POST['id_kriteria'])?$con->real_escape_string($_POST['id_kriteria']):'';
	$sub_kriteria = isset($_POST['sub_kriteria'])?$con->real_escape_string($_POST['sub_kriteria']):'';

	if($id_kriteria == "" || $sub_kriteria == ""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=jenis_kompetensi");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO data_penilaian_kinerja (id_kriteria, sub_kriteria)  VALUES ('$id_kriteria', '$sub_kriteria')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE data_penilaian_kinerja SET id_kriteria = '$id_kriteria', sub_kriteria = '$sub_kriteria'  WHERE id_sub_kriteria = '$id_sub_kriteria'";
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

	header("location:../index.php?p=jenis_kompetensi");
}

if(isset($_GET['id'])){
	$id_sub_kriteria = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM data_penilaian_kinerja WHERE id_sub_kriteria = '$id_sub_kriteria'";

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
	header("location:../index.php?p=jenis_kompetensi");
}

?>