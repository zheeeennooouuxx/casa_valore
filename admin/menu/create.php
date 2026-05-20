<?php
include "../auth_check.php";
include "../../koneksi.php";
include "../../navbar_admin.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Menu</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f2f2f2;
}
.container {
    display: flex;
    justify-content: center;
    padding: 40px;
}
.card {
    width: 450px;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.15);
}
label {
    font-weight: bold;
    margin-top: 12px;
    display: block;
}
input, select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
button {
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: #28a745;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="container">
<div class="card">

<h3>➕ Tambah Menu</h3>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Menu</label>
    <input type="text" name="nama_menu" required>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Kategori</label>
    <select name="kategori_id" required>
        <option value="">-- Pilih --</option>
        <?php
        $kat = mysqli_query($koneksi,"SELECT * FROM kategori_menu");
        while ($k = mysqli_fetch_assoc($kat)) {
            echo "<option value='{$k['id']}'>{$k['nama_kategori']}</option>";
        }
        ?>
    </select>

    <label>Foto Menu</label>
    <input type="file" name="foto" accept="image/*" required>

    <button type="submit" name="save">Simpan</button>
</form>

</div>
</div>

<?php
if (isset($_POST['save'])) {

    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $harga    = (int)$_POST['harga'];
    $kategori = (int)$_POST['kategori_id'];

    $file = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];
    if (!in_array($ext, $allowed)) {
        exit("<script>alert('Format foto tidak valid');history.back();</script>");
    }

    $newname = time() . '-' . rand(1000,9999) . '.' . $ext;
    $folder  = $_SERVER['DOCUMENT_ROOT'] . '/sistem_restoran/assets/menu/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    if (!move_uploaded_file($tmp, $folder . $newname)) {
        exit("<script>alert('Upload gagal');</script>");
    }

    mysqli_query($koneksi,"
        INSERT INTO menu (nama_menu, harga, foto, kategori_id)
        VALUES ('$nama','$harga','$newname','$kategori')
    ");

    echo "<script>alert('Menu berhasil ditambahkan');location='index.php';</script>";
}
?>

</body>
</html>
