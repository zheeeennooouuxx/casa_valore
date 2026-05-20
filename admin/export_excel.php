<?php
include '../koneksi.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan.xls");

$dari = $_GET['dari'];
$sampai = $_GET['sampai'];

echo "LAPORAN PENJUALAN DAN PENGELUARAN\n";
echo "Periode: $dari s/d $sampai\n\n";

echo "=== PENJUALAN ===\n";
echo "Tanggal\tTotal Harga\n";

$q = mysqli_query($koneksi,
    "SELECT * FROM pesanan WHERE tanggal BETWEEN '$dari' AND '$sampai'"
);

$total = 0;

while ($row = mysqli_fetch_assoc($q)) {
    echo $row['tanggal']."\t".$row['total_harga']."\n";
    $total += $row['total_harga'];
}

echo "TOTAL\t$total\n\n";
echo "=== PENGELUARAN ===\n";
echo "Tanggal\tKeterangan\tNominal\n";

$q = mysqli_query($koneksi,
    "SELECT * FROM pengeluaran WHERE tanggal BETWEEN '$dari' AND '$sampai'"
);

$totalPeng = 0;

while ($row = mysqli_fetch_assoc($q)) {
    echo $row['tanggal']."\t".$row['keterangan']."\t".$row['nominal']."\n";
    $totalPeng += $row['nominal'];
}

echo "TOTAL\t\t$totalPeng\n";
?>
