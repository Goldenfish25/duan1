<?php ob_start(); ?>
<h2>Đăng nhập</h2>
<form action="/login" method="post" class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-danger w-100">Đăng nhập</button>
    <div class="mt-3">
        <a href="/forgot-password">Quên mật khẩu?</a>
    </div>
</form>
<?php
$content = ob_get_clean();
$title = 'Đăng nhập';
include __DIR__ . '/../layouts/main.php';

