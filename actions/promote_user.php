<?php
require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método não suportado.");
}

if (!isset($_POST['user_id'])) {
    http_response_code(400);
    die("Usuário não especificado.");
}

$userIdToPromote = intval($_POST['user_id']);

try {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE User SET isAdmin = 1 WHERE id = ?');
    $stmt->execute([$userIdToPromote]);
    http_response_code(200);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>
