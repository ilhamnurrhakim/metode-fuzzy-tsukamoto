<?php
$hasil = mysqli_query($kon, "SELECT * FROM hasil ORDER BY tgl_proses DESC");
$sil = mysqli_fetch_array($hasil);

?>
<div class="main-content">
    <section class="section">
        <!-- <h3>Nilai Batas = <?= $sil['hasil']; ?></h3> -->
        <hr>
        <div class="card">
            <div class="card-header">
                <a href="cetak.php" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak
                    Laporan</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                   No
                                </th>
                                <th>Nama Lengkap</th>
                                <?php
                                $varial = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Input' ORDER BY idvariabel");
                                $row = mysqli_num_rows($varial);
                                foreach ($varial as $var) {
                                ?>
                                <th><?= $var['namavariabel'] ?></th>
                                <?php } ?>

                                <?php
                                $variall = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Output' ORDER BY idvariabel");
                                foreach ($variall as $varr) {
                                ?>
                                <th><?= $varr['namavariabel'] ?></th>
                                <?php } ?>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $a = "INNER JOIN variabel ON detail_dataset.idvariabel = variabel.idvariabel";
                            $query = $kon->query("SELECT * FROM dataset");
                            foreach ($query as $key) {

                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $key['namadataset'] ?></td>

                                <?php
                                    $total = 0;
                                    foreach ($varial as $var) {
                                        $dataset = $kon->query("SELECT * FROM detail_dataset  WHERE iddataset = '$key[iddataset]' and idvariabel = '$var[idvariabel]'");
                                        $rul = mysqli_fetch_array($dataset);
                                        $total += $rul['nilai'];
                                    ?>
                                <td align="center">
                                    <?= $rul['nilai'] ?>
                                </td>
                                <?php
                                    }
                                    $tot = $total / 5.6;
                                    if ($tot > $sil['hasil']) {
                                        $ket = "Baik";
                                    }else{
                                        $ket = "Tidak Baik";
                                    }
                                  
                                    ?>

                                <td align="center">
                                    <?php
                                     echo number_format($tot, 3);
                                         $tot;
                                        ?>
                                        
                                </td>
                                
                                <td>
                                    <?= $ket?>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>