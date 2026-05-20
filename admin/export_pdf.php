<?php
include '../koneksi.php';
require('../fpdf/fpdf.php');

$dari = $_GET['dari'];
$sampai = $_GET['sampai'];

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Cell(190,10,'Laporan Penjualan & Pengeluaran',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,8,"Periode: $dari s/d $sampai",0,1,'C');
$pdf->Ln(5);

// ================= PENJUALAN =================
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'PENJUALAN',0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(60,8,'Tanggal',1);
$pdf->Cell(60,8,'Total Harga',1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);

$q = mysqli_query($koneksi,
    "SELECT * FROM pesanan WHERE tanggal BETWEEN '$dari' AND '$sampai'"
);

$totalPenjualan = 0;

while ($row = mysqli_fetch_assoc($q)) {
    $pdf->Cell(60,8,$row['tanggal'],1);
    $pdf->Cell(60,8,"Rp ".number_format($row['total_harga']),1);
    $pdf->Ln();
    $totalPenjualan += $row['total_harga'];
}

$pdf->Cell(60,8,'TOTAL',1);
$pdf->Cell(60,8,"Rp ".number_format($totalPenjualan),1);
$pdf->Ln(12);

// ================= PENGELUARAN =================
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,'PENGELUARAN',0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(60,8,'Tanggal',1);
$pdf->Cell(80,8,'Keterangan',1);
$pdf->Cell(40,8,'Nominal',1);
$pdf->Ln();

$pdf->SetFont('Arial','',11);

$q = mysqli_query($koneksi,
    "SELECT * FROM pengeluaran WHERE tanggal BETWEEN '$dari' AND '$sampai'"
);

$totalPengeluaran = 0;

while ($row = mysqli_fetch_assoc($q)) {
    $pdf->Cell(60,8,$row['tanggal'],1);
    $pdf->Cell(80,8,$row['keterangan'],1);
    $pdf->Cell(40,8,"Rp ".number_format($row['nominal']),1);
    $pdf->Ln();
    $totalPengeluaran += $row['nominal'];
}

$pdf->Cell(140,8,'TOTAL',1);
$pdf->Cell(40,8,"Rp ".number_format($totalPengeluaran),1);

$pdf->Output();
?>
