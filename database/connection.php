<?php

  function getDatabaseConnection() {
    return new PDO('sqlite:'.__DIR__.'/database.db');
  }

?>