<?php
    require_once("config/koneksi.php");

    $nip_user = $_SESSION['user'];
    $sql = "SELECT * FROM penilai a JOIN penilai_detail b ON a.id_penilai = b.id_penilai JOIN user d ON a.nip = d.nip WHERE b.nip = '$nip_user' AND b.id_penilai_detail NOT IN(SELECT c.id_penilai_detail FROM penilaian c WHERE c.id_penilai_detail = b.id_penilai_detail) GROUP BY a.id_penilai";

    $id_periode = get_tahun_ajar_id();

    $sql2 = "SELECT 
              a.nip AS 'nip_dinilai',
              d.nama_guru AS 'nama_dinilai',
              b.nip AS 'nama_penilai',
              e.nama_guru AS 'nama_penilai',
              SUM(c.hasil_nilai) AS nilai
            FROM (penilai a JOIN user d ON a.nip = d.nip)
            JOIN (penilai_detail b  JOIN user e ON b.nip = e.nip) ON a.id_penilai = b.id_penilai
            LEFT JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail
            WHERE a.id_periode = $id_periode
            GROUP BY a.nip, b.nip
            HAVING  ISNULL(SUM(c.hasil_nilai))";


    $q = mysqli_query($con, $sql);
    $nr = mysqli_num_rows($q);

    if($_SESSION['type']==2 || $_SESSION['type']==3){

        $q2 = mysqli_query($con, $sql2);
        $nr = $nr+mysqli_num_rows($q2);
    }
    
?>
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <?php if($nr>0):?>
        <span class="badge badge-danger badge-counter"><?= $nr; ?></span>
        <?php endif;?>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header" style="background-color: yellow;color: black">
            Anda belum melakukan penilaian kepada :
        </h6>
        <?php
            while ($row = mysqli_fetch_array($q)):
        ?>
        <a class="dropdown-item d-flex align-items-center" href="index.php?p=melakukanpen&ket=tambah&id=<?= $row['id_penilai'];?>">
            <div class="mr-3">
                <div class="icon-circle">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
            <div>
                <span class="font-weight-bold"><strong><?= $row['nama_guru']; ?></strong></span>
            </div>
        </a>
        <?php endwhile; ?>
        <?php if($_SESSION['type']==2 || $_SESSION['type']==3): ?>
        <h6 class="dropdown-header">
            Guru dan siswa yang belum melakukan penilaian :
        </h6>
        <div class="notif_scrooll">
        <?php
            $i=1;
            while ($row = mysqli_fetch_array($q2)):
        ?>
        <a class="dropdown-item d-flex align-items-center" href="">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
            <div>
                <span class="font-weight-bold"><strong><?= $row['nama_penilai']; ?></strong> kepada : <strong><?= $row['nama_dinilai']; ?></strong></span>
            </div>
        </a>
        <?php
            
            endwhile; ?>
        </div>
        <?php endif; ?>
        <!-- <div class="dropdown-item text-center small text-gray-500"></div> -->
        <a class="dropdown-item text-center small text-gray-500" href="index.php?p=notification_all">Show All Alerts</a>
    </div>
</li>