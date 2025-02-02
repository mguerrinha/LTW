<?php
  class Session {

    private array $notifications;

    public function __construct() {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
  
      $this->notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : array();
      unset($_SESSION['notifications']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function addNotification(string $type, string $text) {
      $_SESSION['notifications'][] = array('type' => $type, 'text' => $text);
    }

    public function getNotifications() {
      return $this->notifications;
    }

    public function generate_random_token() {
      return bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;    
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setEmail(string $email){
      $_SESSION['email'] = $email;
    }
  }
?>