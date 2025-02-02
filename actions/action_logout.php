<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../entities/session.class.php');
  $session = new Session();
  $session->logout();

  header('Location: ../index.php');
?>