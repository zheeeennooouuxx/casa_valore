<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

/* --- VALIDASI ID --- */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h3>ID menu tidak ditemukan!</h3>");
}

$id = intval($_GET['id']);

/* --- QUERY MENU --- */
$q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id=$id");
$m = mysqli_fetch_assoc($q);

/* --- CEK APAKAH ADA DATA --- */
if (!$m) {
    die("<h3>Menu tidak ditemukan di database!</h3>");
}
?>

<h2><?= $m['nama_menu'] ?></h2>
<p>Harga : Rp <?= number_format($m['harga']) ?></p>

<form method="post" action="cart.php">
    <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
    <button>Tambah ke Keranjang</button>
</form>
