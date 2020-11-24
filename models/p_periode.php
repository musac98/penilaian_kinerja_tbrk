<?php

require_once("../config/koneksi.php");


if(isset($_POST['btnSimpan'])){
	$id_periode = isset($_POST['id_periode'])?$con->real_escape_string($_POST['id_periode']):'';
	$tahun = isset($_POST['tahun'])?$con->real_escape_string($_POST['tahun']):'';
	$bulan = isset($_POST['bulan'])?$con->real_escape_string($_POST['bulan']):'';
	$pekan = isset($_POST['pekan'])?$con->real_escape_string($_POST['pekan']):'';

	if($tahun=="" || $bulan=="" || $pekan==""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=periode");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "UPDATE periode SET status_periode = 0";
		$proses = mysqli_query($con, $sql);
		if($proses){
			$sql = "INSERT INTO periode (tahun, bulan, pekan, status_periode)  VALUES ('$tahun',  '$bulan',  '$pekan',  '2')";
			$proses = mysqli_query($con, $sql);
		}
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE periode SET tahun = '$tahun',  bulan = '$bulan', pekan = '$pekan'  WHERE id_periode = '$id_periode'";
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

	header("location:../index.php?p=periode");
}

?>