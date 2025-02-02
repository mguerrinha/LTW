<?php
class WishList {
    public int $buyerId;
    public int $productId;

    public function __construct(int $buyerId, int $productId) {
        $this->buyerId = $buyerId;
        $this->productId = $productId;
    }

    public static function getWishListByBuyerId(PDO $db, int $buyerId) : array {
        $stmt = $db->prepare('SELECT * FROM WishList WHERE buyerId = ?');
        $stmt->execute(array($buyerId));
        $wishListItems = $stmt->fetchAll();

        $wishList = array();
        foreach ($wishListItems as $item) {
            $wishList[] = new WishList(
                intval($item['buyerId']),
                intval($item['productId'])
            );
        }
        return $wishList;
    }
}
?>
