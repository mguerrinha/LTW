<?php
  require_once('../commons/default.php');
  require_once('../commons/shoppingList.php');
  require_once('../database/connection.php');
  require_once('../entities/product.class.php');
  require_once('../entities/session.class.php');
  require_once('../entities/shoppinglist.class.php');
    
  $db = getDatabaseConnection();

  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);

  
  $shoppingList = ShoppingList::getShoppingListByBuyerId($db, $session->getId());

  drawHeader();
  drawShoppingListMain($db, $shoppingList);
  drawFooter(); 
?>