<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    die("Produto não especificado.");
}

try {
    $buyerId = $session->getId();
    $productId = $_POST['id'];

    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM WishList WHERE buyerId = ? AND productId = ?');
    $stmt->execute(array($buyerId, $productId));

    $attempt = $stmt->fetch();

    if (!$attempt) {
        $insert = $db->prepare('INSERT INTO WishList (buyerId, productId) VALUES (?, ?)');
        
        if ($insert->execute(array($buyerId, $productId))) {
            http_response_code(201);
        } else {
            http_response_code(500);
        }
    } else {
        http_response_code(409);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
