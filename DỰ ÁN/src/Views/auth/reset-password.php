<?php ob_start(); ?>
<h2>Đặt lại mật khẩu</h2>
<form action="/reset-password" method="post" class="col-md-4">
    <input type="hidden" name="token" value="<?= $token ?>">
    <div class="mb-3">
        <label class="form-label">Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <button class="btn btn-danger w-100">Cập nhật</button>
</form>
<?php
$content = ob_get_clean();
$title = 'Đặt lại mật khẩu';
include __DIR__ . '/../layouts/main.php';

