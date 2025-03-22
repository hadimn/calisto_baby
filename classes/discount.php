<?php

class Discount
{
    private $conn;
    private $table_name = "discounts";
    private $orders_table = "orders"; // Assuming an orders table exists

    public $discount_id;
    public $customer_id;
    public $discount_type;
    public $discount_percentage;  // Renamed from discount_value
    public $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Check if the customer is eligible for a first-order discount
    public function isFirstOrderDiscountEligible()
    {
        $query = "SELECT COUNT(*) AS order_count FROM " . $this->orders_table . " WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row['order_count'] == 0; // Eligible if user has no orders
    }

    // Apply a first-order discount (10%)
    public function applyFirstOrderDiscount()
    {
        if ($this->isFirstOrderDiscountEligible()) {
            // Insert discount into database
            $query = "INSERT INTO " . $this->table_name . " (customer_id, discount_type, discount_percentage, status) 
                      VALUES (:customer_id, 'first_order', 10, 'active')";  // Updated to discount_percentage
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":customer_id", $this->customer_id);

            return $stmt->execute();
        }
        return false;
    }

    // Get active discount for a customer
    public function getActiveDiscount()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE customer_id = :customer_id AND status = 'active' 
                  ORDER BY discount_id DESC LIMIT 1"; // Get latest active discount
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
