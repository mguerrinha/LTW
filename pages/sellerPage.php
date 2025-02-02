<?php
  require_once('../commons/default.php');
  require_once('../commons/seller.php');
  require_once('../database/connection.php');
  require_once('../entities/session.class.php');

  $db = getDatabaseConnection();

  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);

  drawHeader();
  drawSellerMain($db);
  drawFooter(); 
?>