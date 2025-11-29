<?php ob_start(); ?>
<h2>Giỏ hàng</h2>
<?php if (empty($items)): ?>
    <p>Giỏ hàng trống, hãy <a href="/menu">chọn món</a>.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Món ăn</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Tạm tính</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item->name ?></td>
                <td><?= number_format($item->price, 0, ',', '.') ?> đ</td>
                <td>
                    <form action="/cart/update" method="post" class="d-flex gap-2">
                        <input type="hidden" name="food_id" value="<?= $item->food_id ?>">
                        <input type="number" name="quantity" class="form-control" min="1" value="<?= $item->quantity ?>">
                        <button class="btn btn-sm btn-outline-secondary">Cập nhật</button>
                    </form>
                </td>
                <td><?= number_format($item->subtotal(), 0, ',', '.') ?> đ</td>
                <td>
                    <form action="/cart/remove" method="post">
                        <input type="hidden" name="food_id" value="<?= $item->food_id ?>">
                        <button class="btn btn-sm btn-link text-danger">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center">
        <h4>Tổng cộng: <?= number_format($total, 0, ',', '.') ?> đ</h4>
        <a href="/checkout" class="btn btn-danger">Thanh toán</a>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();
$title = 'Giỏ hàng';
include __DIR__ . '/../layouts/main.php';

