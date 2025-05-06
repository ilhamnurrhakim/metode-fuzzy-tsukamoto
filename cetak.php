<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php

require_once "include/koneksi.php";
include "include/function.php";

$hasil = mysqli_query($kon, "SELECT * FROM hasil ORDER BY tgl_proses DESC");
$sil = mysqli_fetch_array($hasil);

?>

<body>
    <div class="container-fluid">
        <center>
            <h3>Hasil Laporan fuzzy</h3>
        </center>

        <div class="card">
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
                                    $tot = $total / $row;
                                    if ($tot > $sil['hasil']) {
                                        $ket = "Baik";
                                    } else {
                                        $ket = "Tidak Baik";
                                    }
                                    ?>

                                <td align="center">
                                    <?php

                                        echo $tot;
                                        ?>
                                </td>
                                <td>
                                    <?= $ket ?>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <table width="100%">
                        <tr>
                            <td width="60%"></td>
                            <td align="center">Padang,
                                <?= date('d F Y') ?><br><br><br><br><br>(     Pimpinan  )</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.print();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>