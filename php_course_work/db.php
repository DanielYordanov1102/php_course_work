<?php


try {
    $host = 'sql204.infinityfree.com';
    $db   = 'if0_37902962_gamecollection';
    $user = 'if0_37902962';
    $pass = 'rdw1cyOxAhU';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES   => false, 
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>