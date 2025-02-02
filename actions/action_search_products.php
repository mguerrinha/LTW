<?php
require_once('../database/connection.php');
require_once('../entities/product.class.php');

$query = $_GET['query'] ?? '';
$filters = [
    'categories' => !empty($_GET['categories']) ? explode(',', $_GET['categories']) : [],
    'states' => !empty($_GET['states']) ? explode(',', $_GET['states']) : [],
    'price_min' => $_GET['price_min'] ?? null,
    'price_max' => $_GET['price_max'] ?? null
];

$orderBy = $_GET['orderBy'] ?? 'publicationDate';
$orderDirection = $_GET['orderDirection'] ?? 'ASC';

try {
    $db = getDatabaseConnection();
    $products = Product::searchProducts($db, $query, $filters, $orderBy, $orderDirection);

    header('Content-Type: application/json');
    echo json_encode($products);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ocorreu um erro ao procurar os produtos. Tente novamente mais tarde.']);
    error_log($e->getMessage());
}
?>
