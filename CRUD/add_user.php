<?php      
        include('../database/connection.php');
        require_once('../entities/session.class.php');

        $session = new Session();

        $email=$_POST["email"];
        $userName=$_POST["username"];
        $name=$_POST["name"];
        $surname=$_POST["surname"];
        $password=$_POST["password"];
        $phoneNumber=$_POST["phoneNumber"];
        $address=$_POST["address"];
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $session->addNotification('warning', "Valid email is required");
            die(header("Location: ../pages/signupPage.php"));
        }
        
        if (strlen($password) < 8) {
            $session->addNotification('warning', "Password must be at least 8 characters");
            die(header("Location: ../pages/signupPage.php"));
        }
        
        if ( ! preg_match("/[a-zA-Z\s]/i", $password)) {
            $session->addNotification('warning', "Password must contain at least one letter");
            die(header("Location: ../pages/signupPage.php"));
        }
        
        if ( ! preg_match("/[0-9]/", $password)) {
            $session->addNotification('warning', "Password must contain at least one number");
            die(header("Location: ../pages/signupPage.php"));
        }
        
        if ($password !== $_POST["password_confirmation"]) {
            $session->addNotification('warning', "The Passwords Must Be The Same");
            die(header("Location: ../pages/signupPage.php"));
        }

        $db = getDatabaseConnection();
        
        $user = $db->prepare('SELECT * FROM User WHERE email = ?');
        $user->execute(array($email));
        $users = $user->fetch();

        if($users['email'] != $email){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $insert = $db->prepare('INSERT INTO User (userName, name, surname, password, email, phoneNumber, address) VALUES(?,?,?,?,?,?,?)');
            $insert->execute(array($userName, $name, $surname, $password_hash, $email, $phoneNumber, $address));

            $id = $db->prepare('SELECT id FROM User WHERE email = ?');
            $id->execute(array($email));
            $user_id = $id->fetch();
            $session->setId($user_id['id']);

            $session->addNotification('success', "User added successfully");
            header("Location: ../index.php");
            
        } else{  
            $session->addNotification('warning', "This Email is already in use");
            die(header("Location: ../pages/signupPage.php"));   
        }
?> 