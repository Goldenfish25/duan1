<?php ob_start(); ?>
<div class="row">
    <div class="col-md-6">
        <img src="<?= $food->thumbnail ?>" class="img-fluid rounded" alt="<?= $food->name ?>">
    </div>
    <div class="col-md-6">
        <h1><?= $food->name ?></h1>
        <p><?= $food->description ?></p>
        <p class="display-6 text-danger"><?= number_format($food->price, 0, ',', '.') ?> đ</p>
        <form action="/cart/add" method="post" class="d-flex gap-2 align-items-center">
            <input type="hidden" name="food_id" value="<?= $food->id ?>">
            <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
            <button class="btn btn-danger">Thêm vào giỏ</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = $food->name;
include __DIR__ . '/layouts/main.php';

