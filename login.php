<?php
session_start();
require_once 'db.php';

// Already logged in? Go straight to dashboard
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pass  = trim($_POST['password']);
    if ($email === ADMIN_EMAIL && $pass === ADMIN_PASSWORD) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Kariez</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --primary: #FFCC00; --dark: #0a0a0a; }
        body { font-family: 'DM Sans', sans-serif; background: #f4f6f9; margin: 0; color: #333; }
        h1, h2 { font-family: 'Outfit', sans-serif; }

        /* PRELOADER */
        #preloader { position: fixed; inset: 0; background: #fff; display: flex; align-items: center; justify-content: center; z-index: 999999; transition: opacity .35s ease, visibility .35s ease; }
        #preloader.loaded { opacity: 0; visibility: hidden; }

        .login-wrap {
            max-width: 420px; margin: 100px auto; background: #fff;
            padding: 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .login-wrap h1 { text-align: center; margin-bottom: 10px; font-size: 28px; }
        .login-wrap p { text-align: center; color: #777; margin-bottom: 30px; font-size: 14px; }
        .login-wrap label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        .login-wrap input {
            width: 100%; padding: 12px 14px; border: 1px solid #ddd; border-radius: 6px;
            font-size: 15px; box-sizing: border-box; margin-bottom: 20px; font-family: 'DM Sans', sans-serif;
        }
        .login-wrap input:focus { outline: none; border-color: var(--primary); }
        .login-wrap button {
            width: 100%; padding: 14px; background: var(--primary); border: none;
            border-radius: 6px; font-size: 16px; font-weight: 700; cursor: pointer; transition: 0.3s;
            font-family: 'DM Sans', sans-serif; color: #000;
        }
        .login-wrap button:hover { background: #000; color: var(--primary); }
        .alert-error { background: #ffe0e0; color: #b00020; border-left: 4px solid #b00020; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

<div id="preloader"><img width="200" height="200" src="https://thunderboltcarriers.com/wp-content/uploads/2024/12/preloader.gif" alt=""></div>

<div class="login-wrap">
    <h1><i class="fa-solid fa-truck-fast" style="color: var(--primary);"></i> Admin Login</h1>
    <p>Enter your credentials to access the dashboard</p>

    <?php if ($error): ?>
        <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label><i class="fa-solid fa-envelope"></i> Email</label>
        <input type="email" name="email" placeholder="admin@kariez.com" required>

        <label><i class="fa-solid fa-lock"></i> Password</label>
        <input type="password" name="password" placeholder="••••••••" required>

        <button type="submit" name="login"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
    </form>
</div>

<script>
window.addEventListener('load', function(){
    var p = document.getElementById('preloader');
    if (p) setTimeout(function(){ p.classList.add('loaded'); }, 300);
});
</script>

</body>
</html>