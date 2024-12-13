<?php
require_once('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);

    if ($product_id <= 0) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Невалидно ID!";
        header('Location: ../index.php?page=products');
        exit;
    }

    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? '';
    $year = $_POST['year'] ?? date('Y');
    $description = $_POST['description'] ?? '';
    $forAuction = isset($_POST['for_auction']) ? 1 : 0;
    $uploadedBy = $_SESSION['user_id'] ?? 0;

    $image = $_FILES['image']['name'];

    if ($image) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        } else {
            $_SESSION['flash']['message']['type'] = 'danger';
            $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
            header('Location: ../index.php?page=products');
            exit;
        }
    } else {
        $query = "SELECT image FROM products WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch();
        $image = $product['image'];
    }

    $query = "UPDATE products 
              SET title = :title, price = :price, year = :year, description = :description, 
                  for_auction = :for_auction, image = :image, uploaded_by = :uploaded_by 
              WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $params = [
        ':title' => $title,
        ':price' => $price,
        ':year' => $year,
        ':description' => $description,
        ':for_auction' => $forAuction,
        ':image' => $image,
        ':uploaded_by' => $uploadedBy,
        ':id' => $product_id,
    ];
    if ($stmt->execute($params)) {
        $_SESSION['flash']['message']['type'] = 'success';
        $_SESSION['flash']['message']['text'] = "Продуктът беше редактиран успешно!";
        header('Location: ../index.php?page=products');
        exit;
    } else {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Грешка при редактиране на продукт!";
        header('Location: ../index.php?page=products');
        exit;
    }
    
}
