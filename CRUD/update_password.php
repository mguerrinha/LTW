<?php
require_once('../database/connection.php');
require_once('../entities/session.class.php');
require_once('../entities/user.class.php');

$session = new Session();

try {
    $db = getDatabaseConnection();
    $user = User::getUser($db,  $session->getId());
    $password = $user->password;
    $current_password = $_POST['edit-password'];
    $new_password = $_POST['edit-new-password'];
    $confirm_password = $_POST['edit-confirm-password'];

    if (!password_verify($current_password, $password)){
        $session->addNotification("warning", "Current password different");
        die(header("Location: ../pages/profilePage.php"));
    }

    if (strlen($new_password) < 8) {
        $session->addNotification("warning", "New password should have more than 8 characters");
        die(header("Location: ../pages/profilePage.php"));
    }
    
    if ( ! preg_match("/[a-zA-Z\s]/i", $new_password)) {
        $session->addNotification("warning", "New password should contain at least 1 letter");
        die(header("Location: ../pages/profilePage.php"));
    }
    
    if ( ! preg_match("/[0-9]/", $new_password)) {
        $session->addNotification("warning", "New password should contain a number");
        die(header("Location: ../pages/profilePage.php"));
    }

    if ($new_password !== $confirm_password) {
        $session->addNotification("warning", "Passwords don't match");
        die(header("Location: ../pages/profilePage.php"));
    }

    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    echo $password_hash;
    echo $user->id;
    $update = $db->prepare('UPDATE User SET password = :password WHERE id = :userId');
    $update->bindValue(':password', $password_hash, SQLITE3_TEXT);
    $update->bindValue(':userId', $user->id, SQLITE3_INTEGER);
    $res = $update->execute();
    if ($res) {
        $session->addNotification("success", "Password chenged successfully");
        header("Location: ../pages/loginPage.php");
    }
    else {
        $session->addNotification("error", "Failed to update password");
        header("Location: ../pages/profilePage.php");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();

}
?>