<?php
  require_once('../commons/default.php');
  require_once('../commons/signup.php');
  require_once('../entities/session.class.php');


  $session = new Session();
  if (count($session->getNotifications())) drawNotifications($session);

  drawSignUp();
?>
