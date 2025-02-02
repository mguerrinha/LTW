<?php

require_once('../database/connection.php');
require_once('../entities/session.class.php');

$session = new Session();

try {
    $userId = $session->getId();
    $userName = trim($_POST["edit-username"]);
    $name = trim($_POST["edit-name"]);
    $surname = trim($_POST["edit-surname"]);
    $email = trim($_POST["edit-email"]);
    $address = trim($_POST["edit-address"]);
    $phoneNumber = trim($_POST["edit-phone-number"]);

    error_log($userId);
    error_log($userName);
    error_log($name);
    error_log($surname);
    error_log($email);
    error_log($address);
    error_log($phoneNumber);

    if (empty($userName) || empty($name) || empty($surname) || empty($email) || empty($address) || empty($phoneNumber)) {
        $session->addNotification("warning", "Username, name, surname, email, address and phoneNumber cannot be empty.");
        exit;
    }

    $db = getDatabaseConnection();

    $update = $db->prepare('UPDATE User SET userName = :userName, name = :name, surname = :surname, email = :email, address = :address, phoneNumber = :phoneNumber WHERE id = :userId');
    $update->bindValue(':userName', $userName, SQLITE3_TEXT);
    $update->bindValue(':name', $name, SQLITE3_TEXT);
    $update->bindValue(':surname', $surname, SQLITE3_TEXT);
    $update->bindValue(':email', $email, SQLITE3_TEXT);
    $update->bindValue(':address', $address, SQLITE3_TEXT);
    $update->bindValue(':phoneNumber', $phoneNumber, SQLITE3_INTEGER);
    $update->bindValue(':userId', $userId, SQLITE3_INTEGER);
    $res = $update->execute();

    if ($res) {
        $session->addNotification("success", "User updated successfully!");
        header("Location: ../pages/profilePage.php");
    }
    else {
        $session->addNotification("success", "Failed to update product!");
        header("Location: ../pages/profilePage.php");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>