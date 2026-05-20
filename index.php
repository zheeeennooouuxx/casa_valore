<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Casa Valoré</title>

<style>
*{
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    /* ✅ BACKGROUND */
    background: linear-gradient(
        135deg,
        rgba(179,30,30,0.9),
        rgba(27,108,46,0.9)
    ),
    url("assets/background/bg-login.jpg") center/cover no-repeat;
}

.login-box{
    background:#fff;
    width:360px;
    padding:30px;
    border-radius:16px;
    box-shadow:0 15px 40px rgba(0,0,0,.3);
}

.login-box h2{
    text-align:center;
    margin-bottom:20px;
}

.login-box input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
}

.login-box button{
    width:100%;
    padding:10px;
    background:#b31e1e;
    border:none;
    color:white;
    border-radius:8px;
    font-size:15px;
    cursor:pointer;
}

.login-box button:hover{
    background:#8c1515;
}

.login-box small{
    display:block;
    margin-top:10px;
    text-align:center;
}

.error{
    background:#fbeaea;
    color:#b31e1e;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    text-align:center;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🍝 Casa Valoré</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="error">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login_process.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <small>© <?= date('Y') ?> Casa Valoré</small>
</div>

</body>
</html>
