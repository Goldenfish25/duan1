<?php use App\Core\Session; use App\Services\AuthService; $auth = new AuthService(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Foodly' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Foodly</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/menu">Thực đơn</a></li>
                <li class="nav-item"><a class="nav-link" href="/cart">Giỏ hàng</a></li>
                <?php if ($auth->isAdmin()): ?>
                    <li class="nav-item"><a class="nav-link" href="/admin">Quản trị</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($auth->check()): ?>
                    <li class="nav-item"><span class="navbar-text me-3">Chào, <?= htmlspecialchars($auth->user()->name) ?></span></li>
                    <li class="nav-item">
                        <form action="/logout" method="post">
                            <button class="btn btn-sm btn-light">Đăng xuất</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/login">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container mb-5">
    <?php if ($message = Session::flash('success')): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    <?php if ($error = Session::flash('error')): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <?= $content ?? '' ?>
</main>
<footer class="bg-light py-3">
    <div class="container text-center">
        © <?= date('Y') ?> Foodly - Đặt đồ ăn online
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

