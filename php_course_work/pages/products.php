<?php
require_once('functions.php');
require_once('db.php');

$productId = $_GET['id'] ?? null;

$selectedYears = isset($_GET['years']) ? $_GET['years'] : [];
$sortOrder = $_GET['sort_order'] ?? null;
$yearRange = range(2014, 2024);

if ($productId) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo '<div class="alert alert-danger">Product not found.</div>';
        exit;
    }
    ?>
    <!-- Детайли -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo !filter_var($product['image'], FILTER_VALIDATE_URL) ? './uploads/' . $product['image'] : $product['image']; ?>" class="img-fluid" alt="<?php echo $product['title']; ?>">
            </div>
            <div class="col-md-6">
                <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                <h4 class="text-success mt-3">Цена: <?php echo htmlspecialchars($product['price']); ?> лв.</h4>
                <h5>Година: <?php echo htmlspecialchars($product['year']); ?></h5>
                <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <div class="d-flex flex-column mt-4">
                    <form method="POST" action="handlers/handle_delete_product.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <button type="submit" class="btn btn-success mb-2">Купи сега</button>
                    </form>
                    <a href="index.php?page=edit_product&product_id=<?php echo $product['id']; ?>" class="btn btn-warning mb-2">Редактирай</a>
                    <a href="?page=products" class="btn btn-secondary mb-2">Назад към игри</a>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $query = "SELECT * FROM products";
    $conditions = [];

    if (!empty($selectedYears)) {
        $conditions[] = "year IN (" . implode(',', array_map('intval', $selectedYears)) . ")";
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    if ($sortOrder === 'asc') {
        $query .= " ORDER BY price ASC";
    } elseif ($sortOrder === 'desc') {
        $query .= " ORDER BY price DESC";
    }

    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$products) {
        echo '<div class="alert alert-info">No products available.</div>';
        exit;
    }
    ?>
    <!-- Всички игри -->
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar bg-light p-3">
                    <h2>Филтър</h2>
                    <h4>По година:</h4>
                    <form method="GET" action="?page=products">
                        <input type="hidden" name="page" value="products">
                        <?php foreach ($yearRange as $year): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="year<?php echo $year; ?>" name="years[]" value="<?php echo $year; ?>" <?php echo in_array($year, $selectedYears) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="year<?php echo $year; ?>"><?php echo $year; ?></label>
                            </div>
                        <?php endforeach; ?>
                        <h4 class="mt-4">По цена:</h4>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="sortAsc" name="sort_order" value="asc" <?php echo $sortOrder === 'asc' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="sortAsc">Възходяща</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="sortDesc" name="sort_order" value="desc" <?php echo $sortOrder === 'desc' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="sortDesc">Низходяща</label>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Филтрирай</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9">
                <h1 class="mt-4">Игри</h1>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?php echo !filter_var($product['image'], FILTER_VALIDATE_URL) ? './uploads/' . $product['image'] : $product['image']; ?>" class="card-img-top" alt="<?php echo $product['title']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                                    <h6 class="text-success">Цена: <?php echo htmlspecialchars($product['price']); ?> лв.</h6>
                                    <h6>Година: <?php echo htmlspecialchars($product['year']); ?></h6>
                                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                                    <a href="?page=products&id=<?php echo $product['id']; ?>" class="btn btn-primary">Детайли</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
