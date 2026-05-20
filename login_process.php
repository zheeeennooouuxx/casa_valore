<?php 
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$q = mysqli_query($koneksi,"
    SELECT * FROM users 
    WHERE username='$username' 
    AND password='$password'
");

$data = mysqli_fetch_assoc($q);

if ($data) {
    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $data['id'];    
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] === 'admin') {
        header("Location: /sistem_restoran/admin/dashboard.php");
    } else {
        header("Location: /sistem_restoran/costumer/dashboard.php");
    }
    exit;
} else {
    header("Location: /sistem_restoran/login.php");
    exit;
}
