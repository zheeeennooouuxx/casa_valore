<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

$pelanggan = $_SESSION['username'];

$q = mysqli_query($koneksi,"
    SELECT * FROM pesanan
    WHERE pelanggan='$pelanggan'
    ORDER BY id DESC
");

$detail_id = $_GET['detail'] ?? null;
?>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f6f6f6;
}
.wrap{padding:30px}
.card{
    background:#fff;
    padding:20px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,.1);
}
table{width:100%;border-collapse:collapse;margin-top:10px}
th,td{padding:8px;border-bottom:1px solid #ddd}
a.btn{
    display:inline-block;
    margin-top:8px;
    text-decoration:none;
    color:#b31e1e;
    font-weight:bold;
}
</style>

<div class="wrap">
<h2>📦 Riwayat Pesanan</h2>

<?php while($o=mysqli_fetch_assoc($q)): ?>
<div class="card">
    <p><strong>ID Pesanan:</strong> <?= $o['id'] ?></p>
    <p><strong>Total:</strong> Rp <?= number_format($o['total']) ?></p>
    <p><strong>Status:</strong> <?= $o['status'] ?></p>
    <small><?= $o['tanggal'] ?></small><br>

   <a class="btn" href="?detail=<?= $o['id'] ?>">📄 Lihat Detail</a>
   <a class="btn" target="_blank"
   href="struk.php?id=<?= $o['id'] ?>">
   🧾 Cetak Struk
   </a>
    <?php if($detail_id == $o['id']): ?>
        <table>
            <tr>
                <th>Menu</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $d = mysqli_query($koneksi,"
                SELECT d.*, m.nama_menu
                FROM pesanan_detail d
                JOIN menu m ON d.menu_id = m.id
                WHERE d.pesanan_id = {$o['id']}
            ");
            while($x=mysqli_fetch_assoc($d)):
            ?>
            <tr>
                <td><?= $x['nama_menu'] ?></td>
                <td><?= $x['qty'] ?></td>
                <td>Rp <?= number_format($x['subtotal']) ?></td>
            </tr>
            <?php endwhile; ?>

            <tr>
                <th colspan="2">Total</th>
                <th>Rp <?= number_format($o['total']) ?></th>
            </tr>
        </table>
    <?php endif; ?>

</div>
<?php endwhile; ?>

</div>
