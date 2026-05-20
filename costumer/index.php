<?php
include "auth_customer.php";
include "../koneksi.php";
include "../navbar_costumer.php";

/* -------------------------------
   AMBIL DATA KATEGORI
--------------------------------*/
$kategori = mysqli_query($koneksi, "SELECT * FROM kategori_menu");

$filter = isset($_GET['kategori']) ? intval($_GET['kategori']) : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

/* -------------------------------
   QUERY BEST SELLER OTOMATIS
--------------------------------*/
$bestSellerQuery = mysqli_query($koneksi, "
    SELECT menu_id, SUM(qty) AS total
    FROM pesanan_detail
    GROUP BY menu_id
    ORDER BY total DESC
    LIMIT 5
");

$bestSeller = [];
while ($b = mysqli_fetch_assoc($bestSellerQuery)) {
    $bestSeller[] = $b['menu_id'];
}

/* -------------------------------
   QUERY MENU + BEST SELLER PALING ATAS
--------------------------------*/
$query = "
    SELECT m.*, k.nama_kategori 
    FROM menu m 
    JOIN kategori_menu k ON m.kategori_id = k.id 
    WHERE 1
";

if ($filter) {
    $query .= " AND m.kategori_id = $filter";
}

if ($search) {
    $query .= " AND m.nama_menu LIKE '%$search%'";
}

/* Urutkan Best Seller paling atas */
if (!empty($bestSeller)) {
    $query .= " ORDER BY (m.id IN (" . implode(",", $bestSeller) . ")) DESC, m.id DESC";
} else {
    $query .= " ORDER BY m.id DESC";
}

$menu = mysqli_query($koneksi, $query);
?>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f6f6f6;
}
.menu-wrapper {
    padding: 35px;
}

h2 {
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center
}

.search-filter {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
}

.search-filter input, .search-filter select {
    padding: 12px;
    border: 1px solid #bbb;
    border-radius: 10px;
    width: 100%;
    font-size: 15px;
    transition: .2s;
}

.search-filter input:focus, .search-filter select:focus {
    border-color: #b31e1e;
    box-shadow: 0 0 5px rgba(179,30,30,.4);
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 28px;
}

.menu-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    overflow: hidden;
    transition: .3s ease;
    position: relative;
}

.menu-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 22px rgba(0,0,0,.18);
}

.menu-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.menu-tag {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #b31e1e;
    padding: 5px 10px;
    color: white;
    font-size: 13px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,.2);
}

.menu-body {
    padding: 18px;
}

.menu-body h4 {
    margin: 0;
    font-size: 19px;
    font-weight: 600;
    margin-bottom: 4px;
}

.menu-body small {
    color: #777;
    font-size: 14px;
}

.menu-body strong {
    display: block;
    margin: 12px 0;
    font-size: 19px;
    color: #b31e1e;
    font-weight: 700;
}

.menu-body button {
    background: linear-gradient(90deg, #b31e1e, #d72626);
    color: white;
    border: none;
    padding: 11px;
    width: 100%;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: .2s;
}

.menu-body button:hover {
    background: linear-gradient(90deg, #a81818, #c91f1f);
    transform: scale(1.03);
}
</style>

<div class="menu-wrapper">
    <h2>🍽️ Daftar Menu</h2>

    <form method="GET" class="search-filter">
        <input type="text" name="search" placeholder="Cari menu..." value="<?= $search ?>">

        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php while($k = mysqli_fetch_assoc($kategori)) : ?>
                <option value="<?= $k['id'] ?>" <?= ($filter == $k['id']) ? 'selected' : '' ?>>
                    <?= $k['nama_kategori'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button style="padding:10px 20px; border:none; background:#b31e1e; color:white; border-radius:8px; cursor:pointer;">Filter</button>
    </form>

    <div class="menu-grid">
    <?php while($m = mysqli_fetch_assoc($menu)) : ?>
        <div class="menu-card">
            <img src="../assets/menu/<?= $m['foto'] ?? 'food.jpg' ?>">

            <!-- BEST SELLER BADGE OTOMATIS -->
            <?php if (in_array($m['id'], $bestSeller)) : ?>
                <div class="menu-tag">⭐ Best Seller</div>
            <?php endif; ?>

            <div class="menu-body">
                <h4><?= $m['nama_menu'] ?></h4>
                <small><?= $m['nama_kategori'] ?></small>
                <strong>Rp <?= number_format($m['harga']) ?></strong>

                <form method="post" action="cart.php">
                    <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
                    <button>Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</div>
