<?php
declare(strict_types = 1);

class Comment {
    public int $id;
    public int $userId;
    public int $productId;
    public string $commentary;
    public DateTime $dateTime;

    public function __construct(int $id, int $userId, int $productId, string $commentary, DateTime $dateTime) {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->commentary = $commentary;
        $this->dateTime = $dateTime;
    }

    static function getCommentsByProduct(PDO $db, int $productId): array {
        $stmt = $db->prepare('SELECT id, userId, productId, commentary, dateTime FROM Comment WHERE productId = ?');
        $stmt->execute([$productId]);

        $comments = [];
        while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dateTime = new DateTime($comment['dateTime']);
            $comments[] = new Comment(
                (int)$comment['id'],
                (int)$comment['userId'],
                (int)$comment['productId'],
                $comment['commentary'],
                $dateTime
            );
        }

        return $comments;
    }
}
?>
