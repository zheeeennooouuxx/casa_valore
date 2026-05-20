<?php
session_start();
include '../koneksi.php';
include '../navbar_admin.php';
?>

<h2>📄 Laporan Penjualan & Pengeluaran</h2>

<form method="GET">
    <label>Dari Tanggal:</label>
    <input type="date" name="dari" required>
    <label>Sampai Tanggal:</label>
    <input type="date" name="sampai" required>
    <button type="submit">Tampilkan</button>
</form>

<br>

<?php
if (isset($_GET['dari']) && isset($_GET['sampai'])) {

    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    echo "<h3>Periode: $dari s/d $sampai</h3><br>";

    // PENJUALAN
    $penjualan = mysqli_query($koneksi,
        "SELECT * FROM pesanan WHERE tanggal BETWEEN '$dari' AND '$sampai'"
    );

    // TOTAL
    $totalPenjualan = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT SUM(total_harga) AS total FROM pesanan 
         WHERE tanggal BETWEEN '$dari' AND '$sampai'"
    ));

    echo "<h3>📈 Laporan Penjualan</h3>";

    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
            </tr>";

    while ($p = mysqli_fetch_assoc($penjualan)) {
        echo "<tr>
                <td>{$p['id_pesanan']}</td>
                <td>{$p['tanggal']}</td>
                <td>Rp " . number_format($p['total_harga']) . "</td>
              </tr>";
    }

    echo "</table><br>";
    echo "<h4>Total Penjualan: Rp " . number_format($totalPenjualan['total'] ?? 0) . "</h4><br>";

    // PENGELUARAN
    echo "<h3>📉 Laporan Pengeluaran</h3>";

    $pengeluaran = mysqli_query($koneksi,
        "SELECT * FROM pengeluaran WHERE tanggal BETWEEN '$dari' AND '$sampai'"
    );

    $totalPengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT SUM(nominal) AS total FROM pengeluaran
         WHERE tanggal BETWEEN '$dari' AND '$sampai'"
    ));

    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>ID Pengeluaran</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Nominal</th>
            </tr>";

    while ($g = mysqli_fetch_assoc($pengeluaran)) {
        echo "<tr>
                <td>{$g['id_pengeluaran']}</td>
                <td>{$g['tanggal']}</td>
                <td>{$g['keterangan']}</td>
                <td>Rp " . number_format($g['nominal']) . "</td>
              </tr>";
    }

    echo "</table><br>";
    echo "<h4>Total Pengeluaran: Rp " . number_format($totalPengeluaran['total'] ?? 0) . "</h4><br>";

?>

<!-- Button Export -->
<a href="export_pdf.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>" target="_blank">
    <button>📄 Export PDF</button>
</a>

<a href="export_excel.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>">
    <button>📊 Export Excel</button>
</a>

<?php } ?>
