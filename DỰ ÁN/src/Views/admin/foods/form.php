<?php ob_start(); ?>
<h2><?= isset($food) ? 'Cập nhật' : 'Thêm' ?> món ăn</h2>
<form action="<?= isset($food) ? '/admin/foods/' . $food->id : '/admin/foods' ?>" method="post" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Tên</label>
        <input type="text" name="name" value="<?= $food->name ?? '' ?>" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" value="<?= $food->slug ?? '' ?>" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Giá</label>
        <input type="number" name="price" value="<?= $food->price ?? '' ?>" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Danh mục</label>
        <select name="category_id" class="form-select">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= isset($food) && $food->category_id === $category->id ? 'selected' : '' ?>>
                    <?= $category->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Ảnh</label>
        <input type="text" name="thumbnail" value="<?= $food->thumbnail ?? '' ?>" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4"><?= $food->description ?? '' ?></textarea>
    </div>
    <?php if (isset($food)): ?>
        <div class="col-12">
            <label class="form-check">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= $food->is_active ? 'checked' : '' ?>>
                <span class="form-check-label">Hiển thị</span>
            </label>
        </div>
    <?php endif; ?>
    <div class="col-12 text-end">
        <button class="btn btn-danger">Lưu</button>
    </div>
</form>
<?php
$content = ob_get_clean();
$title = 'Admin - Món ăn';
include __DIR__ . '/../../layouts/main.php';

