<?php
  require_once('../commons/default.php');
  require_once('../commons/admin.php');
  require_once('../database/connection.php');
  require_once('../entities/session.class.php');

  $db = getDatabaseConnection();

  drawHeader();
  drawAdminMain($db);
  drawFooter(); 
?>