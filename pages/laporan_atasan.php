<?php
    require_once("../config/koneksi.php");
    if(isset($_GET['idp'])){
        $id_periode = $_GET['idp'];
    }else{
        $id_periode = get_tahun_ajar_id();
    }


?>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Keseluruhan</h6>
                <div class="dropdown no-arrow">
                    <a href="pages/pdf.php?idp=<?= $id_periode; ?>" target="blank" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Export PDF"><i class="fa fa-file-pdf"></i></a>
                </div>
            </div>
            <div class="card-body">
                <?php
                if ($_SESSION['type']==2) {
                    $data['data'] = [];
                        $i=0;
                        $sql = "SELECT *,
                                c.id_kar AS 'dinilai'
                                FROM penilai a
                                JOIN toko b ON a.id_toko = b.id_toko
                                JOIN grup_dinilai c ON a.id_penilai  = c.id_penilai
                                JOIN karyawan d ON c.id_kar = d.id_kar
                                WHERE a.id_periode = $id_periode
                                ORDER BY a.grup
                                ";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)){
                            $tot = 7;
                            if(!isset($data['grup'][$row['grup']])){
                                $data['grup'][$row['grup']] = 1;
                            }else{
                                $data['grup'][$row['grup']] += 1;
                            }

                            $pen = new Penilian($con, $row['id_penilai'], $id_periode);
                            $ni = $pen->get_tot_nilai_individu($row['dinilai']);
                            $ng = $pen->get_tot_nilai();
                            $data['data'][] = array(
                                                    'id_penilai' => $row['id_penilai'],
                                                    'id_periode' => $row['id_periode'],
                                                    'id_grup' => $row['id_grup'],
                                                    'nama' => $row['nama'],
                                                    'nil_id' => $ni.'<br><strong>'.get_kategori_nilai($ni).'</strong>',
                                                    'nil_gr' =>  $ng.'<br><strong>'.get_kategori_nilai($ng).'</strong>',
                                                    'tot' => $ni,
                                                    'grup' => $row['grup'],
                                                    'sts' => $row['sts'],
                                                    );
                        }
                        //print_r($data);
                    
                ?>    
                <table class="table table-bordered dataTable ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Nilai Individu</th>
                            <th>Nilai Grup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $tmp_grup = "";
                        foreach ($data['data'] as $k => $row):
                            $tot = 7;   
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['nil_id']; ?></td>
                            <?php
                                if($tmp_grup!=$row['grup']){
                                    $tmp_grup = $row['grup'];
                            ?>
                            <td rowspan="<?= $data['grup'][$row['grup']]; ?>"><?= $row['nil_gr']; ?></td>
                            <?php } ?>
                            <td>
                                <?php if($tot!="-"): ?>
                                    <a href="index.php?p=laporan&detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                                    <?php if($row['sts']!=0): ?>
                                    <a href="pages/pdf.php?detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Export Pdf"><i class="fa fa-file-pdf"></i></a>
                                    <?php else: ?>
                                    <a href="index.php?p=laporan&acc=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Konfirmasi"><i class="fa fa-check"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                        endforeach;
                    ?>
                    </tbody>
                </table>
                <?php
                }else{
                    $data['data'] = [];
                        $i=0;
                        $sql = "SELECT *,
                                c.id_kar AS 'dinilai'
                                FROM penilai a
                                JOIN toko b ON a.id_toko = b.id_toko
                                JOIN grup_dinilai c ON a.id_penilai  = c.id_penilai
                                JOIN karyawan d ON c.id_kar = d.id_kar
                                WHERE a.id_periode = $id_periode AND a.sts = 1
                                ORDER BY a.grup
                                ";
                        $q = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($q)){
                            $tot = 7;
                            if(!isset($data['grup'][$row['grup']])){
                                $data['grup'][$row['grup']] = 1;
                            }else{
                                $data['grup'][$row['grup']] += 1;
                            }

                            $pen = new Penilian($con, $row['id_penilai'], $id_periode);
                            $ni = $pen->get_tot_nilai_individu($row['dinilai']);
                            $ng = $pen->get_tot_nilai();
                            $data['data'][] = array(
                                                    'id_penilai' => $row['id_penilai'],
                                                    'id_periode' => $row['id_periode'],
                                                    'id_grup' => $row['id_grup'],
                                                    'nama' => $row['nama'],
                                                    'nil_id' => $ni.'<br><strong>'.get_kategori_nilai($ni).'</strong>',
                                                    'nil_gr' =>  $ng.'<br><strong>'.get_kategori_nilai($ng).'</strong>',
                                                    'tot' => $ni,
                                                    'grup' => $row['grup'],
                                                    'sts' => $row['sts'],
                                                    );
                        }
                        //print_r($data);
                    
                ?>    
                <table class="table table-bordered dataTable ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Nilai Individu</th>
                            <th>Nilai Grup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i=0;
                        $tmp_grup = "";
                        foreach ($data['data'] as $k => $row):
                            $tot = 7;   
                    ?>
                        <tr>
                            <td><?= ++$i; ?></td>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['nil_id']; ?></td>
                            <?php
                                if($tmp_grup!=$row['grup']){
                                    $tmp_grup = $row['grup'];
                            ?>
                            <td rowspan="<?= $data['grup'][$row['grup']]; ?>"><?= $row['nil_gr']; ?></td>
                            <?php } ?>
                            <td>
                                <?php if($tot!="-"): ?>
                                    <a href="index.php?p=laporan&detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                                    <?php if($row['sts']!=0): ?>
                                    <a href="pages/pdf.php?detail=<?= $row['id_penilai'] ?>&idp=<?= $row['id_periode']; ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Export Pdf"><i class="fa fa-file-pdf"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                        endforeach;
                    ?>
                    </tbody>
                </table>
                <?php
                }?>
                        

            </div>
        </div>
    </div>
</div>