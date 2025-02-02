<?php
require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['category_id'])) {
    http_response_code(400);
    die("Categoria não especificada.");
}

try {
    $categoryId = $_POST['category_id'];
    $db = getDatabaseConnection();

    $stmt = $db->prepare('DELETE FROM Category WHERE id = ?');
    if ($stmt->execute([$categoryId])) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
