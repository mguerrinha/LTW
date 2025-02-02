<?php
  require_once('../commons/default.php');
  require_once('../commons/wishList.php');
  require_once('../database/connection.php');
  require_once('../entities/product.class.php');
  require_once('../entities/session.class.php');
  require_once('../entities/wishlist.class.php');

  $db = getDatabaseConnection();
  
  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);

  $wishList = WishList::getWishListByBuyerId($db, $session->getId());

  drawHeader();
  drawWishListMain($db, $wishList);
  drawFooter(); 
?>