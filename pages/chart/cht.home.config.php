
<?php
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }
$i=0;
$sql = "SELECT
            c.id_penilai,
            d.nip,
            d.nama_guru
        FROM penilaian a
        JOIN penilai_detail b ON a.id_penilai_detail = b.id_penilai_detail
        JOIN penilai c ON b.id_penilai = c.id_penilai
        JOIN user d ON c.nip = d.nip
        WHERE c.id_periode = $id_periode
        GROUP BY d.nip
        HAVING COUNT(a.id_nilai) = 
        (
            SELECT 
                SUM(
                CASE 
                    WHEN bb.id_jenis_user=11 THEN (SELECT COUNT(*) FROM jenis_kompetensi dd JOIN isi_kompetensi ee ON dd.id_kompetensi = ee.id_kompetensi WHERE ee.ket LIKE '%2%')
                    WHEN bb.id_jenis_user=6 THEN (SELECT COUNT(*) FROM jenis_kompetensi dd JOIN isi_kompetensi ee ON dd.id_kompetensi = ee.id_kompetensi WHERE ee.ket LIKE '%1%')
                    ELSE (SELECT COUNT(*) FROM jenis_kompetensi dd JOIN isi_kompetensi ee ON dd.id_kompetensi = ee.id_kompetensi WHERE ee.ket LIKE '%0%')
                END) AS 'SUDAH_NILAI'
            FROM penilai_detail aa
            JOIN user bb ON aa.nip = bb.nip
            JOIN penilai cc ON aa.id_penilai = cc.id_penilai
            WHERE cc.nip = d.nip  AND cc.id_periode = $id_periode
            GROUP BY cc.id_penilai
            ORDER BY cc.id_penilai
        )";
$q = mysqli_query($con, $sql);
$data = [];
while($row = mysqli_fetch_array($q)){
	$data[] = array(
						'nip' => $row['nip'],
						'nama_guru' => $row['nama_guru'],
						'nilai' => get_tot_nilai($con, $row['nip'], $id_periode),
						);
}
?>