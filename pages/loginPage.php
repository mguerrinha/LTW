<?php
  require_once('../commons/default.php');
  require_once('../commons/login.php');
  require_once('../entities/session.class.php');

  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);
  drawLogIn();
?>


