
<?php
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }
$i=0;
/*$sql = "SELECT
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
*/

$sql = "SELECT *
        FROM penilai a
        JOIN toko b ON a.id_toko = b.id_toko
        WHERE a.id_periode = $id_periode AND a.sts = 1
        ";
$q = mysqli_query($con, $sql);

$tmp = [];
$data2 = [];
while($row = mysqli_fetch_array($q)){
    $pen = new Penilian($con, $row['id_penilai'], $id_periode);
    $tot = $pen->get_tot_nilai();
    $data2[] = array(
                        'nip' => $row['id_penilai'],
                        'nama_guru' => get_dinilai_2($con, $row['id_penilai']),
                        'nilai' => $tot,
                        );
    $tmp[$row['id_toko']][] = array(
                        'nip' => $row['id_toko'],
                        'nama_guru' => $row['lokasi'],
                        'nilai' => $tot,
                        );
}
$data = [];
foreach ($tmp as $key => $value) {
    $ni = 0;
    foreach ($value as $a => $b) {
        $ni += $b['nilai'] / sizeof($value);
    }
    foreach ($value as $k => $v) {
        $data[$key] = array(
                            'nip' => $v['nip'],
                            'nama_guru' => $v['nama_guru'],
                            'nilai' => $ni,
                            );
    }
}
?>