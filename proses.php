<div class="main-content">
    <section class="section">
        <h3>Proses</h3>
        <hr>
        <div class="card">
            <div class="card-body">

                <form class="needs-validation" novalidate="" method="post">
                    <?php
                    $variabel = $kon->query("SELECT * FROM variabel WHERE ketvariabel = 'Input'");
                    foreach ($variabel as $row) {
                    ?>
                    <div class="form-group">
                        <label><?= $row['namavariabel'] ?></label>
                        <input type="hidden" class="form-control" name="idvariabel[]" value="<?= $row['idvariabel'] ?>"
                            required="">
                        <input type="number" class="form-control" name="input[]" required="">
                    </div>
                    <?php } ?>

                    <button type="submit" name="submit" class="btn btn-primary">Proses</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST['submit'])) { ?>
        <div class="card">
            <div class="card-body">
                <h3>Fungsi Keanggotaan</h3>
                <table class="table table-bordered">
                    <?php
                        //echo "<br><br>";
                        $input = $_POST['input'] ?? [];
                        $ids = $_POST['idvariabel'] ?? [];

                        // Array to store membership values for each variable
                        $membershipValues = [];

                        // Query untuk mendapatkan data variabel
                        $query = $kon->query("SELECT * FROM variabel");

                        $totalVariables = $query->num_rows;
                        $counter = 0;

                        foreach ($query as $key) {
                            $counter++;
                            if ($counter == $totalVariables) break; // Skip the last variable

                            $namavariabel = $key['namavariabel'];
                            $idvariabel = $key['idvariabel'];

                            // Ambil data data maksimum dan minimum untuk variabel ini
                            $him = $kon->query("SELECT * FROM himpunan WHERE idvariabel = '$idvariabel'");
                            $himpunanData = [];
                            foreach ($him as $pun) {
                                $namahimpunan = $pun['namahimpunan'];
                                $nilai = $pun['nilai'];
                                $himpunanData[$namahimpunan] = $nilai;
                            }

                            // Ambil input data untuk variabel ini
                            $data = $input[array_search($idvariabel, $ids)];
                        ?>
                    <thead>
                        <tr>
                            <th colspan="4" align="center"><b>Nama Variabel: <?= $namavariabel ?></b></th>
                        </tr>
                    </thead>
                    <?php
                            // Hitung keanggotaan untuk setiap himpunan
                            foreach ($himpunanData as $namahimpunan => $nilai) {
                                // Mengambil nilai minimum dan maksimum dari himpunan
                                $dataMin = $himpunanData['Min'] ?? 0;
                                $dataMax = $himpunanData['Max'] ?? 100;

                                if ($namahimpunan == 'Turun') {
                                    $membershipValue = keanggotaanTurun($data, $dataMax, $dataMin);
                                } elseif ($namahimpunan == 'Naik') {
                                    $membershipValue = keanggotaanNaik($data, $dataMin, $dataMax);
                                }
                            ?>
                    <tbody>
                        <tr>
                            <td width="50%">Himpunan Keanggotaan <?= $namahimpunan ?> :</td>
                            <td width="10%" align="center"><?= $data ?></td>
                            <td align="center">
                                <?php
                                            if ($namahimpunan == 'Turun') {
                                                echo TampilTurun($data, $dataMax, $dataMin);
                                            } elseif ($namahimpunan == 'Naik') {
                                                echo TampilNaik($data, $dataMin, $dataMax);
                                            }
                                            ?>
                            </td>
                            <td width="10%" align="center"><?= number_format($membershipValue, 2) ?> </td>
                        </tr>
                    </tbody>
                    <?php
                                // Store the membership value
                                $membershipValues[$idvariabel][$namahimpunan] = $membershipValue;
                            }
                        }
                        ?>
                </table>

                <h3>Rule Dan Defuzzyfikasi</h3>
                <!-- Table for rules -->
                <table class="table table-bordered" width="100%" style="float: left; margin-right: 20px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Rule</th>
                            <th colspan="2">Details</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $sum_z = 0;
                            $array_z = 0;
                            $a = "INNER JOIN variabel ON detail_rule.idvariabel = variabel.idvariabel";
                            $b = "INNER JOIN himpunan ON detail_rule.idhimpunan = himpunan.idhimpunan";
                            $min_rule = $kon->query("SELECT MIN(himpunan.nilai) AS min_nilai FROM detail_rule $a $b WHERE ketvariabel='Output'");
                            $min_value_row = $min_rule->fetch_assoc();
                            $min_value = $min_value_row['min_nilai'];

                            $max_rule = $kon->query("SELECT MAX(himpunan.nilai) AS max_nilai FROM detail_rule $a $b WHERE ketvariabel='Output'");
                            $max_value_row = $max_rule->fetch_assoc();
                            $max_value = $max_value_row['max_nilai'];;

                            $no = 1;
                            $query = $kon->query("SELECT * FROM rule");
                            foreach ($query as $key) {
                            ?>
                        <tr>
                            <td rowspan="3"><?= $no ?></td>
                            <td width="20%"><?= $key['namarule'] ?></td>
                            <td colspan="2"> IF
                                <?php
                                        $rule = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Input'");
                                        $rulesArray = [];
                                        $membershipForRule = [];
                                        foreach ($rule as $rul) {
                                            $rulesArray[] = "{$rul['namavariabel']} is <b>{$rul['namahimpunan']}</b>";
                                            $membershipForRule[] = $membershipValues[$rul['idvariabel']][$rul['namahimpunan']];
                                        }
                                        $rulesString = implode(' And ', $rulesArray);
                                        echo $rulesString;
                                        ?>

                                <?php

                                        $rule = $kon->query("SELECT * FROM detail_rule $a $b WHERE idrule = '$key[idrule]' AND ketvariabel='Output'");
                                        foreach ($rule as $rul) {
                                        ?>
                                Then <?= $rul['namavariabel'] ?> <b><?= $rul['namahimpunan'] ?></b>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>𝛼 − 𝒑𝒓𝒆𝒅𝒊𝒌𝒂t<sub><?= $no ?></sub></td>
                            <td>
                                MIN = (
                                <?php
                                        $length = count($membershipForRule);
                                        foreach ($membershipForRule as $index => $value) {
                                            echo number_format($value, 2);
                                            if ($index < $length - 1) {
                                                echo " ,";
                                            }
                                        }

                                        ?>
                                )
                            </td>
                            <td align="right">
                                <?php
                                        // Find the minimum membership value for this rule
                                        if (!empty($membershipForRule)) {
                                            $minMembership = min($membershipForRule);
                                            echo number_format($minMembership, 2);
                                        }

                                        $a_min[] = $minMembership;
                                        ?>
                            </td>
                        </tr>
                        <tr>
                            <td>𝑵𝒊𝒍𝒂𝒊 𝒁<sub><?= $no ?></sub></td>
                            <td>
                                <?php
                                        foreach ($rule as $rul) {
                                            if ($rul['namahimpunan'] == 'Baik') {
                                                $zZ = $minMembership . " = Z - 33 / (67 - 33) ";
                                            } else {
                                                $zZ =   $minMembership . " = 67 - Z /(67 - 33) ";
                                            }
                                            
                                            echo $zZ;
                                        }
                                        ?>
                            </td>
                            <td align="right">
                                <?php
                                        foreach ($rule as $rul) {
                                            if ($rul['namahimpunan'] == 'Baik') {
                                                $z =  33 + ((67 - 33) * $minMembership);
                                            } else {
                                                $z =  67 - ((67 - 33) * $minMembership);
                                            }
                                            echo $z;
                                            $z_rule[] = $z;
                                        }

                                        $sum_z +=  $minMembership;
                                        $z_kali = $z * $minMembership;
                                        $array_z += $z_kali;
                                        ?>
                            </td>
                        </tr>
                        <?php
                                $no++;
                            }
                            $hasil =  number_format(($array_z / $sum_z), 3);
                            ?>
                        <tr>
                            <td align="center" colspan="2" rowspan="2">
                                <b>Defuzzifikasi</b>
                            </td>
                            <td align="center" colspan="2">
                                <?php
                                    $length = count($z_rule);
                                    foreach ($z_rule as $index => $zzz) {
                                        echo "( " . $zzz . " * " .  number_format($a_min[$index], 2) . " )";
                                        if ($index < $length - 1) {
                                            echo " + ";
                                        }
                                    }
                                    ?>
                                <hr>
                                <?php
                                    $lengthh = count($a_min);
                                    foreach ($a_min as $indexx => $zzzz) {
                                        echo number_format($zzzz, 2);
                                        if ($indexx < $lengthh - 1) {
                                            echo " + ";
                                        }
                                    }
                                    ?>
                            </td>
                        </tr>
                        <tr>

                            <td align="center">
                                <br>
                                <?= $array_z ?>
                                <hr>
                                <?= $sum_z ?>
                            </td>
                            <td align="right">
                                <?= $hasil ?>
                            </td>
                             </tr>
                             <tr>
                     
                            <td align="center" colspan="2" rowspan="2">
                                <b>Kinerja</b>
                            </td>
                            <td align="center">
                                <b><?= $hasil ?></b>
                            </td>
                            <td align="center">
                            </td>
                            <td align="center">
                                <?php
                                
                                 if ($sil ['hasil'] > 50) {
                                    $ket = "Baik";
                                } else {
                                    $ket = "Tidak Baik";
                                }
                                ?>
                                <td align="right" colspan="2">
                                <b><?= $ket ?></b>
                            </td>
                                </tr>
                                   
                            </td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <?php
                mysqli_query($kon, "INSERT INTO hasil (hasil, tgl_proses) VALUES ('$hasil', NOW())");
            } ?>
                
            </div>
        </div>
    </section>
</div>