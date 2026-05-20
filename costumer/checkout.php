<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p style='padding:30px'>Keranjang masih kosong</p>";
    exit;
}

$pelanggan = $_SESSION['username']; // sesuai tabel pesanan
$total = 0;

// hitung total
foreach ($cart as $id => $qty) {
    $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id=$id");
    $m = mysqli_fetch_assoc($q);

    $total += $m['harga'] * $qty;
}

if (isset($_POST['checkout'])) {

    // simpan ke tabel pesanan
    mysqli_query($koneksi, "
        INSERT INTO pesanan (pelanggan, total, status)
        VALUES ('$pelanggan', $total, 'pending')
    ");

    $pesanan_id = mysqli_insert_id($koneksi);

    // simpan detail
    foreach ($cart as $id => $qty) {
        $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id=$id");
        $m = mysqli_fetch_assoc($q);

        $subtotal = $m['harga'] * $qty;

        mysqli_query($koneksi, "
            INSERT INTO pesanan_detail (pesanan_id, menu_id, qty, subtotal)
            VALUES ($pesanan_id, $id, $qty, $subtotal)
        ");
    }

    unset($_SESSION['cart']);
    header("Location: orders.php");
    exit;
}
?>

<style>
.wrap{padding:30px}
button{
    background:#b31e1e;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:6px;
}
</style>

<div class="wrap">
<h2>✅ Checkout</h2>
<p>Total Bayar: <strong>Rp <?= number_format($total) ?></strong></p>

<form method="post">
    <button name="checkout">Proses Pesanan</button>
</form>
</div>
