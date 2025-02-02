<?php
  require_once('../commons/default.php');
  require_once('../commons/edit_product.php');
  require_once('../database/connection.php');
  require_once('../entities/session.class.php');
  require_once('../entities/product.class.php');

  $db = getDatabaseConnection();

  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);
  

  if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $product = Product::getProduct($db, $product_id);

    if ($product) {
        drawHeader();
        editProductPage($product);
        drawFooter();
    } else {
        echo "Produto não encontrado.";
    }
  } else {
    echo "ID do produto não fornecido.";
  }
?>