
<?php
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }
    $i=0;


$sql = "SELECT *
        FROM penilai a
        JOIN toko b ON a.id_toko = b.id_toko
        WHERE a.id_periode = $id_periode AND a.sts = 1
        ";
$q = mysqli_query($con, $sql);

$tmp = [];
$data2 = [];
$data3 = [];
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
    $sql2 = "SELECT * FROM grup_dinilai a JOIN karyawan b ON a.id_kar = b.id_kar WHERE a.id_penilai = $row[id_penilai]";
    $q2 = mysqli_query($con, $sql2);
    while($row2 = mysqli_fetch_array($q2)){
        $data3[] = array(
                        'nip' => $row2['id_grup'],
                        'nama_guru' => $row2['nama'],
                        'nilai' => $pen->get_tot_nilai_individu($row2['id_kar']),
                        );
    }
}
$data = [];
if(!empty($tmp)){
    foreach ($tmp as $key => $value) {
        $ni = 0;
        foreach ($value as $a => $b) {
            if($b['nilai']!="-"){
                $ni += $b['nilai'] / sizeof($value);
            }
        }
        foreach ($value as $k => $v) {
            $data[$key] = array(
                                'nip' => $v['nip'],
                                'nama_guru' => $v['nama_guru'],
                                'nilai' => $ni,
                                );
        }
    }
}
/*echo '<pre>';
print_r($data3);
echo '</pre>';*/
?>