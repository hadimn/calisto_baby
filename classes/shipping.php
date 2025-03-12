<?php
namespace Classes;
class Shipping {
    private $conn;
    private $table_name = "shipping";

    public $shipping_id;
    public $order_id;
    public $address;
    public $shipping_status;
    public $delivery_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create shipping details
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (order_id, address, shipping_status, delivery_date) VALUES (:order_id, :address, :shipping_status, :delivery_date)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":shipping_status", $this->shipping_status);
        $stmt->bindParam(":delivery_date", $this->delivery_date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get shipping status
    public function getShippingStatus() {
        $query = "SELECT shipping_status FROM " . $this->table_name . " WHERE order_id = :order_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
