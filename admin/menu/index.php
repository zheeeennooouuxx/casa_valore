<?php
include $_SERVER['DOCUMENT_ROOT'] . '/sistem_restoran/admin/auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sistem_restoran/koneksi.php';
include $_SERVER['DOCUMENT_ROOT'] . '/sistem_restoran/navbar_admin.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Menu</title>

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #eef2f3;
    }

    h2 {
        padding: 25px 30px 10px;
        margin: 0;
        font-size: 26px;
        color: #1b6c2e;
        font-weight: 700;
    }

    .add-btn {
        margin-left: 30px;
        display: inline-block;
        padding: 10px 18px;
        background: #1b6c2e;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.2s;
    }

    .add-btn:hover {
        background: #145323;
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 22px;
        padding: 30px;
        padding-top: 10px;
    }

    .menu-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.13);
    }

    .menu-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        background: #e6e6e6;
    }

    .menu-info {
        padding: 16px;
    }

    .menu-info h4 {
        margin: 0;
        font-size: 18px;
        color: #222;
        font-weight: 600;
    }

    .menu-info p {
        margin: 6px 0;
        color: #666;
        font-size: 14px;
    }

    .btn-group {
        margin-top: 15px;
        display: flex;
        gap: 8px;
    }

    .btn-group a {
        flex: 1;
        padding: 8px;
        text-align: center;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: bold;
        transition: 0.2s;
    }

    .edit {
        background: #f29d14;
    }
    .edit:hover {
        background: #d1840f;
    }

    .delete {
        background: #c52626;
    }
    .delete:hover {
        background: #9d1e1e;
    }
</style>
</head>

<body>

<h2>🍽️ Daftar Menu Restoran</h2>
<a href="create.php" class="add-btn">➕ Tambah Menu</a>

<div class="menu-container">

<?php
$q = mysqli_query($koneksi,"
    SELECT menu.*, kategori_menu.nama_kategori
    FROM menu
    JOIN kategori_menu ON menu.kategori_id = kategori_menu.id
    ORDER BY menu.id DESC
");

while ($row = mysqli_fetch_assoc($q)):

$imgUrl  = "/sistem_restoran/assets/menu/" . $row['foto'];
$imgFile = $_SERVER['DOCUMENT_ROOT'] . $imgUrl;
?>

<div class="menu-card">
    <img src="<?= file_exists($imgFile) ? $imgUrl : '/sistem_restoran/assets/no-image.png'; ?>">

    <div class="menu-info">
        <h4><?= htmlspecialchars($row['nama_menu']); ?></h4>
        <p>💰 Rp <?= number_format($row['harga']); ?></p>
        <p>📂 <?= htmlspecialchars($row['nama_kategori']); ?></p>

        <div class="btn-group">
            <a href="edit.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
            <a href="delete.php?id=<?= $row['id']; ?>"
               class="delete"
               onclick="return confirm('Hapus menu ini?')">Delete</a>
        </div>
    </div>
</div>

<?php endwhile; ?>
</div>
</body>
</html>
