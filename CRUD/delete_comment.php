<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');
require_once('../entities/comment.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['id'])) {
    http_response_code(400);
    die("Dados insuficientes para remover o comentário.");
}

try {
    $commentId = $_POST['id'];
    $userId = $session->getId();

    $db = getDatabaseConnection();

    $delete = $db->prepare('DELETE FROM Comment WHERE id = ?');

    if ($delete->execute(array($commentId))) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro: " . $e->getMessage();
}
?>
