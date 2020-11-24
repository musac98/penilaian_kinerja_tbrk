<?php

require '../vendor/autoload.php';
require '../config/koneksi.php';
use iio\libmergepdf\Merger;
use Dompdf\Dompdf;
$root = "http://".$_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }

    if(isset($_GET['detail'])){
        $dd= $_GET['detail'];
        $idu="?detail=".$_GET['detail']."&idp=".$id_periode;

        $data = file_get_contents($root."cetak_laporan_detail.php".$idu);
        //echo $data;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($data);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tgl = date("dmy");

        $dompdf->stream("laporan_kinerja_".$dd."_".$tgl.'.pdf');
    }else{
        $m = new Merger();

        $data = file_get_contents($root."cetak_laporan_all.php?idp=".$id_periode);
        //echo $data;
        $dompdf = new Dompdf();
        $dompdf->loadHtml($data);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $tgl = date("dmy");

        $dompdf->stream("laporan_kinerja_".$tgl.'.pdf');
    }
?>