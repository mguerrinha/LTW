<?php
declare(strict_types = 1);

class Category {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getCategoryById(PDO $db, int $id) : ?Category {
        $stmt = $db->prepare('SELECT * FROM Category WHERE id = ?');
        $stmt->execute(array($id));
        $categoryItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryItem) {
            return new Category(
                intval($categoryItem['id']),
                $categoryItem['name']
            );
        } else {
            return null;
        }
    }

    public static function getAllCategories(PDO $db) : array {
        $stmt = $db->prepare('SELECT * FROM Category');
        $stmt->execute();
        $categoryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = array();
        foreach ($categoryItems as $item) {
            $categories[] = new Category(
                intval($item['id']),
                $item['name']
            );
        }
        return $categories;
    }
}
?>
