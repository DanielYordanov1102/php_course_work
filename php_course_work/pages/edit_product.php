<?php
$product_id = intval($_GET['product_id'] ?? 0);

if ($product_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Invalid product ID!";
    header('Location: ../index.php?page=products');
    exit;
}

$query = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch();
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_edit_product.php" enctype="multipart/form-data">
    <h3 class="text-center">Редактиране</h3>
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($product['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Цена:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="year" class="form-label">Година:</label>
        <input type="number" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($product['year']) ?>" min="2000" max="<?php echo date('Y'); ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание:</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <?php if ($product['image']): ?>
            <img src="./uploads/<?php echo htmlspecialchars($product['image']) ?>" alt="<?php echo htmlspecialchars($product['title']) ?>" class="img-thumbnail">
        <?php endif; ?>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="for_auction" name="for_auction" value="1" <?php echo $product['for_auction'] ? 'checked' : ''; ?>>
        <label class="form-check-label" for="for_auction">За търг</label>
    </div>
    <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
    <button type="submit" class="btn btn-success mx-auto">Запази промените</button>
</form>
