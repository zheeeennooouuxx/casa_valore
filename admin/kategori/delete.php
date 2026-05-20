<?php
include "../auth_check.php";
include "../../koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM kategori_menu WHERE id=$id");

echo "<script>
        alert('Kategori berhasil dihapus');
        window.location='index.php';
      </script>";
?>
