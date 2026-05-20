<?php
session_start();
include '../../koneksi.php';
include '../../navbar_admin.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengeluaran</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .container {
            padding: 25px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 18px;
            background: #b31e1e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        table th {
            background: #1b6c2e;
            color: white;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .action a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            margin: 0 3px;
        }

        .edit {
            background: orange;
        }

        .delete {
            background: red;
        }

        .action a:hover {
            opacity: 0.85;
        }

        .laporan-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #1b6c2e;
            font-weight: bold;
        }

        .laporan-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>📉 Daftar Pengeluaran</h2>

    <a href="create.php" class="add-btn">➕ Tambah Pengeluaran</a>

    <table>
        <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Aksi</th>
        </tr>

        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM pengeluaran ORDER BY tanggal DESC");
        while ($d = mysqli_fetch_assoc($data)) {
        ?>
            <tr>
                <td><?= $d['tanggal']; ?></td>
                <td><?= htmlspecialchars($d['keterangan']); ?></td>
                <td>Rp <?= number_format($d['nominal'], 0, ',', '.'); ?></td>
                <td class="action">
                    <a href="edit.php?id=<?= $d['id_pengeluaran']; ?>" class="edit">Edit</a>
                    <a href="delete.php?id=<?= $d['id_pengeluaran']; ?>"
                       class="delete"
                       onclick="return confirm('Yakin ingin menghapus data ini?');">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php } ?>

    </table>

    <a href="laporan.php" class="laporan-link">📊 Laporan Pengeluaran</a>

</div>

</body>
</html>
