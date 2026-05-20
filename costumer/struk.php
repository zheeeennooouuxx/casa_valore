<?php
include "auth_customer.php";
include "../koneksi.php";

$id = $_GET['id'];
$pelanggan = $_SESSION['username'];

/* Ambil data pesanan */
$p = mysqli_query($koneksi,"
    SELECT * FROM pesanan
    WHERE id='$id' AND pelanggan='$pelanggan'
");
$pesanan = mysqli_fetch_assoc($p);

if (!$pesanan) {
    die("Pesanan tidak ditemukan");
}

/* Detail pesanan */
$d = mysqli_query($koneksi,"
    SELECT d.*, m.nama_menu
    FROM pesanan_detail d
    JOIN menu m ON d.menu_id = m.id
    WHERE d.pesanan_id='$id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pesanan</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f7f7f7;
    padding: 25px;
}

.receipt {
    width: 380px;
    margin: auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.header {
    text-align: center;
    margin-bottom: 10px;
}

.header h2 {
    margin: 0;
    font-size: 23px;
    font-weight: 700;
}

.header small {
    color: #555;
    font-size: 13px;
}

.line {
    border-bottom: 1.5px dashed #aaa;
    margin: 12px 0;
}

.info p {
    margin: 3px 0;
    font-size: 14px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
    font-size: 14px;
}

th {
    background: #b31e1e;
    color: white;
    padding: 8px;
    border-radius: 6px;
    font-size: 14px;
}

td {
    padding: 8px;
    border-bottom: 1px dashed #ddd;
}

.total {
    text-align: right;
    font-size: 17px;
    font-weight: 700;
    margin-top: 12px;
}

.qr {
    text-align: center;
    margin-top: 20px;
}

.qr img {
    border: 5px solid #eee;
    border-radius: 10px;
}

button {
    width: 100%;
    padding: 12px;
    background: #b31e1e;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    margin-top: 15px;
}

button:hover {
    background: #a01818;
}

@media print {
    button { display: none; }
    body { background: white; }
    .receipt {
        box-shadow: none;
        width: 100%;
        padding: 0;
    }
}
</style>
</head>

<body>

<div class="receipt">

    <div class="header">
        <h2>🍝 Casa Valoré</h2>
        <small>Jl. DaengTata No.13 - Makassar</small>
    </div>

    <div class="line"></div>

    <div class="info">
        <p><strong>ID Pesanan:</strong> <?= $pesanan['id'] ?></p>
        <p><strong>Pelanggan:</strong> <?= $pesanan['pelanggan'] ?></p>
        <p><strong>Tanggal:</strong> <?= $pesanan['tanggal'] ?></p>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <th style="text-align:left">Menu</th>
            <th>Qty</th>
            <th style="text-align:right">Subtotal</th>
        </tr>

        <?php while($r=mysqli_fetch_assoc($d)): ?>
        <tr>
            <td><?= $r['nama_menu'] ?></td>
            <td style="text-align:center"><?= $r['qty'] ?></td>
            <td style="text-align:right">Rp <?= number_format($r['subtotal'],0,',','.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="line"></div>

    <div class="total">
        Total: Rp <?= number_format($pesanan['total'],0,',','.') ?>
    </div>

    <?php
    $qr_text = "Pesanan #{$pesanan['id']} | Customer: {$pesanan['pelanggan']} | Total: Rp {$pesanan['total']}";
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" . urlencode($qr_text);
    ?>

    <div class="qr">
        <img src="<?= $qr_url ?>" alt="QR Code Pesanan">
        <p style="font-size:12px; color:#666">Scan untuk verifikasi pesanan</p>
    </div>

    <button onclick="window.print()">🖨 Cetak Struk</button>

</div>

</body>
</html>
