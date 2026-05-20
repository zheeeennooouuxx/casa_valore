<?php
include "../auth_check.php";
include "../../koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <style>

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #eef2f3;
            margin: 0;
            padding: 40px;
        }

        .box {
            width: 380px;
            padding: 30px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e5e5e5;
            animation: fadeIn 0.3s ease-in-out;
        }

        h3 {
            margin-top: 0;
            font-size: 22px;
            color: #1b6c2e;
            text-align: center;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            margin-top: 14px;
            border: 1px solid #cccccc;
            font-size: 15px;
            transition: 0.2s;
        }

        input:focus {
            border-color: #1b6c2e;
            outline: none;
            box-shadow: 0 0 6px rgba(27,108,46,0.3);
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 18px;
            background: #1b6c2e;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #145323;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

    </style>
</head>

<body>

<div class="box">
    <h3>Tambah Kategori</h3>

    <form action="" method="POST">
        <input type="text" name="nama_kategori" placeholder="Nama kategori..." required>
        <button type="submit" name="save">Simpan</button>
    </form>
</div>

<?php
if (isset($_POST['save'])) {
    $nama = $_POST['nama_kategori'];

    mysqli_query($koneksi, "INSERT INTO kategori_menu (nama_kategori)
                             VALUES ('$nama')");

    echo "<script>
            alert('Kategori berhasil ditambahkan');
            window.location='index.php';
          </script>";
}
?>

</body>
</html>
