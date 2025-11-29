<?php ob_start(); ?>
<h2>Đơn hàng #<?= $order->id ?></h2>
<p><strong>Trạng thái:</strong> <?= $order->status ?></p>
<p><strong>Địa chỉ:</strong> <?= $order->delivery_address ?></p>
<p><strong>Thanh toán:</strong> <?= $order->payment_method ?></p>

<table class="table">
    <thead>
    <tr>
        <th>Món ăn</th>
        <th>Số lượng</th>
        <th>Giá</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item->food_id ?></td>
            <td><?= $item->quantity ?></td>
            <td><?= number_format($item->price, 0, ',', '.') ?> đ</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
$title = 'Chi tiết đơn hàng';
include __DIR__ . '/../layouts/main.php';

