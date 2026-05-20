<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../koneksi.php';
include "../navbar_admin.php";

$id = $_GET['id'];

$order = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id='$id'");
$data = mysqli_fetch_assoc($order);

$items = mysqli_query($koneksi, "
    SELECT pd.*, m.nama_menu, m.harga 
    FROM pesanan_detail pd
    JOIN menu m ON pd.menu_id = m.id
    WHERE pd.pesanan_id = '$id'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan</title>

<style>
    body {
        margin: 0;
        padding: 30px;
        font-family: 'Poppins', sans-serif;
        background: #f0f2f5;
    }
    .card {
        width: 80%;
        margin: auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        animation: fadeIn .4s ease;
    }
    h2 {
        color: #1b6c2e;
        margin-bottom: 15px;
    }
    p {
        font-size: 15px;
        margin: 5px 0;
    }
    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        color: white;
        font-weight: bold;
    }
    .pending { background: #f0ad4e; }
    .diproses { background: #0275d8; }
    .selesai { background: #5cb85c; }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
    }
    th {
        background: #1b6c2e;
        color: white;
        padding: 12px;
        font-size: 14px;
        text-align: left;
    }
    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }
    tr:hover td {
        background: #f3f7f5;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 16px;
        background: #1b6c2e;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s;
    }
    .back-btn:hover {
        background: #145022;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>

<div class="card">
    <h2>🧾 Detail Pesanan</h2>

    <p><strong>Nama Customer:</strong> <?= $data['pelanggan'] ?></p>

    <p><strong>Status:</strong> 
        <span class="badge <?= $data['status'] ?>">
            <?= ucfirst($data['status']) ?>
        </span>
    </p>

    <p><strong>Total:</strong> 
        <span style="color:#1b6c2e; font-weight:bold;">
            Rp <?= number_format($data['total'], 0, ',', '.') ?>
        </span>
    </p>

    <p><strong>Tanggal:</strong> <?= $data['tanggal'] ?></p>

    <h3 style="margin-top:25px;">📋 Item Pesanan</h3>

    <table>
        <tr>
            <th>Menu</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($item = mysqli_fetch_assoc($items)) { ?>
        <tr>
            <td><?= $item['nama_menu'] ?></td>
            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td><?= $item['qty'] ?></td>
            <td><strong>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></strong></td>
        </tr>
        <?php } ?>
    </table>

    <a href="orders.php" class="back-btn">⬅ Kembali</a>
</div>

</body>
</html>
