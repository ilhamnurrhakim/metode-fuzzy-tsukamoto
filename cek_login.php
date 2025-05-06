<?php
require_once "include/koneksi.php";

$username = mysqli_real_escape_string($kon, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = mysqli_real_escape_string($kon, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password'])))));
if (empty($username) and empty($password)) {
    header("Location: index.php?alert=1");
} else {
    $query = mysqli_query($kon, "SELECT * FROM user WHERE username='$username' AND  password='$password' AND status='Aktif'");
    $row = mysqli_num_rows($query);
    if ($row > 0) {
        $data = mysqli_fetch_array($query);
        session_start();
        $_SESSION['iduser']    = $data['iduser'];
        $_SESSION['username']   = $data['username'];
        $_SESSION['password']   = $data['password'];
        $_SESSION['namalengkap'] = $data['namalengkap'];
        $_SESSION['posisi'] = $data['posisi'];
        header("Location: main.php?p=home");
    } else {
        header("Location: index.php?alert=5");
    }
}
