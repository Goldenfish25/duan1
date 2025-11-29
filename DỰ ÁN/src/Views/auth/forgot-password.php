<?php ob_start(); ?>
<h2>Quên mật khẩu</h2>
<form action="/forgot-password" method="post" class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <button class="btn btn-danger w-100">Gửi liên kết</button>
</form>
<?php
$content = ob_get_clean();
$title = 'Quên mật khẩu';
include __DIR__ . '/../layouts/main.php';

