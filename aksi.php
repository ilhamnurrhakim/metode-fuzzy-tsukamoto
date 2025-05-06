<?php
require_once "include/koneksi.php";
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_GET['form'] == "user_add") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $namalengkap = $_POST["namalengkap"];
    $posisi = $_POST["posisi"];
    $status = $_POST["status"];
    $query = mysqli_query($kon, "INSERT INTO user (username, password, namalengkap, posisi, status) VALUES ('$username','$password','$namalengkap', '$posisi', '$status')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=user&alert=1'>";
    }
} else if ($_GET['form'] == "user_edit") {
    $iduser = $_GET["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $namalengkap = $_POST["namalengkap"];
    $posisi = $_POST["posisi"];
    $status = $_POST["status"];;
    $query = mysqli_query($kon, "UPDATE user SET username='$username', password='$password',namalengkap='$namalengkap',posisi='$posisi',status='$status'  WHERE  iduser='$iduser' ");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=user&alert=2'>";
    }
} else if ($_GET['form'] == "user_del") {

    $query = mysqli_query($kon, "DELETE FROM user WHERE iduser='$_GET[id]'")
        or die('Ada Kesalahan pada Query Data User:' . mysqli_error($kon));
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=user&alert=3'>";
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_GET['form'] == "variabel_add") {
    $namavariabel = $_POST["namavariabel"];
    $ketvariabel = $_POST["ketvariabel"];
    $query = mysqli_query($kon, "INSERT INTO variabel (namavariabel, ketvariabel) VALUES ('$namavariabel','$ketvariabel')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=variabel&alert=1'>";
    }
} else if ($_GET['form'] == "variabel_edit") {
    $idvariabel = $_GET["id"];
    $namavariabel = $_POST["namavariabel"];
    $ketvariabel = $_POST["ketvariabel"];
    $query = mysqli_query($kon, "UPDATE variabel SET namavariabel='$namavariabel', ketvariabel='$ketvariabel' WHERE  idvariabel='$idvariabel' ");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=variabel&alert=2'>";
    }
} else if ($_GET['form'] == "variabel_del") {

    $query = mysqli_query($kon, "DELETE FROM variabel WHERE idvariabel='$_GET[id]'")
        or die('Ada Kesalahan pada Query Data variabel:' . mysqli_error($kon));
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=variabel&alert=3'>";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_GET['form'] == "himpunan_add") {
    $idvariabel = $_POST["idvariabel"];
    $namahimpunan = $_POST["namahimpunan"];
    $kethimpunan = $_POST["kethimpunan"];
    $nilai = $_POST["nilai"];
    $query = mysqli_query($kon, "INSERT INTO himpunan (idvariabel, namahimpunan, kethimpunan, nilai) VALUES ('$idvariabel','$namahimpunan','$kethimpunan', '$nilai')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=himpunan&alert=1'>";
    }
} else if ($_GET['form'] == "himpunan_edit") {
    $idhimpunan = $_GET["id"];
    $idvariabel = $_POST["idvariabel"];
    $namahimpunan = $_POST["namahimpunan"];
    $kethimpunan = $_POST["kethimpunan"];
    $nilai = $_POST["nilai"];
    $query = mysqli_query($kon, "UPDATE himpunan SET idvariabel='$idvariabel', namahimpunan='$namahimpunan',kethimpunan='$kethimpunan',nilai='$nilai' WHERE idhimpunan='$idhimpunan' ");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=himpunan&alert=2'>";
    }
} else if ($_GET['form'] == "himpunan_del") {

    $query = mysqli_query($kon, "DELETE FROM himpunan WHERE idhimpunan='$_GET[id]'")
        or die('Ada Kesalahan pada Query Data himpunan:' . mysqli_error($kon));
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=himpunan&alert=3'>";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_GET['form'] == "rule_add") {
    $namarule = $_POST["namarule"];
    $query = mysqli_query($kon, "INSERT INTO rule (namarule) VALUES ('$namarule')");
    $idrule = mysqli_insert_id($kon);

    for ($i = 0; $i < count($_POST['idvariabel']); $i++) {
        $idvariabel = $_POST['idvariabel'][$i];
        $idhimpunan = $_POST['idhimpunan'][$i];
        mysqli_query($kon, "INSERT INTO detail_rule (idrule, idvariabel, idhimpunan) VALUES ('$idrule', '$idvariabel', '$idhimpunan')");
    }

    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=rule&alert=1'>";
    }
} else if ($_GET['form'] == "rule_edit") {
    $idrule = $_GET["id"];
    $namarule = $_POST["namarule"];

    $query = mysqli_query($kon, "UPDATE rule SET namarule='$namarule' WHERE idrule='$idrule' ");

    for ($i = 0; $i < count($_POST['idvariabel']); $i++) {
        $idvariabel = $_POST['idvariabel'][$i];
        $idhimpunan = $_POST['idhimpunan'][$i];
        echo $idrule . ",";
        echo $idvariabel . ",";
        echo $idhimpunan . "<br>";
        mysqli_query($kon, "UPDATE detail_rule SET idhimpunan='$idhimpunan' WHERE idrule='$idrule' and idvariabel='$idvariabel' ");
    }

    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=rule&alert=2'>";
    }
} else if ($_GET['form'] == "rule_del") {

    $query = mysqli_query($kon, "DELETE FROM rule WHERE idrule='$_GET[id]'");
    $query = mysqli_query($kon, "DELETE FROM detail_rule WHERE idrule='$_GET[id]'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=rule&alert=3'>";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_GET['form'] == "dataset_add") {
    $namadataset = $_POST["namadataset"];
    $query = mysqli_query($kon, "INSERT INTO dataset (namadataset) VALUES ('$namadataset')");
    $iddataset = mysqli_insert_id($kon);

    for ($i = 0; $i < count($_POST['idvariabel']); $i++) {
        $idvariabel = $_POST['idvariabel'][$i];
        $nilai = $_POST['nilai'][$i];
        mysqli_query($kon, "INSERT INTO detail_dataset (iddataset, idvariabel, nilai) VALUES ('$iddataset', '$idvariabel', '$nilai')");
    }

    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=dataset&alert=1'>";
    }
} else if ($_GET['form'] == "dataset_edit") {
    $iddataset = $_GET["id"];
    $namadataset = $_POST["namadataset"];

    $query = mysqli_query($kon, "UPDATE dataset SET namadataset='$namadataset' WHERE iddataset='$iddataset' ");

    for ($i = 0; $i < count($_POST['idvariabel']); $i++) {
        $idvariabel = $_POST['idvariabel'][$i];
        $nilai = $_POST['nilai'][$i];
        echo $iddataset . ",";
        echo $idvariabel . ",";
        echo $nilai . "<br>";
        mysqli_query($kon, "UPDATE detail_dataset SET nilai='$nilai' WHERE iddataset='$iddataset' and idvariabel='$idvariabel' ");
    }

    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=dataset&alert=2'>";
    }
} else if ($_GET['form'] == "dataset_del") {

    $query = mysqli_query($kon, "DELETE FROM dataset WHERE iddataset='$_GET[id]'");
    $query = mysqli_query($kon, "DELETE FROM detail_dataset WHERE iddataset='$_GET[id]'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=?p=dataset&alert=3'>";
    }
}