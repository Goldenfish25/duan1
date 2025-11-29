<?php ob_start(); ?>
<h2>Thực đơn</h2>
<div class="row">
    <?php foreach ($foods as $food): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="<?= $food->thumbnail ?>" class="card-img-top" alt="<?= $food->name ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $food->name ?></h5>
                    <p class="text-muted"><?= $food->description ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-danger"><?= number_format($food->price, 0, ',', '.') ?> đ</span>
                        <form action="/cart/add" method="post">
                            <input type="hidden" name="food_id" value="<?= $food->id ?>">
                            <button class="btn btn-sm btn-danger">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Thực đơn';
include __DIR__ . '/layouts/main.php';

