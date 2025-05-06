<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

function pesan($alert)
{
    if (empty($_GET['alert'])) {
        echo "";
    } elseif ($_GET['alert'] == 1) { ?>
        <script>
            Swal.fire({
                title: 'Selamat!',
                text: 'Anda Berhasil Manambah Data',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 2) { ?>
        <script>
            Swal.fire({
                title: 'Selamat!',
                text: 'Anda Berhasil Mengedit Data',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 3) { ?>
        <script>
            Swal.fire({
                title: 'Selamat!',
                text: 'Anda Berhasil Menghapus Data',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 4) { ?>
        <script>
            Swal.fire({
                title: 'Maaf!',
                text: 'Username & Password TidaK Boleh Kosong',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 5) { ?>
        <script>
            Swal.fire({
                title: 'Maaf!',
                text: 'Username & Password Salah',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 6) { ?>
        <script>
            Swal.fire({
                title: 'Selamat!',
                text: 'Anda Berhasil Logout',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 7) { ?>
        <script>
            Swal.fire({
                title: 'Maaf!',
                text: 'Data Tidak Cukup',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } elseif ($_GET['alert'] == 8) { ?>
        <script>
            Swal.fire({
                title: 'Selamat!',
                text: 'Data Berhasil Ditambah',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    <?php }
}

function delete($name, $id, $data)
{
    ?>
    <script>
        document.getElementById('<?= $name ?><?= $id ?>').addEventListener('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Apakah Anda Menghapus Data <?= $data ?>?',
                showDenyButton: true,
                confirmButtonText: 'Yess',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href = '?p=aksi&form=<?= $name ?>&id=<?= $id ?>';
                }
            })
        })
    </script>
<?php }


function posisi($selected)
{
    $rows = array("Admin", "Pimpinan");
    $opt = '';
    foreach ($rows as $row) {
        $opt .= '<option class="form-control" value="' . $row . '"' . ($row == $selected ? ' selected' : '') . '>' . $row . '</option>';
    }
    return $opt;
}

function ketvariabel($selected)
{
    $rows = array("Input", "Output");
    $opt = '';
    foreach ($rows as $row) {
        $opt .= '<option class="form-control" value="' . $row . '"' . ($row == $selected ? ' selected' : '') . '>' . $row . '</option>';
    }
    return $opt;
}

function status($selected)
{
    $rows = array("Aktif", "Tidak Aktif");
    $opt = '';
    foreach ($rows as $row) {
        $opt .= '<option class="form-control" value="' . $row . '"' . ($row == $selected ? ' selected' : '') . '>' . $row . '</option>';
    }
    return $opt;
}


function variabel($selected)
{
    include "koneksi.php";
    $rows = $kon->query("SELECT * FROM variabel ORDER BY idvariabel ASC");
    $opt = '';
    foreach ($rows as $row) {
        if ($row['idvariabel'] == $selected) {
            $opt .= "<option value='" . $row['idvariabel'] . "' selected>" . $row['namavariabel'] . "</option>";
        } else {
            $opt .= "<option value='" . $row['idvariabel'] . "'>" . $row['namavariabel'] . "</option>";
        }
    }
    return $opt;
}

function himpunan($selected, $id)
{
    include "koneksi.php";
    $rows = $kon->query("SELECT * FROM himpunan WHERE idvariabel = '$id'");
    $opt = '';
    foreach ($rows as $row) {
        if ($row['idhimpunan'] == $selected) {
            $opt .= "<option value='" . $row['idhimpunan'] . "' selected>" . $row['namahimpunan'] . "</option>";
        } else {
            $opt .= "<option value='" . $row['idhimpunan'] . "'>" . $row['namahimpunan'] . "</option>";
        }
    }
    return $opt;
}

function himpunann($selected, $id)
{
    include "koneksi.php";
    $rows = $kon->query("SELECT * FROM himpunan WHERE idvariabel = '$id'");
    $opt = '';
    foreach ($rows as $row) {
        if ($row['idhimpunan'] == $selected) {
            $opt .= "<option value='" . $row['idhimpunan'] . "' selected>" . $row['namahimpunan'] . "</option>";
        } else {
            $opt .= "<option value='" . $row['idhimpunan'] . "'>" . $row['namahimpunan'] . "</option>";
        }
    }
    return $opt;
}



function keanggotaanTurun($data, $dataMax, $dataMin)
{
    if ($data < 33) {
        $ket = 1;
    } else if ($data > 33 && $data < 67) {
        $ket = (67 - $data) / (67 - 33);
    } else if ($data > 67 && $data < 100) {
        $ket = 0;
    }
    return $ket;
}

// Fungsi untuk menghitung keanggotaan naik
function keanggotaanNaik($data, $dataMin, $dataMax)
{
    if ($data < 33) {
        $ket = 0;
    } else if ($data > 33 && $data < 67) {
        $ket = ($data - 33) / (67 - 33);
    } else if ($data > 67 && $data < 100) {
        $ket = 1;
    }
    return $ket;
}

function TampilTurun($data, $dataMax, $dataMin)
{
    if ($data < 33) {
        $ket = "0 ; x > 67";
    } else if ($data > 33 && $data < 67) {
        $ket = "(67 - " . $data . ") / (67 - 33)";
    } else if ($data > 67 && $data < 100) {
        $ket = "0 ; x < 30";
    }
    return $ket;
}

// Fungsi untuk menghitung keanggotaan naik
function TampilNaik($data, $dataMin, $dataMax)
{
    if ($data < 33) {
        $ket = "0 ; x > 67";
    } else if ($data > 33 && $data < 67) {
        $ket = "(" . $data . " - 33) / (67 - 33)";
    } else if ($data > 67 && $data < 100) {
        $ket = "1 ; x < 30";
    }
    return $ket;
}
