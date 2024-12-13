<?php
require_once('db.php'); 

$product_id = intval($_GET['product_id'] ?? 0);

if ($product_id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Invalid product ID!";
    header('Location: ./index.php?page=products');
    exit;
}

$query = "SELECT id, title, price, image FROM products WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $product_id]);
$product = $stmt->fetch();

?>

<div class="container">
    <div class="card mb-4">
        <img src="<?php echo !filter_var($product['image'], FILTER_VALIDATE_URL) ? './uploads/' . $product['image'] : $product['image']; ?>" class="card-img-top" alt="<?php echo $product['title']; ?>" style="width: 100%; height: 100%;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $product['title']; ?></h5>
            <p class="card-text"><?php echo $product['price']; ?> USD</p>
        </div>
    </div>
</div>
