<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

try{
    $userId = $session->getId();
    $name=$_POST["name_product"];
    $description=$_POST["description_product"];
    $brand = $_POST["brand_product"];
    $model = $_POST["model_product"];
    $size = $_POST["size_product"];
    $price=$_POST["price_product"];
    $state=$_POST["state_product"];
    $categories = $_POST["categories_product"];
    $currentDate = date('Y-m-d');

    $db = getDatabaseConnection();
    
    $uploadFileDir = '../images/uploaded_images/';
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    $imagePath = '';
    if (isset($_FILES['image_product']) && $_FILES['image_product']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image_product']['tmp_name'];
        $fileName = $_FILES['image_product']['name'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $imagePath = 'images/uploaded_images/' . $newFileName;
        } else {
            throw new Exception('Erro no upload da imagem.');
        }
    }

    $insert = $db->prepare('INSERT INTO Product (userId, publicationDate, name, description, brand, model, size, price, state, imagePath) VALUES(?,?,?,?,?,?,?,?,?,?)');
    $insert->execute([$userId, $currentDate, $name, $description, $brand, $model, $size, $price, $state, $imagePath]);

    if ($insert->rowCount() > 0) {
        $productId = $db->lastInsertId();

        $insertCategory = $db->prepare('INSERT INTO ProductCategory (productId, categoryId) VALUES (?, ?)');
        foreach ($categories as $categoryId) {
            $insertCategory->execute([$productId, $categoryId]);
        }

        $session->addNotification("success", "Product added successfully!");
        header("Location: ../pages/sellerPage.php");
    } else {
        $session->addNotification("error", "Failed to add product!");
        header("Location: ../pages/sellerPage.php");
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
?>