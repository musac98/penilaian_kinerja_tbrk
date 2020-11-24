<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
	$id_kar = isset($_POST['id_kar'])?$con->real_escape_string($_POST['id_kar']):'';
	$id_jabatan = isset($_POST['id_jabatan'])?$con->real_escape_string($_POST['id_jabatan']):'';
	$id_toko = isset($_POST['id_toko'])?$con->real_escape_string($_POST['id_toko']):'';
	$password = isset($_POST['password'])?$con->real_escape_string($_POST['password']):'';
	$nama = isset($_POST['nama'])?$con->real_escape_string($_POST['nama']):'';
	$alamat = isset($_POST['alamat'])?$con->real_escape_string($_POST['alamat']):'';
	$no_telp = isset($_POST['no_telp'])?$con->real_escape_string($_POST['no_telp']):'';

	if($id_jabatan=="" || $id_toko=="" ||$password=="" || $nama=="" || $alamat=="" ||$no_telp==""){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Silahkan lengkapi form!";
		header("location:../index.php?p=user");
		exit();
	}

	if($_POST['btnSimpan']=="Tambah"){
		$sql = "INSERT INTO karyawan (id_kar,  id_jabatan, id_toko, password, nama, alamat, no_telp)  VALUES ('$id_kar',  '$id_jabatan', '$id_toko', '$password',  '$nama', '$alamat', '$no_telp')";
		$sql2 = "INSERT INTO presensi (id_kar, jml_masuk) VALUES ('$id_kar','0')";
		$proses = mysqli_query($con, $sql);
		$proses2 = mysqli_query($con, $sql2);
	}else if($_POST['btnSimpan']=="Ubah"){
		$sql = "UPDATE karyawan SET id_jabatan = '$id_jabatan', id_toko = '$id_toko', password = '$password',  nama = '$nama', alamat = '$alamat', no_telp = '$no_telp'  WHERE id_kar = '$id_kar'";
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

	header("location:../index.php?p=user");
}

if(isset($_GET['id_kar'])){
	$id_kar = isset($_GET['id_kar'])?$con->real_escape_string($_GET['id_kar']):'';
	$sql = "DELETE FROM karyawan WHERE id_kar = '$id_kar'";

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
	header("location:../index.php?p=user");
}

?>