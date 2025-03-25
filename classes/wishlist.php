<?php
class Wishlist
{
    private $conn;
    private $table = "wishlist";

    public $wishlist_id;
    public $customer_id;
    public $product_id;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Add a product to the wishlist
    public function addToWishlist()
    {
        $query = "INSERT INTO " . $this->table . " (customer_id, product_id, created_at) VALUES (:customer_id, :product_id, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);

        return $stmt->execute();
    }

    // Remove a product from the wishlist
    public function removeFromWishlist()
    {
        $query = "DELETE FROM " . $this->table . " WHERE customer_id = :customer_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);

        return $stmt->execute();
    }

    // Get all wishlist items with product details
    public function getWishlistByCustomer()
    {
        $query = "SELECT p.product_id, p.name, p.price, p.new_price, p.image, p.description
                FROM " . $this->table . " w
                JOIN products p ON w.product_id = p.product_id
                WHERE w.customer_id = :customer_id
                ORDER BY w.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Check if a product is in the wishlist
    public function isProductInWishlist()
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE customer_id = :customer_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}
