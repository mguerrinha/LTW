<?php
declare(strict_types = 1);

class Product {
    public int $id;
    public int $userId;
    public string $publicationDate;
    public string $name;
    public string $description;
    public string $brand;
    public string $model;
    public string $size;
    public float $price;
    public string $state;
    public string $imagePath;
    public bool $isSold;

    public function __construct(int $id, int $userId, string $publicationDate, string $name, string $description, string $brand, string $model, string $size, float $price, string $state, string $imagePath, bool $isSold) {
        $this->id = $id;
        $this->userId = $userId;
        $this->publicationDate = $publicationDate;
        $this->name = $name;
        $this->description = $description;
        $this->brand = $brand;
        $this->model = $model;
        $this->size = $size;
        $this->price = $price;
        $this->state = $state;
        $this->imagePath = $imagePath;
        $this->isSold = $isSold;
    }

    public function setSold(PDO $db, int $id) {
        $this->isSold = true;
        $stmt = $db->prepare('UPDATE Product SET isSold = ? WHERE id = ?');
        $stmt->execute([intval($this->isSold), $id]);
    }

    static function getAllProducts(PDO $db, string $orderBy = 'publicationDate', string $orderDirection = 'ASC') : array {
        $allowedOrderBy = ['publicationDate', 'name', 'price'];
        $allowedOrderDirection = ['ASC', 'DESC'];

        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'publicationDate';
        }

        if (!in_array($orderDirection, $allowedOrderDirection)) {
            $orderDirection = 'ASC';
        }

        if ($orderBy === 'name') {
            $orderBy = 'LOWER(name)';
        }

        $stmt = $db->prepare("SELECT id, userId, publicationDate, name, description, brand, model, size, price, state, imagePath, isSold FROM Product WHERE isSold = 0 ORDER BY $orderBy $orderDirection");
        $stmt->execute();
        
