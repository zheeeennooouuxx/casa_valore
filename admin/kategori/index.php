<?php
include "../auth_check.php";
include "../../koneksi.php";
include "../../navbar_admin.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori Menu</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .container {
            padding: 25px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 20px;
            background: #1b6c2e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 25px;
        }

        .category-card {
            width: 220px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .category-card h4 {
            margin-bottom: 15px;
            color: #333;
        }

        .btn-group a {
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 4px;
            display: inline-block;
            font-size: 14px;
        }

        .edit {
            background: orange;
        }

        .delete {
            background: red;
        }

        .btn-group a:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>🍽 Kategori Menu</h2>

    <a href="create.php" class="add-btn">➕ Tambah Kategori</a>

    <div class="category-container">

        <?php
        $q = mysqli_query($koneksi, "SELECT * FROM kategori_menu ORDER BY id DESC");

        while ($row = mysqli_fetch_assoc($q)) {
        ?>
            <div class="category-card">
                <h4><?= htmlspecialchars($row['nama_kategori']); ?></h4>

                <div class="btn-group">
                    <a href="edit.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>"
                       class="delete"
                       onclick="return confirm('Yakin ingin menghapus kategori ini?');">
                        Delete
                    </a>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

</body>
</html>
