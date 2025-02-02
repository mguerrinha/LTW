<?php      
        include('../database/connection.php');
        require_once('../entities/session.class.php');

        $session = new Session();

        $db = getDatabaseConnection();
        
        $email=trim($_POST["email"]);
        $userName=trim($_POST["username"]);
        $password=trim($_POST["password"]);
    

        $pass = $db->prepare('SELECT password FROM User WHERE email = ?');
        $pass->execute(array($email));
        $password_hash = $pass->fetch();
        $user = $db->prepare('SELECT userName FROM User WHERE email = ?');
        $user->execute(array($email));
        $name = $user->fetch();

        if ($userName != $name['userName']){
            $session->addNotification('warning', 'This username doesn\'t exist');
            header("Location: ../pages/loginPage.php");
            exit;
        }

        if($password_hash['password'] == null){
            $session->addNotification('warning', 'This email doesn\'t exist');
            header("Location: ../pages/loginPage.php");
        }

        
        if(password_verify($password, $password_hash['password'])){
            $query = $db->prepare('SELECT * FROM User WHERE email = ?');
            $query->execute(array($email));
            $user = $query->fetch();

            $session->setEmail($email);
            $session->setId($user['id']);

            $session->addNotification('correct', 'Welcome '.$user['name'].'!');
            header("Location: ../index.php");  
        }  
        else{  
            $session->addNotification('warning', 'Invalid Login please try again');
            header("Location: ../pages/loginPage.php");
        }        
?> 