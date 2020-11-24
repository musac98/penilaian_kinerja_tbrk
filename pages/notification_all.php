<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-bell"></i> Notification</h1>
</div>
<div class="row row_angket">
	<div class="col mb-4">
		<div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Guru dan siswa yang belum melakukan penilaian</h6>
            </div>
            <div class="card-body">
            	<table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Guru Dinilai</th>
                            <th>Penilai</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

    					$id_periode = get_tahun_ajar_id();
                    	$i=0;
                    	$sql = "SELECT 
					              a.nip AS 'nip_dinilai',
					              d.nama_guru AS 'nama_dinilai',
					              b.nip AS 'nama_penilai',
					              e.nama_guru AS 'nama_penilai',
					              j.jabatan AS 'jabatan',
					              SUM(c.hasil_nilai) AS nilai
					            FROM (penilai a JOIN user d ON a.nip = d.nip)
					            JOIN (penilai_detail b  JOIN user e ON b.nip = e.nip JOIN jenis_user j ON e.id_jenis_user = j.id_jenis_user) ON a.id_penilai = b.id_penilai
					            LEFT JOIN penilaian c ON b.id_penilai_detail = c.id_penilai_detail
					            WHERE a.id_periode = $id_periode
					            GROUP BY a.nip, b.nip
					            HAVING  ISNULL(SUM(c.hasil_nilai))";
                    	$q = mysqli_query($con, $sql);
                    	while($row = mysqli_fetch_array($q)){
                    ?>
                    	<tr>
                    		<td><?= ++$i; ?></td>
                    		<td><?= $row['nama_dinilai']; ?></td>
                    		<td><?= $row['nama_penilai']; ?></td>
                    		<td><?= $row['jabatan']; ?></td>
                    	</tr>
                    <?php
                    	}
                    ?>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
</div>