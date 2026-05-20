<?php
$host = "sql100.infinityfree.com";
$user = "if0_41612708t";
$pass = "pOv0K2CzmSoRtx";
$db   = "if0_41612708_casa_valore";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
