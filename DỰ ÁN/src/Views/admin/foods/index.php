<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Quản lý món ăn</h2>
    <a href="/admin/foods/create" class="btn btn-danger">Thêm món</a>
    </div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Tên</th>
        <th>Giá</th>
        <th>Trạng thái</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($foods as $food): ?>
        <tr>
            <td><?= $food->id ?></td>
            <td><?= $food->name ?></td>
            <td><?= number_format($food->price, 0, ',', '.') ?> đ</td>
            <td><?= $food->is_active ? 'Hiển thị' : 'Ẩn' ?></td>
            <td class="text-end">
                <a href="/admin/foods/<?= $food->id ?>/edit" class="btn btn-sm btn-outline-secondary">Sửa</a>
                <form action="/admin/foods/<?= $food->id ?>/delete" method="post" class="d-inline">
                    <button class="btn btn-sm btn-link text-danger">Xóa</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Admin - Món ăn';
include __DIR__ . '/../../layouts/main.php';

