<?php ob_start(); ?>
<div class="row">
    <div class="col-md-8">
        <h2>Món ăn nổi bật</h2>
        <div class="row">
            <?php foreach ($featuredFoods as $food): ?>
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <img src="<?= $food->thumbnail ?>" class="card-img-top" alt="<?= $food->name ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $food->name ?></h5>
                            <p class="card-text text-danger fw-bold"><?= number_format($food->price, 0, ',', '.') ?> đ</p>
                            <a href="/foods/<?= $food->id ?>" class="btn btn-outline-danger btn-sm">Chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4">
        <h2>Danh mục</h2>
        <div class="list-group">
            <?php foreach ($categories as $category): ?>
                <div class="list-group-item"><?= $category->name ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Foodly - Đặt đồ ăn online';
include __DIR__ . '/layouts/main.php';

