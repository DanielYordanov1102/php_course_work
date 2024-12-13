<?php
require_once('functions.php');
require_once('db.php');

$query = "SELECT * FROM collection";
$stmt = $pdo->query($query);
$collectionItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$collectionItems) {
    echo '<div class="alert alert-info">Няма игри в колекцията.</div>';
    exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Колекция</h1>
            <div class="row">
                <?php foreach ($collectionItems as $item): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo !filter_var($item['image'], FILTER_VALIDATE_URL) ? './uploads/' . $item['image'] : $item['image']; ?>" class="card-img-top" alt="<?php echo $item['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <h6 class="text-success">Цена: <?php echo htmlspecialchars($item['price']); ?> лв.</h6>
                                <h6>Година: <?php echo htmlspecialchars($item['year']); ?></h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
