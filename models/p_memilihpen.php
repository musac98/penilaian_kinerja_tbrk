<?php

require_once("../config/koneksi.php");

if(isset($_POST['btnSimpan'])){
 
	if( sizeof($_POST['group_1']) != sizeof($_POST['group_2']) ){
		$_SESSION["flash"]["type"] = "danger";
		$_SESSION["flash"]["head"] = "Terjadi Kesalahan";
		$_SESSION["flash"]["msg"] = "Data gagal disimpan!";
		header("location:../index.php?p=memilihpen&ket=Tambah");
	}else{
		/// insert
		if(!isset($_POST['penilai_1'])){
			$idp = get_tahun_ajar_id();
			$id_kar = isset($_POST['id_kar'])?$con->real_escape_string($_POST['id_kar']):'';
			$toko = isset($_POST['toko'])?$con->real_escape_string($_POST['toko']):'';
			for($i=1; $i<=2; $i++){
				$grup = "grup$toko$idp$i";
				$sql = "SELECT * FROM penilai WHERE grup = '$grup' ";
				$q = mysqli_query($con, $sql);
				if(mysqli_fetch_array($q)>0){
					$_SESSION["flash"]["type"] = "warning";
					$_SESSION["flash"]["head"] = "Sukses";
					$_SESSION["flash"]["msg"] = "Data sudah ada!";
					header("location:../index.php?p=memilihpen");
					exit();
				}else{
					mysqli_autocommit($con,FALSE);
					$sql = "INSERT INTO penilai (id_toko, id_periode, grup, sts) VALUES ($toko, $idp, '$grup', '0')";
					$proses[] = mysqli_query($con, $sql)?1:0;
					$id_penilai = mysqli_insert_id($con);
					foreach ($_POST["group_$i"] as $k => $v) {
						$sql = "INSERT INTO grup_dinilai (id_penilai, id_kar) VALUES ($id_penilai, '$v')";	
						$proses[] = mysqli_query($con, $sql)?1:0;
					}
					$owner = get_owener();
					$sql = "INSERT penilai_detail (id_penilai, id_kar) VALUES($id_penilai, '$id_kar'), ($id_penilai, '$owner')";
					$proses[] = mysqli_query($con, $sql)?1:0;
				}
			}
		}else{
		/// ubah
			$id_penilai[] = $_POST['penilai_1'];
			$id_penilai[] = $_POST['penilai_2'];
			$group_1 = $_POST['group_1'];
			$group_2 = $_POST['group_2'];

			$id_kar = isset($_POST['id_kar'])?$con->real_escape_string($_POST['id_kar']):'';

			mysqli_autocommit($con,FALSE);
			foreach ($id_penilai as $k => $v) {
				$i = $k + 1;
				$idpd = $_POST['penilai_detail_'.$i];
				$sql = "UPDATE penilai_detail SET id_kar = '$id_kar' WHERE id_penilai_detail = $idpd";
				$proses[] = mysqli_query($con, $sql)?1:0;

				$sql = "DELETE FROM grup_dinilai WHERE id_penilai = $v";
				$proses[] = mysqli_query($con, $sql)?1:0;

				foreach ($_POST["group_$i"] as $ka => $va) {
					$sql = "INSERT INTO grup_dinilai (id_penilai, id_kar) VALUES ($v, '$va')";	
					$proses[] = mysqli_query($con, $sql)?1:0;
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
		header("location:../index.php?p=memilihpen");
	}

}

if(isset($_GET['id'])){
	$id = isset($_GET['id'])?$con->real_escape_string($_GET['id']):'';
	$idper = get_tahun_ajar_id();
	$sql = "DELETE FROM penilai WHERE id_toko = $id AND id_periode = $idper";

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