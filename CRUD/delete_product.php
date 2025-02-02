<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');
require_once('../entities/product.class.php');
 
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
    $sellerId = $session->getId();
    $productId = $_POST['id'];

    $db = getDatabaseConnection();
    $desiredProduct = Product::getProduct($db, $productId);

    $stmt = $db->prepare('SELECT * FROM Product WHERE userId = ? AND id = ?');
    $stmt->execute(array($sellerId, $productId));

    $attempt = $stmt->fetch();

    if ($attempt) {
        $delete = $db->prepare('DELETE FROM Product WHERE userId = ? AND id = ?');
        if ($delete->execute(array($sellerId, $productId))) {
            $imagePath = '../' . $desiredProduct->imagePath;
            
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    } else {
        http_response_code(404);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}

?>