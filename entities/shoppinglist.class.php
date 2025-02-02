<?php
class ShoppingList {
    public int $buyerId;
    public int $productId;

    public function __construct(int $buyerId, int $productId) {
        $this->buyerId = $buyerId;
        $this->productId = $productId;
    }

    public static function getShoppingListByBuyerId(PDO $db, int $buyerId) : array {
        $stmt = $db->prepare('SELECT * FROM ShoppingList WHERE buyerId = ?');
        $stmt->execute(array($buyerId));
        $shoppingListItems = $stmt->fetchAll();

        $shoppingList = array();
        foreach ($shoppingListItems as $item) {
            $shoppingList[] = new ShoppingList(
                intval($item['buyerId']),
                intval($item['productId'])
            );
        }
        return $shoppingList;
    }
}
?>
