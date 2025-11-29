<?php ob_start(); ?>
<h2>Đăng ký</h2>
<form action="/register" method="post" class="col-md-6">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
    </div>
    <button class="btn btn-danger mt-3">Tạo tài khoản</button>
</form>
<?php
$content = ob_get_clean();
$title = 'Đăng ký';
include __DIR__ . '/../layouts/main.php';

