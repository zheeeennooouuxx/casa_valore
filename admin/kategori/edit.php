<?php
include "../auth_check.php";
include "../../koneksi.php";

$id = $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM kategori_menu WHERE id=$id");
$data = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        .box {
            width: 300px; padding: 20px; margin: 40px auto; background: white;
            border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, button {
            width: 100%; padding: 10px; margin-top: 10px;
        }
        button { background: orange; color: white; border: none; }
    </style>
</head>

<body>

<div class="box">
    <h3>Edit Kategori</h3>

    <form action="" method="POST">
        <input type="text" name="nama_kategori" 
               value="<?php echo $data['nama_kategori']; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>

</div>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama_kategori'];

    mysqli_query($koneksi, "UPDATE kategori_menu SET nama_kategori='$nama'
                            WHERE id=$id");

    echo "<script>
            alert('Kategori berhasil diperbarui');
            window.location='index.php';
          </script>";
}
?>

</body>
</html>
