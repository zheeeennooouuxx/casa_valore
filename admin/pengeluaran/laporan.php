<?php
session_start();
include '../../koneksi.php';
include '../../navbar_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #eef2f3;
        }

        .container {
            padding: 30px;
        }

        h2 {
            color: #1b6c2e;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 28px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            border: 1px solid #e4e4e4;
        }

        h3 {
            margin-top: 0;
            color: #1b6c2e;
            font-size: 22px;
            margin-bottom: 18px;
        }

        form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 15px;
            background: #f7f7f7;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        label {
            font-weight: 600;
            color: #333;
        }

        input[type="date"] {
            padding: 7px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            background: #1b6c2e;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #145323;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table th {
            background: #1b6c2e;
            color: white;
            padding: 12px;
            font-size: 15px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e6e6e6;
        }

        table tr:hover {
            background: #fafafa;
        }

        .total {
            margin-top: 18px;
            font-size: 18px;
            font-weight: bold;
            color: #1b6c2e;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 25px 0;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>📊 Laporan Pengeluaran</h2>

    <!-- LAPORAN HARIAN -->
    <div class="card">
        <h3>🔹 Laporan Harian</h3>

        <form method="POST">
            <label>Tanggal:</label>
            <input type="date" name="tgl_harian" required>
            <button type="submit" name="lihat_harian">Lihat</button>
        </form>

        <?php
        if (isset($_POST['lihat_harian'])) {
            $tgl = $_POST['tgl_harian'];

            $data = mysqli_query($koneksi, "SELECT * FROM pengeluaran WHERE tanggal='$tgl'");
            $total = mysqli_fetch_array(mysqli_query(
                $koneksi,
                "SELECT SUM(nominal) AS total FROM pengeluaran WHERE tanggal='$tgl'"
            ));
        ?>
            <h4><strong>Hasil Tanggal:</strong> <?= $tgl ?></h4>

            <table>
                <tr>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>
                <?php while ($d = mysqli_fetch_array($data)) { ?>
                <tr>
                    <td><?= $d['keterangan'] ?></td>
                    <td>Rp <?= number_format($d['nominal'], 0, ',', '.') ?></td>
                </tr>
                <?php } ?>
            </table>

            <div class="total">
                Total: Rp <?= number_format($total['total'] ?? 0, 0, ',', '.') ?>
            </div>
        <?php } ?>
    </div>

    <!-- LAPORAN RENTANG -->
    <div class="card">
        <h3>🔹 Laporan Rentang Tanggal</h3>

        <form method="POST">
            <label>Dari:</label>
            <input type="date" name="dari" required>
            <label>Sampai:</label>
            <input type="date" name="sampai" required>
            <button type="submit" name="lihat_range">Lihat</button>
        </form>

        <?php
        if (isset($_POST['lihat_range'])) {
            $dari = $_POST['dari'];
            $sampai = $_POST['sampai'];

            $data = mysqli_query(
                $koneksi,
                "SELECT * FROM pengeluaran 
                 WHERE tanggal BETWEEN '$dari' AND '$sampai'
                 ORDER BY tanggal ASC"
            );

            $total = mysqli_fetch_array(mysqli_query(
                $koneksi,
                "SELECT SUM(nominal) AS total 
                 FROM pengeluaran 
                 WHERE tanggal BETWEEN '$dari' AND '$sampai'"
            ));
        ?>
            <h4><strong>Periode:</strong> <?= $dari ?> s/d <?= $sampai ?></h4>

            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>
                <?php while ($d = mysqli_fetch_array($data)) { ?>
                <tr>
                    <td><?= $d['tanggal'] ?></td>
                    <td><?= $d['keterangan'] ?></td>
                    <td>Rp <?= number_format($d['nominal'], 0, ',', '.') ?></td>
                </tr>
                <?php } ?>
            </table>

            <div class="total">
                Total: Rp <?= number_format($total['total'] ?? 0, 0, ',', '.') ?>
            </div>

        <?php } ?>
    </div>

</div>

</body>
</html>
