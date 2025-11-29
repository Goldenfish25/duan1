<?php http_response_code(404); ?>
<?php ob_start(); ?>
<div class="text-center py-5">
    <h1>404</h1>
    <p>Trang bạn tìm không tồn tại.</p>
    <a href="/" class="btn btn-danger">Về trang chủ</a>
</div>
<?php
$content = ob_get_clean();
$title = 'Không tìm thấy trang';
include __DIR__ . '/../layouts/main.php';

