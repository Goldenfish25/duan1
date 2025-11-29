<?php ob_start(); ?>
<h2>Đơn hàng của bạn</h2>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Ngày tạo</th>
        <th>Tổng tiền</th>
        <th>Trạng thái</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order->id ?></td>
            <td><?= $order->created_at ?></td>
            <td><?= number_format($order->total, 0, ',', '.') ?> đ</td>
            <td><span class="badge text-bg-secondary"><?= $order->status ?></span></td>
            <td><a href="/orders/<?= $order->id ?>" class="btn btn-sm btn-outline-primary">Chi tiết</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Đơn hàng';
include __DIR__ . '/../layouts/main.php';

