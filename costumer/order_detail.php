<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

$id = $_GET['id'] ?? 0;

// ambil data pesanan
$pesanan = mysqli_query($koneksi,"
    SELECT * FROM pesanan WHERE id=$id
");
$p = mysqli_fetch_assoc($pesanan);

// ambil detail pesanan
$detail = mysqli_query($koneksi,"
    SELECT d.*, m.nama_menu
    FROM pesanan_detail d
    JOIN menu m ON d.menu_id = m.id
    WHERE d.pesanan_id = $id
");
?>

<style>
.wrap{padding:30px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border-bottom:1px solid #ddd}
.back{display:inline-block;margin-top:20px}
</style>

<div class="wrap">

<h2>📄 Detail Pesanan #<?= $p['id'] ?></h2>
<p><strong>Pelanggan:</strong> <?= $p['pelanggan'] ?></p>
<p><strong>Status:</strong> <?= $p['status'] ?></p>

<table>
<tr>
    <th>Menu</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php while($d=mysqli_fetch_assoc($detail)): ?>
<tr>
    <td><?= $d['nama_menu'] ?></td>
    <td><?= $d['qty'] ?></td>
    <td>Rp <?= number_format($d['subtotal']) ?></td>
</tr>
<?php endwhile; ?>

<tr>
    <th colspan="2">Total</th>
    <th>Rp <?= number_format($p['total']) ?></th>
</tr>
</table>

<a class="back" href="orders.php">← Kembali</a>

</div>
