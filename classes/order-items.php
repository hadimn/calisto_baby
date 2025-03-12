<?php
namespace Classes;
class OrderItem {
    private $conn;
    private $table_name = "order_items";

    public $order_item_id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price_at_purchase;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new order item
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (order_id, product_id, quantity, price_at_purchase) VALUES (:order_id, :product_id, :quantity, :price_at_purchase)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price_at_purchase", $this->price_at_purchase);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
