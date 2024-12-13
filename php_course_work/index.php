<?php
session_start();
require_once('functions.php');
require_once('db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Game Collection</title>
    <!-- Add no-cache headers -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha384-qH6Pq7d4jJ4X1v6cmGoztLomD1HjjbP5N3+5zQmRgtz4/E+j65FB1M8o7HTNTG4z" crossorigin="anonymous">

    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .image-panel {
            text-align: center;
            margin-bottom: 20px;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            display: inline-block;
        }
        .summary-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }
        .price {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn {
            width: 100%;
        }
        .sidebar {
            position: sticky;
            top: 0;
            height: 100%;
            padding-right: 15px;
        }
        .sidebar h4 {
            margin-bottom: 15px;
        }
        #userDropdown i {
            color: #fff;
            cursor: pointer;
        }
        .dropdown-menu {
            min-width: 200px;
            font-size: 0.9rem;
        }
        
    </style>
    
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="?page=home">The Game Collection</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo($page == 'home' ? 'active' : '') ?>" aria-current="page" href="?page=home">Начало</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo($page == 'products' ? 'active' : '') ?>" href="?page=products">Игри</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo($page == 'contacts' ? 'active' : '') ?>" href="?page=contacts">Контакти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo($page == 'add_product' ? 'active' : '') ?>" href="?page=add_product">Добави продукт</a>
                    </li>
                </ul>
                <div class="d-flex flex-row align-items-center gap-3">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="?page=collection" class="btn btn-outline-light d-flex align-items-center gap-2">
                            <i class="bi bi-bag-check" style="font-size: 1.2rem;"></i> Колекция
                        </a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-light d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item disabled">Здравей, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="./handlers/handle_logout.php" class="m-0">
                                        <button type="submit" class="dropdown-item text-danger">Изход</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="?page=login" class="btn btn-outline-light">Вход</a>
                        <a href="?page=register" class="btn btn-outline-light">Регистрация</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>


    <main class="container py-4" style="min-height:80vh;">
        <?php
            if (isset($flash['message'])) {
                echo '
                    <div class="alert alert-' . $flash['message']['type'] . '">
                        ' . $flash['message']['text'] . '
                    </div>
                ';
            }

            if (file_exists("pages/$page.php")) {
                require_once("pages/$page.php");
            } else {
                require_once("pages/not_found.php");
            }
        ?>
    </main>
    <footer class="bg-dark text-center py-5 mt-auto">
        <div class="container">
            <span class="text-light">© 2024 All rights reserved</span>
        </div>
    </footer>
</body>
</html>
