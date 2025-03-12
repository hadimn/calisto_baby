<?php
namespace Classes;
class Cart {
    private $conn;
    private $table_name = "cart";

    public $cart_id;
    public $customer_id;
    public $product_id;
    public $quantity;
    public $added_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add product to cart
    public function add() {
        $query = "INSERT INTO " . $this->table_name . " (customer_id, product_id, quantity, added_at) VALUES (:customer_id, :product_id, :quantity, :added_at)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":added_at", $this->added_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get items in cart
    public function getItems() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();
        return $stmt;
    }

    // Update quantity in cart
    public function updateQuantity() {
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":cart_id", $this->cart_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
