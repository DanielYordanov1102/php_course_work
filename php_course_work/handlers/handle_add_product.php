<?php

require_once('../functions.php');
require_once('../db.php');

$uploadedBy = $_SESSION['user_id'] ?? 0;

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$year = $_POST['year'] ?? date('Y');
$description = $_POST['description'] ?? '';
$forAuction = isset($_POST['for_auction']) ? 1 : 0;

if (mb_strlen($title) <= 0 || mb_strlen($price) <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";
    header('Location: ../index.php?page=add_product');
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля качете изображение!";
    header('Location: ../index.php?page=add_product');
    exit;
}

$new_filename = time() . '_' . $_FILES['image']['name'];
$upload_dir = '../uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
    header('Location: ../index.php?page=add_product');
    exit;
}

$query = "INSERT INTO products (title, price, image, year, description, for_auction, uploaded_by) 
          VALUES (:title, :price, :image, :year, :description, :for_auction, :uploaded_by)";
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':image' => $new_filename,
    ':year' => $year,
    ':description' => $description,
    ':for_auction' => $forAuction,
    ':uploaded_by' => $uploadedBy,
];
if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Продуктът беше добавен успешно!";
    header('Location: ../index.php?page=products');
    exit;
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при добавяне на продукт!";
    header('Location: ../index.php?page=add_product');
    exit;
}
