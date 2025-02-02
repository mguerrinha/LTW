<?php
    require_once('../commons/default.php');
    require_once('../commons/profile.php');
    require_once('../database/connection.php');
    require_once('../entities/user.class.php');
    require_once('../entities/session.class.php');
    
    $db = getDatabaseConnection();
    
    $session = new Session();
    if (count($session->getNotifications())) drawNotifications($session);
    
    if ($session->getId()) {
        $user = User::getUser($db,  $session->getId());
        if ($user) {
            drawHeader();
            drawProfilePage($user);
            drawFooter();
        }
        else {
            echo "User não encontrado.";
        }
    }
    else {
        echo "ID do user não fornecido.";
    }

?>