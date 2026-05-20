<?php
session_start();
include '../../koneksi.php';
include '../../navbar_admin.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengeluaran</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }

        .card {
            background: white;
            width: 420px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 18px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #28a745;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.95;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #555;
        }

        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">

        <h2>➕ Tambah Pengeluaran</h2>

        <form method="POST">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required>

            <label>Keterangan</label>
            <input type="text" name="keterangan" placeholder="Contoh: Beli Gas" required>

            <label>Nominal</label>
            <input type="number" name="nominal" placeholder="Contoh: 50000" required>

            <button type="submit" name="simpan">💾 Simpan Pengeluaran</button>
        </form>

        <a href="index.php" class="back">⬅ Kembali ke Daftar Pengeluaran</a>

    </div>
</div>

</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $ket = $_POST['keterangan'];
    $nom = $_POST['nominal'];

    mysqli_query($koneksi, "INSERT INTO pengeluaran VALUES (NULL, '$tanggal', '$ket', '$nom')");
    header("Location: index.php");
}
?>
