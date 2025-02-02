<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');
require_once('../entities/comment.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['id'], $_POST['commentary'])) {
    http_response_code(400);
    die("Dados insuficientes para adicionar o comentário.");
}

try {
    $userId = $session->getId();
    $productId = $_POST['id'];
    $commentary = $_POST['commentary'];

    date_default_timezone_set('Europe/Lisbon');
    $dateTime = new DateTime();

    $db = getDatabaseConnection();

    $insert = $db->prepare('INSERT INTO Comment (userId, productId, commentary, dateTime) VALUES (?, ?, ?, ?)');

    if ($insert->execute(array($userId, $productId, $commentary, $dateTime->format('Y-m-d H:i:s')))) {
      http_response_code(201);
    } else {
      http_response_code(500);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro: " . $e->getMessage();
}
?>
