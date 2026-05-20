<?php
include "../auth_check.php";
include "../../koneksi.php";

$id = $_GET['id'];

$q = mysqli_query($koneksi, "SELECT foto FROM menu WHERE id=$id");
$d = mysqli_fetch_assoc($q);

// hapus foto fisik
unlink("../../uploads/menu/" . $d['foto']);

// hapus database
mysqli_query($koneksi, "DELETE FROM menu WHERE id=$id");

echo "<script>
        alert('Menu berhasil dihapus');
        window.location='index.php';
      </script>";
?>
