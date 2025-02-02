<?php
require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['category_name'])) {
    http_response_code(400);
    die("Categoria não especificada.");
}

$categoryName = $_POST['category_name'];

try {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('INSERT INTO Category (name) VALUES (?)');
    $stmt->execute([$categoryName]);

    $newCategoryId = $db->lastInsertId();
    $newCategory = [
        "id" => $newCategoryId,
        "name" => $categoryName
    ];

    header('Content-Type: application/json');
    echo json_encode($newCategory);
    http_response_code(200);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
