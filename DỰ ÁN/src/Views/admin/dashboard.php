<?php ob_start(); ?>
<h2>Dashboard</h2>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Đơn hàng mới</div>
            <ul class="list-group list-group-flush">
                <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>#<?= $order->id ?> - <?= $order->status ?></span>
                        <strong><?= number_format($order->total, 0, ',', '.') ?> đ</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Món ăn gần đây</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($foods as $food): ?>
                    <li class="list-group-item"><?= $food->name ?> - <?= number_format($food->price, 0, ',', '.') ?> đ</li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Admin - Dashboard';
include __DIR__ . '/../layouts/main.php';

