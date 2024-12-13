<?php

require_once('../functions.php');
require_once('../db.php');

$id = intval($_POST['product_id'] ?? 0);
$userId = intval($_POST['user_id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешен идентификатор на игра!";
    header('Location: ../index.php?page=products');
    exit;
}

$pdo->beginTransaction();

try {
    $query = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception("Product not found");
    }

    $query = "INSERT INTO collection (title, image, price, year, user_collection)
              VALUES (:title, :image, :price, :year, :user_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':title' => $product['title'],
        ':image' => $product['image'],
        ':price' => $product['price'],
        ':year' => $product['year'],
        ':user_id' => $userId
    ]);

    $query = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $pdo->commit();

    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Играта беше успешно закупена!";
} catch (Exception $e) {
    $pdo->rollBack();

    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка: " . $e->getMessage();
}

header('Location: ../index.php?page=products');
exit;
