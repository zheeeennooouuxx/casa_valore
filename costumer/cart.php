<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

if (isset($_POST['id_menu'])) {
    $id_menu = $_POST['id_menu'];
    $_SESSION['cart'][$id_menu] = ($_SESSION['cart'][$id_menu] ?? 0) + 1;
}

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="cart.css">
</head>

<body>

<div class="cart-container">
    <h2>🛒 Keranjang Belanja</h2>

    <?php if(empty($cart)): ?>
        <div class="empty-cart">
            <img src="../assets/icon/empty.png" alt="Empty Cart">
            <p>Keranjang kamu masih kosong</p>
            <a href="menu.php" class="back-btn">Lihat Menu</a>
        </div>

    <?php else: ?>

    <table class="cart-table">
        <tr>
            <th>Menu</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>

        <?php
        $total = 0;
        foreach($cart as $id => $qty):
            $q = mysqli_query($koneksi,"SELECT * FROM menu WHERE id=$id");
            $m = mysqli_fetch_assoc($q);
            $sub = $m['harga'] * $qty;
            $total += $sub;
        ?>
        <tr>
            <td>
                <div class="item-info">
                    <img src="../assets/menu/<?= $m['foto'] ?>" alt="<?= $m['nama_menu'] ?>">
                    <span><?= $m['nama_menu'] ?></span>
                </div>
            </td>

            <td>Rp <?= number_format($m['harga'],0,',','.') ?></td>

            <td class="qty-col">
                <?= $qty ?>
            </td>

            <td>Rp <?= number_format($sub,0,',','.') ?></td>

            <td>
                <form method="post" action="remove_item.php">
                    <input type="hidden" name="id_menu" value="<?= $id ?>">
                    <button class="remove-btn">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <div class="total-box">
        <p><strong>Total:</strong> Rp <?= number_format($total,0,',','.') ?></p>
        <a href="checkout.php" class="checkout-btn">Checkout</a>
    </div>

    <?php endif; ?>

</div>

</body>
</html>
