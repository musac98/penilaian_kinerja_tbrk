<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_kriteria = isset($_POST['id_kriteria'])?$con->real_escape_string($_POST['id_kriteria']):'';
	$kriteria = isset($_POST['kriteria'])?$con->real_escape_string($_POST['kriteria']):'';
	$sub_kriteria = isset($_POST['sub_kriteria'])?$con->real_escape_string($_POST['sub_kriteria']):'';
	$bobot = isset($_POST['bobot'])?$con->real_escape_string($_POST['bobot']):'';

	if($kriteria == "" || $sub_kriteria == "" || $bobot == ""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=jenis_kompetensi");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO data_penilaian_kinerja (kriteria, sub_kriteria, bobot)  VALUES ('$kriteria', '$sub_kriteria', '$bobot')";
		$proses = mysqli_query($con, $sql);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE data_penilaian_kinerja SET kriteria = '$kriteria', sub_kriteria = '$sub_kriteria', bobot = '$bobot'  WHERE id_kriteria = '$id_kriteria'";
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
	$id_kriteria = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$sql = "DELETE FROM data_penilaian_kinerja WHERE id_kriteria = '$id_kriteria'";

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