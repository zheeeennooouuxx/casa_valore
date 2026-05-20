<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../koneksi.php';
include '../navbar_admin.php';

// ================= DATA HARI INI =================
$tgl = date("Y-m-d");

$kategori = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM kategori_menu"
))['jml'] ?? 0;

$menu = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM menu"
))['jml'] ?? 0;

$pesanan_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM pesanan WHERE DATE(tanggal)='$tgl'"
))['jml'] ?? 0;

$pendapatan_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT SUM(total) AS jml FROM pesanan WHERE DATE(tanggal)='$tgl'"
))['jml'] ?? 0;

$pengeluaran_hari_ini = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT SUM(nominal) AS jml FROM pengeluaran WHERE DATE(tanggal)='$tgl'"
))['jml'] ?? 0;


// ================= DATA GRAFIK 7 HARI =================
$labels = [];
$dataPendapatan = [];
$dataPengeluaran = [];
$dataPesanan = [];

for ($i = 6; $i >= 0; $i--) {
    $tanggal = date("Y-m-d", strtotime("-$i days"));
    $labels[] = $tanggal;

    $dataPendapatan[] = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT SUM(total) AS jml FROM pesanan WHERE DATE(tanggal)='$tanggal'"
    ))['jml'] ?? 0;

    $dataPengeluaran[] = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT SUM(nominal) AS jml FROM pengeluaran WHERE DATE(tanggal)='$tanggal'"
    ))['jml'] ?? 0;

    $dataPesanan[] = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT COUNT(*) AS jml FROM pesanan WHERE DATE(tanggal)='$tanggal'"
    ))['jml'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <!-- CSS Dashboard -->
    <link rel="stylesheet" href="dashboard.css">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

    <h2>📊 Dashboard Admin</h2>

    <!-- CARD -->
    <div class="dashboard-box">
        <div class="box">
            <h3>📂 Kategori</h3>
            <p><?= $kategori ?></p>
        </div>

        <div class="box">
            <h3>🍽 Menu</h3>
            <p><?= $menu ?></p>
        </div>

        <div class="box">
            <h3>🧾 Pesanan Hari Ini</h3>
            <p><?= $pesanan_hari_ini ?></p>
        </div>

        <div class="box">
            <h3>💰 Pendapatan Hari Ini</h3>
            <p>Rp <?= number_format($pendapatan_hari_ini,0,',','.') ?></p>
        </div>

        <div class="box">
            <h3>💸 Pengeluaran Hari Ini</h3>
            <p>Rp <?= number_format($pengeluaran_hari_ini,0,',','.') ?></p>
        </div>
    </div>

    <!-- GRAFIK -->
    <div class="chart-box">
        <h3>📈 Grafik 7 Hari Terakhir</h3>

        <canvas id="chartPendapatan"></canvas>
        <canvas id="chartPengeluaran"></canvas>
        <canvas id="chartPesanan"></canvas>
    </div>
</div>

<!-- ================= SCRIPT GRAFIK ================= -->
<script>
const labels = <?= json_encode($labels) ?>;
const pendapatan = <?= json_encode($dataPendapatan) ?>;
const pengeluaran = <?= json_encode($dataPengeluaran) ?>;
const pesanan = <?= json_encode($dataPesanan) ?>;

// Pendapatan
new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: pendapatan,
            borderWidth: 3,
            borderColor: '#1b6c2e',
            tension: 0.4
        }]
    }
});

// Pengeluaran
new Chart(document.getElementById('chartPengeluaran'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pengeluaran (Rp)',
            data: pengeluaran,
            borderWidth: 3,
            borderColor: '#b31e1e',
            tension: 0.4
        }]
    }
});

// Pesanan
new Chart(document.getElementById('chartPesanan'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Pesanan',
            data: pesanan,
            backgroundColor: '#1f6ed4'
        }]
    }
});
</script>

</body>
</html>
