<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/commons/default.php');
  require_once(__DIR__ . '/commons/buyer.php');
  require_once(__DIR__ . '/database/connection.php');
  require_once(__DIR__ . '/entities/product.class.php');
  require_once(__DIR__ . '/entities/session.class.php');
  
  $session = new Session();
  $db = getDatabaseConnection();
  if (count($session->getNotifications())) drawNotifications($session);

  drawHeader();
  drawBuyerMain($db);
  drawFooter(); 
?>
