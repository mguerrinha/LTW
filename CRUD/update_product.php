<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');
require_once('../entities/product.class.php');

$db = getDatabaseConnection();

$session = new Session();

try {
    $productId = $_POST['product-id'];
    $productName = $_POST['product-name'];
    $productDescription = $_POST['edit-description'];
    $productPrice = $_POST['edit-price'];
    $productBrand = $_POST['edit-brand'];
    $productModel = $_POST['edit-model'];
    $productSize = $_POST['edit-size'];

    if (empty($productName) || empty($productDescription) || empty($productPrice) || empty($productBrand) || empty($productModel) || empty($productSize)) {
        echo "All fields must be filled.";
        exit;
    }

    $update = $db->prepare('UPDATE Product SET name = :name, description = :description, price = :price, brand = :brand, model = :model, size = :size WHERE id = :productId');
    $update->bindValue(':name', $productName, SQLITE3_TEXT);
    $update->bindValue(':description', $productDescription, SQLITE3_TEXT);
    $update->bindValue(':price', $productPrice, SQLITE3_INTEGER);
    $update->bindValue(':brand', $productBrand, SQLITE3_TEXT);
    $update->bindValue(':model', $productModel, SQLITE3_TEXT);
    $update->bindValue(':size', $productSize, SQLITE3_TEXT);
    $update->bindValue(':productId', $productId, SQLITE3_INTEGER);
    $res = $update->execute();

    if ($res) {
        $session->addNotification("success", "Product updated successfully");
        header("Location: ../pages/productPage.php?product_id=$productId");
    } else {
        $session->addNotification("error", "Failed to update product");
        header("Location: ../pages/productPage.php?product_id=$productId");

    }
} catch (PDOException $e) {
    echo "Erros: " . $e->getMessage();
}
?>