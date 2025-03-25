<?php

namespace Classes;

class Order
{
    private $conn;
    private $table_name = "orders";

    public $order_id;
    public $customer_id;
    public $total_amount;
    public $currency;
    public $status;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new order
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (customer_id, total_amount, currency, status, created_at) VALUES (:customer_id, :total_amount, :currency, :status, :created_at)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":total_amount", $this->total_amount);
        $stmt->bindParam(":currency", $this->currency);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all orders by customer
    public function getByCustomer()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE customer_id = :customer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->execute();
        return $stmt;
    }

    // Add this method to your Order class
    public function delete()
    {
        // First delete all order items
        $item_query = "DELETE FROM order_items WHERE order_id = :order_id";
        $item_stmt = $this->conn->prepare($item_query);
        $item_stmt->bindParam(":order_id", $this->order_id);
        $item_stmt->execute();

        // Then delete the order
        $query = "DELETE FROM " . $this->table_name . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getOrderDetails()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
