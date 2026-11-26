<?php
session_start();
require_once 'db.php';

// Already logged in? Go straight to dashboard
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: admin.php');
    exit;
}

// CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        $error = 'Session expired. Please try again.';
    } elseif (hash_equals(ADMIN_EMAIL, $email) && hash_equals(ADMIN_PASSWORD, $pass)) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        usleep(600000); // small delay slows down password guessing
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Thunderbolt Carriers</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --primary: #FFCC00; --cream: #FFFCEE; --dark: #0a0a0a; --muted: #888888; }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #f4f6f9; margin: 0; color: #484848; min-height: 100vh; display: grid; place-items: center; padding: 20px; }
        h1 { font-family: 'Outfit', sans-serif; margin: 0; }

        /* Preloader */
        #preloader { position: fixed; inset: 0; background: #fff; display: flex; align-items: center; justify-content: center; z-index: 999999; transition: opacity .35s ease, visibility .35s ease; }
        #preloader.loaded { opacity: 0; visibility: hidden; }

        .card { width: 100%; max-width: 420px; background: #fff; border-radius: 16px; overflow: hidden; border: 1px solid #eee; box-shadow: 0 12px 40px rgba(0,0,0,.08); }
        .card-head { background: var(--dark); border-bottom: 3px solid var(--primary); padding: 30px 30px 26px; text-align: center; }
        .bolt { width: 56px; height: 56px; border-radius: 50%; background: var(--primary); color: #000; display: grid; place-items: center; font-size: 22px; margin: 0 auto 14px; }
        .card-head h1 { color: #fff; font-size: 24px; font-weight: 600; }
        .card-head p { margin: 6px 0 0; color: #aaa; font-size: 14px; }

        form { padding: 30px; }
        label { display: block; font-weight: 600; font-size: 13px; color: #333; margin-bottom: 6px; }
        .field { position: relative; margin-bottom: 18px; }
        .field i.lead { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: 14px; }
        .field input { width: 100%; padding: 13px 14px 13px 40px; border: 1px solid #ddd; border-radius: 8px; font: 400 15px 'DM Sans', sans-serif; color: #222; transition: border-color .2s, box-shadow .2s; }
        .field input::placeholder { color: var(--muted); }
        .field input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,204,0,.25); }
        .field input:focus ~ i.lead { color: #000; }
        .eye { position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border: none; background: transparent; color: var(--muted); cursor: pointer; border-radius: 50%; }
        .eye:hover { color: #000; }
        .field.pw input { padding-right: 44px; }

        .btn { width: 100%; padding: 14px; margin-top: 6px; border: 1px solid #000; background: #000; color: #fff; border-radius: 40px; font: 700 15px 'DM Sans', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: .3s; }
        .btn:hover { background: var(--primary); color: #000; border-color: var(--primary); }

        .alert-error { background: #ffe0e0; color: #b00020; border-left: 4px solid #b00020; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; gap: 10px; align-items: center; }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>
<body>

<div id="preloader"><img width="200" height="200" src="https://thunderboltcarriers.com/wp-content/uploads/2024/12/preloader.gif" alt="Loading..."></div>

<div class="card">
    <div class="card-head">
        <div class="bolt"><i class="fa-solid fa-bolt"></i></div>
        <h1>Admin Login</h1>
        <p>Sign in to manage consignments</p>
    </div>

    <form method="POST" autocomplete="off">
        <?php if ($error): ?>
            <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <label for="email">Email</label>
        <div class="field">
            <input id="email" type="email" name="email" placeholder="you@thunderboltcarriers.com" required autofocus>
            <i class="fa-solid fa-envelope lead"></i>
        </div>

        <label for="password">Password</label>
        <div class="field pw">
            <input id="password" type="password" name="password" placeholder="Enter your password" required>
            <i class="fa-solid fa-lock lead"></i>
            <button type="button" class="eye" id="eye" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
        </div>

        <button class="btn" type="submit" name="login"><i class="fa-solid fa-right-to-bracket"></i> Sign in</button>
    </form>
</div>

<script>
window.addEventListener('load', function () {
    var p = document.getElementById('preloader');
    if (p) setTimeout(function () { p.classList.add('loaded'); }, 300);
});

document.getElementById('eye').addEventListener('click', function () {
    var input = document.getElementById('password');
    var show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    this.innerHTML = '<i class="fa-solid ' + (show ? 'fa-eye-slash' : 'fa-eye') + '"></i>';
    this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
});
</script>

</body>
</html>