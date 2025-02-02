<?php
class User {
    public int $id;
    public string $userName;
    public string $name;
    public string $surname;
    public string $password;
    public string $email;
    public int $phoneNumber;
    public string $address;
    public bool $isAdmin;

    public function __construct(int $id, string $userName, string $name, string $surname, string $password, string $email, int $phoneNumber, string $address, bool $isAdmin) {
        $this->id = $id;
        $this->userName = $userName;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->isAdmin = $isAdmin;
    }

    public function getUserName() : string {
        $names = explode(" ", $this->userName);
        return count($names) > 1 ? $names[0] . " " . $names[count($names)-1] : $names[0];
    }

    public function setAdmin(PDO $db, int $id) {
        $this->isAdmin = true;
        $stmt = $db->prepare('UPDATE User SET isAdmin = ? WHERE id = ?');
        $stmt->execute([intval($this->isAdmin), $id]);
    }

    static function getUserWithPassword(PDO $db, string $email, string $password) : ?User {
        $stmt = $db->prepare('SELECT * FROM User WHERE email = ?');
        $stmt->execute(array(strtolower($email)));
        $user = $stmt->fetch();
        if ($user !== false && password_verify($password, $user['password'])) {
            return new User(
                intval($user['id']),
                $user['userName'],
                $user['name'],
                $user['surname'],
                $user['password'],
                $user['email'],
                intval($user['phoneNumber']),
                $user['address'],
                boolval($user['isAdmin'])
            );
        } else return null;
    }

    static function getUsers(PDO $db, int $count) : array {
        $stmt = $db->prepare('SELECT id, userName, name, surname, password, email, phoneNumber, address, isAdmin FROM User LIMIT ?');
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                intval($user['id']),
                $user['userName'],
                $user['name'],
                $user['surname'],
                $user['password'],
                $user['email'],
                intval($user['phoneNumber']),
                $user['address'],
                boolval($user['isAdmin'])
            );
        }

        return $users;
    }

    public static function getAllUsersExceptCurrent(PDO $db, int $currentUserId): array {
        $stmt = $db->prepare('SELECT id, userName, isAdmin FROM User WHERE id != ?');
        $stmt->execute([$currentUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getUser(PDO $db, int $id) : ?User {
        $stmt = $db->prepare('SELECT id, userName, name, surname, password, email, phoneNumber, address, isAdmin FROM User WHERE id = ?');
        $stmt->execute(array($id));

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new User(
                intval($user['id']),
                $user['userName'],
                $user['name'],
                $user['surname'],
                $user['password'],
                $user['email'],
                intval($user['phoneNumber']),
                $user['address'],
                boolval($user['isAdmin'])
            );
        }

        return null;
    }
}
?>
