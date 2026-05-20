<?php
include "../auth_check.php";
include "../../koneksi.php";

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id=$id");
$data = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<title>Edit Menu</title>

<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #eef2f3;
        padding: 30px;
        margin: 0;
    }

    .box {
        width: 450px;
        margin: 30px auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 14px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }

    .box h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 22px;
        color: #1b6c2e;
        font-weight: 700;
        text-align: center;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        color: #444;
    }

    input, select {
        width: 100%;
        padding: 11px;
        margin-top: 6px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    input:focus, select:focus {
        border-color: #1b6c2e;
        box-shadow: 0 0 0 2px rgba(27,108,46,0.2);
    }

    .img-preview {
        width: 140px;
        height: 140px;
        border-radius: 10px;
        overflow: hidden;
        border: 3px solid #e0e0e0;
        margin-bottom: 15px;
    }

    .img-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    button {
        padding: 12px;
        width: 100%;
        background: #f29d14;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        transition: 0.2s;
    }

    button:hover {
        background: #d3840f;
    }
</style>
</head>

<body>

<div class="box">
    <h3>✏️ Edit Menu</h3>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Nama Menu</label>
        <input type="text" name="nama_menu" 
               value="<?php echo $data['nama_menu']; ?>" required>

        <label>Harga</label>
        <input type="number" name="harga" 
               value="<?php echo $data['harga']; ?>" required>

        <label>Kategori</label>
        <select name="kategori_id" required>
            <?php
            $kat = mysqli_query($koneksi, "SELECT * FROM kategori_menu");
            while ($k = mysqli_fetch_assoc($kat)) {
                $sel = ($k['id'] == $data['kategori_id']) ? "selected" : "";
                echo "<option value='{$k['id']}' $sel>{$k['nama_kategori']}</option>";
            }
            ?>
        </select>

        <label>Foto Lama</label><br>
        <div class="img-preview">
            <img src="../../uploads/menu/<?php echo $data['foto']; ?>">
        </div>

        <label>Ganti Foto (opsional)</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit" name="update">Update Menu</button>
    </form>
</div>

<?php
if (isset($_POST['update'])) {

    $nama = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori_id'];

    // jika ganti foto
    if ($_FILES['foto']['name']) {

        // hapus foto lama
        if (file_exists("../../uploads/menu/" . $data['foto'])) {
            unlink("../../uploads/menu/" . $data['foto']);
        }

        // upload foto baru
        $file = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $newname = time() . "-" . rand(1000,9999) . "." . $ext;
        move_uploaded_file($tmp, "../../uploads/menu/" . $newname);

        mysqli_query($koneksi,
            "UPDATE menu SET 
             nama_menu='$nama',
             harga='$harga',
             kategori_id='$kategori',
             foto='$newname'
             WHERE id=$id");

    } else {

        mysqli_query($koneksi,
            "UPDATE menu SET 
             nama_menu='$nama',
             harga='$harga',
             kategori_id='$kategori'
             WHERE id=$id");
    }

    echo "<script>alert('Menu berhasil diperbarui');
          window.location='index.php';</script>";
}
?>

</body>
</html>
