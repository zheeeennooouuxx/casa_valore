<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include "../koneksi.php";
include "../navbar_admin.php";

/* FILTER TANGGAL */
$where = "";
if (!empty($_GET['dari']) && !empty($_GET['sampai'])) {
    $dari   = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $where  = "WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'";
}

/* DATA PESANAN */
$query = mysqli_query($koneksi,"
    SELECT id, pelanggan, total, status, tanggal
    FROM pesanan
    $where
    ORDER BY tanggal DESC
");

/* TOTAL PENDAPATAN */
$totalQuery = mysqli_query($koneksi,"SELECT SUM(total) AS jumlah FROM pesanan $where");
$totalPendapatan = mysqli_fetch_assoc($totalQuery)['jumlah'] ?? 0;

/* UPDATE STATUS */
if (isset($_POST['id_pesanan'])) {
    $id     = $_POST['id_pesanan'];
    $status = $_POST['status'];

    mysqli_query($koneksi,"UPDATE pesanan SET status='$status' WHERE id=$id");

    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pesanan</title>

<style>
body {
    margin: 0;
    background: #f5f7fa;
    font-family: 'Poppins', sans-serif;
}

.container {
    padding: 35px;
}

/* HEADER */
.header-box {
    background: linear-gradient(135deg, #1b6c2e, #1b6c2e);
    padding: 25px;
    border-radius: 18px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.18);
}

.header-box h2 {
    margin: 0;
    font-size: 30px;
    font-weight: 700;
}

.header-box p {
    margin-top: 6px;
    font-size: 17px;
    opacity: .9;
}

/* FILTER */
.filter-box {
    background: white;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-box input, .filter-box button, .filter-box a {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 14px;
}

.filter-box input {
    border: 1px solid #bbb;
}

.filter-box button {
    background: #1b6c2e;
    border: none;
    color: white;
    cursor: pointer;
}

.filter-box a {
    background: #333;
    color: white;
    text-decoration: none;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.10);
}

table th {
    background: #1b6c2e;
    color: white;
    padding: 14px;
    font-size: 15px;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f7dede;
    transition: .2s;
}

/* STATUS BADGE */
.status-badge {
    padding: 6px 12px;
    color: white;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.pending { background: #ffa534; }
.diproses { background: #3498db; }
.selesai { background: #2ecc71; }

select {
    padding: 6px;
    border-radius: 6px;
    border: 1px solid #aaa;
}

button.update-btn {
    padding: 6px 10px;
    background: #1b6c2e;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.update-btn:hover {
    background: #145a24;
}

.detail-btn {
    padding: 8px 12px;
    background: #555;
    color: white;
    text-decoration: none;
    border-radius: 6px;
}

.detail-btn:hover {
    background: #000;
}
</style>

</head>
<body>

<div class="container">

    <div class="header-box">
        <h2>📦 Data Pesanan Masuk</h2>
        <p>Kelola seluruh pesanan pelanggan dengan tampilan yang lebih modern.</p>
    </div>

    <form method="GET" class="filter-box">
        <label><b>Dari</b></label>
        <input type="date" name="dari" value="<?= $_GET['dari'] ?? '' ?>">

        <label><b>Sampai</b></label>
        <input type="date" name="sampai" value="<?= $_GET['sampai'] ?? '' ?>">

        <button type="submit">Filter</button>
        <a href="orders.php">Reset</a>
    </form>

    <h3 style="margin-bottom: 10px; font-size: 20px;">
        💰 Total Pendapatan :  
        <span style="color:#b31e1e; font-weight:bold;">
            Rp <?= number_format($totalPendapatan,0,',','.') ?>
        </span>
    </h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['pelanggan'] ?></td>
            <td><b>Rp <?= number_format($row['total'],0,',','.') ?></b></td>

            <td>
                <span class="status-badge <?= $row['status']; ?>">
                    <?= ucfirst($row['status']); ?>
                </span>

                <form method="post" style="margin-top:6px;">
                    <input type="hidden" name="id_pesanan" value="<?= $row['id']; ?>">
                    <select name="status">
                        <option value="pending"  <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                        <option value="diproses" <?= $row['status']=='diproses'?'selected':'' ?>>Diproses</option>
                        <option value="selesai"  <?= $row['status']=='selesai'?'selected':'' ?>>Selesai</option>
                    </select>
                    <button class="update-btn">✔</button>
                </form>
            </td>

            <td><?= $row['tanggal'] ?></td>

            <td>
                <a class="detail-btn" href="order_detail.php?id=<?= $row['id'] ?>">Detail</a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>
