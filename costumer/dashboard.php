<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

/* Ambil menu unggulan terbaru */
$unggulan = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT * FROM menu ORDER BY id DESC LIMIT 1")
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Casa Valoré</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>

<div class="dashboard">
    <div class="dashboard-text">
        <h1>Today's Delicious <br> Menu</h1>
        <p>
            Nikmati berbagai hidangan khas Italia terbaik dari Casa Valoré.
            Semua dibuat menggunakan bahan-bahan segar dengan cita rasa autentik.
        </p>
        <a class="order-btn" href="index.php">Order Now</a>
    </div>

    <div class="dashboard-img">
        <?php if($unggulan): ?>
            <img src="../assets/background/bg_dashboard.jpg" alt="<?= $unggulan['nama_menu']; ?>">
        <?php else: ?>
            <img src="../assets/background/bg_dashboard.jpg">
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    <strong>Casa Valoré Food Ordering System</strong><br>
    © 2025 All Rights Reserved.<br>
    CopyRight || Muhammad Ikram Kamil, Khaerunnisa Pakata, Muh. Faiz
</div>

</body>
</html>
