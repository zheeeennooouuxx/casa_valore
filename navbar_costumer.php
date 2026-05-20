<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* BASE URL PROJECT */
define("BASE_URL", "/sistem_restoran/");

/* Username */
$username = $_SESSION['username'] ?? 'User';
?>

<style>
    body {
        margin: 0;
        padding: 0;
    }

    .navbar {
        background: #ffffff;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        border-bottom: 5px solid #b31e1e;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .navbar .logo {
        font-family: "Playfair Display", serif;
        font-size: 26px;
        font-weight: bold;
        color: #333;
    }

    .navbar ul {
        display: flex;
        gap: 25px;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    .navbar ul li a {
        text-decoration: none;
        padding: 6px 12px;
        color: #333;
        font-size: 16px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .navbar ul li a:hover {
        background: #1b6c2e;
        color: white;
    }

    .logout-btn {
        background: #b31e1e !important;
        color: white !important;
    }

    .logout-btn:hover {
        background: #8c1515 !important;
        color: white !important;
    }

    .user {
        font-weight: bold;
        color: #1b6c2e;
    }
</style>

<nav class="navbar">
    <div class="logo">🍝 Casa Valoré</div>

    <ul>
        <li><a href="<?= BASE_URL ?>costumer/dashboard.php">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>costumer/index.php">Menu</a></li>
        <li><a href="<?= BASE_URL ?>costumer/cart.php">Keranjang</a></li>
        <li><a href="<?= BASE_URL ?>costumer/orders.php">Riwayat</a></li>

        <li class="user">👤 <?= htmlspecialchars($username) ?></li>

        <li>
            <a class="logout-btn" href="<?= BASE_URL ?>logout.php">Logout</a>
        </li>
    </ul>
</nav>