        $products = [];
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                (int)$product['id'],
                (int)$product['userId'],
                $product['publicationDate'],
                $product['name'],
                $product['description'],
                $product['brand'],
                $product['model'],
                $product['size'],
                (float)$product['price'],
                $product['state'],
                $product['imagePath'],
                (bool)$product['isSold']
            );
        }
        
        return $products;
    }
  
    static function getProduct(PDO $db, int $id) : ?Product {
        $stmt = $db->prepare('SELECT id, userId, publicationDate, name, description, brand, model, size, price, state, imagePath, isSold FROM Product WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            return new Product(
                (int)$product['id'],
                (int)$product['userId'],
                $product['publicationDate'],
                $product['name'],
                $product['description'],
                $product['brand'],
                $product['model'],
                $product['size'],
                (float)$product['price'],
                $product['state'],
                $product['imagePath'],
                (bool)$product['isSold']
            );
        } else {
            return null;
        }
    }

    static function getProductCategories(PDO $db, int $productId): array {
        $stmt = $db->prepare('
            SELECT c.id, c.name FROM Category c
            JOIN ProductCategory pc ON c.id = pc.categoryId
            WHERE pc.productId = ?
        ');
        $stmt->execute([$productId]);

        $categories = [];
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = [
                'id' => (int) $category['id'],
                'name' => $category['name']
            ];
        }
        
        return $categories;
    }

    static function getProductsByFilters(PDO $db, array $filters = [], string $query = '', string $orderBy = 'publicationDate', string $orderDirection = 'ASC'): array {
        $allowedOrderBy = ['publicationDate', 'name', 'price'];
        $allowedOrderDirection = ['ASC', 'DESC'];
    
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'publicationDate';
        }
    
        if (!in_array($orderDirection, $allowedOrderDirection)) {
            $orderDirection = 'ASC';
        }
    
        if ($orderBy === 'name') {
            $orderBy = 'LOWER(name)';
        }
    
        $queryStr = "SELECT DISTINCT p.* FROM Product p";
        $joinCategory = !empty($filters['categories']);
        $params = [];
    
        if ($joinCategory) {
            $queryStr .= " INNER JOIN ProductCategory pc ON p.id = pc.productId";
        }
        $queryStr .= " WHERE p.isSold = 0";
    
        if ($joinCategory) {
            $placeholders = implode(',', array_fill(0, count($filters['categories']), '?'));
            $queryStr .= " AND pc.categoryId IN ($placeholders)";
            $params = array_merge($params, $filters['categories']);
        }
    
        if (!empty($filters['states'])) {
            $placeholders = implode(',', array_fill(0, count($filters['states']), '?'));
            $queryStr .= " AND p.state IN ($placeholders)";
            $params = array_merge($params, $filters['states']);
        }
    
        if (!empty($filters['price_min'])) {
            $queryStr .= " AND p.price >= ?";
            $params[] = $filters['price_min'];
        }
    
        if (!empty($filters['price_max'])) {
            $queryStr .= " AND p.price <= ?";
            $params[] = $filters['price_max'];
        }
    
        if (!empty($query)) {
            $queryStr .= " AND (LOWER(p.name) LIKE LOWER(?) OR LOWER(p.brand) LIKE LOWER(?) OR LOWER(p.model) LIKE LOWER(?))";
            $searchTerm = "%$query%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
        }
    
        $queryStr .= " ORDER BY $orderBy $orderDirection";
    
        $stmt = $db->prepare($queryStr);
        $stmt->execute($params);
    
        $products = [];
        $productIds = [];
    
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!in_array($product['id'], $productIds)) {
                $products[] = new Product(
                    (int) $product['id'],
                    (int) $product['userId'],
                    $product['publicationDate'],
                    $product['name'],
                    $product['description'],
                    $product['brand'],
                    $product['model'],
                    $product['size'],
                    (float) $product['price'],
                    $product['state'],
                    $product['imagePath'],
                    (bool) $product['isSold']
                );
                $productIds[] = $product['id'];
            }
        }
    
        return $products;
    }
    
    static function searchProducts(PDO $db, string $query, array $filters = [], string $orderBy = 'publicationDate', string $orderDirection = 'ASC'): array {
        $allowedOrderBy = ['publicationDate', 'name', 'price'];
        $allowedOrderDirection = ['ASC', 'DESC'];
    
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'publicationDate';
        }
    
        if (!in_array($orderDirection, $allowedOrderDirection)) {
            $orderDirection = 'ASC';
        }
    
        if ($orderBy === 'name') {
            $orderBy = 'LOWER(name)';
        }
    
        $queryStr = "
            SELECT DISTINCT p.* 
            FROM Product p
            WHERE (LOWER(p.name) LIKE LOWER(?) OR LOWER(p.brand) LIKE LOWER(?) OR LOWER(p.model) LIKE LOWER(?))
            AND p.isSold = 0
        ";
    
        $params = ["%$query%", "%$query%", "%$query%"];
    
        if (!empty($filters['categories'])) {
            $queryStr .= " AND EXISTS (SELECT 1 FROM ProductCategory pc WHERE pc.productId = p.id AND pc.categoryId IN (" . implode(',', array_fill(0, count($filters['categories']), '?')) . "))";
            $params = array_merge($params, $filters['categories']);
        }
    
        if (!empty($filters['states'])) {
            $queryStr .= " AND p.state IN (" . implode(',', array_fill(0, count($filters['states']), '?')) . ")";
            $params = array_merge($params, $filters['states']);
        }
    
        if (!empty($filters['price_min'])) {
            $queryStr .= " AND p.price >= ?";
            $params[] = $filters['price_min'];
        }
    
        if (!empty($filters['price_max'])) {
            $queryStr .= " AND p.price <= ?";
            $params[] = $filters['price_max'];
        }
    
        $queryStr .= " ORDER BY $orderBy $orderDirection";
    
        $stmt = $db->prepare($queryStr);
        $stmt->execute($params);
    
        $products = [];
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                (int)$product['id'],
                (int)$product['userId'],
                $product['publicationDate'],
                $product['name'],
                $product['description'],
                $product['brand'],
                $product['model'],
                $product['size'],
                (float)$product['price'],
                $product['state'],
                $product['imagePath'],
                (bool)$product['isSold']
            );
        }
        return $products;
    }       

    static function getProductsByUser(PDO $db, int $userId) : array {
        $stmt = $db->prepare('SELECT id, userId, publicationDate, name, description, brand, model, size, price, state, imagePath, isSold FROM Product WHERE userId = ?');
        $stmt->execute([$userId]);
        
        $products = [];
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                (int)$product['id'],
                (int)$product['userId'],
                $product['publicationDate'],
                $product['name'],
                $product['description'],
                $product['brand'],
                $product['model'],
                $product['size'],
                (float)$product['price'],
                $product['state'],
                $product['imagePath'],
                (bool)$product['isSold']
            );
        }
        
        return $products;
    }

    static function getProductsPurchasedByUser(PDO $db, int $buyerId) : array {
        $stmt = $db->prepare('
            SELECT p.id, p.userId, p.publicationDate, p.name, p.description, p.brand, p.model, p.size, p.price, p.state, p.imagePath, p.isSold, pu.transactionDate
            FROM Purchase pu
            JOIN Product p ON pu.productId = p.id
            WHERE pu.buyerId = ?
        ');
        $stmt->execute([$buyerId]);
        
        $products = [];
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = [
                'product' => new Product(
                    (int)$product['id'],
                    (int)$product['userId'],
                    $product['publicationDate'],
                    $product['name'],
                    $product['description'],
                    $product['brand'],
                    $product['model'],
                    $product['size'],
                    (float)$product['price'],
                    $product['state'],
                    $product['imagePath'],
                    (bool)$product['isSold']
                ),
                'transactionDate' => $product['transactionDate']
            ];
        }
        
        return $products;
    }
}
?>
