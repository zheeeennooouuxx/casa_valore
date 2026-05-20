<?php
session_start();
include '../../koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM pengeluaran WHERE id_pengeluaran='$id'");
$d = mysqli_fetch_array($data);
?>

<h2>Edit Pengeluaran</h2>

<form action="" method="POST">
    Tanggal: <input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" required> <br><br>
    Keterangan: <input type="text" name="keterangan" value="<?= $d['keterangan'] ?>" required> <br><br>
    Nominal: <input type="number" name="nominal" value="<?= $d['nominal'] ?>" required> <br><br>

    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {
    mysqli_query($koneksi, "UPDATE pengeluaran SET 
        tanggal='$_POST[tanggal]', 
        keterangan='$_POST[keterangan]', 
        nominal='$_POST[nominal]' 
        WHERE id_pengeluaran='$id'
    ");
    header("Location: index.php");
}
?>
