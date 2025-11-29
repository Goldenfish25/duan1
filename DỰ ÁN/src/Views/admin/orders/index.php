<?php ob_start(); ?>
<h2>Quản lý đơn hàng</h2>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Khách hàng</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order->id ?></td>
            <td><?= $order->user_id ?></td>
            <td><?= number_format($order->total, 0, ',', '.') ?> đ</td>
            <td>
                <form action="/admin/orders/<?= $order->id ?>/status" method="post" class="d-flex gap-2">
                    <select name="status" class="form-select form-select-sm">
                        <?php foreach (['pending','processing','completed','cancelled'] as $status): ?>
                            <option value="<?= $status ?>" <?= $order->status === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary">Lưu</button>
                </form>
            </td>
            <td><a href="/orders/<?= $order->id ?>" class="btn btn-sm btn-link">Xem</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Admin - Đơn hàng';
include __DIR__ . '/../../layouts/main.php';

