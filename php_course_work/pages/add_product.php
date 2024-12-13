<?php
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_add_product.php" enctype="multipart/form-data">
    <h3 class="text-center">Добави продукт</h3>
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Цена:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="year" class="form-label">Година:</label>
        <input type="number" class="form-control" id="year" name="year" min="2000" max="<?php echo date('Y'); ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание:</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="for_auction" name="for_auction" value="1">
        <label class="form-check-label" for="for_auction">За търг</label>
    </div>
    <button type="submit" class="btn btn-success mx-auto">Добави</button>
</form>
