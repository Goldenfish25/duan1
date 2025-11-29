<?php ob_start(); ?>
<h2>Thanh toán</h2>
<?php if (empty($items)): ?>
    <p>Giỏ hàng trống, hãy <a href="/menu">chọn món</a>.</p>
<?php else: ?>
<div class="row">
    <div class="col-md-7">
        <form action="/checkout" method="post" class="row g-3">
    <div class="col-12">
        <label class="form-label">Địa chỉ giao hàng</label>
        <textarea name="delivery_address" class="form-control" required></textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Phương thức thanh toán</label>
        <select name="payment_method" class="form-select">
            <option value="cod">Thanh toán khi nhận hàng</option>
            <option value="bank">Chuyển khoản</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Ghi chú</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>
        <div class="col-12 text-end">
        <button class="btn btn-danger">Đặt hàng</button>
    </div>
        </form>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Đơn hàng</div>
            <ul class="list-group list-group-flush">
                <?php foreach ($items as $item): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?= $item->name ?> x <?= $item->quantity ?></span>
                        <strong><?= number_format($item->subtotal(), 0, ',', '.') ?> đ</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="card-footer text-end">
                <strong>Tổng: <?= number_format($total, 0, ',', '.') ?> đ</strong>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php
$content = ob_get_clean();
$title = 'Thanh toán';
include __DIR__ . '/../layouts/main.php';

